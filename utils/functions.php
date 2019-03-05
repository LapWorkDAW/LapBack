<?php
/**
 * Created by PhpStorm.
 * User: alu2017375
 * Date: 2019-02-15
 * Time: 12:41
 */

foreach (glob("models/*.php") as $filename) {
    require_once $filename;
}

function saveProject($json)
{
    $objeto = new Project();
    foreach ($json as $item => $value) {
        if ($item == 'idUser') {
            $objeto->setUserId($value);
        } else {
            $objeto->setNameCreatorByUser();
            $objeto->$item = $value;
        }
    }
    return $objeto;
}

function saveInscription($json)
{
    $objeto = new Inscription();
    foreach ($json as $item => $value) {
        if ($item == 'idUser') {
            $objeto->setUserId($value);
        } else if ($item == 'idProject') {
            $objeto->setProjectId($value);
        } else {
            $objeto->$item = $value;
        }
    }
    return $objeto;
}

function savePost($json)
{
    $object = new Post();
    foreach ($json as $item => $value) {
        if ($item == 'remitter') {
            $object->setUserId($value);
        } else {
            $object->$item = $value;
        }
    }
    return $object;

}
