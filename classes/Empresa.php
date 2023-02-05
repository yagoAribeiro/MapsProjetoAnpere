<?php 

class Empresa{
    private $idempresa;
    private $nomeempresa;
    private $cnpjempresa;
    private $emailempresa;
    private $senhaempresa;
    private $telefoneempresa;
    private $logradouro;
    private $estado;
    private $cidade;
    private $bairro;
    private $cep;
    private $num;
    private $nivel_acesso;
    private $disponibildiade;
    private $idcategoria;

    /* --------- MÉTODOS --------- */
    public function readEmpresas($id){
        $conn = Connection::GET_PDO();
        //ADD consulta numa variável
        $querySelect = "SELECT * FROM tbempresa WHERE idEmpresa = '$id'";
        //Fazendo a consulta
        $resultado = $conn->query($querySelect);
        //Retornando um array
        $empresas = $resultado->fetch(PDO::FETCH_BOTH);

        return $empresas;
    }

    public function verificarEmail($empresa){
        $conn = Connection::GET_PDO();

        $email = $empresa->getEmailempresa();
        $querySelect = "SELECT nomeEmpresa FROM tbempresa WHERE emailEmpresa = '$email'";
        $retorno = $conn->query($querySelect);
        $consulta_nome = $retorno->fetch(PDO::FETCH_ASSOC);
        $nome = $consulta_nome['nomeEmpresa'];

        return $nome;
    }

    public function verificarCnpj($empresa){
        $conn = Connection::GET_PDO();

        $cnpj = $empresa->getCnpjempresa();
        $querySelect = "SELECT nomeEmpresa FROM tbempresa WHERE cnpjempresa = '$cnpj'";
        $retorno = $conn->query($querySelect);
        $consulta_nome = $retorno->fetch(PDO::FETCH_ASSOC);
        $nome = $consulta_nome['nomeEmpresa'];

        return $nome;
    }

    public function cadastrar($empresa){
        $conn = Connection::GET_PDO();

        
        //Etapa 1 - Insert na tabela tbempresa
        $queryInsert = "INSERT INTO tbempresa (nomeempresa, cnpjempresa, emailempresa, senhaempresa, logradouroempresa, estadoempresa, 
        cidadeempresa, bairroempresa, cepempresa, numendempresa, idcategoria)
                        VALUES ('".$empresa->getNomeempresa()."',
                        '".$empresa->getCnpjempresa()."',
                        '".$empresa->getEmailempresa()."',
                        '".$empresa->getSenhaempresa()."',
                        '".$empresa->getLogradouro()."',
                        '".$empresa->getEstado()."',
                        '".$empresa->getCidade()."',
                        '".$empresa->getBairro()."',
                        '".$empresa->getCep()."',
                        '".$empresa->getNum()."',
                        '".$empresa->getIdcategoria()."')";
        $conn->exec($queryInsert);

        //Etapa 2 - Insert na tabela tbtelefoneempresa -> Selecionar id
        $cnpj = $empresa->getCnpjempresa();

        $querySelect_id = "SELECT idempresa FROM tbempresa WHERE cnpjempresa = '$cnpj'";
        $retorno = $conn->query($querySelect_id);
        $consulta_id = $retorno->fetch(PDO::FETCH_BOTH);
        $id = $consulta_id['idempresa'];

        //Etapa 2.2 - Insert na tabela tbtelefoneempresa

        $queryInsert_2 = "INSERT INTO tbtelefoneempresa (idempresa, numtelefoneempresa)
                          VALUE ('$id', '".$empresa->getTelefoneempresa()."')";
        $conn->exec($queryInsert_2);
    }

    public function listarEmpresasIndex(){
        $conn = Connection::GET_PDO();
        //ADD consulta numa variável
        $querySelect = "SELECT * FROM tbempresa WHERE idCategoria BETWEEN 10 AND 11";
        //Fazendo a consulta
        $resultado = $conn->query($querySelect);
        //Retornando um array
        $empresas = $resultado->fetchAll();

        return $empresas;
    }

    public function listarEmpresasIndex2(){
        $conn = Connection::GET_PDO();
        //ADD consulta numa variável
        $querySelect = "SELECT * FROM tbempresa WHERE idCategoria IN (7, 9)";
        //Fazendo a consulta
        $resultado = $conn->query($querySelect);
        //Retornando um array
        $empresas = $resultado->fetchAll();

        return $empresas;
    }

    public function listarEmpresasParceria(){
        $conn = Connection::GET_PDO();
        //ADD consulta numa variável
        $querySelect = "SELECT * FROM tbempresa WHERE disponibilidade = 0";
        //Fazendo a consulta
        $resultado = $conn->query($querySelect);
        //Retornando um array
        $empresas = $resultado->fetchAll();

        return $empresas;
    }


    public function updateCategoria($upCat){
        $conn = Connection::GET_PDO();

        $idcategoria = $upCat->getIdcategoria();
        $idempresa = $upCat->getIdempresa();

        $queryUpdate = "UPDATE tbempresa SET idCategoria = '$idcategoria' WHERE idEmpresa = '$idempresa'";
        $conn->exec($queryUpdate);
    }

    /* ----------- GETTERS & SETTERS ---------- */

    public function getIdempresa()
    {
        return $this->idempresa;
    }

    public function setIdempresa($idempresa)
    {
        $this->idempresa = $idempresa;

        return $this;
    }
 
    public function getNomeempresa()
    {
        return $this->nomeempresa;
    }

    public function setNomeempresa($nomeempresa)
    {
        $this->nomeempresa = $nomeempresa;

        return $this;
    }
 
    public function getCnpjempresa()
    {
        return $this->cnpjempresa;
    }

    public function setCnpjempresa($cnpjempresa)
    {
        $this->cnpjempresa = $cnpjempresa;

        return $this;
    }

    public function getEmailempresa()
    {
        return $this->emailempresa;
    }

    public function setEmailempresa($emailempresa)
    {
        $this->emailempresa = $emailempresa;

        return $this;
    }

    public function getSenhaempresa()
    {
        return $this->senhaempresa;
    }

    public function setSenhaempresa($senhaempresa)
    {
        $this->senhaempresa = $senhaempresa;

        return $this;
    }

    public function getLogradouro()
    {
        return $this->logradouro;
    }

    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;

        return $this;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }
 
    public function getNum()
    {
        return $this->num;
    }

    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }



    public function getIdcategoria()
    {
        return $this->idcategoria;
    }

    public function setIdcategoria($idcategoria)
    {
        $this->idcategoria = $idcategoria;

        return $this;
    }

    public function getDisponibildiade()
    {
        return $this->disponibildiade;
    }

    public function setDisponibildiade($disponibildiade)
    {
        $this->disponibildiade = $disponibildiade;

        return $this;
    }

    public function getTelefoneempresa()
    {
        return $this->telefoneempresa;
    }

    public function setTelefoneempresa($telefoneempresa)
    {
        $this->telefoneempresa = $telefoneempresa;

        return $this;
    }

    public function getNivel_acesso()
    {
        return $this->nivel_acesso;
    }
 
    public function setNivel_acesso($nivel_acesso)
    {
        $this->nivel_acesso = $nivel_acesso;

        return $this;
    }
}

?>