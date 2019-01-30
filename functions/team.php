<?php
/**
 * Created by PhpStorm.
 * User: uriigrao
 * Date: 11/01/19
 * Time: 12:22
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
        switch(strtolower($function)){
            case "allteam":
            $datos = $objeto->allTeam($id);
            $http->setHTTPHeaders(200, new Response("Lista Users en Proyect", $datos));
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