<?php

/************************************************************************************
* Name:				User Repository													*
* File:				Application\Controller\Repository\User.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Service with information.			*
*																					*
* Creation Date:	30/03/2015														*
* Version:			1.15.0330														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace Application\Controller\Repository;

class User {

	private $db;
	private $table = 'user';
	private $classPath = 'Application\Controller\Repository\User';

	public function __construct() {
		$this->db = $GLOBALS['db'];
	}

	public function getById($userId = false) {
		try {
			return $this->db->getRow($this->table, '*', "id = {$userId}");
		} catch (Exception $e) {
			die('['.$classPath.'::getById] - '.  $e->getMessage());
		}
	}

	public function getByEmail($email = false) {
		try {
			return $this->db->getRow($this->table, '*', "email = '{$email}'");
		} catch (Exception $e) {
			die('['.$classPath.'::getByEmail] - '.  $e->getMessage());
		}
	}

	public function saveNewUser($user) {
		try {
			$this->db->insertRow(
				$this->table,
				array(
					$user->getUser(),
					$user->getEmail(),
					$user->getPassword(),
					1
				)
			);
			return $this->db->lastId();
		} catch (Exception $e) {
			die('['.$classPath.'::saveNewUser] - '.  $e->getMessage());
		}
	}

	public function updateUser($user) {
		try {
			if (!$user->getId()) {
				throw new Exception("No User Id");
			}
			$this->db->updateRow(
				$this->table,
				array(
					'user',
					'email',
					'password',
					'active'
				),
				array(
					$user->getUser(),
					$user->getEmail(),
					$user->getPassword(),
					$user->getActive()
				),
				"id = ".$user->getId()
			);
			return true;
		} catch (Exception $e) {
			die('['.$classPath.'::updateUser] - '.  $e->getMessage());
		}
		return false;
	}

	public function deleteUser($user) {
		try {
			return $this->deleteUserById($user->getId());
		} catch (Exception $e) {
			die('['.$classPath.'::deleteUser] - '.  $e->getMessage());
		}
	}

	public function deleteUserById($userId) {
		try {
			return $this->db->deleteRow($this->table, " id = " . $userId);
		} catch (Exception $e) {
			die('['.$classPath.'::deleteUserById] - '.  $e->getMessage());
		}
	}

	public function findUserByLogin($user, $password) {
		try {
			return $this->db->getRow($this->table, '*', "active = 1 AND user = '{$user}' AND password = '{$password}'");
		} catch (Exception $e) {
			die('['.$classPath.'::findUserByLogin] - '.  $e->getMessage());
		}
	}
}
