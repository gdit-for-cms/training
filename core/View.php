<?php

namespace Core;

/**
 * View
 *
 * PHP version 7.0
 */
class View {

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = []) {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/app/views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }
}
