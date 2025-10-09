<?php
namespace App;
use PDO;
use PDOException;

class Database {
	private static $pdo = null;
	public static $dbName = 'draft-shop';
	public static $dbHost = 'localhost';
	public static $dbUser = 'root';
	public static $dbPass = '';

	public static function connect(): PDO|string {
		if (self::$pdo !== null) {
			return self::$pdo;
		}
		try {
			self::$pdo = new PDO('mysql:host='.self::$dbHost.';dbname='.self::$dbName, self::$dbUser, self::$dbPass);
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

			return self::$pdo;
		}
		catch (PDOException $e) {
			return 'Error: MySQL database connection failed: ' . $e->getMessage();
		}
	}

	public static function closeConnection(): void {
		self::$pdo = null;
	}
}