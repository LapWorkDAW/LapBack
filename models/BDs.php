<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 16/11/2018
 * Time: 11:46
 */

abstract class  BDs
{

    static $server = "172.16.2.51";
    static $user = "oriol";
    static $password = "";
    static $database = "lapwork";

    protected $table; // Nombre de la Tabla.
    protected $idField; // Nombre del campo clave.
    protected $fields; // Array con los nombres de los campos.
    protected $showFields; // Array con los nombres de los campos a mostrar en determinadas consultas

    static protected $conn; // Para la conexion.
    static protected $desc; // Pra desconectar

    /**
     * El Constructor necesita el nombre de la tabla y el nombre del campo clave
     * Opcionalmente podemos indicar los campos que tiene la tabla y aquellos que queremos mostrar
     * Cuando se haga una seleccion
     *
     * @param type $table
     * @param type $idField
     * @param type $fields
     * @param type $showFields
     */
    public function __construct($table, $idField, $fields = [], $showFields = "")
    {
        $this->table = $table;
        $this->idField = $idField;
        $this->fields = $fields;
        $this->showFields = $showFields;
        self::conectar();
    }

    /**
     * Función de conexión
     */
    static function conectar()
    {
        try {
            self::$conn = new PDO("mysql:host=" . self::$server . ";dbname=" . self::$database, self::$user, self::$password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * funcion de desconexion.
     */
    static function desconectar()
    {
        try {
            self::$conn->close();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Getter de las propiedades
     * @param type $name
     * @return type
     */
    function __get($name)
    {
        echo $name;
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    /**
     * Setter de las propiedades
     * @param type $name
     * @param type $value
     * @throws Exception
     */
    function __set($name, $value)
    {
        if (property_exists($this, $name) && !empty($value)) {
            $this->$name = $value;
        } else {
            throw new Exception("Error: datos incorrectos");
        }
    }

    /**
     * Esta funcion nos devuelve el elemento de la tabla que tenga este id.
     * @param int $id El id de la fila
     * @return el elemento que tenga este id.
     */
    function getByID($id)
    {
        $res = self::$conn->query("SELECT * FROM " . $this->table . " WHERE "
            . $this->idField . " = " . $id);
        return $res->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Lo mismo que la anterior pero usando prepare
     * @param type $condicion
     * @param type $completo
     * @return type
     */
    function getAll($condicion = [], $completo = true)
    {
        $where = "";
        $campos = " * ";
        if (!empty($condicion)) {
            $where = " where " . join(" and ", array_map(function ($v) {
                    return $v . "=:" . $v;
                }, array_keys($condicion)));
        }
        if (!$completo && !empty($this->showFields)) {
            $campos = implode(",", $this->showFields);
        }
        $st = self::$conn->prepare("select $campos from " . $this->table . $where);
        $st->execute($condicion);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Esta funcion toma como parametros un array asociativo y nos inserta en la tabla
     * un registro donde la clave del array hace referencia al campo de la tabla y
     * el valor del array al valor de la tabla.
     * ejemplo para la tabla user: insert(['name'=>'Orito', 'surname1'=>'Grarito'])
     * @param $values
     */
    protected function insert($values)
    {
        try {
            $fields = join(",", array_keys($values));
            $parameters = ":" . join(",:", array_keys($values));
            $sql = "INSERT into " . $this->table . "($fields) values ($parameters)";
            $st = self::$conn->prepare($sql);
            $st->execute($values);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Elimina el registro que tenga el id que le pasamos
     * @param int $id
     */
    protected function deleteById($id)
    {
        try {
            self::$conn->exec("delete from " . $this->table . " where "
                . $this->idField . "=" . $id);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Modifica el elemento de la base de datos con el id que pasamos.
     * @param int $id id del elemento a modificar.
     * @param array $values Array asociativo con los valores a modificar.
     */
    protected function update($id, $values)
    {
       // print_r($values);die();
        try {
            //Creamos el cuerpo del select con la funcion array_map
            $fields = join(",", array_map(function ($v) {
                return $v . "=:" . $v;
            }, array_keys($values)));
            $sql = "UPDATE " . $this->table . " SET " . $fields . " WHERE "
                . $this->idField . " = " . $id;
            $st = self::$conn->prepare($sql);
            $st->execute($values);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * funcion para coger los valores de la BD. La usamos en el Save...
     * @return array
     */
    protected function valores()
    {
        $valores = array_map(function ($v) {
            return $this->$v;
        }, $this->fields);
        //    print_r($valores);die();
        return array_combine($this->fields, $valores);
    }

    function serialize()
    {
        return $this->valores();
    }

    function loadAll()
    {
        $objetos = $this->getAll();
        return $objetos;
    }

    function toArray()
    {
        foreach ($this->fields as $field) {
            $datos{$field} = $this->$field;

        }
        return $datos;
    }

    abstract function save();

    abstract function delete();

    abstract function load($id);

}
