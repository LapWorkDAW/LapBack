<?php
/**
 * Created by PhpStorm.
 * User: uriigrao
 * Date: 11/01/19
 * Time: 12:22
 */

#TODO: implementar metodo rest:

//headers obligate.
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');

$method = $_SERVER['REQUEST_METHOD'];

echo("aun va: " . $method);
switch ($method) {
    case 'GET':
        break;
    case 'PUT':
        break;
    case 'POST':
        break;
    case 'DELETE':
       break;
}