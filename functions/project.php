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
    if ($method == 'GET' || $method == 'POST') {
        switch (strtolower($function)) {
            case "getnofinish":
                $datos = $objeto->getNoFinish();
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "getfinish":
                $datos = $objeto->getFinish();
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "byuserfinish":
                $user = new User();
                $user->getByToken($token);
                $idUser = $user->getIdUser();
                $datos = $objeto->getUFinish($idUser);
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "byusernofinish":
                $user = new User();
                $user->getByToken($token);
                $idUser = $user->getIdUser();
                $datos = $objeto->getUNoFinish($idUser);
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "byuser":
                $datos = $objeto->getByUser($id);
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "projectid":
                if (empty($id)) {
                    $http->setHTTPHeaders(400, new Response("Bad Request No ID"));
                    die();
                }
                $objeto->load($id);
                $http->setHTTPHeaders(200, new Response("Lista $controller", $objeto->serialize()));
                break;
            case "typeprojects":
                $body = file_get_contents('php://input');
                $json = json_decode($body);
                $type = $json->type;
                $datos = $objeto->getByType($type);
                $http->setHTTPHeaders(200, new Response("Lista $controller", $datos));
                break;
            default:
                $http = new HTTP();
                $http->setHTTPHeaders(201, new Response("Not a function from project: " . $function, ""));
                die();
        }
    } else {
        $http = new HTTP();
        $http->setHTTPHeaders(422, new Response("Bad Request", ""));
        die();
    }
} catch (Exception $ex) {
    echo "Error! " . $ex->getMessage();
}

