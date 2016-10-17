<?php

namespace App\Transformers;

use App\Models\Number;
use League\Fractal\TransformerAbstract;

class RomanNumberTransformer extends TransformerAbstract
{
    public function transform(\stdClass $number)
    {
        return [
            'number'    => $number->number,
        ];
    }
}
