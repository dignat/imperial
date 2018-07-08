<?php


namespace App\Http\Controllers;


use App\lib\CSVConverter;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    /**
     * @var CSVConverter
     */
    private $csvConverter;

    public function __construct(CSVConverter $converter)
    {
        $this->csvConverter = $converter;
    }

    public function import()
    { DB::enableQueryLog();
        $csv = $this->csvConverter->normalizeCsvFile(__DIR__.'/../../../userfiles/cars.csv');
        DB::table('cars')->insert($csv);

        $items = $this->csvConverter->normalizeJsonCarFeatures(__DIR__.'/../../../userfiles/features.json');

       array_walk($items, function($feature) {
           $car_id = $feature['car_id'];
           DB::insert("insert into features (feature, car_id) values('" . implode("',$car_id),('", $feature['feature']) . "',$car_id)");
       });

    }

}