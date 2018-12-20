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
require_once 'ClassBD/MessageProject.php';
require_once 'ClassBD/Portfolio.php';
require_once 'ClassBD/Team.php';
require_once 'ClassBD/VoteUser.php';


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
 *
 * AQUI TENEMOS UN INSERT DE MESSAGEPROJECT
 *
 * $msnProject->setProject($project);
 * $msnProject->setPost($post);
 * $msnProject->save();
 *
 * AQUI TENEMOS UN INSERT DE PORTFOLIO
 *
 * $portfolio->setUsuario($usuario);
 * $portfolio->setArchive($json->archive);
 * $portfolio->save();
 *
 * AQUI TENEMOS UN INSERT DEL USUARIO EN EL PROYECTO (TEAM)
 *
 * $team->setProject($project);
 * $team->setUsuario($usuario);
 * $team->save();
 **/

$body = file_get_contents('php://input');
$json = json_decode($body);


/**
 * Pruebas de Loads...
 */
$usuario = new User();
$usuario->load(1);
echo "Aqui tenemos nombre Usuario: 1. " . $usuario->getFirstName();

$user2 = new User();
$user2->load(2);
echo "<br> Aqui tenemos nombre Usuario: 2. " . $user2->getFirstName();


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
echo "<br> receptor es: " . $msn->getReceiverName();

$msnProject = new MessageProject();
$msnProject->load(1);
echo "<br> proyecto mensajeado es: " . $msnProject->getProjectName();

$portfolio = new Portfolio();
$portfolio->load(1);
echo "<br> Archivo: " . $portfolio->getArchive();

$team = new Team();
$team->load(1);
echo "<br> Nombre Proyecto: " . $team->getProjectName();
echo "<br>       ->  Miembro: " . $team->getUserName();

$voteU = new VoteUser();
$voteU->setQuantity(5);
$voteU->setUserVote($user2);
$voteU->setCandidate($usuario);
$voteU->save();
