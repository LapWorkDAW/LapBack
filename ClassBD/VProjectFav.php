<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 2018-11-30
 * Time: 12:02
 */

class VProjectFav extends BDs
{
    private $id_voteFavourite;
    private $id_user;
    private $id_project;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("voteprojectfavourite", "id_voteFavourite", $fields);

    }

    /**
     * @return mixed
     */
    public function getIdVoteFavourite()
    {
        return $this->id_voteFavourite;
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
    public function getIdProject()
    {
        return $this->id_project;
    }

    /**
     * funcion para generar votos en la Tabla.
     */
    public function save()
    {
        $votos = $this->valores();
        unset($votos['id_votos']);
        if (empty($this->id_votos)) {
            $this->insert($votos);
            $this->id_votos = self::$conn->lastInsertId();
        } else {
            $this->update($this->id_votos, $votos);
        }
    }

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    function load($id)
    {
        $votos = $this->getById($id);
        if (!empty($votos)) {
            foreach ($this->fields as $field) {
                $this->$field = $votos["$field"];
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }
}