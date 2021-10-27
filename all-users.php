<?php

require_once 'app/db_connection.php';
$link = db_connect();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header(
    'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With'
);

$allUsers = mysqli_query(
    $link,
    'SELECT id, email, phone, ip, token FROM users'
);

if (mysqli_num_rows($allUsers) > 0) {
    $all_users = mysqli_fetch_all($allUsers, MYSQLI_ASSOC);

    echo json_encode(['success' => 1, 'users' => $all_users]);
} else {
    print 'else';
    echo json_encode(['success' => 0]);
}
