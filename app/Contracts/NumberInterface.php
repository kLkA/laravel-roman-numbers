<?php

namespace App\Contracts;

interface NumberInterface {
    public function createObjectFromInteger($num);

    public function getRecentNumbers($limit);

    public function getTopNumbers();
}

