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
require_once 'ClassBD/Post.php';


echo 'Hola Pacman : <br> ';

$usuario = new User();

$usuario->load(1);
echo "Aqui tenemos nombre Usuario: " . $usuario->getFirstName();

$project = new Project();

$project->load(1);

echo "<br> Fecha Final Proyecto: " . $project->getDateFinish();

$inscrip = new Inscription();

$inscrip->load(1);

echo "<br>Id Ins " . $inscrip->getEstado();

$post = new Post();

$post->setRemitter($usuario);
$post->setMessage("Hola Buenos Dias");
$post->save();