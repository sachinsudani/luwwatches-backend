<?php

    require "../bootstrap.php";
    
    use Src\Controller\ProductController;
    use Src\Utils\UserAuth;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST GET PUT DELETE");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);
    
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    if($requestMethod == "GET") {
        $user[1]["role"] = "user";
    } else {
        $user = UserAuth::validateJWT();
    }
    if($user[1]["role"] == "user") {
        if($requestMethod == "POST" || $requestMethod == "PUT" || $requestMethod == "DELETE") {
            header("HTTP/1.1 401 Unauthorised");
            exit();
        }
    }
    
    $product = new ProductController($con, $requestMethod, $uri);
    $product->process_request();
?>