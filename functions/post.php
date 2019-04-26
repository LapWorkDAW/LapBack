<?php

try {
    if ($method == 'GET' || $method == 'POST') {
        switch (strtolower($function)) {
            case "getbyproject":
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
