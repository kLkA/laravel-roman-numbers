<?php

namespace App\Transformers;

use App\Models\Number;
use League\Fractal\TransformerAbstract;

class NumberTransformer extends TransformerAbstract
{
    public function transform(Number $number)
    {
        return [
            'id'        => (int)$number->id,
            'number'    => (int)$number->number,
            'count'     => (int)$number->count,
            'updated_at' => $number->updated_at,
        ];
    }
}
