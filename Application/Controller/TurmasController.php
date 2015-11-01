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

use SaSeed\View\View;
use SaSeed\Session;
use SaSeed\URLRequest;

use Application\Controller\Service\Turma as TurmaService;
use Application\Model\Turma as TurmaModel;
use Application\Controller\Entities\Turma as TurmaEntity;

class TurmasController {

	private $classPath = 'Application\Controller\TurmasController';
	private $service;
	private $params;

	public function __construct() {
		Session::start();
		if (Session::getVar('sessionKey') == null) {
			View::redirect('Login');
		}
		$this->service = new TurmaService();
		$this->params = new URLRequest();
	}

	public function listarTurmas() {
		try {
			View::set('turmas', $this->service->listarTurmas());
			View::render('turmas');
		} catch (Exception $e) {
			throw('['.$this->classPath.'::listarTurmas] - '.  $e->getMessage());
		}
	}

	public function novaTurma() {
		try {
			View::set('turma', new TurmaEntity());
			View::render('turma_form');
		} catch (Exception $e) {
			throw('['.$this->classPath.'::novaTurma] - '.  $e->getMessage());
		}
	}

	public function salvarTurma() {
		try {
			$turma = new TurmaEntity();
			$turma->populateMe($this->params->getParams());
			$turma = $this->service->salvarTurma($turma);
			View::set('turma', $turma);
			$response['response'] = 1;
			$response['message'] = View::renderTo('turma_salva');
		} catch (Exception $e) {
			throw('['.$this->classPath.'::salvarTurma] - '. $e->getMessage());
			$response['response'] = 0;
			$response['message'] = View::renderTo('turma_naoSalva');
		}
		View::renderJson($response);
	}

	public function apagarTurma() {
		try {
			$params = $this->params->getParams();
			$turma = $this->service->getById($params['turmaId']);
			$this->service->apagarTurma($params['turmaId']);
			View::set('turmas', $this->service->listarTurmas());
			View::set('turma', $turma);
			$response['response'] = 1;
			$response['content'] = View::renderTo('turmas');
			$response['message'] = View::renderTo('turma_apagada');
		} catch (Exception $e) {
			throw('['.$this->classPath.'::apagarTurma] - '.  $e->getMessage());
			$response['response'] = 0;
			$response['message'] = View::renderTo('turma_naoApagada');
		}
		View::renderJson($response);
	}

	public function abrirTurma() {
		try {
			$params = $this->params->getParams();
			View::set(
				'turma',
				$this->service->getById(
					$params['key']
				)
			);
			View::render('turma_form');
		} catch (Exception $e) {
			throw('['.$this->classPath.'::abrirTurma] - '.  $e->getMessage());
		}
	}

}
