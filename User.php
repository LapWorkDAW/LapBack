<?php
/**
 * Created by PhpStorm.
 * User: uryy95
 * Date: 15/11/2018
 * Time: 19:45
 */

class User extends Tabla
{
    private $id_user; // int -> el id del usuario.
    private $name; // // String -> Nombre del Usuario.
    private $surname1; // String -> Apellido del usuario.
    private $surname2; // String -> Segundo apellido del usuario si tiene.
    private $location; // ??? -> Localizacion del Usuario ya puede ser ciudad pais o region
    private $userName; // String -> Nombre de Usuario para iniciar sesion tambien se puede usar correo.
    private $mail; // String -> Correo electronico del usuario.
    private $password; // String -> Sera cifrada + la contraseña del usuario
    private $picture; // ?? -> Foto del Usuario.
    private $birthDate; // Date -> Fecha de Nacimiento del usuario.
    private $description; // String -> Descripcion del usuario
    private $knowing; // String -> Conocimientos del usuario
    private $curriculum; // ?? > PDF del curriculum del usuario.

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
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
    public function getSurname1()
    {
        return $this->surname1;
    }

    /**
     * @param mixed $surname1
     */
    public function setSurname1($surname1)
    {
        $this->surname1 = $surname1;
    }

    /**
     * @return mixed
     */
    public function getSurname2()
    {
        return $this->surname2;
    }

    /**
     * @param mixed $surname2
     */
    public function setSurname2($surname2)
    {
        $this->surname2 = $surname2;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
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
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
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
    public function getKnowing()
    {
        return $this->knowing;
    }

    /**
     * @param mixed $knowing
     */
    public function setKnowing($knowing)
    {
        $this->knowing = $knowing;
    }

    /**
     * @return mixed
     */
    public function getCurriculum()
    {
        return $this->curriculum;
    }

    /**
     * @param mixed $curriculum
     */
    public function setCurriculum($curriculum)
    {
        $this->curriculum = $curriculum;
    }


}