<?php

/************************************************************************************
* Name:				Turmas Service													*
* File:				Application\Controller\Service\Turmas.php 						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Controller with information.		*
*																					*
* Creation Date:	19/04/2015														*
* Version:			1.15.0326														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace Application\Controller\Service;

use Application\Controller\Entities\Turma as TurmaEntity;
use Application\Controller\Repository\Turma as TurmaRepository;
use Application\Controller\Repository\Aluno as AlunoRepository;

class Turma {

	public function __construct() {
		$this->turmaRepository = new TurmaRepository();
	}

	public function getById($turmaId) {
		return $this->validateObject($this->turmaRepository->getById($turmaId));
	}

	public function salvarTurma($turma) {
		$turma = $this->validateObject($turma);
		if ($turma->getId() > 0) {
			$this->turmaRepository->updateTurma($turma);
		} else {
			$turma->setId($this->turmaRepository->saveNewTurma($turma));
		}
		return $turma;
	}

	public function listarTurmas() {
		$turmas = $this->turmaRepository->listAll();
		for ($i = 0; $i < count($turmas); $i++) {
			$turmas[$i] = $this->validateObject($turmas[$i]);
		}
		return $turmas;
	}

	public function apagarTurma($turmaId) {
		$alunoRepository = new AlunoRepository();
		$alunoRepository->deleteAllAlunosByTurmaId($turmaId);
		return $this->turmaRepository->deleteTurmaById($turmaId);
	}

	private function validateObject($turmaArray) {
		if (!is_object($turmaArray)) {
			$turma = new TurmaEntity();
			$turma = $turma->populateEntity($turmaArray);
			return $turma;
		}
		return $turmaArray;
	}

}