<?php
/**
 * Print out every php error
 *
 * When debugging, copy in these lines or require this file to make sure every
 * error is echoed out.
 *
 * NOTE: Never leave these to production!
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
