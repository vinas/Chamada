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
use Application\Controller\Repository\Chamada as ChamadaRepository;

class Turma {

	public function __construct() {
		$this->turmaRepository = new TurmaRepository();
	}

	public function getById($turmaId) {
		if ($turmaId) {
			return $this->turmaRepository->getById($turmaId);
		}
		throw new \Exception("ID da Turma nao enviado");
	}

	public function salvarTurma($turma) {
		if ($turma->getId() > 0) {
			$this->turmaRepository->updateTurma($turma);
		} else {
			$turma->setId($this->turmaRepository->saveNewTurma($turma));
		}
		return $turma;
	}

	public function listarTurmas() {
		return $this->turmaRepository->listAll();
	}

	public function apagarTurma($turmaId) {
		$alunoRepository = new AlunoRepository();
		$alunoRepository->deleteAllAlunosByTurmaId($turmaId);
		return $this->turmaRepository->deleteTurmaById($turmaId);
	}

	/*public function listTurmasChamadasHoje() {
		$chamadaRepository = new ChamadaRepository();
		return $chamadaRepository->listTurmasChamadasHoje();
	}*/

}