<?php

try {
    if ($method == 'GET' || $method == 'POST') {
        switch (strtolower($function)) {
            case "byproject":
                if (empty($id)) {
                    $http->setHTTPHeaders(400, new Response("Bad Request No ID"));
                    die();
                }
                $datos = $objeto->getByProject($id);
                $http->setHTTPHeaders(200, new Response("Lista $controller", $datos));
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
