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

function saveTeam($json)
{
    $object = new Team();
    foreach ($json as $item => $value) {
        if ($item == 'idUser') {
            $object->setUserId($value);
        } else if ($item == 'idProject') {
            $object->setProjectId($value);
        } else {
            $object->$item = $value;
        }
    }
    return $object;
}

function saveVoteUser($json)
{
    $object = new VoteUser();
    foreach ($json as $item => $value) {
        if ($item == 'idUserVote') {
            $object->setUserId($value);
        } else if ($item == 'idCandidate') {
            $object->setUserId($value);
        } else {
            $object->$item = $value;
        }
    }
    return $object;
}

function saveProjectFav($json){
    $object = new VProjectFav();
    foreach ($json as $item => $value) {
        if ($item == 'idUser') {
            $object->setUserId($value);
        } else if ($item == 'idProject') {
            $object->setProjectId($value);
        } else {
            $object->$item = $value;
        }
    }
    return $object;
}

function saveProjectStar($json){
    $object = new VProjectStar();
    foreach ($json as $item => $value) {
        if ($item == 'idUser') {
            $object->setUserId($value);
        } else if ($item == 'idProject') {
            $object->setProjectId($value);
        } else {
            $object->$item = $value;
        }
    }
    return $object;
}
