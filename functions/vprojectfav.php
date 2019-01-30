<?php
/**
 * Created by PhpStorm.
 * User: uriigrao
 * Date: 11/01/19
 * Time: 12:22
 */

try {
    if ($method == 'GET') {
        switch (strtolower($function)) {
            case "allVotes":
                $datos = $objeto->allVotes($id);
                $http->setHTTPHeaders(200, new Response("Lista Votos al proyecto", $datos));
                break;
            default:
                $http = new HTTP();
                $http->setHTTPHeaders(201, new Response("Not a Function"));
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
