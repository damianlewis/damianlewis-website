<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class BaseSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    protected function getDataArray(string $file): array
    {
        $records = [];

        $path = database_path('data/' . $file);

        $csv = Reader::createFromPath($path);
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $record) {
            $records[] = $record;
        }

        return $records;
    }
}
