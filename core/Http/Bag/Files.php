<?php

namespace Core\Http\Bag;

use Core\Http\Bag\File;

class Files {
    protected $container;

    public function __construct() {
        $this->container = $_FILES;
    }

    public function get(string $key) {
        return $this->container[$key];
        return new File($this->container[$key]);
    }

    public function hasSet() {
        // There are no file field in the form
        if (!isset($this->container) or empty($this->container)) {
            return false;
        }

        // There at least one file field but any of them is sent to the server
        $fileEntry = array_values($this->container);
        if (!isset($fileEntry) or empty($fileEntry)) {
            return false;
        }

        // The are file field but any file is selected/uploaded
        $firstElement = $fileEntry[0];
        if (!isset($firstElement) or empty($firstElement["name"])) {
            return false;
        }

        return true;
    }
}
