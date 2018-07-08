<?php


namespace App\Http\Controllers;


use App\Cars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\View;


class CarsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('result')) {
            $cars = DB::select(
                "select cars.*,group_concat(features.feature separator ',') as feature from cars join features on cars.id = features.car_id where cars.id = features.car_id group by features.car_id order by cars.{$request->input('result')} asc "
            );
            $request->flash();
        } else {
            if ($request->input('feature')) {
                $cars = DB::table('cars')->join('features', 'cars.id', '=', 'car_id')->where(
                    'feature',
                    'LIKE',
                    '%'.$request->input('feature').'%'
                )->get();
            } else {
                $cars = DB::select(
                    "select cars.*,group_concat(features.feature separator ',') as feature from cars join features on cars.id = features.car_id where cars.id = features.car_id group by features.car_id"
                );
                $request->flush();
            }
        }
        $features = DB::table('features')->groupBy('features.feature')->orderBy('feature_id')->get();

        return View::make('cars.cars', compact('cars', 'features'));
    }

    public function store(Request $request)
    {
        if ($request->input('result')) {
            return DB::table('cars')->orderBy($request->input('result', 'asc'))->get();
        }
    }



    public function filter(Request $request)
    {
        $make = $request->input('make');
        if (!is_null($make)) {
            $cars = DB::table('cars')->where('make', '=', $make)->get();
        } else {
            $cars = DB::table('cars')->get();

        }

        return View::make('cars.include_cars', compact('cars'));
    }

    public function getFeature()
    {
        DB::select("select cars.*, sum(features.price) as featureSum from cars join features on cars.id = features.car_id group by cars.id having featureSum > 1500");
    }


}