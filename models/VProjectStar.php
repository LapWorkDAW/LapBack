<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 2018-11-30
 * Time: 12:48
 */

class VProjectStar extends BDs
{
    private $idVoteStar;
    private $userVote;
    private $project;
    private $quantity; // 5 maximas

    private $num_fields = 4;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("voteprojectstar", "idVoteStar", $fields);
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
    public function getIdVoteStar()
    {
        return $this->idVoteStar;
    }

    /**
     * @return mixed
     */
    public function getuserVote()
    {
        return $this->userVote;
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
    public function setuserVote($user)
    {
        $this->userVote = $user;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }


    public function save()
    {
        $votos = $this->valores();
        unset($votos['idVoteStar']);

        $this->userVote->save();
        $votos["idUser"] = $this->userVote->idUser;
        unset($votos['userVote']);

        $this->project->save();
        $votos['idProject'] = $this->project->idProject;
        unset($votos['project']);

        if (empty($this->idVoteStar)) {
            $this->insert($votos);
            $this->idVoteStar = self::$conn->lastInsertId();
        } else {
            $this->update($this->idVoteStar, $votos);
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
                if ($field == "userVote"){
                    $usuario = new User();
                    $usuario->load($votos["idUser"]);
                    $this->$field = $usuario;
                } else if ($field == "project") {
                    $project = new Project();
                    $project->load($votos['idProject']);
                    $this->$field = $project;
                } else {
                    $this->$field = $votos["$field"];
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
}