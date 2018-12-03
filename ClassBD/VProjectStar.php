<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 2018-11-30
 * Time: 12:48
 */

class VProjectStar extends BDs
{
    private $id_voteStar;
    private $id_user;
    private $id_project;
    private $quantity; // 5 maximas

    private $num_shields = 4;

    public function __construct($id_user, $id_project, $quantity)
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("voteprojectstar", "id_voteStar", $fields);

        $this->id_project = $id_project;
        $this->id_user = $id_user;
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getIdVoteStar()
    {
        return $this->id_voteStar;
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
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }


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