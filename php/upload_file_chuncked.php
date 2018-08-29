<?php
/**
 * Handle uploading a large file to server as small pieces
 *
 * Servers tend to have quite small size limits when it comes to file uploading.
 * This little piece splits the file to be uploaded into
 *
 * @todo documentation & refactoring
 * @todo integrity check the file
 */

$dir = 'uploads';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: x-requested-with, x-file-name, x-index, x-total, x-hash, Content-Type, origin, authorization, accept, client-security-token");

if (!isset($_SERVER['HTTP_X_FILE_NAME'])) {
  throw new Exception('Name required');
}
if (!isset($_SERVER['HTTP_X_INDEX'])) {
  throw new Exception('Index required');
}
if (!isset($_SERVER['HTTP_X_TOTAL'])) {
  throw new Exception('Total chunks required');
}
if(!preg_match('/^[0-9]+$/', $_SERVER['HTTP_X_INDEX'])) {
  throw new Exception('Index error');
}
if(!preg_match('/^[0-9]+$/', $_SERVER['HTTP_X_TOTAL'])) {
  throw new Exception('Total error');
}

$filename = $_SERVER['HTTP_X_FILE_NAME'];
$index = intval($_SERVER['HTTP_X_INDEX']);
$total = intval($_SERVER['HTTP_X_TOTAL']);
$hash = $_SERVER['HTTP_X_HASH'];
$target = $dir."/".$filename."-".$index."-".$total;
$input = fopen("php://input", "r");

file_put_contents($target, $input);
$input = file_get_contents($target);
$hash_file = md5($input);

if ($hash===$hash_file) {
	$result = array(
		'filename' => $filename,
		'start' => $index,
		'end' => $total,
		'percent' => intval(($index+1) * 100 / $total),
		'hash' => $hash_file
	);

	if ($index>0) {
		$target_old = $dir."/".$filename."-".($index-1)."-".$total;
		file_put_contents($target_old, $input, FILE_APPEND);
		rename($target_old, $target);
	}
	if ($index===intval($total-1)) {
		$result['percent'] = 100;
		$result['newname'] = createFileName($filename);
		rename($target, $dir."/".$result['newname']);
	}
} else {
	$result = array(
		'error' => 'E_HASH'
	);
}
echo json_encode($result);


// Generates a random string for use as the name of the file
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
function createFileName($oldFilename) {
	$name_parts = explode('.', $oldFilename);
	$extension = end($name_parts);
  	return time() . generateRandomString() . '.' . $extension;
}
