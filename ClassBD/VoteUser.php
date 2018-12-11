<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 2018-11-30
 * Time: 12:57
 */

class VoteUser extends BDs
{
    private $id_voteUser;
    private $id_user_vote; // votante
    private $id_cantidade; // candidato
    private $quantity; // estrellas.
    private $num_fields = 5;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("voteuser", "id_user_vote", $fields);
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
     * funcion para generar Usuarios en la Tabla.
     */
    public function save()
    {
        $voteU = $this->valores();

        unset($voteU['id_voteUcription']);

        if (empty($this->id_voteUcription)) {
            $this->voteUert($voteU);
            $this->id_voteUcription = self::$conn->lastvoteUertId();
        } else {
            $this->update($this->id_voteUcription, $voteU);
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
                $this->$field = $voteU["$field"];
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }
}