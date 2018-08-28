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

class MagicMethods {
  private $sampleProperty = 0;
  private $sampleProperty2 = 0;

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


  // User defined getters and setters
  public function get_sampleProperty() {
    return $this->sampleProperty;
  }
  public function set_sampleProperty($val) {
    $this->sampleProperty = $val;
  }
}





/**
 * Usage
 */

$sample = new MagicMethods;

// Setter
$sample->sampleProperty = 5;

// Getter
echo "I can set and get $sample->sampleProperty with -> notation. This makes echoing $sample->sampleProperty a breeze.";

echo "<br><br>";


/**
 * Errors
 */

// No setter
try {
  $sample->sampleProperty2 = 5;
} catch (Exception $e){
  echo "Error: " . $e->getMessage() . '<br>';
}

// No getter
try {
  echo $sample->sampleProperty2;
} catch (Exception $e){
  echo "Error: " . $e->getMessage();
}
