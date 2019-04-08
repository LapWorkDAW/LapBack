<?php
/**
 * Created by PhpStorm.
 * User: uriigrao
 * Date: 11/01/19
 * Time: 12:22
 */

try {
    if ($method == 'GET' || $method == 'DELETE') {
        switch (strtolower($function)) {
            case "allvotes":
                $datos = $objeto->allVotes($id);
                $http->setHTTPHeaders(200, new Response("Lista Votos al proyecto", $datos));
                break;
            case "userproject":
                $user = new User();
                $user->getByToken($token);
                $idUser = $user->getIdUser();
                $datos = $objeto->votebyUser($idUser, $id);
                $http->setHTTPHeaders(200, new Response("Usuario Ha Votado?", $datos));
                break;
            case "unlike":
                $user = new User();
                $user->getByToken($token);
                $idUser = $user->getIdUser();
                $datos = $objeto->unLike($idUser, $id);
                break;
            case "alllikes":
                $user = new User();
                $user->getByToken($token);
                $idUser = $user->getIdUser();
                $datos = $objeto->allLikes($idUser);
                $http->setHTTPHeaders(200, new Response("Todos los Project que ha Votado User ", $datos));
                break;
            default:
                $http = new HTTP();
                $http->setHTTPHeaders(201, new Response("Not a Function"));
                die();
        }
    } else {
        $http = new HTTP();
        $http->setHTTPHeaders(422, new Response("Bad Request"));
        die();
    }
} catch (Exception $ex) {
    echo "Error! " . $ex->getMessage();
}
