<?php

    require "../bootstrap.php";
    
    use Src\Controller\CompanyController;
    use Src\Utils\UserAuth;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST GET");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);

    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $user = UserAuth::validateJWT();
    if($user[1]["role"] == "user") {
        if($requestMethod == "POST" || $requestMethod == "PUT" || $requestMethod == "DELETE") {
            header("HTTP/1.1 401 Unauthorised");
            exit();
        }
    }

    $company = new CompanyController($con, $requestMethod, $uri);
    $company->process_request();

?>