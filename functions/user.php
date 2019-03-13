<?php
/**
 * Created by PhpStorm.
 * User: uriigrao
 * Date: 25/01/19
 * Time: 11:50
 */



try {
    if ($method == 'GET' || $method == 'POST') {
        switch (strtolower($function)) {
            case "getbymail":
                $datos = $objeto->getByMail($id);
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "getactiv":
                $datos = $objeto->getByActiv();
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "login":
                $body = file_get_contents('php://input');
                $json = json_decode($body);
                $username = $json->username;
                $pass = $json->pass;
                $token = $json->token;
                $datos = $objeto->login($username, $pass, $token);
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "logout":
                $object = new User();
                $datos = $object->logout($token);
                $http->setHTTPHeaders(200, new Response("This: ", $datos));
                break;
            default:
                $http = new HTTP();
                $http->setHTTPHeaders(201, new Response("Not a function from User: " . $function, ""));
                die();
        }
    } else {
        $http = new HTTP();
        $http->setHTTPHeaders(400, new Response("Bad Request"));
        die();
    }
} catch (Exception $ex) {
    echo "Error! " . $ex->getMessage();
}
