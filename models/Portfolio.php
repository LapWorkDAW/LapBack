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
    private $idPortfolio;
    private $usuario;
    private $archive;
    private $numFields = 3;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->numFields);
        parent::__construct("portfolio", "idPortfolio", $fields);
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
    public function getIdPortfolio()
    {
        return $this->idPortfolio;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * @param mixed $archive
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
    }


    /**
     * funcion para generar Usuarios en la Tabla.
     */
    public function save()
    {
        $portF = $this->valores();
        unset($portF['idPortfolio']);

        $portF['idUser'] = $this->usuario->idUser;
        unset($portF['usuario']);

        if (empty($this->idPortfolio)) {
            $this->insert($portF);
            $this->idPortfolio = self::$conn->lastInsertId();
        } else {
            $this->update($this->idPortfolio, $portF);
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
                if ($field == "usuario") {
                    $usuario = new User();
                    $usuario->load($portF['idUser']);
                    $this->$field = $usuario;
                } else {
                    $this->$field = $portF["$field"];
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
