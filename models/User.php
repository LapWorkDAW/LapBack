<?php
/**
 * Created by PhpStorm.
 * User: UriiGrao
 * Date: 15/11/2018
 * Time: 19:45
 */
require_once 'BDs.php';

class User extends BDs
{

    private $idUser; // int -> el id del usuario.
    private $firstname; // // String -> Nombre del Usuario.
    private $surname; // String -> Apellido del usuario.
    private $location;
    private $userName; // String -> Nombre de Usuario para iniciar sesion tambien se puede usar correo.
    private $email; // String -> Correo electronico del usuario.
    private $pass; // String -> Sera cifrada + la contraseña del usuario
    private $photo; // String -> Foto del Usuario.((guardamos la ruta))
    private $birthdate; // Date -> Fecha de Nacimiento del usuario.
    private $description; // String -> Descripcion del usuario
    private $knowledge; // String -> Conocimientos del usuario
    private $cv; // String -> PDF del curriculum del usuario. (guardamos la ruta)
    private $isActiv; // int -> Para saber si el usuario esta activo o No!. 0-activ, 1-noactiv
    private $saveName; // bool -> Para saber si quieren guardar su nombre o no.
    private $token; // String -> token de session on.
    private $num_fields = 15;

    public function __construct()
    {
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("usuario", "idUser", $fields);
        $this->isActiv = 1;
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

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }


    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $name
     */
    public function setFirstName($name)
    {
        $this->firstname = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname1
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     * @param mixed $cv
     */
    public function setCv($cv)
    {
        $this->cv = $cv;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getCv()
    {
        return $this->cv;
    }


    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->email;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->email = $mail;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $picture
     */
    public function setPhoto($picture)
    {
        $this->photo = $picture;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthdate($birthDate)
    {
        $this->birthdate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getKnowledge()
    {
        return $this->knowledge;
    }

    /**
     * @param mixed $knowing
     */
    public function setKnowledge($knowing)
    {
        $this->knowledge = $knowing;
    }

    /**
     * @return mixed
     */
    public function getCurriculum()
    {
        return $this->cv;
    }

    /**
     * @param mixed $curriculum
     */
    public function setCurriculum($curriculum)
    {
        $this->cv = $curriculum;
    }

    /**
     * @return mixed
     */
    public function getSaveName()
    {
        return $this->saveName;
    }

    /**
     * @param mixed $saveName
     */
    public function setSaveName($saveName)
    {
        $this->saveName = $saveName;
    }

    /**
     * @return mixed
     */
    public function getisActiv()
    {
        return $this->isActiv;
    }

    /**
     * @param mixed $isActiv
     */
    public function setIsActiv($isActiv)
    {
        $this->isActiv = $isActiv;
    }

    /**
     * funcion para generar Usuarios en la Tabla.
     */
    public function save()
    {
        $user = $this->valores();
        unset($user['idUser']);
        if (empty($this->idUser)) {
            $this->insert($user);
            $this->idUser = self::$conn->lastInsertId();
        } else {
            $this->update($this->idUser, $user);
        }
    }

    /**
     * function de load a partir del id y mira si existe o no.
     * @param $id
     * @throws Exception
     */
    public function load($id)
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

    public function delete()
    {
        $this->setIsActiv(0);
        $this->save();
    }

    public function getByMail($id)
    {
        $user = $this->getAll(['email' => $id]);
        if (!empty($user)) {
            $this->load($user[0]['idUser']);
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    public function getByToken($token)
    {
        $user = $this->getAll(['token' => $token]);
        if (!empty($user)) {
            $this->load($user[0]['idUser']);
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    public function getByActiv()
    {
        $user = $this->getAll(['isActiv' => 1]);
        if (!empty($user)) {
            return $user;
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    public function login($username, $pass, $token = "")
    {
        if ($pass != null) {
            $user = $this->getAll(['userName' => $username, 'isActiv' => 1]);
            if (!empty($user)) {
                $us = new User();
                $us->load($user[0]["idUser"]);
                if (password_verify($pass, $us->pass)) {
                    $us->setToken(bin2hex(random_bytes(45)));
                    $us->save();
                    $user = $this->getAll(['userName' => $username]);
                    return $user;
                }
            }
            throw new Exception("Error Login Datos incorrectos");
        } else {
            $user = $this->getAll(['email' => $username, 'isActiv' => 1]);
            if (empty($user)) {
                $user = $this->getAll(['email' => $username, 'isActiv' => 0]);
                if (!empty($user)) {
                    $us = new User();
                    $us->load($user[0]["idUser"]);
                    $us->setIsActiv(1);
                    $us->save();
                    $user = $this->getAll(['email' => $username]);
                }
            } else {
                $us = new User();
                $us->load($user[0]["idUser"]);
                $us->setToken($token);
                $us->save();
                $user = $this->getAll(['email' => $username]);
            }
            return $user;
        }
    }

    public function logout($token)
    {
        try {
            $this->getByToken($token);
            $this->setToken("");
            $this->save();
            return $this;
        } catch (Exception $ex) {
            return -1;
        }
    }

    public function changePass($old, $new, $idUser)
    {
        $user = $this->getAll(['idUser' => $idUser]);
        if (!empty($user)) {
            $us = new User();
            $us->load($user[0]["idUser"]);
            if (password_verify($old, $us->pass)) {
                $pass = password_hash($new, PASSWORD_DEFAULT);
                $us->setPass($pass);
                $us->save();
            }
        }
        die();
    }
}
