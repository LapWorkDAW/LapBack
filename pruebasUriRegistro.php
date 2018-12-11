<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 21/11/2018
 * Time: 12:37
 */

require_once 'ClassBD/User.php';
require_once 'ClassBD/Project.php';
require_once 'ClassBD/Inscription.php';


echo 'Hola Pacman : <br> ';

$usuario = new User();

$usuario->load(6);

echo "Aqui tenemos nombre Usuario: " . $usuario->getName();

$project = new Project();

$project->setUserO($usuario);
$project->setProjectName("firstProject");
$project->setNameCreator("" . $usuario->getName()
    . " " . $usuario->getSurname());
$project->setType(5);
$project->setDateFinish("2018-12-21");

echo "<br> Fecha Final Proyecto: " . $project->getDateFinish();

$project->save();