<?php

namespace App\Actions;


use App\Models\location;
use XMLReader;
use DOMDocument;

class ImportLocationsAction
{
    public function execute(string $filePath, int $batchSize = 1000, callable $progressCallback = null): int
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Файл не знайдено: {$filePath}");
        }

        $content = file_get_contents($filePath);

        $content = preg_replace('/encoding="[^"]+"/i', 'encoding="UTF-8"', $content);

        $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1251');

        $tempFile = tempnam(sys_get_temp_dir(), 'xml_utf8_');
        file_put_contents($tempFile, $content);

        $reader = new XMLReader();
        $reader->open($tempFile);

        $batch = [];
        $count = 0;

        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT && $reader->name === 'RECORD') {
                $node = $reader->expand();

                $dom = new DOMDocument();
                $node = $dom->importNode($node, true);
                $dom->appendChild($node);

                $simpleXml = simplexml_import_dom($dom);

                $oblName    = (string) $simpleXml->OBL_NAME;
                $regionName = (string) $simpleXml->REGION_NAME;
                $cityName   = (string) $simpleXml->CITY_NAME;
                $cityRegion = (string) $simpleXml->CITY_REGION_NAME;
                $streetName = (string) $simpleXml->STREET_NAME;

                $batch[] = [
                    'region'   => $oblName,
                    'district' => $regionName,
                    'name'     => $cityName ?: $streetName ?: $cityRegion,
                    'type'     => $streetName ? 'street' : ($cityName ? 'city' : 'region'),
                ];

                $count++;

                if (count($batch) >= $batchSize) {
                    location::insert($batch);
                    $batch = [];

                    if ($progressCallback) {
                        $progressCallback($count);
                    }
                }
            }
        }

        if (!empty($batch)) {
            Location::insert($batch);
        }

        $reader->close();
        unlink($tempFile);

        return $count;
    }
}
