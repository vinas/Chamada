<?php
/************************************************************************************
* Name:				Login Controller												*
* File:				Application\Controller\LginCoontroller.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the Login ontroller.									*
*																					*
* Creation Date:	16/07/2014														*
* Version:			1.12.1114														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

namespace Application\Controller;

use SaSeed\View;
use SaSeed\Session;
use SaSeed\URLRequest;

use Application\Controller\Service\User as UserService;
use Application\Controller\Service\SessionService;
use Application\Model\Index as ModIndex;

class LoginController {

	public static function index() {
		View::set('css', '<link href="/Chamada/Application/View/css/login.css" rel="stylesheet">');
		View::render('login');
	}

	public static function in() {
		$URLRequest = new URLRequest();
		$userService = new UserService();
		$sessionService = new SessionService();
		$params = $URLRequest->getParams();
		$user = $userService->findUserByLogin($params['user'], md5($params['password']));
		if ($user->getId() > 0) {
			$sessionKey = $sessionService->generateSessionKey($user);
			$sessionService->setUserSession($user, $sessionKey);
			$response['response'] = 1;
			$response['url'] = '/Chamada/';
		} else {
			$response['response'] = 0;
			$response['message'] = $GLOBALS['exceptions']['GENERAL']['userPassNotMatch'];
		}
		View::jsonEncode($response);
	}

	public static function out() {
		Session::start();
		Session::resetAll();
		Session::destroy();
		View::redirect("/Chamada/");
	}

}