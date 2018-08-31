<?php
/**
 * Usage
 */

require 'Autoloader.class.php';

class MagicMethodsExample {
  use MagicMethods;

  private $sampleProperty = 0;
  private $sampleProperty2 = 0;

  // User defined getters and setters
  public function get_sampleProperty() {
    return $this->sampleProperty;
  }
  public function set_sampleProperty($val) {
    $this->sampleProperty = $val;
  }
}

$sample = new MagicMethodsExample;

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
