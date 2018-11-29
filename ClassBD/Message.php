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
    private $id_message;
    private $id_post;
    private $receiver;
    private $num_fields = 3;

    public function __construct($id_post, $receiver)
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);

        parent::__construct("message", "id_message", $fields);
    }

    /**
     * @return mixed
     */
    public function getIdMessage()
    {
        return $this->id_message;
    }

    /**
     * @return mixed
     */
    public function getIdPost()
    {
        return $this->id_post;
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
        unset($msn['id_message']);
        if (empty($this->id_message)) {
            $this->insert($msn);
            $this->id_message = self::$conn->lastInsertId();
        } else {
            $this->update($this->id_user, $msn);
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