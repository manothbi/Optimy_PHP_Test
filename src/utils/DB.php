<?php
namespace App\Utils;

class DB
{
	private $pdo;

	private static $instance = null;

	private function __construct()
	{
		$dsn = 'mysql:dbname=phptest;host=127.0.0.1;port=3308';
		$user = 'root';
		$password = 'root1981';


		try {
			$this->pdo = new \PDO($dsn, $user, $password);

			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

		} catch (\PDOException $e) {
			echo $e->getMessage();
		}


	}

	public static function getInstance()
	{
		if (null === self::$instance) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	// execute statement
	private function executeStatement( $statement = "" , $parameters = [] ){
			try{

					$stmt = $this->pdo->prepare($statement);
					$stmt->execute($parameters);
					return $stmt;

			}catch(Exception $e){
					throw new Exception($e->getMessage());
			}
	}

	// Insert a row/s in a Database Table
	public function Insert( $statement = "" , $parameters = [] ){
			try{

					$this->executeStatement( $statement , $parameters );
					return $this->pdo->lastInsertId();

			}catch(Exception $e){
					throw new Exception($e->getMessage());
			}
	}

	// Select a row/s in a Database Table
	public function Select( $statement = "" , $parameters = [] ){
			try{

					$stmt = $this->executeStatement( $statement , $parameters );
					return $stmt->fetchAll();

			}catch(Exception $e){
					throw new Exception($e->getMessage());
			}
	}

	// Update a row/s in a Database Table
	public function Update( $statement = "" , $parameters = [] ){
			try{

					$this->executeStatement( $statement , $parameters );

			}catch(Exception $e){
					throw new Exception($e->getMessage());
			}
	}

	// Remove a row/s in a Database Table
	public function Remove( $statement = "" , $parameters = [] ){
			try{

					$this->executeStatement( $statement , $parameters );

			}catch(Exception $e){
					throw new Exception($e->getMessage());
			}
	}
}
