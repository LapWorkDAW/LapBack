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

    function getAll($condicion = "", $completo = true)
    {
        $where = "";
        $campos = "*";
        if (!empty($condicion)) {
            $where = " WHERE 1=1 ";
        }
    }
}