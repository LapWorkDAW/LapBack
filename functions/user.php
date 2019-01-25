<?php
/**
 * Created by PhpStorm.
 * User: uriigrao
 * Date: 25/01/19
 * Time: 11:50
 */

// require de carpetas utils y models.
// permite la recarga de todos los archivos dentro de las carpetas
foreach (glob("utils/*.php") as $filename) {
    require_once $filename;
}
foreach (glob("models/*.php") as $filename) {
    require_once $filename;
}

try {
    if ($method == 'GET') {
        if ($function = "getByMail") {
            $datos = $objeto->getByMail($id);
            $http->setHTTPHeaders(200, new Response("Datos", $datos));
        }
    } else {
        $http = new HTTP();
        $http->setHTTPHeaders(400, new Response("Bad Request"));
        die();
    }
} catch (Exception $ex) {
    echo "Error! " . $ex->getMessage();
}
