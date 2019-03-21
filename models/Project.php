<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 15/11/2018
 * Time: 19:58
 */
require_once 'BDs.php';
require_once "User.php";

class Project extends BDs
{
    private $idProject; // Int -> id del Proyecto.
    private $userO;  // Usuario que crea el proyecto.
    private $nameCreator; //String -> Nombre del Usuario que creo proyecto.
    private $projectName; // String -> Nombre del Proyecto.
    private $idType; // Tipo de proyecto que creamos.
    private $description; //String -> descripcion del Proyecto.
    private $dateStart; //date  -> Fecha inicio Proyecto
    private $dateFinish; //date -> Fecha final del Proyecto si esta acabado.
    private $img; // ? -> fotos del proyecto.
    private $projectStatus;  // int. -> estado del Proyecto si acabado o no. // Si es 0 proyecto no acabado.
    // 0 -> Sin acabar 1 -> Acabado
    private $num_fields = 10;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("project", "idProject", $fields);
        $this->dateStart = date("Y/m/d");
        $this->projectStatus = 1;
    }

    function __get($name)
    {
        $metodo = "get$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo();
        } else {
            throw new Exception("Propiedad no encontrada " . $name);
        }
    }

    function __set($name, $value)
    {
        $metodo = "set$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo($value);
        } else {
            throw new Exception("Propiedad no encontrada " . $name);
        }
    }

    /**
     * Coger id del proyecto
     * @return mixed
     */
    public function getIdProject()
    {
        return $this->idProject;
    }

    /**
     * Coger id Usuario que creo Proyecto
     * @return mixed
     */
    public function getUserO()
    {
        return $this->userO;
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
    public function getIdType()
    {
        return $this->idType;
    }

    /**
     * @param mixed $idType
     */
    public function setIdType($idType)
    {
        $this->idType = $idType;
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
    public function getNumFields()
    {
        return $this->num_fields;
    }

    /**
     * @param mixed $user
     */
    public function setUserO($user)
    {
        $this->userO = $user;
    }

    public function setUserId($id)
    {
        $user = new User();
        $user->load($id);
        $this->userO = $user;
    }

    public function setNameCreatorByUser()
    {
        $this->nameCreator = $this->userO->getFirstName() . " " . $this->userO->getSurname();
    }

    /**
     * @param mixed $nameCreator
     */
    public function setNameCreator($nameCreator)
    {
        $this->nameCreator = $nameCreator;
    }

    /**
     * @param mixed $projectName
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
    }

    /**
     * @param mixed $dateStart
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @param mixed $dateFinish
     */
    public function setDateFinish($dateFinish)
    {
        $this->dateFinish = $dateFinish;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @param mixed $projectStatus
     */
    public function setProjectStatus($projectStatus)
    {
        $this->projectStatus = $projectStatus;
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
        //var_dump($project);
        unset($project['idProject']);

        $this->userO->save();
        $project['idUser'] = $this->userO->idUser;
        unset($project['userO']);

        if (empty($this->idProject)) {
            $this->insert($project);
            $this->idProject = self::$conn->lastInsertId();
        } else {
            $this->update($this->idProject, $project);
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
                if ($field == "userO") {
                    $usuario = new User();
                    $usuario->load($project['idUser']);
                    $this->$field = $usuario;
                } else {
                    $this->$field = $project["$field"];
                }
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function delete()
    {
        return false;
    }

    public function getNoFinish()
    {
        $project = $this->getAll(['projectStatus' => 0]);
        if (!empty($project)) {
            return $project;
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    public function getFinish()
    {
        $project = $this->getAll(['projectStatus' => 1]);
        if (!empty($project)) {
            return $project;
        } else {
            throw new Exception("No existe ese registro");
        }
    }
}
