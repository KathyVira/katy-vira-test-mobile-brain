<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header(
    'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With'
);

require 'app/db_connection.php';
$link = db_connect();

// POST DATA
$data = json_decode(file_get_contents('php://input'));

function isValidEmail($useremail)
{
    return preg_match(
        '/\A[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}\z/',
        $useremail
    ) && preg_match('/^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/', $useremail);
}

function isValidIsraelPhone($userphone)
{
    return preg_match('\+?([0]{1})-?([2-9]{2})-?([0-9]{6,7})', $userphone);
}

if (
    isset($data->id) &&
    isset($data->email) &&
    isset($data->phone) &&
    isset($data->ip) &&
    !empty(trim($data->id)) &&
    !empty(trim($data->email)) &&
    !empty(trim($data->phone)) &&
    !empty(trim($data->ip))
) {
    $id = mysqli_real_escape_string($link, trim($data->id));
    $useremail = mysqli_real_escape_string($link, trim($data->email));
    $userphone = mysqli_real_escape_string($link, trim($data->phone));
    $usertoken = bin2hex(random_bytes(15));
    $userip = mysqli_real_escape_string($link, trim($data->ip));
    echo $userphone;
    if (
        filter_var(
            $id
            // isValidEmail($useremail),
            // isValidIsraelPhone($userphone)
        )
    ) {
        $insertUser = mysqli_query(
            $link,
            "INSERT INTO `users`(`id`,`email`,`phone`,`token`,`ip`) VALUES('$id','$useremail', '$userphone', '$usertoken', '$userip')"
        );
        if ($insertUser) {
            $last_id = mysqli_insert_id($link);
            echo json_encode([
                'success' => 1,
                'msg' => 'User Inserted.',
                'id' => $last_id,
            ]);
        } else {
            echo json_encode(['success' => 0, 'msg' => 'User Not Inserted!']);
        }
    } else {
        echo json_encode(['success' => 0, 'msg' => 'Invalid Email Address!']);
    }
} else {
    echo json_encode([
        'success' => 0,
        'msg' => 'Please fill all the required fields!',
    ]);
}
