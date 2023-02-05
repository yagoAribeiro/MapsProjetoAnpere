<?php 

class PerfilEmpresa{
    private $idperfilempresa;
    private $idempresa;
    private $fotoperfilempresa;
    private $biografia;

/* -------- MÉTODOS -------- */
    public function criarPerfil($perfil){
        $conn = Connection::GET_PDO();
    
        $queryInsert = "INSERT INTO tbperfilempresa (idempresa, fotoperfilempresa, biografiaperfilempresa);
                        VALUES (
                        '".$perfil->getIdempresa()."',
                        '".$perfil->getFotoperfilempresa()."',
                        '".$perfil->getBiografia()."')";
    
        $conn->exec($queryInsert);
    }

    public function listarImagensIndex($id){
        $conn = Connection::GET_PDO();
        //ADD consulta numa variável
        $querySelect = "SELECT fotoperfilempresa FROM tbperfilempresa WHERE idEmpresa = '$id'";
        //Fazendo a consulta
        $resultado = $conn->query($querySelect);
        //Retornando um array
        $imagem = $resultado->fetch(PDO::FETCH_BOTH);

        return $imagem;
    }

    public function readPerfil($id){
        $conn = Connection::GET_PDO();
        //ADD consulta numa variável
        $querySelect = "SELECT * FROM tbperfilempresa WHERE idEmpresa = '$id'";
        //Fazendo a consulta
        $resultado = $conn->query($querySelect);
        //Retornando um array
        $imagem = $resultado->fetch(PDO::FETCH_BOTH);

        return $imagem;
    }


    public function getIdperfilempresa()
    {
        return $this->idperfilempresa;
    }

    public function setIdperfilempresa($idperfilempresa)
    {
        $this->idperfilempresa = $idperfilempresa;

        return $this;
    }

    public function getIdempresa()
    {
        return $this->idempresa;
    }

    public function setIdempresa($idempresa)
    {
        $this->idempresa = $idempresa;

        return $this;
    }
 
    public function getFotoperfilempresa()
    {
        return $this->fotoperfilempresa;
    }

    public function setFotoperfilempresa($fotoperfilempresa)
    {
        $this->fotoperfilempresa = $fotoperfilempresa;

        return $this;
    }
 
    public function getBiografia()
    {
        return $this->biografia;
    }

    public function setBiografia($biografia)
    {
        $this->biografia = $biografia;

        return $this;
    }
}

?>