<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 28/11/2018
 * Time: 12:56
 */
require_once 'BDs.php';

class Inscription extends BDs
{
    protected $id_inscription; // id de la inscripcion.
    protected $user; // Guardaremos el usuario inscrito en el proyecto.
    protected $project; // Guardaremos el proyecto al cual se registra el usuario.
    protected $estado; // estado del usuario al proyecto.
    // 0 = en espera.
    // 1 = aceptado.
    // 2 = rechazado.
    private $num_fields = 4; // numero de filas.


    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("inscription", "id_inscription", $fields);
        $this->estado = 0;
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
    public function getIdInscription()
    {
        return $this->id_inscription;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project): void
    {
        $this->project = $project;
    }

    /**
     * @param int $estado
     */
    public function setEstado(int $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return int
     */
    public function getEstado(): int
    {
        return $this->estado;
    }

    /**
     * funcion para generar Usuarios en la Tabla.
     */
    public function save()
    {
        $ins = $this->valores();

        unset($ins['id_inscription']);

        if (empty($this->id_inscription)) {
            $this->insert($ins);
            $this->id_inscription = self::$conn->lastInsertId();
        } else {
            $this->update($this->id_inscription, $ins);
        }
    }

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    function load($id)
    {
        $ins = $this->getById($id);
        if (!empty($ins)) {
            foreach ($this->fields as $field) {
                $this->$field = $ins["$field"];
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }
}