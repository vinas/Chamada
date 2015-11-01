<?php

/************************************************************************************
* Name:				Turma Repository												*
* File:				Application\Controller\Repository\Turma.php						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Service with information.			*
*																					*
* Creation Date:	19/04/2015														*
* Version:			1.15.0419														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace Application\Controller\Repository;

use Application\Controller\Entities\Turma as TurmaEntity;

class Turma extends \SaSeed\Database\DAO {

	private $db;
	private $table = 'turma';
	private $classPath = 'Application\Controller\Repository\Turma';
	private $turma;

	public function __construct() {
		$this->db = self::setDatabase('localhost');
		$this->turma = new TurmaEntity();
	}

	public function getById($turmaId = false) {
		try {
			return $this->turma->populateMe(
				$this->db->getRow(
					$this->table,
					'*',
					"id = ".$turmaId
				)
			);
		} catch (Exception $e) {
			throw('['.$this->classPath.'::getById] - '.  $e->getMessage());
		}
		return false;
	}

	public function listAll() {
		try {
			$turmas = $this->db->getAllRows($this->table, '*');
			for ($i = 0; $i < count($turmas); $i++) {
				$turma = new TurmaEntity();
				$turmas[$i] = $turma->populateMe($turmas[$i]);
			}
			return $turmas;
		} catch (Exception $e) {
			throw('['.$this->classPath.'::listAll] - '.  $e->getMessage());
		}
	}

	public function saveNewTurma($turma) {
		try {
			$this->db->insertRow(
				$this->table,
				array(
					$turma->getTurma(),
					$turma->getSemestre(),
					$turma->getPeriodo()
				)
			);
			return $this->db->lastId();
		} catch (Exception $e) {
			throw('['.$this->classPath.'::saveNewTurma] - '.  $e->getMessage());
		}
	}

	public function updateTurma($turma) {
		try {
			$this->db->updateRow(
				$this->table,
				array(
					'turma',
					'semestre',
					'periodo'
				),
				array(
					$turma->getTurma(),
					$turma->getSemestre(),
					$turma->getPeriodo()
				),
				"id = ".$turma->getId()
			);
			return true;
		} catch (Exception $e) {
			throw('['.$this->classPath.'::updateTurma] - '.  $e->getMessage());
		}
		return false;
	}

	public function deleteTurmaById($turmaId = false) {
		try {
			if (!$turmaId) {
				throw new \Exception("ID da Turma nao enviado");
			}
			$this->db->deleteRow(
				$this->table,
				"id = ".$turmaId
			);
			return true;
		} catch (Exception $e) {
			throw('['.$this->classPath.'::updateTurma] - '.  $e->getMessage());
		}
		return false;
	}

}
