<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 21/11/2018
 * Time: 12:37
 */

require_once 'User.php';
require_once 'Project.php';
require_once 'Table.php';

$usu1 = new User("Uryy95", "1234", "Oriol", "oriolgm95@gmail.com", "1995-08-11");

echo $usu1->getName();