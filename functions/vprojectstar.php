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
            case "allvotes":
                $datos = $objeto->allvotes($id);
                $http->setHTTPHeaders(200, new Response("Lista Media Cantidad Estrellas", $datos));
                break;
            case "userproject":
                $user = new User();
                $user->getByToken($token);
                $idUser = $user->getIdUser();
                $datos = $objeto->votebyUser($idUser, $id);
                $http->setHTTPHeaders(200, new Response("Usuario Ha Votado?", $datos));
                break;

            default:
                $http = new HTTP();
                $http->setHTTPHeaders(422, new Response("Error Function", ""));
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
