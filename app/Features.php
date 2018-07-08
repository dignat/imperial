<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    protected $fillable =
        ['feature', 'car_id'];

    public function cars()
    {
        return $this->belongsTo(Cars::class);
    }

}