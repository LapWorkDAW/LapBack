<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 2018-11-30
 * Time: 11:50
 */
require_once 'BDs.php';;

class Team extends BDs
{
    private $idTeam;
    private $project; // proyecto al cual le ponemos los miembros.
    private $usuario; // Usuario que queremos que se una al equipo del proyecto.

    private $num_fields = 3;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("team", "idTeam", $fields);
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
     * @return mixed
     */
    public function getIdTeam()
    {
        return $this->idTeam;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    public function getProjectName()
    {
        return $this->project->getProjectName();
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getUserName()
    {
        return $this->usuario->getFirstName() . " " . $this->usuario->getSurname();
    }

    /**
     * @param mixed $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @param mixed $user
     */
    public function setUsuario($user)
    {
        $this->usuario = $user;
    }

    /**
     * funcion para generar Teams en la Tabla.
     */
    public function save()
    {
        $team = $this->valores();
        unset($team['idTeam']);

        $this->usuario->save();
        $team['idUser'] = $this->usuario->idUser;
        unset($team['usuario']);


        $this->project->save();
        $team['idProject'] = $this->project->idProject;
        unset($team['project']);

        if (empty($this->idTeam)) {
            $this->insert($team);
            $this->idTeam = self::$conn->lastInsertId();
        } else {
            $this->update($this->idTeam, $team);
        }
    }

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    function load($id)
    {
        $team = $this->getById($id);
        if (!empty($team)) {
            foreach ($this->fields as $field) {
                if ($field == "usuario") {
                    $usuario = new User();
                    $usuario->load($team['idUser']);
                    $this->$field = $usuario;
                } elseif ($field == "project") {
                    $project = new Project();
                    $project->load($team['idProject']);
                    $this->$field = $project;
                } else {
                    $this->$field = $team["$field"];
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

    function allTeam($idProject) {
        $users = $this->getAll(['idProject' => $idProject]);
        $newList = Array();

        if (!empty($users)) {
            foreach ($users as $user){
                $object = new User();
                $object->load($user['idUser']);
                array_push($newList, $object->toArray());
            }
            return $newList;
        } else {
            throw new Exception("This Project don't have Team");
        }
    }

    public function setUserId($id)
    {
        $user = new User();
        $user->load($id);
        $this->usuario = $user;
    }

    public function setProjectId($id)
    {
        $project = new Project();
        $project->load($id);
        $this->project = $project;
    }
}
