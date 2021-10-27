<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header(
    'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With'
);

require 'db_connection.php';
$link = db_connect();

$data = json_decode(file_get_contents('php://input'));

if (
    !isset($data->id) &&
    !isset($data->email) &&
    !isset($data->phone) &&
    !isset($data->ip) &&
    !is_numeric($data->id) &&
    !is_numeric($data->phone) &&
    empty(trim($data->email)) &&
    empty(trim($data->phone)) &&
    empty(trim($data->ip))
) {
    echo json_encode([
        'success' => 0,
        'msg' => 'Please fill all the fields!',
    ]);
    return;
}

$id = mysqli_real_escape_string($link, trim($data->id));
$useremail = mysqli_real_escape_string($link, trim($data->email));
$userphone = mysqli_real_escape_string($link, trim($data->phone));
$usertoken = bin2hex(random_bytes(15));
$userip = mysqli_real_escape_string($link, trim($data->ip));

if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => 0,
        'msg' => 'Invalid Email Address!',
    ]);
    return;
}

$updateUser = mysqli_query(
    $link,
    "UPDATE `users` SET `email`='$useremail', `phone`='$userphone' , `token`='$usertoken' , `ip`='$userip' WHERE `id`='$data->id'"
);

if (!$updateUser) {
    echo json_encode(['success' => 0, 'msg' => 'User Not Updated!']);
}

echo json_encode(['success' => 1, 'msg' => 'User Updated.']);
