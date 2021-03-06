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
    private $idMessage;
    private $post; // guardamos el post.
    private $receiver;
    private $num_fields = 3;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("message", "idMessage", $fields);
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
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver)
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
     * Metodo para devolver como String el nombre y apellido del receiver.
     */
    public function getReceiverName()
    {
        return $this->receiver->getFirstName() . " " . $this->receiver->getSurname();
    }

    /**
     * funcion para generar Mensajes en la Tabla.
     */
    public function save()
    {
        $msn = $this->valores();
        unset($msn["idMessage"]);

        $msn['receiver'] = $this->receiver->idUser;

        $msn['idPost'] = $this->post->idPost;
        unset($msn['post']);

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
                if ($field == "receiver") {
                    $usuario = new User();
                    $usuario->load($msn['receiver']);
                    $this->$field = $usuario;
                } else if ($field == "post") {
                    $post = new Post();
                    $post->load($msn['idPost']);
                    $this->$field = $post;
                } else {
                    $this->$field = $msn["$field"];
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
