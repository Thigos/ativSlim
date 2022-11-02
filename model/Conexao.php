<?php

class Conexao
{
    public static function conectar()
    {

        $server = "localhost";
        $database = "bdagenda";
        $user = "root";
        $password = "";

        // conexão local
        $conexao = new PDO(
            "mysql:host=$server;
            dbname=$database",
            $user,
            $password
        );

        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexao->exec("SET CHARACTER SET utf8");

        return $conexao;
    }
}