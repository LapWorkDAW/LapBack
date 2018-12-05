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
    private $id_post;
    private $remitter;
    private $message;
    private $dataDay;
    private $numfields = 4;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("post", "id_post", $fields);
        $this->dataDay = date("Y-m-d");
    }

    /**
     * funcion para generar Usuarios en la Tabla.
     */
    public function save()
    {
        $post = $this->valores();
        unset($post['id_post']);
        if (empty($this->id_post)) {
            $this->insert($post);
            $this->id_post = self::$conn->lastInsertId();
        } else {
            $this->update($this->id_post, $post);
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