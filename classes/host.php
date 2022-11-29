<?php

	class Host {

		private static $pdo;

		public static function criarConexao(){

			try {

				$user = 'imob';
				$password =  'imob123';

			  	self::$pdo = new PDO('mysql:host=imob-database;dbname=imob', $user, $password);
			    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			    return self::$pdo;

			} catch(PDOException $e) {
			    die( 'Erro ao conectar com o Banco: ' . $e->getMessage());
			}
		}

		public static function getConexao(){
			return ( ! empty(self::$pdo)) ? self::$pdo : self::criarConexao();
		}

	}
