<?php
/**
 * Created by PhpStorm.
 * User: alu2017375
 * Date: 16/11/2018
 * Time: 11:46
 */

abstract class  Table
{
    static $server = "localhost";
    static $user = "root";
    static $password = "";
    static $database = "LapWork";

    private $table; // Nombre de la Tabla.
    private $idField; // Nombre del campo clave.
    private $fields; // Array con los nombres de los campos.
    private $showFields; // Array con los nombres de los campos a mostrar en determinadas consultas

    static private $conn; // Para la conexion.
    static private $desc; // Pra desconectar

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
    public function __construct($table, $idField, $fields = "", $showFields = "")
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
     * Nos recupera todos los registros, opcionalmente podemos pasar una condición del tipo fields=valor.
     * Si no queremos que salgan todos los campos $completed debe estar a falso.
     * @param string $condition
     * @param bool $completed
     * @return mixed
     */
    function getAll($condition = "", $completed = true)
    {
        $where = "";
        $fields = "*";
        if (!empty($condition)) {
            $where = " WHERE 1=1 ";
            foreach ($condition as $key => $value) {
                $where .= " and " . $key .= " = " . $value . " ";
            }
        }
        if (!$completed && !empty($this->showFields)) {
            $fields = implode(",", $this->showFields);
        }
        $res = self::$conn->query("SELECT $fields FROM $this->table $where");
        return $res->fetchALll(PDO::FETCH_ASSOC);
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
     * Modifica el elemento de la base de datos con el id que pasamos.
     * @param int $id id del elemento a modificar.
     * @param array $values Array asociativo con los valores a modificar.
     */
    protected function update($id, $values)
    {
        try {
            //Creamos el cuerpo del select con la funcion array_map
            $fields = join(",", array_map(function ($v) {
                return $v . "=:" . $v;
            }, array_keys($values)));
            $sql = "UPDATE " . $this->table . " SET " . $fields . " WHERE "
                . $this->idField . " = " . $id;
            $st = self::$conn->prepare($sql);

        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}