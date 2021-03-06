<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 2018-11-30
 * Time: 12:57
 */

class VoteUser extends BDs
{
    private $idVoteUser;
    private $userVote; // votante
    private $candidate; // candidato
    private $quantity; // estrellas.
    private $num_fields = 4;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("voteuser", "idVoteUser", $fields);
    }

    function __get($name)
    {
        $metodo = "get$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo();
        } else {
            throw new Exception("Propiedad no encontrada");
        }
    }

    function __set($name, $value)
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
    public function getIdVoteUser()
    {
        return $this->idVoteUser;
    }

    /**
     * @return mixed
     */
    public function getUserVote()
    {
        return $this->userVote;
    }

    /**
     * @param mixed $userVote
     */
    public function setUserVote($userVote)
    {
        $this->userVote = $userVote;
    }

    /**
     * @return mixed
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @param mixed $candidate
     */
    public function setCandidate($candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * funcion para generar votos en la Tabla.
     */
    public function save()
    {
        $voteU = $this->valores();
        unset($voteU["idVoteUser"]);

        $voteU['idUserVote'] = $this->userVote->idUser;
        unset($voteU['userVote']);

        $voteU['idCandidate'] = $this->candidate->idUser;
        unset($voteU['candidate']);

        if (empty($this->idVoteUser)) {
            $this->insert($voteU);
            $this->idVoteUser = self::$conn->lastInsertId();
        } else {
            $this->update($this->idVoteUser, $voteU);
        }
    }

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    function load($id)
    {
        $voteU = $this->getById($id);
        if (!empty($voteU)) {
            foreach ($this->fields as $field) {
                if ($field == "userVote") {
                    $usuario = new User();
                    $usuario->load($voteU["idUserVote"]);
                    $this->$field = $usuario;
                } else if ($field == "candidate") {
                    $usuario2 = new User();
                    $usuario2->load($voteU["idCandidate"]);
                    $this->$field = $usuario2;
                } else {
                    $this->$field = $voteU["$field"];
                }
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function delete()
    {
        $this->deleteById($this->getIdVoteUser);
        if (!empty($this)) {
            foreach ($this->fields as $field) {
                $this->$field = null;
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function allVotes($idUserVotado)
    {
        $values = $this->getAll(['idCandidate' => $idUserVotado]);
        $average = 0;
        foreach ($values as $value) {
            $average += $value['quantity'];
        }
        if ($average == 0) {
            return "This User don't Have votes";
        } else {
            return $average / count($values);
        }
    }

    public function setUserId($id)
    {
        $user = new User();
        $user->load($id);
        $this->usuario = $user;
    }
}
