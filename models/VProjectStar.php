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

        $votos["idUser"] = $this->userVote->idUser;
        unset($votos['userVote']);

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

    function loadAll()
    {
        $vprojects = parent::loadAll();
        for ($i = 0; $i < count($vprojects); $i++) {
            $vproject = $vprojects[$i];
            $user = new User();
            $user->load($vproject["idUser"]);
            $vprojects[$i]['user'] = $user->serialize();
            $project = new Project();
            $project->load($vproject['idProject']);
            $vprojects[$i]['project'] = $project->serialize();
        }
        return $vprojects;
    }

    function delete()
    {
        return false;
    }

    function allVotes($idProjectVotado)
    {
        $values = $this->getAll(['idProject' => $idProjectVotado]);
        $average = 0;
        foreach ($values as $value) {
            $average += $value['quantity'];
        }
        if ($average == 0) {
            return 0;
        } else {
            return round($average / count($values), 1);
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

    public function allStars($idUser)
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
