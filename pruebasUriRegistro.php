<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 21/11/2018
 * Time: 12:37
 */

require_once 'ClassBD/User.php';
require_once 'ClassBD/Project.php';
require_once 'ClassBD/BDs.php';
require_once 'ClassBD/Inscription.php';


echo 'Hola Pacman : ';

$name = $_GET['name'];


$usuario = new User();

$usuario->setName($name);


echo $name;
