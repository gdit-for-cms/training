<?php

namespace Core\Http\Bag;

class Bag {
    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function has(String $key) {
        return isset($this->container[$key]);
    }

    public function get(String $key) {
        return $this->container[$key];
    }

    public function set(String $key, $value) {
        if ($this->container === $_COOKIE) {
            throw new \Exception("Cookies must be set on the response", 1);
        }
        $this->container[$key] = $value;

        return $this;
    }

    public function hasSet() {
        return isset($this->container) && !empty($this->container);
    }

    public function all() {
        return $this->container;
    }
}
