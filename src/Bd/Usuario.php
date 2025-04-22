<?php
namespace App\Bd;

use \PDO;
use \PDOException;
use \PDOStatement;

class Usuario extends Conexion{
    private int $id;
    private string $password;
    private string $username;

    private static function executeQuery(string $query, array $options=[], bool $flag=false): ?PDOStatement{
        $stmt=parent::getConexion()->prepare($query);
        try{
            $stmt->execute($options);
            return ($flag) ? $stmt : null;
        }catch(PDOException $ex){
            throw new PDOException("Error en la consulta: ".$ex->getMessage());
        }finally{
            parent::cerrarConexion();
        }
        
    }

    public static function loginValido(string $usuario, string $password): bool{
        $q="select password from usuarios where username=:u";
        $stmt=self::executeQuery($q, [':u'=>$usuario], true);
        $aux=$stmt->fetch(PDO::FETCH_OBJ); //devuelve o false o un objeto de una clase generica con el unico atributo password
        return ($aux && password_verify($password, $aux->password));
      // $aux=$stmt->fetchAll(PDO::FETCH_OBJ); //esto es un array que sera o vacvio o con un unico elemento, un objeto de la stdclass
       //aux[0]->password;
      // return count($aux) && password_verify($password, $aux[0]->password);
    }


    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of password
     * haseamos el password antes de guardarlo en la bbdd
     */
    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * Set the value of username
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
}