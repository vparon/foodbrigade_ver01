<?php

class Db
{
	private static $pdo = null;
	
	private static function CreatePdo()
	{
		if (!self::$pdo)
		{
			self::$pdo = new \PDO("mysql:host=localhost;dbname=cheesedb;charset=utf8", "root", "mysql");
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}
	
	public static function Query($sql, $params = [])
	{
		self::CreatePdo();
		try {
			$query = self::$pdo->prepare($sql);
			$query->execute($params);
			return [ 'success' => $query->fetchAll(\PDO::FETCH_ASSOC), 'error' => null ];
		}
		catch (Exception $e) {
			return [ 'success' => null, 'error' => $e->getMessage() ];
		}
	}
	
	public static function Execute($sql, $params = [])
	{
		self::CreatePdo();
		try {
			$query = self::$pdo->prepare($sql);
			$query->execute($params);
			return [ 'success' => null, 'error' => null ];
		}
		catch (Exception $e) {
			return [ 'success' => null, 'error' => $e->getMessage() ];
		}
	}
}

?>
