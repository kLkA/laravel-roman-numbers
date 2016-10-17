<?php

namespace App\Providers;

use App\Contracts\NumberInterface;
use App\Models\Number;
use Illuminate\Support\ServiceProvider;


class NumberServiceProvider extends ServiceProvider implements NumberInterface
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NumberInterface::class, function($app) {
            return new NumberServiceProvider($app);
        });

        //$this->app->bind(NumberInterface::class, NumberServiceProvider::class, true);
        /*$this->app->singleton('App\Interfaces\NumberInterface', function ($app) {
            return new NumberServiceProvider();
        });*/
    }

    public function boot()
    {

    }


    public function createObjectFromInteger($num, $isUpper = true)
    {
        $n = intval($num);

        $number = Number::where('number', '=', $n)->first();
        if ($number == null) {
            $number = new Number;
            $number->number = $n;
        } else {
            $number->count++;
        }

        $number->save();

        $res = '';

        /*** roman_numerals array ***/
        $roman_numerals = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        ];

        foreach ($roman_numerals as $roman => $number) {
            /*** divide to get matches ***/
            $matches = intval($n / $number);

            /*** assign the roman char * $matches ***/
            $res .= str_repeat($roman, $matches);

            /*** substract from the number ***/
            $n = $n % $number;
        }

        /*** return the res ***/
        if (!$isUpper) {
            $res = strtolower($res);
        }

        $obj = new \stdClass();
        $obj->number = $res;

        return $obj;
    }

    public function getRecentNumbers($limit = 10)
    {
        return Number::orderBy('updated_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getTopNumbers($limit = 10)
    {
        return Number::orderBy('count', 'desc')
            ->take($limit)
            ->get();
    }
}
