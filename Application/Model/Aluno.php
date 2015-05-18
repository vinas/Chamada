<?php
/************************************************************************************
* Name:				Aluno Model														*
* File:				Application\Model\Aluno.php 									*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the Alunos's model.										*
*																					*
* Creation Date:	21/04/2015														*
* Version:			1.15.0421														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

namespace Application\Model;

use SaSeed\General;

class Aluno {

	private $classPath = 'Application\Model\Aluno';

	public function savedMessage($aluno) {
		$content = '';
		try {
			$content .= '<br /><div>O aluno <b>"'.$aluno->getNome().'</b>" foi SALVO com sucesso!</div>'.PHP_EOL;
		} catch (Exception $e) {
			die('['.$this->classPath.'::savedMessage] - '.  $e->getMessage());
		}
		return $content;
	}

	public function editedMessage($turma) {
		$content = '';
		try {
			$content .= '<br /><div>O turma <b>"'.$turma->getTurma().' - '.$turma->getPeriodoExtenso().
				' - '.$turma->getSemestre().'o S</b>" foi ALTERADA com sucesso!</div>'.PHP_EOL;
		} catch (Exception $e) {
			die('['.$this->classPath.'::savedMessage] - '.  $e->getMessage());
		}
		return $content;
	}

	public function deletedMessage($aluno) {
		$content = '';
		try {
			$content .= '<br /><div>O aluno <b>"'.$aluno->getNome().'</b>" foi APAGADO com sucesso!</div>'.PHP_EOL;
		} catch (Exception $e) {
			die('['.$this->classPath.'::deletedMessage] - '.  $e->getMessage());
		}
		return $content;
	}

	public function listarAlunos($alunos, $turma) {
		$content = '';
		$content .= '<div><b>Turma: </b>'.$turma->getTurma().' - '.$turma->getPeriodoExtenso().' - '.$turma->getSemestre().'o Semestre'.PHP_EOL;
		$content .= '<br /><br />';
		if (count($alunos) > 0) {
			$content .= '<div>';
			foreach ($alunos as $aluno) {
				$content .= '<div><b>Id</b> - '.$aluno->getId().'</div>'.PHP_EOL;
				$content .= '<div><b>Nome</b> - '.$aluno->getNome().'</div>'.PHP_EOL;
				$content .= '<div class="pointyWhenOver abrirAluno" key="'.$aluno->getId().'"><b>(Editar)</b></div>'.PHP_EOL;
				$content .= '<div class="pointyWhenOver apagarAluno" key="'.$aluno->getId().'"><b>(Excluir - X)</b></div>'.PHP_EOL;
				$content .= '<br />'.PHP_EOL;
			}
			$content .= '</div>';
		}
		return $content;
	}

	public function alunoForm($aluno, $turma) {
		$content = '		<br />'.PHP_EOL;
		$content .= '<div>'.PHP_EOL;
		$content .= '	<b>Turma: '.$turma->getTurma().' - '.$turma->getPeriodoExtenso().' - '.$turma->getSemestre().'o Semestre<br />'.PHP_EOL;
		if ($aluno->getId() > 0) {
			$content .= '	<form id="formEditaAluno">'.PHP_EOL;
			$content .= '		<input type="hidden" name="id" id="id" value="'.$aluno->getId().'" />'.PHP_EOL;
			$content .= '		<b>Editar aluno</b><br />'.PHP_EOL;
			$content .= '		<br />Id: '.$aluno->getId().'<br />'.PHP_EOL;
		} else {
			$content .= '	<form id="formNovoAluno">'.PHP_EOL;
			$content .= '		<b>Novo aluno</b><br />'.PHP_EOL;
		}
		$content .= '		<input type="hidden" name="turmaId" id="turmaId" value="'.$turma->getId().'" />'.PHP_EOL;
		$content .= '		Foto: <input type="text" name="foto" id="foto" value="'.$aluno->getFoto().'" /><br />'.PHP_EOL;
		$content .= '		Nome: <input type="text" name="nome" id="nome" value="'.$aluno->getNome().'" /><br />'.PHP_EOL;
		$content .= '		Ra: <input type="text" name="ra" id="ra" value="'.$aluno->getRa().'" /><br />'.PHP_EOL;
		$content .= '		Observacoes: <textarea name="observacoes" id="observacoes">'.General::quotes($aluno->getObservacoes()).'</textarea><br />'.PHP_EOL;
		$content .= '		<br />'.PHP_EOL;
		$content .= '		<input type="submit" value="OK" />'.PHP_EOL;
		$content .= '	</form>'.PHP_EOL;
		$content .= '</div>'.PHP_EOL;

return $content;
	}

}
