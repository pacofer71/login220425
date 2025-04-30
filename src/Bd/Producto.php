<?php
namespace App\Bd;
use \PDO;
use \PDOException;
use \PDOStatement;

class Producto extends Conexion{
    private int $id;
    private string $nombre;
    private float $precio;
    private string $imagen;
    private int $user_id;

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

    public static function readAll(): array{
        $q="select productos.*, username from productos, usuarios where user_id=usuarios.id order by productos.id desc";
        $stmt=self::executeQuery($q, [], true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function read(string $username): array{
        $q="select productos.* from productos, usuarios where user_id=usuarios.id AND username=? order by id desc";
        $stmt=self::executeQuery($q, [$username], true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function existeProducto(string $nombre): bool{
        $q="select id from productos where nombre=:n";
        $stmt=self::executeQuery($q, [':n'=>$nombre], true);
        return (bool) $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create(){
        $q="insert into productos(nombre, precio, imagen, user_id) values(:n, :p, :i, :ui)";
        $parametros=[
            ':n'=>$this->nombre,
            ':p'=>$this->precio,
            ':i'=>$this->imagen,
            ':ui'=>$this->user_id,
        ];
        self::executeQuery($q, $parametros, false);
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
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Set the value of imagen
     */
    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Set the value of user_id
     */
    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}