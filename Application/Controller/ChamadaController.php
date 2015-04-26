<?php
/************************************************************************************
* Name:				Chamada Controller												*
* File:				Application\Controller\ChamadaController.php						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the Chamada's controller.								*
*																					*
* Creation Date:	24/04/2015														*
* Version:			1.15.0425														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

namespace Application\Controller;

use SaSeed\View;
use SaSeed\Session;
use SaSeed\URLRequest;

use Application\Controller\Service\Turma as TurmaService;
use Application\Model\Chamada as ChamadaModel;

class ChamadaController {

	private $classPath = 'Application\Controller\TurmasController';

	public function __construct() {
		Session::start();
		if (Session::getVar('sessionKey') == null) {
			View::redirect('Login');
		}
	}

	public function fazerChamada() {
		$turmaService = new TurmaService();
		$turma = $turmaService->getById($params['key']);
		$content['response'] = 1;
		View::set('content', $turmaModel->turmaForm($turma));
		View::render('partial_formTurma');
	}

}
