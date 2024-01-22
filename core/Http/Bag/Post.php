<?php

namespace Core\Http\Bag;

class Post extends Bag {
    public function __construct() {
        parent::__construct($_POST);
    }
}
