<?php
session_start();
// OAuth 2.0 client credentials
$CLIENT_ID = '';
$CLIENT_SECRET = '';
$REDIRECT_URI = 'https://demo.phpcupcake.shop/Plugins/OAuth/callback.php';
$AUTHORIZATION_URL = 'https://github.com/login/oauth/authorize';
$TOKEN_URL = 'https://github.com/login/oauth/access_token';
$USER_INFO_URL = 'https://api.github.com/user';

if (isset($_GET['code'])) {
    // Exchange the authorization code for an access token
    $code = $_GET['code'];
    $data = array(
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $REDIRECT_URI,
        'client_id' => $CLIENT_ID,
        'client_secret' => $CLIENT_SECRET
    );
    function post_request($url, $data) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded'
        ));
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        if ($error) {
            echo "CURL error: " . $error;
            return false;
        }
    
        if ($http_code != 200) {
            echo "HTTP code: " . $http_code;
            return false;
        }
    
        return json_decode($response, true);
    }
    
    $token_response = post_request($TOKEN_URL, $data);
    print_r($token_response);
    $access_token = $token_response['access_token'];
    $_SESSION['access_token'] = $access_token;

    function get_user_info($access_token, $USER_INFO_URL) {
        $ch = curl_init($USER_INFO_URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$access_token,
            'Accept: application/json',
            'User-Agent: request'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        if ($error) {
            echo "CURL error: " . $error;
            return false;
        }
    
        if ($http_code != 200) {
            echo "HTTP code: " . $http_code;
            return false;
        }
    
        return json_decode($response, true);
    }
        // Fetch user information using the access token
        $user_info = get_user_info($access_token, $USER_INFO_URL);
        print_r($user_info);
        $_SESSION['username'] = $user_info['login'];
        $_SESSION['user_id'] = $user_info['id'];

        // Display user-specific content


    if (isset($_SESSION['access_token'])) {
    header('Location: https://demo.phpcupcake.shop/');

    exit;
    }
} else {
    // Generate the authorization URL
    $params = array(
        'response_type' => 'code',
        'client_id' => $CLIENT_ID,
        'redirect_uri' => $REDIRECT_URI,
        'scope' => 'user:email'
    );
    $auth_url = $AUTHORIZATION_URL . '?' . http_build_query($params);
    header('Location: ' . $auth_url);
    exit;
}

?>