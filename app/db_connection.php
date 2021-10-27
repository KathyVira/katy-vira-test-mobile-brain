<?php

// DB connect

if (!function_exists('db_connect')) {
    function db_connect()
    {
        if (
            !($link = @mysqli_connect(
                '5.153.13.148',
                'kfkfk_user_test',
                'LKo7Xk5JdY8icAeH',
                'kfkfk_test_db'
            ))
        ) {
            die('Error connecting to mysql server!');
        }

        return $link;
    }
}
?>
