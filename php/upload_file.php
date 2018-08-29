<?php
/**
 * Handle uploading a file to the server
 *
 * @todo documentation & refactoring
 * @todo integrity check the file
 */

try {
  $file = $_FILES['file'];

  $root = realpath(dirname(__FILE__)) . '/../../..';
  $uploaddir = $root . '/uploads/';

  $filename = createFileName(pathinfo($file['name'], PATHINFO_EXTENSION));
  $uploadfile = $uploaddir . $filename;

  if (!move_uploaded_file($file['tmp_name'], $uploadfile)) {
    throw new Exception('Failed executing move_upload_file()');
  }

  die(json_encode(array(
    'code' => 200,
    'file' => array(
      'name' => $filename,
      'path' => $uploaddir,
      'fullpath' => $uploadfile,
    ),
  )));

} catch(Exception $e) {
  header('HTTP/1.1 500 ' . $e->getMessage());
  header('Content-Type: application/json');
  die(json_encode(array(
    'code' => 500,
    'message' => $e->getMessage(),
    'data' => $file,
  )));
}

// Generates a random string that's used as the name of the file
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Return file name as timestamp + random string
function createFileName($extension) {
  return time() . generateRandomString() . '.' . $extension;
}
