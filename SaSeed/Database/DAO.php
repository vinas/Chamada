<?php
/************************************************************************************
* Name:				DAO																*
* File:				SaSeed\Database\DAO.php 										*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		Someone will eventually write a desctiption here.				*
*																					*
* Creation Date:	02/09/2015														*
* Version:			1.15.0902														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace SaSeed\Database;

use SaSeed\Database\Database;
use SaSeed\Database\Pagination;

class DAO {

	public function setDatabase($dbName) {
		$settings = parse_ini_file(ConfigPath.'database.ini', true);
		$db	= new Database();
		$db->DBConnection(
			$settings[$dbName]['driver'],
			$settings[$dbName]['host'],
			$settings[$dbName]['dbname'],
			$settings[$dbName]['user'],
			$settings[$dbName]['password']
		);
		return $db;
	}

	public function setPaginationObj() {
		$obj = new Pagination();
		return $obj;
	}

}
