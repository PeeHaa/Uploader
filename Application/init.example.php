<?php
/**
 * Setup error reporting
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 0);

/**
 * Set the timezone
 */
ini_set('date.timezone', 'Europe/Amsterdam');

/**
 * Bootstrap the library
 */
require_once '/../Src/RichUploader/bootstrap.php';

/**
 * Setup the database connection
 */
$dbConnection = new \PDO('pgsql:dbname=fileuploader;host=127.0.0.1', 'username', 'password');
$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);