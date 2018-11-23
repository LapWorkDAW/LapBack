<?php
/**
 * Created by PhpStorm.
 * User: uryy95
 * Date: 15/11/2018
 * Time: 19:58
 */
require_once 'BDs.php';

class Project extends BDs
{
    private $id_project; // Int -> id del Proyecto.
    private $id_user;  // Int -> id del Usuario que a creado Proyecto.
    private $nameCreator; //String -> Nombre del Usuario que creo proyecto.
    private $projectName; // String -> Nombre del Proyecto.
    private $id_type; // entero ? Tipo del Proyecto.
    private $description; //String -> descripcion del Proyecto.
    private $dateStart; //date  -> Fecha inicio Proyecto
    private $dateFinish; //date -> Fecha final del Proyecto si esta acabado.
    private $img; // ? -> fotos del proyecto.
    private $projectStatus;  // int. -> estado del Proyecto si acabado o no. // Si es 0 proyecto no acabado.
    private $num_fields = 10;

    public function __construct($projectName, $nameCreator, $id_user)
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("project", "id_project", $fields);
        $this->projectName = $projectName;
        $this->nameCreator = $nameCreator;
        $this->dateStart = date("Y-m-d");
        $this->projectStatus = 0;
        $this->id_user = $id_user;
        $this->id_type = 2;
        $this->dateFinish = '2019-01-01'; // He puesto esta para poder registrar pero esto se tendra que poner por la funcion.
    }

    /**
     * Coger id del proyecto
     * @return mixed
     */
    public function getIdProject()
    {
        return $this->id_project;
    }

    /**
     * Coger id Usuario que creo Proyecto
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * Coger Nombre proyecto
     * @return mixed
     */
    public function getName()
    {
        return $this->projectName;
    }

    /**
     * Id del Proyecto
     * @return mixed
     */
    public function getType()
    {
        return $this->id_type;
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
        return $this->dateStart;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->dateStart = $startDate;
    }

    /**
     * @return mixed
     */
    public function getFinalDate()
    {
        return $this->dateFinish;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->img;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->img = $picture;
    }


    /**
     * @return mixed
     */
    public function isStatus()
    {
        return $this->projectStatus;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->projectStatus = $status;
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
        $project = $this->valores();
        unset($project['id_project']);
        if (empty($this->id_project)) {
            $this->insert($project);
            $this->id_project = self::$conn->lastInsertId();
        } else {
            $this->update($this->id_project, $project);
        }
    }

}