<?php
/**
 * Created by PhpStorm.
 * User: uriigrao
 * Date: 21/03/19
 * Time: 14:24
 */

require_once 'BDs.php';

class TypeProject extends BDs
{
    private $idType;
    private $nameType;
    private $num_fields = 2;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("typeproject", "idType", $fields);
    }

    /**
     * @return mixed
     */
    public function getIdType()
    {
        return $this->idType;
    }

    /**
     * @param mixed $idType
     */
    public function setIdType($idType)
    {
        $this->idType = $idType;
    }

    /**
     * @return mixed
     */
    public function getNameType()
    {
        return $this->nameType;
    }

    /**
     * @param mixed $nameType
     */
    public function setNameType($nameType)
    {
        $this->nameType = $nameType;
    }

    function __get($name)
    {
        $metodo = "get$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo();
        } else {
            throw new Exception("Propiedad no encontrada " . $name);
        }
    }

    function __set($name, $value)
    {
        $metodo = "set$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo($value);
        } else {
            throw new Exception("Propiedad no encontrada " . $name);
        }
    }


    public function save()
    {
        $type = $this->valores();
        unset($type['idType']);

        if (empty($this->idType)) {
            $this->insert($type);
            $this->idType = self::$conn->lastInsertId();
        } else {
            $this->update($this->idType, $type);
        }
    }

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    function load($id)
    {
        $type = $this->getById($id);
        if (!empty($type)) {
            foreach ($this->fields as $field) {
                    $this->$field = $type["$field"];
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
