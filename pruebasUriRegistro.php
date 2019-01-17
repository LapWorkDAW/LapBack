<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 21/11/2018
 * Time: 12:37
 */

require_once 'models/User.php';
require_once 'models/Project.php';
require_once 'models/Inscription.php';
require_once 'models/Post.php';
require_once 'models/Message.php';
require_once 'models/MessageProject.php';
require_once 'models/Portfolio.php';
require_once 'models/Team.php';
require_once 'models/VoteUser.php';
require_once 'models/VProjectFav.php';
require_once 'models/VProjectStar.php';


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
 * $project->setDateFinish($json->dateFinish); // "Y/m/d"
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
 *
 * AQUI TENEMOS UN INSERT DE UN USUARIO VOTANDO A OTRO
 *
 * $voteU->setQuantity(5);
 * $voteU->setUserVote($user2);
 * $voteU->setCandidate($usuario);
 * $voteU->save();
 *
 * AQUI TENEMOS UN INSERT DE UN USUARIO VOTANDO UN PROYECTO CON FAV
 * $voteFav->setProject($project);
 * $voteFav->setUserO($usuario);
 * $voteFav->save();
 *
 * AQUI TENEMOS UN INSERT DE UN USUARIO VOTANDO UN PROYECTO CON STARS
 * $voteStar->setProject($project);
 * $voteStar->setUserO($usuario);
 * $voteStar->setQuantity(5);
 * $voteStar->save();
 **/

$body = file_get_contents('php://input');
$json = json_decode($body);


// Pruebas de Loads...

$usuario = new User();
$usuario->load(1);
echo "Aqui tenemos nombre Usuario: 1. " . $usuario->getFirstName();


$project = new Project();
$project->load(1);
echo "<br> Fecha Final Proyecto: " . $project->getDateFinish();


$user2 = new User();
$user2->load(2);
echo "<br> Aqui tenemos nombre Usuario: 2. " . $user2->getFirstName();


$inscrip = new Inscription();
$inscrip->load(1);
echo "<br>Estado de Inscripcion " . $inscrip->getEstado();


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
$team2 = new Team();
$team->load(1);
$team2->load(2);
echo "<br> Nombre Proyecto: " . $team->getProjectName();
echo "<br>       ->  Miembro: " . $team->getUserName();
echo "<br>       ->  Miembro: " . $team2->getUserName();


$voteU = new VoteUser();
$voteU->load(1);
echo "<br>Votante: " . $voteU->getUserVote()->getUserName() . " _ ";
echo "Candidato: " . $voteU->getCandidate()->getUserName() . " - ";
echo "Quantity: " . $voteU->getQuantity();

$voteFav = new VProjectFav();
$voteFav->load(1);
echo " <br> El usuario: " . $voteFav->getUserVote()->getFirstName();
echo " ha votado al proyecto: " . $voteFav->getProject()->getProjectName();

$voteStar = new VProjectStar();
$voteStar->load(1);
echo "<br> El usuario: " . $voteStar->getUserVote()->getFirstName();
echo " ha votado al proyecto: " . $voteStar->getProject()->getProjectName();
echo " y le ha dado: " . $voteStar->getQuantity() . " estrellas";
