<?php
namespace PhpCupcakes\Helpers;  

class CheckFormToken {

    
 public static function checkCSRFToken() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (
            !isset($_POST["csrf_token"]) ||
            $_POST["csrf_token"] !== $_SESSION["csrf_token"]
        ) {
            // CSRF token is invalid, reject the request
            http_response_code(400);
            echo "Invalid CSRF token";
            return false;
            exit();
        } else { return true; }
    }
    }



}