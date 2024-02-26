<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config {

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'php_food_code';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'cms-8341';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = FALSE;

    /**
     * Number of retries if catch error when crawl
     * functions crawl.php
     * @var int
     */
    const RETRY_CRAWL_TIMES = 5;
}
