<?php
/************************************************************************************
* Name:				Index Model														*
* File:				Application\Model\Index.php 									*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the Index's model.										*
*																					*
* Creation Date:	15/11/2012														*
* Version:			1.12.1115														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

namespace Application\Model;

class Index {

	public function modelate($content = false) {
		$content	= '<div>'.$content.'</div>'.PHP_EOL;
		return $content;
	}

	public function modelUser($user) {
		$content = '';
		try {
			$content .= '<div>'.PHP_EOL;
			$content .= '	<div><b>Id:</b> ' . $user->getId() . '</div>'.PHP_EOL;
			$content .= '	<div><b>User:</b> ' . $user->getUser() . '</div>'.PHP_EOL;
			$content .= '	<div><b>Email:</b> ' . $user->getEmail() . '</div>'.PHP_EOL;
			$content .= '	<div><b>Password:</b> ' . $user->getPassword() . '</div>'.PHP_EOL;
			$content .= '	<div><b>Active:</b> ' . $user->getActive() . '</div>'.PHP_EOL;
			$content .= '</div>'.PHP_EOL;
		} catch (Exception $e) {
			die('['.$classPath.'::getById] - '.  $e->getMessage());
		}
		return $content;
	}

	public function modelDelete($data) {
		if ($data) {
			return 'Usuario apagado';
		}
		return 'Usuario nao apagado';
	}
}