<?php
/**
 * Created by PhpStorm.
 * User: uriigrao
 * Date: 25/01/19
 * Time: 11:50
 */

try {
    if ($method == 'GET') {
        switch (strtolower($function)) {
            case "getbymail":
                $datos = $objeto->getByMail($id);
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "getactiv":
                $datos = $objeto->getByActiv();
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            default:
                $http = new HTTP();
                $http->setHTTPHeaders(201, new Response("Not a function from User: " . $function));
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
