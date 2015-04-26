<?php

/************************************************************************************
* Name:				User Service													*
* File:				Application\Controller\Service\User.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Controller with information.		*
*																					*
* Creation Date:	17/07/2014														*
* Version:			1.15.0326														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace Application\Controller\Service;

use Application\Controller\Entities\User as UserEntity;
use Application\Controller\Repository\User as UserRepository;

class User {

	private $userRepository;

	public function __construct() {
		$this->userRepository = new UserRepository();
	}

	public function getById($userId = false) {
		return $this->populateUserObject($this->userRepository->getById($userId));
	}

	public function getByEmail($email = false) {
		return $this->populateUserObject($this->userRepository->getByEmail($email));
	}
	
	public function saveNewUser($user) {
		if (!is_object($user)) {
			$user = $this->populateUserObject($user);
		}
		$user->setPassword($user->getPassword());
		return $this->userRepository->saveNewUser($user);
	}

	public function updateUser($user) {
		if (!is_object($user)) {
			$user = $this->populateUserObject($user);
		}
		return $this->userRepository->updateUser($user);
	}

	public function deleteUser($user) {
		return $this->userRepository->deleteUser($user);
	}

	public function findUserByLogin($user, $password) {
		return $this->populateUserObject($this->userRepository->findUserByLogin($user, $password));
	}

	private function populateUserObject($userArray) {
		try {
			$user = new UserEntity();
			$user->setId((isset($userArray['id'])) ? $userArray['id'] : false);
			$user->setUser((isset($userArray['user'])) ? $userArray['user'] : false);
			$user->setEmail((isset($userArray['email'])) ? $userArray['email'] : false);
			$user->setPassword((isset($userArray['password'])) ? $userArray['password'] : false);
			$user->setActive((isset($userArray['active'])) ? $userArray['active'] : false);
			return $user;
		} catch (Exception $e) {
			die('[Application\Controller\Repository\User::populateUserObject] - '.  $e->getMessage());
		}
	}
	
}