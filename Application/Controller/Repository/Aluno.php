<?php
/************************************************************************************
* Name:				Aluno Repository												*
* File:				Application\Controller\Repository\Aluno.php						*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This' function is to feed the Service with information.			*
*																					*
* Creation Date:	21/04/2015														*
* Version:			1.15.0421														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
************************************************************************************/

namespace Application\Controller\Repository;

class Aluno {

	private $db;
	private $table = 'aluno';
	private $classPath = 'Application\Controller\Repository\Turma';

	public function __construct() {
		$this->db = $GLOBALS['db'];
	}

	public function getById($alunoId = false) {
		try {
			if (!$alunoId) {
				throw new \Exception("ID do Aluno nao enviado");
			}
			return $this->db->getRow($this->table, '*', "id = ".$alunoId);
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

	public function saveNew($aluno) {
		try {
			$this->db->insertRow(
				$this->table,
				array(
					$aluno->getTurmaId(),
					$aluno->getNome(),
					$aluno->getRa(),
					$aluno->getFoto(),
					$aluno->getObservacoes()
				)
			);
			return $this->db->lastId();
		} catch (Exception $e) {
			die('['.$this->classPath.'::saveNew] - '.  $e->getMessage());
		}
	}

	public function update($aluno) {
		try {
			if (!$aluno->getId()) {
				throw new \Exception("Aluno sem ID");
			}
			$this->db->updateRow(
				$this->table,
				array(
					'turma',
					'semestre',
					'periodo'
				),
				array(
					$aluno->getTurma(),
					$aluno->getSemestre(),
					$aluno->getTurma(),
					$aluno->getSemestre(),
					$aluno->getPeriodo()
				),
				"id = ".$aluno->getId()
			);
			return true;
		} catch (Exception $e) {
			die('['.$this->classPath.'::updateAluno] - '.  $e->getMessage());
		}
		return false;
	}

	public function deleteById($id = false) {
		try {
			if (!$id) {
				throw new \Exception("ID do aluno nao enviado");
			}
			$this->db->deleteRow(
				$this->table,
				"id = ".$id
			);
			return true;
		} catch (Exception $e) {
			die('['.$this->classPath.'::deleteById] - '.  $e->getMessage());
		}
		return false;
	}

	public function listByTurmaId($turmaId) {
		try {
			return $this->db->getAllRows($this->table, '*', 'turmaId = '.$turmaId);
		} catch (Exception $e) {
			die('['.$this->classPath.'::listAll] - '.  $e->getMessage());
		}

	}


}
