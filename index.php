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
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');

/* Lo Primer es obtener el controlador y el id */
$controller = filter_input(INPUT_GET, "controller");
$id = filter_input(INPUT_GET, "id");
$method = $_SERVER['REQUEST_METHOD'];
$http = new HTTP();

/* Si el controlador esta vacio, o no existem devolvemos un badrequest. */
if (empty($controller) || !file_exists("./models/" . $controller . ".php")) {
    $http = new HTTP();
    $http->setHTTPHeaders(400, new Response("Bad Request"));
    die();
}
// Creamos un objeto de tipo de la clase que nos da el frontEnd.
$objeto = new $controller;

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

            foreach ($json as $item => $value) {
                $objeto->$item = $value;
            }
            $objeto->save();
            break;
        case 'PUT':
            if (empty($id)) {
                $http->setHTTPHeaders(400, new Response("Bad Request"));
                die();
            }
            $objeto->load($id);
            $body = file_get_contents('php://input');
            $json = json_decode($body);
            foreach ($json as $item => $value) {
                $objeto->$item = $value;
            }
            $objeto->save();
            break;
        case 'DELETE':
            // Only have DELETE VProjectFav.
            if (empty($id)) {
                $http->setHttpHeaders(400, new Response("Bad request"));
                die();
            }
            $objeto->load($id);
            $objeto->delete($id);
            break;
    }
}catch (Exception $ex) {
    echo "Error! " . $ex->getMessage();

}