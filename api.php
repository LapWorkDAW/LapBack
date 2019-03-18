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

//headers obligate.
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/json; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');

/* Lo Primer es obtener el controlador y el id */
$controller = filter_input(INPUT_GET, "controller");
$id = filter_input(INPUT_GET, "id");
$function = filter_input(INPUT_GET, "function");
$token = filter_input(INPUT_GET, "token");

$method = $_SERVER['REQUEST_METHOD'];
$http = new HTTP();

/* Si el controlador esta vacio, o no existem devolvemos un badrequest. */
if (empty($controller) || !file_exists("./models/" . $controller . ".php")) {
    $http = new HTTP();
    $http->setHTTPHeaders(400, new Response("Bad Request Controller: " . $controller));
    die();
}
// Creamos un objeto de tipo de la clase que nos da el frontEnd.
$objeto = new $controller;

/* Tenemos el function por si tenemos que coger del GET algo especial lo enviamos a nuestro php de funciones
donde de ahi tenemos las funciones que usaremos para X cosas la manera de acceder a estas funciones es
   // http://localhost/LapBack/api.php?controller=VoteUser&function=allVotes&id=2
    cuando ponemos la ruta api ponemos el controller = tabla de la bd que queremos acceder.
                                            function = funcion especial que queremos realizar
                                            id = el id del usuario o proyecto que queramos acceder.
*/


/* Aqui revisamos si la funcion no es Login que revise el Token para validar.*/

if ($function != "login" && $function != "getbymail") {
    if (empty($token)) {
        if ($controller != "User" or $method != "POST") {
            $http->setHttpHeaders(400, new Response("Bad request Error Token"));
            die();
        }
    } else {
        //Miramos si el Token esta bien del usuario logeado
        try {
            $userLogged = new User();
            $userLogged->getByToken($token);
        } catch (Exception $e) {
            $http->setHttpHeaders(400, new Response("Bad request Error No User With This Token"));
            die();
        }
    }
}


// instalar composer:
// https://developers.google.com/identity/sign-in/web/backend-auth
if (empty($function)) {
// depende que metodo nos den hacemos lo correspondiente dentro el case.
    try {
        switch ($method) {
            case 'GET':
                // si no tiene id nos devuelve todos los registros en la BD
                if (empty($id)) {
                    $datos = $objeto->loadAll();
                    $http->setHTTPHeaders(200, new Response("Lista $controller", $datos));
                } else {
                    // en caso que si tenga id solo devolvemos el registro que quiera FrontEnd.
                    $objeto->load($id);
                    $http->setHTTPHeaders(200, new Response("Lista $controller", $objeto->serialize()));
                }
                break;
            case 'POST':
                $body = file_get_contents('php://input');
                $json = json_decode($body);
                if ($controller == 'Project') {
                    $objeto = saveProject($json);
                } else if ($controller == 'Inscription') {
                    $objeto = saveInscription($json);
                } else if ($controller == 'Post') {
                    $objeto = savePost($json);
                } else if ($controller == 'User') {
                    foreach ($json as $item => $value) {
                        if ($item == "pass") {
                            $pass = password_hash($value, PASSWORD_DEFAULT);
                            $objeto->$item = $pass;
                        } else {
                            $objeto->$item = $value;
                        }
                    }
                } else {
                    foreach ($json as $item => $value) {
                        $objeto->$item = $value;
                    }
                }
                $objeto->save();
                break;
            case 'PUT':
                if ($controller == "User") {
                    $objeto->getByToken($token);
                    $body = file_get_contents('php://input');
                    $json = json_decode($body);
                    foreach ($json as $item => $value) {
                        $objeto->$item = $value;
                    }
                } else {
                    if (empty($id)) {
                        $http->setHTTPHeaders(400, new Response("Bad Request No ID"));
                        die();
                    }
                    $objeto->load($id);
                    $body = file_get_contents('php://input');
                    $json = json_decode($body);
                    foreach ($json as $item => $value) {
                        $objeto->$item = $value;
                    }
                }
                $objeto->save();
                break;
            case 'DELETE':
                if ($controller == "User") {
                    $objeto->getByToken($token);
                    $objeto->delete();
                } else {
                    if (empty($id)) {
                        $http->setHTTPHeaders(400, new Response("Bad Request No ID"));
                        die();
                    }
                    $objeto->load($id);
                    $objeto->delete();
                }
                break;
        }
    } catch (Exception $ex) {
        echo "Error! " . $ex->getMessage();
    }
} else {
    require_once "functions/" . strtolower($controller) . ".php";
}
