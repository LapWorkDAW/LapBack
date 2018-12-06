<?php
/**
 * Created by PhpStorm.
 * user: UriiGrao
 * Date: 2018-11-29
 * Time: 12:37
 */
require_once 'BDs.php';

class Portfolio extends BDs
{
    private $id_portfolio;
    private $id_portF;
    private $archive;
    private $numFields = 3;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("portfolio", "id_portfolio", $fields);
    }

    public function __get($name) {
        $metodo = "get$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo();
        } else {
            throw new Exception("Propiedad no encontrada");
        }
    }

    public function __set($name, $value) {
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
    public function getIdPortfolio()
    {
        return $this->id_portfolio;
    }

    /**
     * @return mixed
     */
    public function getIdPortF()
    {
        return $this->id_portF;
    }

    /**
     * @return mixed
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * @param mixed $id_portF
     */
    public function setIdPortF($id_portF): void
    {
        $this->id_portF = $id_portF;
    }

    /**
     * @param mixed $archive
     */
    public function setArchive($archive): void
    {
        $this->archive = $archive;
    }

    /**
     * funcion para generar Usuarios en la Tabla.
     */
    public function save()
    {
        $portF = $this->valores();
        unset($portF['id_portF']);
        if (empty($this->id_portF)) {
            $this->insert($portF);
            $this->id_portF = self::$conn->lastInsertId();
        } else {
            $this->update($this->id_portF, $portF);
        }
    }

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    function load($id)
    {
        $portF = $this->getById($id);
        if (!empty($portF)) {
            foreach ($this->fields as $field) {
                $this->$field = $portF["$field"];
            }
        } else {
            throw new Exception("No existe ese registro");
        }
    }
}