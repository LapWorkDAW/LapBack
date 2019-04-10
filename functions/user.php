<?php
/**
 * Created by PhpStorm.
 * User: uriigrao
 * Date: 25/01/19
 * Time: 11:50
 */


try {
    if ($method == 'GET' || $method == 'POST') {
        switch (strtolower($function)) {
            case "getbymail":
                $datos = $objeto->getByMail($id);
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "getactiv":
                $datos = $objeto->getByActiv();
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "login":
                $body = file_get_contents('php://input');
                $json = json_decode($body);
                $username = $json->username;
                $pass = $json->pass;
                $token = $json->token;
                $datos = $objeto->login($username, $pass, $token);
                $http->setHTTPHeaders(200, new Response("Datos", $datos));
                break;
            case "logout":
                $datos = $objeto->logout($token);
                $http->setHTTPHeaders(200, new Response("This: ", $objeto->serialize()));
                break;
            case "password":
                $body = file_get_contents('php://input');
                $json = json_decode($body);

                $user = new User();
                $user->getByToken($token);
                $idUser = $user->getIdUser();

                $oldPassword = $json->oldPass;
                $newPassword = $json->newPass;

                $datos = $objeto->changePass($oldPassword, $newPassword, $idUser);
                $http->setHTTPHeaders(200, new Response("This: ", $objeto->serialize()));

                break;
            case "photo":
                $files = $_FILES;
                $objeto->getByToken($token);
                $body = filter_input(INPUT_POST, 'user');
                $json = json_decode($body);
                foreach ($json as $item => $value) {
                    $objeto->$item = $value;
                }
                $objeto->save();
                if (isset($files["photo"])) {
                    if ($files["photo"] != "undefined") {
                        $ido = "id$controller";
                        echo move_uploaded_file($files["photo"]["tmp_name"], "./Assets/$controller" . "s/" . $objeto->$ido . ".jpg");
                    }
                }
                $http->setHTTPHeaders(201, new Response("Actualizado Correctamente", $objeto->serialize()));
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
