<?php
require_once "../app/db/Database.php";
require_once ($_SERVER['DOCUMENT_ROOT'] . '/DeAD/vendor/autoload.php');
include_once "AuthUController.php";
include_once "AuthAController.php";
include_once "RequestController.php";
include_once "UserBanController.php";
include_once "InmateController.php";
include_once "StatisticsController.php";
include_once "ForgotPassword.php";
include_once "RegisterController.php";
include_once "ActivateController.php";
include_once "PhotoController.php";

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

        $request = new RequestController($db, $requestMethod, $type,$username,$uri);
        $request->processRequest();
        break;
    case 'request-nolog':
        $request = new RequestController($db, $requestMethod, 'nolog',null,$uri);
        $request->processRequest();
        break;
    case 'ban':
        $response = $authAController->validateJWT();
        $type = $response->type;
        $username = $response->username;

        $request = new UserBanController($db, $requestMethod, $type,$uri);
        $request->processRequest();
        break;
    case 'statistics':
        $response = $authAController->validateJWT();
        $type = $response->type;
        $username = $response->username;

        $request = new StatisticsController($db, $requestMethod, $username, $type,$uri);
        $request->processRequest();
        break;
    case 'forgot-password':
        $request = new ForgotPassword($db, $requestMethod);
        $request->processRequest();
        break;
    case 'upload':

        $request = new PhotoController();
        //$request->processRequest($pkey, $type);
        break;
    case 'inmates':
        $request = new InmateController($uri);

        if($_SERVER["REQUEST_METHOD"] == "DELETE") {
            $response = $authAController->validateJWT();
            $type = $response->type;
            $username = $response->username;

            $request->delete($uri, $type, $username);
        } else if($_SERVER["REQUEST_METHOD"] == "POST") {
            $response = $authAController->validateJWT();
            $type = $response->type;
            $username = $response->username;

            $request->create($type, $username);
        } else if($_SERVER["REQUEST_METHOD"] == "PUT"){
            $response = $authAController->validateJWT();
            $type = $response->type;
            $username = $response->username;

            $request->update($uri, $type, $username);
        } else if($_SERVER["REQUEST_METHOD"] == "GET"){
            $request->search($uri);
        }
        break;
    case 'register':
        $request = new RegisterController();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $request->register();
        }
        break;
    case 'activate':
        $request = new ActivateController();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $request->activate($uri);
        }
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}
