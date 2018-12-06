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
    private $user;
    private $project;
    private $quantity; // 5 maximas

    private $num_shields = 4;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("voteprojectstar", "id_voteStar", $fields);
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
     * @return int
     */
    public function getNumShields(): int
    {
        return $this->num_shields;
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
    public function getUser()
    {
        return $this->user;
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
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project): void
    {
        $this->project = $project;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
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