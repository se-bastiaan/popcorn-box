<?php if(!class_exists('Config')) exit('No direct script access allowed');

class Database {

	public $pdo, $fpdo;

	public function __construct() {
		$this->pdo = new PDO('mysql:host='.Config::get('database', 'mysql_host').';dbname='.Config::get('database', 'mysql_database'), Config::get('database', 'mysql_user'), Config::get('database', 'mysql_password')); 
		$this->fpdo = new FluentPDO($this->pdo);
	}

	public function closeConnection() {
		$this->pdo = null;
		$this->fpdo = null;
	}

	public function insert($table, $values) {
		$query = $this->fpdo->insertInto($table, $values);
		return $query->execute();
	}

	public function get($table, $values = array(), $order = array(), $group = array()) {
		$query = $this->fpdo->from($table);
		foreach($values as $k=>$v) {
			$query = $query->where($k, $v);
		}
		if(count($order) > 0) {
			foreach($order as $v) {
				$query = $query->orderBy($v);
			}
		}
		if(count($group) > 0) {
			foreach($group as $v) {
				$query = $query->groupBy($v);
			}
		}
		return $query;
	}

	public function update($table, $values, $where) {
		$query = $this->fpdo->update($table)->set($values);
		foreach($where as $k=>$v) {
			$query = $query->where($k, $v);
		}
		return $query->execute();
	}

	public function delete($table, $values = array()) {
		$query = $this->fpdo->deleteFrom($table);
		foreach($values as $k=>$v) {
			$query = $query->where($k, $v);
		}
		return $query->execute();
	}

	public function emptyTable($table) {
		$qry = $this->pdo->prepare("TRUNCATE TABLE $table;");
		$qry->execute();
	}

}