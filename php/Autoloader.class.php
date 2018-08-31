<?php

/**
 * Simple autoloader for class files.
 *
 * When a class is used, find corresponding class from ./Class folder.
 * Do a recursive search if namesapces are used.
 */

class Autoloader {
  public static function register() {
    spl_autoload_register(function ($name) {
      // Recursive search for..
      // Classes
      $file_class = 'Class/' . str_replace('\\', DIRECTORY_SEPARATOR, $name).'class.php';
      // Traits
      $file_trait = 'Traits/' . str_replace('\\', DIRECTORY_SEPARATOR, $name).'traits.php';

      if (file_exists($file_class)) {
        require $file_class;
        return true;
      } elseif (file_exists($file_trait)) {
        require $file_trait;
        return true;
      }

      // Failed to load a class or trait
      return false;
    });
  }
}

/**
 * Register the autoloader for use
 */

Autoloader::register();
