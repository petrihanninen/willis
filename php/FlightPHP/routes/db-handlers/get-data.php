<?php
/**
 * Get data from database
 *
 * @param object $data        The get request data
 *    @param int $offset      Offset used for pagination
 *    @param string $orderby  The field data should be ordered by
 *    @param int $limit       How many items should be returned, default: 10
 * @param int $id             To return only one item, give it's id. In that
 *                            case $data can be omitted
 * @return array|object       If id is given, return the item, otherwise return
 *                            an array of items
 *
 * @todo documentation & refactoring
 */


// Config & autoloader
require_once __DIR__ . '/../../config.php';
require_once $config['autoloader'];

function handleGetRequest($data, $id = false) {
  if (!$id) {
    // Query settings
    $offset = isset($data['offset']) ? (int)$data['offset'] : 0;
    $orderby = isset($data['orderby']) ? (string)$data['orderby'] : false;
    $limit = isset($data['limit']) ? (int)$data['limit'] : 10;
    $index = $offset ? (int)$offset + 1 : NULL;
  }


  // Start of query string
  $sql = "SELECT * FROM ehdokkaat";

  // If id given pick only the appropiate one
  if ($id) {
    $sql .= ' AND id = :id';
  } else {
    $sql .= $orderby ? " ORDER BY $orderby" : "";
    $sql .= "$orderby LIMIT :l OFFSET :o";
  }

  // Connect to database
  $db = Flight::db();

  // Manage prepared statement
  $stmt = $db->prepare($sql);
  if ($id) {
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  } else {
    $stmt->bindValue(':l', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':o', $offset, PDO::PARAM_INT);
  }

  // Execute statement
  if (!$stmt->execute()) {
    throw new Exception("Executing statement failed");
  }

  // Get result data
  $data = $stmt->rowCount() > 0 ? $stmt->fetchAll() : [];

  header('HTTP/1.1 200 OK');
  header('Content-Type: application/json');
  die(json_encode(array(
    'code' => 200,
    'data' => $data,
  )));

  // Respond
  echo json_encode($data);
  die();
}
