<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 21/11/2018
 * Time: 12:37
 */

require_once 'User.php';
require_once 'Project.php';
require_once 'BDs.php';

$usu1 = new User("Uryy95", "1234", "Oriol", "oriolgm95@gmail.com", "1995-08-11");
$usu1->save(); // Asi guardamos usuarios.
echo "Id" . $usu1->getIdUser();
$proyecto = new Project("firstMe", $usu1->getName(), $usu1->getIdUser());

echo $usu1->getName();
echo "<br>" . $proyecto->getName();
echo "<br>";
$proyecto->save(); // Asi guardamos proyectos