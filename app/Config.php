<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'intern';

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
    const SHOW_ERRORS = true;

    // config server by FTP upload file
    const YOUR_SERVER_DIRECTORY = '/htdocs/BT1/training/public/';
    const FTP_SERVER_PUBLIC_DIRECTORY = '/htdocs/training2/training/server_public/';
    const FTP_SERVER = '192.168.1.208';
    const FTP_USERNAME = 'gdit_ftp';
    const FTP_PASSWORD = 'gdit6385';
    const FTP_PUBLIC_DIRECTORY_HTML = '/htdocs/training2/training/server_public/';
    const FTP_PUBLIC_DIRECTORY_CSV = '/htdocs/training2/training/cgi/csv/';
    const FTP_PUBLIC_DIRECTORY_EMAIL = '/htdocs/training2/training/cgi/email/';
    const FTP_PUBLIC_DIRECTORY_LINK_EXAM = '/htdocs/training2/training/cgi/random/';
    const FTP_DOMAIN = 'http://cms208.dev3.local/';
}
