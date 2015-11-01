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

use SaSeed\Session;
use SaSeed\Utils;

class SessionService {

	public function __construct() {
		Session::start();
	}

	/*public function __construct() {
		Session::start();
	}*/

	public function setUserSession($user, $sessionKey) {
		Session::setVar('id', $user->getId());
		Session::setVar('user', $user->getUser());
		Session::setVar('sessionKey', $sessionKey);
	}

	public function generateSessionKey($user) {
		return md5(Utils::phpDateTime() . ' - ' . $user->getId());
	}

}
