<?php

/**
 * Simple autoloader for class files.
 *
 * When a class is used, find corresponding class from ./Class folder.
 * Do a recursive search if namesapces are used.
 */

class Autoloader {
  public static function register() {
    spl_autoload_register(function ($className) {
      // Look into Class folder
      $file = 'Class/';
      // Recursive serach for namespaced classed
      $file .= str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php';

      if (file_exists($file)) {
        require $file;
        return true;
      }
      return false;
    });
  }
}

/**
 * Register the autoloader for use
 */

Autoloader::register();
