<?php

namespace Core\Http\Bag;

class Cookies extends Bag {
    public function __construct() {
        parent::__construct($_COOKIE);
    }
}
