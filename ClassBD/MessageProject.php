<?php
/**
 * Created by PhpStorm.
 * user: UriiGrao
 * Date: 2018-11-29
 * Time: 12:24
 */
require_once 'BDs.php';

class MessageProject extends BDs
{
    private $idMessageProject;
    private $post; // POST
    private $project; // Proyecto al qual posteas.
    private $num_fields = 3;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("messageproject", "idMessageProject", $fields);
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
    public function getIdMessageProject()
    {
        return $this->idMessageProject;
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
    public function getProject()
    {
        return $this->project;
    }

    public function getProjectName()
    {
        return $this->project->getProjectName();
    }

    /**
     * @param mixed $post
     */
    public function setPost($post): void
    {
        $this->post = $post;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project): void
    {
        $this->project = $project;
    }

    /**
     * funcion para generar Mensajes del Proyecto en la Tabla.
     */
    public function save()
    {
        $msnP = $this->valores();
        unset($msnP['idMessageProject']);

        $this->project->save();
        $msnP['idProject'] = $this->project->idProject;
        unset($msnP['project']);

        $this->post->save();
        $msnP['idPost'] = $this->post->idPost;
        unset($msnP['post']);

        if (empty($this->idMessageProject)) {
            $this->insert($msnP);
            $this->idMessageProject = self::$conn->lastInsertId();
        } else {
            $this->update($this->idMessageProject, $msnP);
        }
    }

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    function load($id)
    {
        $msnP = $this->getById($id);
        if (!empty($msnP)) {
            foreach ($this->fields as $field) {
                if ($field == "project") {
                    $project = new Project();
                    $project->load($msnP['idProject']);
                    $this->$field = $project;
                } elseif ($field == "post") {
                    $post = new Post();
                    $post->load($msnP['idPost']);
                    $this->$field = $post;
                } else {
                    $this->$field = $msnP["$field"];
                }

            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }
}