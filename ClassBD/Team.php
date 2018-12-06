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
    private $id_team;
    private $project; // proyecto al cual le ponemos los miembros.
    private $user; // Usuario que queremos que se una al equipo del proyecto.

    private $num_fields = 3;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("team", "id_team", $fields);
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
        return $this->id_team;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project): void
    {
        $this->project = $project;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * funcion para generar Teams en la Tabla.
     */
    public function save()
    {
        $team = $this->valores();
        unset($team['id_team']);
        if (empty($this->id_team)) {
            $this->insert($team);
            $this->id_team = self::$conn->lastInsertId();
        } else {
            $this->update($this->id_team, $team);
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
                $this->$field = $team["$field"];
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }

}