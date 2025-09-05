<?php

namespace App\Console\Commands;

use App\Actions\ImportLocationsAction;
use Illuminate\Console\Command;

class ImportLocations extends Command
{
    protected $signature = 'location:import {file : Path to the XML file}';
    protected $description = 'Імпорт населених пунктів України';

    public function handle(ImportLocationsAction $importer)
    {
        $file = $this->argument('file');

        try {
            $total = $importer->execute($file, 1000, function ($count) {
                $this->info("Імпортовано: {$count}");
            });

            $this->info("Імпорт завершено. Всього: {$total}");
            return 0;

        } catch (\Throwable $e) {
            $this->error("Помилка: " . $e->getMessage());
            return 1;
        }
    }
}