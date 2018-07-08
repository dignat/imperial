<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    protected $fillable =
        ['milleage', 'make', 'model'];

}