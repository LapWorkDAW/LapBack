<?php
/**
 * Created by PhpStorm.
 * user: UriiGrao
 * Date: 2018-11-29
 * Time: 12:54
 */
require_once 'BDs.php';

class Post extends BDs
{
    private $idPost;
    private $remitter;
    private $message;
    private $dataDay;
    private $numfields = 4;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("post", "idPost", $fields);
        $this->dataDay = date("Y-m-d");
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
    public function getIdPost()
    {
        return $this->idPost;
    }


    /**
     * @return mixed
     */
    public function getRemitter()
    {
        return $this->remitter;
    }

    /**
     * @param mixed $remitter
     */
    public function setRemitter($remitter): void
    {
        $this->remitter = $remitter;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return false|string
     */
    public function getDataDay()
    {
        return $this->dataDay;
    }

    /**
     * funcion para generar Usuarios en la Tabla.
     */
    public function save()
    {
        $this->userO->save();
        $post['idUser'] = $this->userO->idUser;

        if (empty($this->idPost)) {
            $this->insert($post);
            $this->idPost = self::$conn->lastInsertId();
        } else {
            $this->update($this->idPost, $post);
        }
    }

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    function load($id)
    {
        $post = $this->getById($id);
        if (!empty($post)) {
            foreach ($this->fields as $field) {
                $this->$field = $post["$field"];
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }
}