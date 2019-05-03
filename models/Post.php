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
    private $num_fields = 4;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("post", "idPost", $fields);
        $this->dataDay = date("Y-m-d H:i:s");
    }

    public function __get($name)
    {
        $metodo = "get$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo();
        } else {
            throw new Exception("Propiedad no encontrada: " . $metodo);
        }
    }

    public function __set($name, $value)
    {
        $metodo = "set$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo($value);
        } else {
            throw new Exception("Propiedad no encontrada: " . $metodo);
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
    public function setRemitter($remitter)
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
    public function setMessage($message)
    {
        echo $message;
        $this->message = $message;
    }

    /**
     * @return false|string
     */
    public function getDataDay()
    {
        return $this->dataDay;
    }

    public function setUserId($id)
    {
        $user = new User();
        $user->load($id);
        $this->remitter = $user;
    }

    /**
     * funcion para generar Usuarios en la Tabla.
     */
    public function save()
    {
        $post = $this->valores();
        unset($post["idPost"]);

        $post['remitter'] = $this->remitter->idUser;

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
                if ($field == "remitter") {
                    $usuario = new User();
                    $usuario->load($post['remitter']);
                    $this->$field = $usuario;
                } else {
                    $this->$field = $post["$field"];
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

    function getByProject($idProject)
    {
        $messageprojects = new MessageProject();
        $all = $messageprojects->getAll(["idProject" => $idProject]);
        $idPosts = [];
        for ($i = 0; $i < count($all); $i++) {
            $idPost = $all[$i]['idPost'][0];
            $idPosts[] = $idPost;
        }

        $st = self::$conn->prepare("select * from " . $this->table . " where idPost in (" . implode(",", $idPosts) . ")");
        $st->execute();
        $posts = $st->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < count($posts); $i++) {
            $post = $posts[$i];
            $usuario = new User();
            $usuario->load($post['remitter']);
            $posts[$i]['remitter'] = $usuario->serialize();
        }
        return $posts;
    }

}
