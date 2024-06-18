<?php
require_once "../app/db/Database.php";
require_once ($_SERVER['DOCUMENT_ROOT'] . '/DeAD/vendor/autoload.php');
include_once "AuthUController.php";
include_once "AuthAController.php";
include_once "RequestController.php";


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$db = Database::getConnection();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$requestMethod = $_SERVER["REQUEST_METHOD"];

$authUController = new AuthUController($db, $requestMethod);
$authAController = new AuthAController($db, $requestMethod);


switch ($uri[3]) {
    case 'auth-user':
        $authUController->processRequest();
        break;
    case 'auth-admin':
        $authAController->processRequest();
        break;
    case 'request':
        $response = $authAController->validateJWT();
        $type = $response->type;
        $username = $response->username;

        $request = new RequestController($db, $requestMethod, $type,$username);
        $request->processRequest();
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}
