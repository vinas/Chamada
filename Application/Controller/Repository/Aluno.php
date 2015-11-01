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

class Aluno extends Utils\General {

	private $db;
	private $table = 'aluno';
	private $classPath = 'Application\Controller\Repository\Turma';

	public function __construct() {
		$this->db = $this->setDatabase();
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
					'turmaId',
					'nome',
					'ra',
					'foto',
					'observacoes',
				),
				array(
					$aluno->getTurmaId(),
					$aluno->getNome(),
					$aluno->getRa(),
					$aluno->getFoto(),
					$aluno->getObservacoes()
				),
				"id = ".$aluno->getId()
			);
			return true;
		} catch (Exception $e) {
			die('['.$this->classPath.'::updateAluno] - '.  $e->getMessage());
		}
		return false;
	}

	public function updateObs($alunoId, $obs) {
		try {
			if (!$alunoId) {
				throw new \Exception("Aluno sem ID");
			}
			$this->db->updateRow(
				$this->table,
				array('observacoes'),
				array($obs),
				"id = ".$alunoId
			);
			return true;
		} catch (Exception $e) {
			die('['.$this->classPath.'::updateObs] - '.  $e->getMessage());
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

	public function deleteAllAlunosByTurmaId($turmaId) {
		try {
			if (!$turmaId) {
				throw new \Exception("ID da turma nao enviado");
			}
			$this->db->deleteRow(
				$this->table,
				"turmaId = ".$turmaId
			);
			return true;
		} catch (Exception $e) {
			die('['.$this->classPath.'::deleteAllAlunosByTurmaId] - '.  $e->getMessage());
		}
		return false;
	}

	public function listByTurmaId($turmaId, $limit = 0) {
		try {
			return $this->db->getAllRows($this->table, '*', 'turmaId = '.$turmaId.' ORDER BY nome', $limit);
		} catch (Exception $e) {
			die('['.$this->classPath.'::listByTurmaId] - '.  $e->getMessage());
		}
	}

	public function listBasicByTurmaId($turmaId) {
		try {
			return $this->db->getAllRows($this->table, 'id, nome', 'turmaId = '.$turmaId.' ORDER BY nome');
		} catch (Exception $e) {
			die('['.$this->classPath.'::listBasicByTurmaId] - '.  $e->getMessage());
		}
	}

}
