<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 2018-11-30
 * Time: 12:02
 */

class VProjectFav extends BDs
{
    private $idVoteFavourite;
    private $userVote;
    private $project;
    private $num_fields = 3;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("voteprojectfavourite", "idVoteFavourite", $fields);
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
    public function getIdVoteFavourite()
    {
        return $this->idVoteFavourite;
    }

    /**
     * @return mixed
     */
    public function getUserVote()
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
     * @param mixed $user
     */
    public function setUserVote($user)
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
     * funcion para generar votos en la Tabla.
     */
    public function save()
    {
        $votos = $this->valores();
        unset($votos['idVoteFavourite']);

        $votos["idUser"] = $this->userVote->idUser;
        unset($votos['userVote']);

        $votos['idProject'] = $this->project->idProject;
        unset($votos['project']);

        if (empty($this->idVoteFavourite)) {
            $this->insert($votos);
            $this->idVoteFavourite = self::$conn->lastInsertId();
        } else {
            $this->update($this->idVoteFavourite, $votos);
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
                if ($field == "userVote") {
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
        $this->deleteById($this->getIdVoteFavourite());
        if (!empty($this)) {
            foreach ($this->fields as $field) {
                $this->$field = null;
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function allVotes($idProject)
    {
        $values = $this->getAll(['idProject' => $idProject]);
        $average = 0;
        foreach ($values as $value) {
            $average += 1;
        }
        if ($average == 0) {
            return 0;
        } else {
            return $average;
        }
    }

    function votebyUser($idUser, $idProject)
    {
        $dates = $this->getAll(['idUser' => $idUser, 'idProject' => $idProject]);
        if (count($dates) == 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function unLike($idUser, $idProject)
    {
        $this->getAll(['idUser' => $idUser, 'idProject' => $idProject]);
        print_r($this);
        die();
    }

    public function allLikes($idUser)
    {
        $users = $this->getAll(['idUser' => $idUser]);
        for ($i = 0; $i < count($users); $i++) {
            $user = $users[$i];
            $project = new Project();
            $project->load($user['idProject']);
            $users[$i]['project'] = $project->serialize();
        }
        return $users;
    }


    public
    function setUserId($id)
    {
        $user = new User();
        $user->load($id);
        $this->usuario = $user;
    }

    public
    function setProjectId($id)
    {
        $project = new Project();
        $project->load($id);
        $this->project = $project;
    }
}
