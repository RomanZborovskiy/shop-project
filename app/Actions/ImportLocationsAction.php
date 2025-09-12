<?php

namespace App\Actions;

use App\Models\District;
use App\Models\Location;
use App\Models\Region;
use XMLReader;
use RuntimeException;
use Lorisleiva\Actions\Concerns\AsAction;

class ImportLocationsAction
{ 
    use AsAction;

    public string $commandSignature = 'locations:import {file : Path to the XML file} {--batch=1000}';
    public string $commandDescription = 'Імпорт населених пунктів з XML файлу';

    public function handle(string $filePath, int $batchSize = 1000, callable $progressCallback = null)
    {
        if (!file_exists($filePath)) {
            throw new RuntimeException("Файл не знайдено: {$filePath}");
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'xml_utf8_');
        $reader = new XMLReader();

        $regionsCache = [];
        $districtsCache = [];

        try {
            $sourceHandle = fopen($filePath, 'r');
            $tempHandle = fopen($tempFile, 'w');

            $firstLine = fgets($sourceHandle);
            if ($firstLine) {
                $firstLine = preg_replace('/encoding="[^"]+"/i', 'encoding="UTF-8"', $firstLine);
                fwrite($tempHandle, $firstLine);
            }

            while (!feof($sourceHandle)) {
                $chunk = fread($sourceHandle, 8192);
                $convertedChunk = mb_convert_encoding($chunk, 'UTF-8', 'Windows-1251');
                fwrite($tempHandle, $convertedChunk);
            }

            fclose($sourceHandle);
            fclose($tempHandle);

            $reader->open($tempFile);

            $batch = [];
            $count = 0;

            while ($reader->read()) {
                if ($reader->nodeType == XMLReader::ELEMENT && $reader->name === 'RECORD') {
                    $xmlString = $reader->readOuterXML();
                    $simpleXml = simplexml_load_string($xmlString);

                    if (!$simpleXml) {
                        continue;
                    }

                    $oblName = (string) $simpleXml->OBL_NAME;
                    $regionName = (string) $simpleXml->REGION_NAME;
                    $cityName = (string) $simpleXml->CITY_NAME;
                    //$cityRegion = (string) $simpleXml->CITY_REGION_NAME;
                    //$streetName = (string) $simpleXml->STREET_NAME;

                    if (!isset($regionsCache[$oblName])) {
                        $region = Region::firstOrCreate(['name' => $oblName]);
                        $regionsCache[$oblName] = $region->id;
                    }
                    $regionId = $regionsCache[$oblName];

                    $districtCacheKey = "{$regionId}_{$regionName}";
                    if (!isset($districtsCache[$districtCacheKey])) {
                        $district = District::firstOrCreate([
                            'name' => $regionName,
                            'region_id' => $regionId
                        ]);
                        $districtsCache[$districtCacheKey] = $district->id;
                    }
                    $districtId = $districtsCache[$districtCacheKey];

                    $locationName = $cityName;
                    $locationType = 'city';

                    if (!empty($locationName)) {
                        $batch[] = [
                            'name' => $locationName,
                            'type' => $locationType,
                            'district_id' => $districtId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    $count++;

                    if (count($batch) >= $batchSize) {
                        Location::insertOrIgnore($batch);
                        $batch = [];

                        if ($progressCallback) {
                            $progressCallback($count);
                        }
                    }
                }
            }

            if (!empty($batch)) {
                Location::insertOrIgnore($batch);
            }

            return $count;
        } finally {
            $reader->close();
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }

    public function asCommand($command): int
    {
        $file = $command->argument('file');
        $batchSize = (int) $command->option('batch');

        $command->info("Починаю імпорт з файлу: {$file}");

        $total = null; 

        $bar = $command->output->createProgressBar($total);
        $bar->start();

        $count = $this->handle($file, $batchSize, function ($processed) use ($bar) {
            $bar->advance();
        });

        $bar->finish();
        $command->newLine(2);
        $command->info("Готово! Імпортовано {$count} записів.");

        return 0;
    }
}
