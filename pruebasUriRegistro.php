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
require_once 'ClassBD/Message.php';


echo 'Hola Pacman<br> ';


/*
* AQUI TENEMOS COMO COGER UN JSON DE INSOMNIA
*
* $body = file_get_contents('php://input');
* $json = json_decode($body);
*/

/**
 * AQUI TENEMOS UN INSERT DE USUARIO
 *
 * $usuario->setUserName($a->userName);
 * $usuario->setPass($a->pass);
 * $usuario->setFirstName($a->firstname);
 * $usuario->setSurname($a->surname);
 * $usuario->setEmail($a->email);
 * $usuario->save();
 *
 * AQUI TENEMOS UN INSERT DE PROYECTO
 *
 * $project->setProjectName($json->projectName);
 * $project->setDateFinish($json->dateFinish);
 * $project->setDescription($json->descprition);
 * $project->setNameCreator($usuario->getFirstName() . " " . $usuario->getSurname());
 * $project->setIdType(5);
 * $project->setUserO($usuario);
 * $project->save();
 *
 * AQUI TENEMOS UN INSERT DE INSCRIPCION
 *
 * $inscrip->setUserO($usuario);
 * $inscrip->setProject($project);
 * $inscrip->save();
 *
 * AQUI TENEMOS UN INSERT DE POST
 * $post->setMessage($json->message);
 * $post->setRemitter($usuario);
 * $post->save();
 *
 * AQUI TENEMOS UN INSERT DE MESSAGE
 *
 * $msn->setReceiver($usuario);
 * $msn->setPost($post);
 * $msn->save();
 **/

$usuario = new User();
$usuario->load(1);
echo "Aqui tenemos nombre Usuario: " . $usuario->getFirstName();

$project = new Project();
$project->load(1);
echo "<br> Fecha Final Proyecto: " . $project->getDateFinish();

$body = file_get_contents('php://input');
$json = json_decode($body);


$inscrip = new Inscription();
$inscrip->load(1);
echo "<br>Estado de Inscripcion " . $inscrip->getEstado();


$body = file_get_contents('php://input');
$json = json_decode($body);

$post = new Post();
$post->load(1);
echo "<br>Mensaje : " . $post->getMessage();


$msn = new Message();
$msn->load(1);

