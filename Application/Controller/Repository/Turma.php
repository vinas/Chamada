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

class Turma {

	private $db;
	private $table = 'turma';
	private $classPath = 'Application\Controller\Repository\Turma';

	public function __construct() {
		$this->db = $GLOBALS['db'];
	}

	public function getById($turmaId = false) {
		try {
			if (!$turmaId) {
				throw new \Exception("ID da Turma nao enviado");
			}
			return $this->db->getRow($this->table, '*', "id = ".$turmaId);
		} catch (Exception $e) {
			die('['.$this->classPath.'::getById] - '.  $e->getMessage());
		}
		return false;
	}

	public function listAll() {
		try {
			return $this->db->getAllRows($this->table, '*');
		} catch (Exception $e) {
			die('['.$this->classPath.'::listAll] - '.  $e->getMessage());
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
			die('['.$this->classPath.'::saveNewTurma] - '.  $e->getMessage());
		}
	}

	public function updateTurma($turma) {
		try {
			if (!$turma->getId()) {
				throw new \Exception("Turma sem ID");
			}
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
			die('['.$this->classPath.'::updateTurma] - '.  $e->getMessage());
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
			die('['.$this->classPath.'::updateTurma] - '.  $e->getMessage());
		}
		return false;
	}

}
