<?php
/**
 * Created by PhpStorm.
 * User: uryy95
 * Date: 15/11/2018
 * Time: 19:45
 */
require_once 'BDs.php';

class User extends BDs
{

    private $id_user; // int -> el id del usuario.
    private $firstname; // // String -> Nombre del Usuario.
    private $surname; // String -> Apellido del usuario.
    private $latitude; // ??? -> Cordenadas
    private $longitude; // ??? -> Cordenadas
    private $username; // String -> Nombre de Usuario para iniciar sesion tambien se puede usar correo.
    private $email; // String -> Correo electronico del usuario.
    private $pass; // String -> Sera cifrada + la contraseña del usuario
    private $photo; // ?? -> Foto del Usuario.
    private $birthdate; // Date -> Fecha de Nacimiento del usuario.
    private $description; // String -> Descripcion del usuario
    private $knowledge; // String -> Conocimientos del usuario
    private $cv; // ?? > PDF del curriculum del usuario.
    private $isActiv; // bool -> Para saber si el usuario esta activo o No!.
    private $saveName; // bool -> Para saber si quieren guardar su nombre o no.
    private $num_fields = 15;

    public function __construct($userName, $password, $name, $mail, $birthDate)
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("usuario", "id_user", $fields);
        $this->firstname = $name;
        $this->username = $userName;
        $this->pass = $password;
        $this->email = $mail;
        $this->birthdate = $birthDate;
        $this->isActiv = 0;
    }


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
        return $this->firstname;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->firstname = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname1
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }


    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->email;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->email = $mail;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $picture
     */
    public function setPhoto($picture)
    {
        $this->photo = $picture;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthdate($birthDate)
    {
        $this->birthdate = $birthDate;
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
    public function getKnowledge()
    {
        return $this->knowledge;
    }

    /**
     * @param mixed $knowing
     */
    public function setKnowledge($knowing)
    {
        $this->knowledge = $knowing;
    }

    /**
     * @return mixed
     */
    public function getCurriculum()
    {
        return $this->cv;
    }

    /**
     * @param mixed $curriculum
     */
    public function setCurriculum($curriculum)
    {
        $this->cvs = $curriculum;
    }

    /**
     * funcion para coger los valores de la BD. La usamos en el Save...
     * @return array
     */
    private function valores()
    {

        $valores = array_map(function ($v) {
            return $this->$v;
        }, $this->fields);
        return array_combine($this->fields, $valores);
    }

    /**
     * funcion para generar Usuarios en la Tabla.
     */
    public function save()
    {
        $user = $this->valores();
        unset($user['id_user']);
        if (empty($this->id_user)) {
            $this->insert($user);
            $this->id_user = self::$conn->lastInsertId();
        } else {
            $this->update($this->id_user, $user);
        }
    }
}