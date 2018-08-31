<?php

/**
 * Getter and setter helper magic methods
 *
 * These magic methods allow accessing programmer-defined getters and setters
 * with arrow notation, which arguably looks super neat.
 *
 * NOTE: The getters and setters need to be named get_propName and set_propName
 *
 * If you don't define getter and/or setter, exceptions will be thrown
 */

trait MagicMethods {
  function __get($prop) {
    $meth = "get_$prop";
    if (method_exists($this, $meth)) {
      return $this->$meth();
    }
    // No getter available
    throw new Exception("No getter for unaccessible property $prop");
  }

  function __set($prop, $value) {
    $meth = "set_$prop";
    if (method_exists($this, $meth)) {
      return $this->$meth($value);
    }
    // No setter available
    throw new Exception("No setter for unaccessible property $prop");
  }
}
