<?php
require __DIR__ . "/Conexao.php";


class Contatos {
    private $idContato, $nomeContato, $emailContato, $telContato;

    /**
     * @return mixed
     */
    public function getIdContato()
    {
        return $this->idContato;
    }

    /**
     * @param mixed $idContato
     */
    public function setIdContato($idContato)
    {
        $this->idContato = $idContato;
    }

    /**
     * @return mixed
     */
    public function getNomeContato()
    {
        return $this->nomeContato;
    }

    /**
     * @param mixed $nomeContato
     */
    public function setNomeContato($nomeContato)
    {
        $this->nomeContato = $nomeContato;
    }

    /**
     * @return mixed
     */
    public function getEmailContato()
    {
        return $this->emailContato;
    }

    /**
     * @param mixed $emailContato
     */
    public function setEmailContato($emailContato)
    {
        $this->emailContato = $emailContato;
    }

    /**
     * @return mixed
     */
    public function getTelContato()
    {
        return $this->telContato;
    }

    /**
     * @param mixed $telContato
     */
    public function setTelContato($telContato)
    {
        $this->telContato = $telContato;
    }

    public function write($contatos){
        $con = Conexao::conectar();
        $stmt = $con->prepare("INSERT INTO tbcontatos(nomeContato, emailContato, telContato)
                                    VALUES(?,?,?)");
        $stmt->bindValue(1, $contatos->getNomeContato());
        $stmt->bindValue(2, $contatos->getEmailContato());
        $stmt->bindValue(3, $contatos->getTelContato());
        $stmt->execute();
    }

    public function read(){
        $con = Conexao::conectar();
        $querySelect = "SELECT * FROM tbcontatos";
        $resultado = $con->query($querySelect);
        $lista = $resultado->fetchAll();
        return $lista;
    }

    public function readWithId($id){
        $con = Conexao::conectar();
        $querySelect = "SELECT * FROM tbcontatos WHERE idContato = " . $id;
        $resultado = $con->query($querySelect);
        $lista = $resultado->fetchAll();
        return $lista;
    }

    public function update($contatos){
        $con = Conexao::conectar();
        $stmt = $con->prepare("UPDATE tbcontatos SET nomeContato = ?, emailContato = ?, telContato = ? WHERE idcontato = ?");
        $stmt->bindValue(1, $contatos->getNomeContato());
        $stmt->bindValue(2, $contatos->getEmailContato());
        $stmt->bindValue(3, $contatos->getTelContato());
        $stmt->bindValue(4, $contatos->getIdContato());
        $stmt->execute();
    }

    public function delete($id){
        $con = Conexao::conectar();
        $stmt = $con->prepare("DELETE FROM tbcontatos WHERE idcontato = ?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}