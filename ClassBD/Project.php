<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 15/11/2018
 * Time: 19:58
 */
require_once 'BDs.php';

class Project extends BDs
{
    private $id_project; // Int -> id del Proyecto.
    private $user;  // Usuario que crea el proyecto.
    private $nameCreator; //String -> Nombre del Usuario que creo proyecto.
    private $projectName; // String -> Nombre del Proyecto.
    private $type; // Tipo de proyecto que creamos.
    private $description; //String -> descripcion del Proyecto.
    private $dateStart; //date  -> Fecha inicio Proyecto
    private $dateFinish; //date -> Fecha final del Proyecto si esta acabado.
    private $img; // ? -> fotos del proyecto.
    private $projectStatus;  // int. -> estado del Proyecto si acabado o no. // Si es 0 proyecto no acabado.
    private $num_fields = 10;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("project", "id_project", $fields);

    }

    public function __get($name)
    {
        $metodo = "get$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo();
        } else {
            throw new Exception("Propiedad no encontrada");
        }
    }

    public function __set($name, $value)
    {
        $metodo = "set$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo($value);
        } else {
            throw new Exception("Propiedad no encontrada");
        }
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @return mixed
     */
    public function getDateFinish()
    {
        return $this->dateFinish;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @return mixed
     */
    public function getProjectStatus()
    {
        return $this->projectStatus;
    }

    /**
     * @return int
     */
    public function getNumFields(): int
    {
        return $this->num_fields;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @param mixed $nameCreator
     */
    public function setNameCreator($nameCreator): void
    {
        $this->nameCreator = $nameCreator;
    }

    /**
     * @param mixed $projectName
     */
    public function setProjectName($projectName): void
    {
        $this->projectName = $projectName;
    }

    /**
     * @param mixed $dateStart
     */
    public function setDateStart($dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @param mixed $dateFinish
     */
    public function setDateFinish($dateFinish): void
    {
        $this->dateFinish = $dateFinish;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img): void
    {
        $this->img = $img;
    }

    /**
     * @param mixed $projectStatus
     */
    public function setProjectStatus($projectStatus): void
    {
        $this->projectStatus = $projectStatus;
    }

    /**
     * @param int $num_fields
     */
    public function setNumFields(int $num_fields): void
    {
        $this->num_fields = $num_fields;
    }


    /**
     * Coger Nombre proyecto
     * @return mixed
     */
    public function getName()
    {
        return $this->projectName;
    }

    public function getNameCreator()
    {
        return $this->nameCreator;
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

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    function load($id)
    {
        $project = $this->getById($id);
        if (!empty($project)) {
            foreach ($this->fields as $field) {
                $this->$field = $project["$field"];
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }
}