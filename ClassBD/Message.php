<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 2018-11-29
 * Time: 12:11
 */
require_once 'BDs.php';

class Message extends BDs
{
    private $post; // guardamos el post.
    private $idMessage;
    private $receiver;
    private $num_fields = 3;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("message", "id_message", $fields);
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
     * @param mixed $post
     */
    public function setPost($post): void
    {
        $this->post = $post;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return mixed
     */
    public function getIdMessage()
    {
        return $this->idMessage;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * funcion para generar Mensajes en la Tabla.
     */
    public function save()
    {
        $msn = $this->valores();
        unset($msn['idMessage']);
        if (empty($this->idMessage)) {
            $this->insert($msn);
            $this->idMessage = self::$conn->lastInsertId();
        } else {
            $this->update($this->idMessage, $msn);
        }
    }

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    function load($id)
    {
        $msn = $this->getById($id);
        if (!empty($msn)) {
            foreach ($this->fields as $field) {
                $this->$field = $msn["$field"];
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }
}