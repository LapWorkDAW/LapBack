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
    protected $id_user; // El id del usuario inscribido.
    protected $id_project; // id del proyecto que se han inscrito
    protected $estado; // estado del usuario al proyecto.
    // 0 = en espera.
    // 1 = aceptado.
    // 2 = rechazado.
    private $num_fields = 4; // numero de filas.


    public function __construct($id_user, $id_project)
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("inscription", "id_inscription", $fields);
        $this->id_user = $id_user;
        $this->id_project = $id_project;
        $this->estado = 0;
    }


    /**
     * funcion para generar Usuarios en la Tabla.
     */
    public function save()
    {
        $project = $this->valores();

        unset($project['id_inscription']);

        if (empty($this->id_inscription)) {
            $this->insert($project);
            $this->id_project = self::$conn->lastInsertId();
        } else {
            $this->update($this->id_inscription, $project);
        }
    }

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    function load($id)
    {
        $user = $this->getById($id);
        if (!empty($user)) {
            foreach ($this->fields as $field) {
                $this->$field = $user["$field"];
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }
}