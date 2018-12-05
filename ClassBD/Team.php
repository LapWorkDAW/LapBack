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
    private $id_project;
    private $id_user;

    private $num_fields = 3;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("team", "id_team", $fields);
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
    public function getIdProject()
    {
        return $this->id_project;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
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