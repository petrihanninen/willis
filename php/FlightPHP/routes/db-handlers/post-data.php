<?php
// Config
require_once __DIR__ . '/../../config.php';

/**
 * Save POST request data to database
 *
 * @param array $data       The data sent as associative array
 * @param array $fields      Array of expected post data keys
 * @param array $db_fields   Array of database keys if different from expected
 *                          post keys
 *
 * @return void
 *
 * @todo Refactoring
 */
function handlePostRequest($data, $fields, $db_fields = false) {
  // Turn the field key arrays to strings
  $fields_string = implode(', ', $fields);
  // If database has different keys from the form, use those
  $db_fields_string =
    $db_fields ?
      ':'.implode(', :', $db_fields) :
      ':'.implode(', :', $fields);

  try {
    // Send data to database
    $db = Flight::db();
    $stmt = $db->prepare(
    "INSERT INTO test($fields_string)
      VALUES($db_fields_string)"
    );
    $stmt->execute($data);

    // Get the id of the inserted row
    $id = $db->lastInsertId();

    // Respond with success code, the id inserted and the request data
    header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    die(json_encode(array(
      'code' => 200,
      'insertedId' => $id,
      'data' => $data,
    )));

  } catch(Exception $e) {
    header('HTTP/1.1 500 Failed Inserting Into Database');
    header('Content-Type: application/json');
    die(json_encode(array(
      'code' => 500,
      'message' => 'Failed Inserting Into Database',
      'error' => $e->getMessage(),
      'data' => $data,
    )));
  }
}

function getPostDataAsJson() {
  return json_decode(file_get_contents('php://input'), true);
}

// Get the data from request as associative array
$data = getPostDataAsJson();
handlePostRequest($data, [ 'etunimi', 'email', 'rules' ]);
