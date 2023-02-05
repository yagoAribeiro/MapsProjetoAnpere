<?php

    class Connection{

        public static function GET_PDO(){
            $servidor = "localhost";
            $banco = "bdservices";
            $usuario = "root";
            $senha = "";
            try{
                $connection = new PDO("mysql:host=$servidor;dbname=$banco",$usuario,$senha);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connection->exec("SET CHARACTER SET utf8");
                return $connection;
            }catch(PDOException $err){
                echo "Error: ".$err -> getMessage();
            }

    }
}
     
?>