<?php
/************************************************************************************
* Name:				Alunos Controller												*
* File:				Application\Controller\AlunosController.php						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the Alunos' controller.									*
*																					*
* Creation Date:	21/04/2015														*
* Version:			1.15.0421														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

namespace Application\Controller;

use SaSeed\View;
use SaSeed\Session;
use SaSeed\URLRequest;

//use Application\Controller\Service\Aluno as AlunoService;
use Application\Model\Aluno as AlunoModel;
use Application\Controller\Entities\Aluno as AlunoEntity;
use Application\Controller\Service\Turma as TurmaService;
use Application\Controller\Service\Aluno as AlunoService;

class AlunosController {

	private $classPath = 'Application\Controller\AlunosController';

	public function __construct() {
		Session::start();
		if (Session::getVar('sessionKey') == null) {
			View::redirect('Login');
		}
	}

	public function novoAluno() {
		$URLRequest = new URLRequest();
		$alunoModel = new AlunoModel();
		$turmaService = new TurmaService();
		$params = $URLRequest->getParams();
		$turma = $turmaService->getById($params['key']);
		$aluno = new AlunoEntity();
		$aluno->setTurmaId($params['key']);
		View::set('content', $alunoModel->alunoForm($aluno, $turma));
		View::render('partial_formAluno');
	}

	public function salvarAluno() {
		try {
			$URLRequest = new URLRequest();
			$alunoService = new AlunoService();
			$turmaService = new TurmaService();
			$alunoModel = new AlunoModel();
			$params = $URLRequest->getParams();
			$aluno = $alunoService->salvarAluno($params);
			$turma = $turmaService->getById($aluno->getTurmaId());
			$response['response'] = 1;
			$response['message'] = $alunoModel->savedMessage($aluno);
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::salvarTurma] - '.  $e->getMessage());
		}
	}

	public function listarAlunos() {
		try {
			$URLRequest = new URLRequest();
			$alunoService = new AlunoService();
			$turmaService = new TurmaService();
			$alunoModel = new AlunoModel();
			$params = $URLRequest->getParams();
			$turma = $turmaService->getById($params['key']);
			$alunos = $alunoService->listarAlunosByTurmaId($params['key']);
			$response['response'] = 1;
			$response['content'] = $alunoModel->listarAlunos($alunos, $turma);
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::listarAlunos] - '.  $e->getMessage());
		}
	}

	public function apagarAluno() {
		try {
			$URLRequest = new URLRequest();
			$alunoService = new AlunoService();
			$turmaService = new TurmaService();
			$alunoModel = new AlunoModel();
			$params = $URLRequest->getParams();
			$aluno = $alunoService->getById($params['id']);
			$turma = $turmaService->getById($aluno->getTurmaId());
			$alunoService->apagarAluno($params['id']);
			$alunos = $alunoService->listarAlunosByTurmaId($aluno->getTurmaId());
			$response['response'] = 1;
			$response['content'] = $alunoModel->listarAlunos($alunos, $turma);
			$response['message'] = $alunoModel->deletedMessage($aluno);
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::apagarTurma] - '.  $e->getMessage());
		}
	}

}
