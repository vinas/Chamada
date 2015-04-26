<?php
/************************************************************************************
* Name:				Turmas Controller												*
* File:				Application\Controller\TurmasController.php						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the Turmas' controller.								*
*																					*
* Creation Date:	17/07/2015														*
* Version:			1.15.1114														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

namespace Application\Controller;

use SaSeed\View;
use SaSeed\Session;
use SaSeed\URLRequest;

use Application\Controller\Service\Turma as TurmaService;
use Application\Model\Turma as TurmaModel;
use Application\Controller\Entities\Turma as TurmaEntity;

class TurmasController {

	private $classPath = 'Application\Controller\TurmasController';

	public function __construct() {
		Session::start();
		if (Session::getVar('sessionKey') == null) {
			View::redirect('Login');
		}
	}

	public function index() {
		View::render('partial_turmas');
	}

	public function novaTurma() {
		$turmaModel = new TurmaModel();
		View::set('content', $turmaModel->turmaForm(new TurmaEntity()));
		View::render('partial_formTurma');
	}

	public function salvarTurma() {
		try {
			$URLRequest = new URLRequest();
			$turmaService = new TurmaService();
			$turmaModel = new TurmaModel();
			$params = $URLRequest->getParams();
			$turma = $turmaService->salvarTurma($params);
			$response['response'] = 1;
			$response['message'] = $turmaModel->savedMessage($turma);
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::salvarTurma] - '.  $e->getMessage());
		}
	}

	public function editarTurma() {
		try {
			$URLRequest = new URLRequest();
			$turmaService = new TurmaService();
			$turmaModel = new TurmaModel();
			$params = $URLRequest->getParams();
			$turma = $turmaService->salvarTurma($params);
			$response['response'] = 1;
			$response['message'] = $turmaModel->editedMessage($turma);
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::editarTurma] - '.  $e->getMessage());
		}
	}

	public function listarTurmas() {
		try {
			$turmaService = new TurmaService();
			$turmaModel = new TurmaModel();
			$turmas = $turmaService->listarTurmas();
			$response['response'] = 1;
			$response['content'] = $turmaModel->listarTurmas($turmas);
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::listarTurmas] - '.  $e->getMessage());
		}
	}

	public function apagarTurma() {
		try {
			$URLRequest = new URLRequest();
			$turmaService = new TurmaService();
			$turmaModel = new TurmaModel();
			$params = $URLRequest->getParams();
			$turma = $turmaService->getById($params['turmaId']);
			$turmaService->apagarTurma($params['turmaId']);
			$turmas = $turmaService->listarTurmas();
			$response['response'] = 1;
			$response['content'] = $turmaModel->listarTurmas($turmas);
			$response['message'] = $turmaModel->deletedMessage($turma);
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::apagarTurma] - '.  $e->getMessage());
		}
	}

	public function abrirTurma() {
		$URLRequest = new URLRequest();
		$turmaService = new TurmaService();
		$turmaModel = new TurmaModel();
		$params = $URLRequest->getParams();
		$turma = $turmaService->getById($params['key']);
		$content['response'] = 1;
		View::set('content', $turmaModel->turmaForm($turma));
		View::render('partial_formTurma');
	}

}
