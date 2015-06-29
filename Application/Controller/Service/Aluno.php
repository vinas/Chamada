<?php
/************************************************************************************
* Name:				Aluno Service													*
* File:				Application\Controller\Service\Aluno.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Controller with information.		*
*																					*
* Creation Date:	21/04/2015														*
* Version:			1.15.0421														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace Application\Controller\Service;

use Application\Controller\Entities\Aluno as AlunoEntity;
use Application\Controller\Repository\Aluno as AlunoRepository;

class Aluno {

	public function __construct() {
		$this->alunoRepository = new AlunoRepository();
	}

	public function getById($id) {
		return $this->validateObject($this->alunoRepository->getById($id));
	}

	public function salvarAluno($aluno) {
		$aluno = $this->validateObject($aluno);
		if ($aluno->getId() > 0) {
			$this->alunoRepository->update($aluno);
		} else {
			$aluno->setId($this->alunoRepository->saveNew($aluno));
		}
		return $aluno;
	}

	public function salvarObservacao($alunoId, $obs) {
		return $this->alunoRepository->updateObs($alunoId, $obs);
	}

	public function listarAlunosByTurmaId($turmaId) {
		$alunos = $this->alunoRepository->listByTurmaId($turmaId);
		for ($i = 0; $i < count($alunos); $i++) {
			$alunos[$i] = $this->validateObject($alunos[$i]);
		}
		return $alunos;
	}

	public function getPrimeirosDoisAlunosByTurmaId($turmaId) {
		$alunos = $this->alunoRepository->listByTurmaId($turmaId, 2);
		for ($i = 0; $i < count($alunos); $i++) {
			$alunos[$i] = $this->validateObject($alunos[$i]);
		}
		return $alunos;
	}

	public function getAlunosIdsByTurmaId($turmaId) {
		$alunos = $this->alunoRepository->listBasicByTurmaId($turmaId);
		for ($i = 0; $i < count($alunos); $i++) {
			$alunos[$i] = $this->validateObject($alunos[$i]);
		}
		return $alunos;
	}

	public function apagarAluno($id) {
		return $this->alunoRepository->deleteById($id);
	}

	public function saveUploadedImage($foto) {
		$path = '/home/u760736354/public_html/Chamada/Application/View/img/';
		$file = uniqid() . '.png';
		if (!file_put_contents($path.$file, base64_decode($foto))) {
			throw new \Exception("Nao foi possivel salvar a foto.");
			return false;
		}
		return $file;
	}

	private function validateObject($alunoArray) {
		if (!is_object($alunoArray)) {
			$aluno = new AlunoEntity();
			$aluno = $aluno->populateEntity($alunoArray);
			return $aluno;
		}
		return $alunoArray;
	}

}