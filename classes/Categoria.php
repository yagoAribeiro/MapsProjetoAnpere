<?php

class Categoria
{
    private $idcategoria;
    private $nomecategoria;


    /* -------- MÉTODOS ---------- */

    public function listarCategoria()
    {
        $pdo = Connection::GET_PDO();
        //ADD consulta numa variável
        $querySelect = "SELECT idCategoria, nomeCategoria FROM tbcategoria";
        //Fazendo a consulta
        $resultado = $pdo->query($querySelect);
        //Retornando um array
        $lista = $resultado->fetchAll();

        return $lista;
    }

    
    public function listarCategoriaEsp($id)
    {
        $pdo = Connection::GET_PDO();
        //ADD consulta numa variável
        $querySelect = "SELECT * FROM tbcategoria WHERE idCategoria = '$id'";
        //Fazendo a consulta
        $resultado = $pdo->query($querySelect);
        //Retornando um array
        $lista = $resultado->fetch(PDO::FETCH_BOTH);

        return $lista;
    }



    /* ------- GETTERS & SETTERS --------- */

    public function getIdcategoria()
    {
        return $this->idcategoria;
    }

    public function setIdcategoria($idcategoria)
    {
        $this->idcategoria = $idcategoria;

        return $this;
    }

    public function getNomecategoria()
    {
        return $this->nomecategoria;
    }

    public function setNomecategoria($nomecategoria)
    {
        $this->nomecategoria = $nomecategoria;

        return $this;
    }
}
