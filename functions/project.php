<?php
/**
 * Created by PhpStorm.
 * User: uriigrao
 * Date: 30/01/19
 * Time: 12:26
 */
// require de carpetas utils y models.
// permite la recarga de todos los archivos dentro de las carpetas

try {
    if ($method == 'GET') {
        switch (strtolower($function)) {
            case "getnofinish":
                $datos = $objeto->getNoFinish();
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "getfinish":
                $datos = $objeto->getFinish();
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            default:
                $http = new HTTP();
                $http->setHTTPHeaders(201, new Response("Not a function"));
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
