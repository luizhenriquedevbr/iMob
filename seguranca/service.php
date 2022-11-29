<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');


    class service {

        private $db;

            public function __construct()
            {
                $this->db = Host::getConexao();
            }

        public function VerificaLogin($usuario, $senha)
        {
            //$usuario = hash("SHA512", $pusuario);

            $sql = "SELECT * FROM tb_autorizado 
                            WHERE co_autorizado = :usuario 
                            AND   senha = :senha
                    ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':usuario', $usuario);
            $stmt->bindValue(':senha', hash("SHA512",$senha));
            $stmt->execute();
            return  $stmt->fetch();

        }

        public function AlteraSenha($co_autorizado, $senha)
        {
            $sql = "UPDATE tb_autorizado 
                       SET senha = :senha  
                     WHERE co_autorizado = :co_autorizado ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':senha', hash("SHA512",$senha));
            $stmt->bindValue(':co_autorizado', $co_autorizado);
            $stmt->execute();

            $resposta = array('message' => 'Senha alterada com sucesso!');
            return $resposta;
        }


    }