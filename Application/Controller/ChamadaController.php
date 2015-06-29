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
use SaSeed\General;

use Application\Controller\Service\Turma as TurmaService;
use Application\Controller\Service\Aluno as AlunoService;
use Application\Controller\Service\Chamada as ChamadaService;
use Application\Model\Chamada as ChamadaModel;

class ChamadaController {

	private $classPath = 'Application\Controller\TurmasController';

	public function __construct() {
		Session::start();
		if (Session::getVar('sessionKey') == null) {
			View::redirect('Login');
		}
	}

	public function index() {
		$turmaService = new TurmaService();
		$chamadaModel = new ChamadaModel();
		$turmas = $turmaService->listarTurmas();
		$turmasHoje = $turmaService->listTurmasChamadasHoje();
		View::set('content', $chamadaModel->home($turmas, $turmasHoje));
		View::render('partial_chamadaHome');
	}

	public function fazerChamada() {
		$URLRequest = new URLRequest();
		$turmaService = new TurmaService();
		$alunoService = new AlunoService();
		$chamadaModel = new ChamadaModel();
		$params = $URLRequest->getParams();
		$turma = $turmaService->getById($params['key']);
		$alunos = $alunoService->getPrimeirosDoisAlunosByTurmaId($params['key']);
		$listaAlunos = $alunoService->getAlunosIdsByTurmaId($params['key']);
		View::set('content', $chamadaModel->chamada($turma, $alunos, $listaAlunos));
		View::render('partial_chamadaHome');
	}

	public function darPresenca() {
		try {
			$URLRequest = new URLRequest();
			$chamadaService = new ChamadaService();
			$params = $URLRequest->getParams();
			$chamadaService->darPresenca($params['idTurma'], $params['idAluno']);
			$response['response'] = 1;
			$response['message'] = '1';
		} catch (Exception $e) {
			$response['response'] = 0;
			$response['message'] = 'Erro ao dar presenca';
			$response['console'] = '['.$this->classPath.'::darPresenca] - '.  $e->getMessage();
		}
		View::jsonEncode($response);
	}

	public function darFalta() {
		try {
			$URLRequest = new URLRequest();
			$chamadaService = new ChamadaService();
			$params = $URLRequest->getParams();
			$chamadaService->darFalta($params['idTurma'], $params['idAluno']);
			$response['response'] = 1;
			$response['message'] = '1';
		} catch (Exception $e) {
			$response['response'] = 0;
			$response['message'] = 'Erro ao dar falta';
			$response['console'] = '['.$this->classPath.'::darFalta] - '.  $e->getMessage();
		}
		View::jsonEncode($response);
	}

	public function gridChamada() {
		try {
			$chamadaService = new ChamadaService();
			$turmaService = new TurmaService();
			$chamadaModel = new ChamadaModel();
			$URLRequest = new URLRequest();
			$params = $URLRequest->getParams();
			if (!isset($params['data'])) {
				$data = General::phpDate();
			}
			$turma = $turmaService->getById($params['key']);
			$grid = $chamadaService->getGrid($params['key'], 'now');
			$response['response'] = 1;
			$response['content'] = $chamadaModel->grid($grid, $turma, $data);
		} catch (Exception $e) {
			$response['response'] = 0;
			$response['message'] = 'Erro ao buscar ou montar grid.';
			$response['console'] = '['.$this->classPath.'::gridChamada] - '.  $e->getMessage();
		}
		View::jsonEncode($response);
	}

	public function editChamadaAluno() {
		try {
			$URLRequest = new URLRequest();
			$turmaService = new TurmaService();
			$alunoService = new AlunoService();
			$chamadaModel = new ChamadaModel();
			$params = $URLRequest->getParams();
			$aluno = $alunoService->getById($params['key']);
			$turma = $turmaService->getById($aluno->getTurmaId());

			$response['response'] = 1;
			$response['content'] = $chamadaModel->editChamadaAluno($turma, $aluno, $params['date']);
		} catch (Exception $e) {
			$response['response'] = 0;
			$response['message'] = 'Erro ao buscar aluno para editar chamada.';
			$response['console'] = '['.$this->classPath.'::editChamadaAluno] - '.  $e->getMessage();
		}
		View::jsonEncode($response);
	}

}
