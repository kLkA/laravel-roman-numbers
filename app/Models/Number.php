<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;


/**
 * Class Number
 *
 * @package App\Models
 *
 * @property $id integer
 * @property $number integer
 * @property $count integer
 * @property $updated_at timestamp
 */
class Number extends Eloquent {

    protected $table = 'number';

    public $timestamps = false;
}