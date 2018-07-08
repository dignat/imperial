<?php


namespace App\lib;


use Illuminate\Support\Facades\DB;

class CSVConverter
{

    public function normalizeCsvFile(string $string): array
    {
        $csv = array_map('str_getcsv', file($string));
        $header = array_shift($csv);
        array_walk($csv, function(&$row, $key, $header){
            $row = array_combine($header, $row);

        }, $header);

        return $csv;
    }

    public function normalizeJsonCarFeatures(string $stringPath) :array
    {
        $jsonFile = file_get_contents($stringPath);
        $json= json_decode($jsonFile, true);
        $items = [];
        foreach ($json as $key => $feature) {
            $fk = DB::table('cars')->select('id')->where('vrm', '=', $key)->get()->toArray()[0]->id;
            $items[] = ['feature' => explode(',',trim($feature)), 'car_id' => $fk];

        }

        return $items;
    }

}