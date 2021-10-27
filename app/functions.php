<?php

// Creates a token that is constantly changing for extra protection against burglary// csrf ( Cross-site request forgery )
if (!function_exists('csrfToken')) {
    function csrfToken()
    {
        $token = sha1(time() . md5('users3232'));
        return $token;
    }
}

// Saves what was recorded in the input before the refresh
if (!function_exists('old')) {
    function old($fn)
    {
        return isset($_POST[$fn]) ? $_POST[$fn] : '';
    }
}

// Message clearer
if (!function_exists('unsetMs')) {
    function unsetMs()
    {
        // sleep();
        if (isset($_SESSION['ms']) && !empty($_SESSION['ms'])) {
            unset($_SESSION['ms']);
        }
    }
}
// cheking IP of user
if (!function_exists('userCheck')) {
    function userCheck()
    {
        if (!empty($_SESSION['uip'])) {
            if (!($_SESSION['uip'] == $_SERVER['REMOTE_ADDR'])) {
                destroyAllSessions();
                // Destroys all session data
                header('location: singin.php');
            }
        }
    }
}

// cheking that $_SESSION['uid'] not empty
if (!function_exists('userConect')) {
    function userConect()
    {
        // session_start();
        if (empty($_SESSION['uid'])) {
            // print_r($_SESSION);
            // die;
            header('location: index.php');
        }
    }
}

//  Generates and updates the current session identifier
if (!function_exists('startMySession')) {
    function startMySession()
    {
        session_start();
        session_regenerate_id();
    }
}

if (!function_exists('destroyAllSessions')) {
    function destroyAllSessions()
    {
        session_start();
        // Stores in Array
        $_SESSION = [];
        // Swipe via memory
        if (ini_get('session.use_cookies')) {
            // Prepare and swipe cookies
            $params = session_get_cookie_params();
            // clear cookies and sessions
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        // Just in case.. swipe these values too
        ini_set('session.gc_max_lifetime', 0);
        ini_set('session.gc_probability', 1);
        ini_set('session.gc_divisor', 1);
        // Completely destroy our server sessions..
        session_destroy();
        // unset($_SESSION['uid']);
        // session_unset();
        // session_destroy();
    }
}

if (!function_exists('getUsers')) {
    function getUsers()
    {
        $link = db_connect();
        $sql = 'SELECT  * FROM `users` ';
        $result = mysqli_query($link, $sql);

        if ($result) {
            // $_SESSION['ms']=" in result";
            $users = mysqli_fetch_assoc($result);

            return $users;
        } else {
            // $_SESSION['ms']=" else ";
            return;
        }
    }
}

if (!function_exists('do_post')) {
    function do_post($url, $params)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
