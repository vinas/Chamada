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

use SaSeed\View\View;
use SaSeed\Session;
use SaSeed\URLRequest;

use Application\Model\Aluno as AlunoModel;
use Application\Model\Chamada as ChamadaModel;
use Application\Controller\Entities\Aluno as AlunoEntity;
use Application\Controller\Service\Turma as TurmaService;
use Application\Controller\Service\Aluno as AlunoService;

class AlunosController {

	private $classPath = 'Application\Controller\AlunosController';
	private $alunoService = new AlunoService();
	private $urlRequest = new URLRequest();

	public function __construct() {
		Session::start();
		if (Session::getVar('sessionKey') == null) {
			View::redirect('Login');
		}
	}

	public function novoAluno() {
		$alunoModel = new AlunoModel();
		$turmaService = new TurmaService();
		$params = $this->urlRequest->getParams();
		$turma = $turmaService->getById($params['key']);
		$aluno = new AlunoEntity();
		$aluno->setTurmaId($params['key']);
		View::set('content', $alunoModel->alunoForm($aluno, $turma));
		View::render('partial_formAluno');
	}

	public function salvarAluno() {
		try {
			$turmaService = new TurmaService();
			$alunoModel = new AlunoModel();
			$params = $this->urlRequest->getParams();
			$aluno = $this->alunoService->salvarAluno($params);
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
			$turmaService = new TurmaService();
			$alunoModel = new AlunoModel();
			$params = $this->urlRequest->getParams();
			$turma = $turmaService->getById($params['key']);
			$alunos = $this->alunoService->listarAlunosByTurmaId($params['key']);
			$response['response'] = 1;
			$response['content'] = $alunoModel->listarAlunos($alunos, $turma);
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::listarAlunos] - '.  $e->getMessage());
		}
	}

	public function apagarAluno() {
		try {
			$turmaService = new TurmaService();
			$alunoModel = new AlunoModel();
			$params = $this->urlRequest->getParams();
			$aluno = $this->alunoService->getById($params['id']);
			$turma = $turmaService->getById($aluno->getTurmaId());
			$this->alunoService->apagarAluno($params['id']);
			$alunos = $this->alunoService->listarAlunosByTurmaId($aluno->getTurmaId());
			$response['response'] = 1;
			$response['content'] = $alunoModel->listarAlunos($alunos, $turma);
			$response['message'] = $alunoModel->deletedMessage($aluno);
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::apagarTurma] - '.  $e->getMessage());
		}
	}

	public function carregarAluno() {
		try {
			$chamadaModel = new ChamadaModel();
			$params = $this->urlRequest->getParams();
			$aluno = $this->alunoService->getById($params['idAluno']);
			$response['response'] = 1;
			$response['content'] = $chamadaModel->alunoLayer($aluno);
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::apagarTurma] - '.  $e->getMessage());
		}
	}

	public function abrirAluno() {
		try {
			$turmaService = new TurmaService();
			$alunoModel = new AlunoModel();
			$params = $this->urlRequest->getParams();
			$aluno = $this->alunoService->getById($params['key']);
			$turma = $turmaService->getById($aluno->getTurmaId());
			$response['response'] = 1;
			$response['content'] = $alunoModel->alunoForm($aluno, $turma);
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::abrirAluno] - '.  $e->getMessage());
		}
	}

	public function webcam() {
		View::render('partial_webCam');
	}

	public function uploadFoto() {
		try {
			$params = $this->urlRequest->getParams();
			$file = $this->alunoService->saveUploadedImage($params['foto']);
			$response['response'] = 1;
			$response['message'] = $file;
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::uploadFoto] - '.  $e->getMessage());
		}
	}

	public function salvarObservacao() {
		try {
			$params = $this->urlRequest->getParams();
			$response['message'] = $this->alunoService->salvarObservacao($params['idAluno'], $params['obs']);
			$response['response'] = 1;
			View::jsonEncode($response);
		} catch (Exception $e) {
			die('['.$this->classPath.'::salvarTurma] - '.  $e->getMessage());
		}
	}

}
