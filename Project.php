<?php
/**
 * Created by PhpStorm.
 * User: uryy95
 * Date: 15/11/2018
 * Time: 19:58
 */

class Project extends Tabla
{
    private $idProject; // Int -> id del Proyecto.
    private $idUser;  // Int -> id del Usuario que a creado Proyecto.
    private $name; //String -> Nombre Proyecto.
    private $type; // entero ? Tipo del Proyecto.
    private $description; //String -> descripcion del Proyecto.
    private $startDate; //date  -> Fecha inicio Proyecto
    private $finalDate; //date -> Fecha final del Proyecto si esta acabado.
    private $picture; // ? -> fotos del proyecto.
    private $post;  //
    private $status; // boolean. -> estado del Proyecto si acabado o no.

    /**
     * @return mixed
     */
    public function getIdProject()
    {
        return $this->idProject;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getFinalDate()
    {
        return $this->finalDate;
    }

    /**
     * @param mixed $finalDate
     */
    public function setFinalDate($finalDate)
    {
        $this->finalDate = $finalDate;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return mixed
     */
    public function isStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }



}