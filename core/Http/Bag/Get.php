<?php

namespace Core\Http\Bag;

class Get extends Bag {
    public function __construct() {
        parent::__construct($_GET);
    }
}
