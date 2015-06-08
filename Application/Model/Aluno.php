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
			$content .= '<div>O aluno <b>"'.$aluno->getNome().'</b>" foi SALVO com sucesso!</div>'.PHP_EOL;
		} catch (Exception $e) {
			die('['.$this->classPath.'::savedMessage] - '.  $e->getMessage());
		}
		return $content;
	}

	public function editedMessage($turma) {
		$content = '';
		try {
			$content .= '<div>O turma <b>"'.$turma->getTurma().' - '.$turma->getPeriodoExtenso().
				' - '.$turma->getSemestre().'o S</b>" foi ALTERADA com sucesso!</div>'.PHP_EOL;
		} catch (Exception $e) {
			die('['.$this->classPath.'::savedMessage] - '.  $e->getMessage());
		}
		return $content;
	}

	public function deletedMessage($aluno) {
		$content = '';
		try {
			$content .= '<div>O aluno <b>"'.$aluno->getNome().'</b>" foi APAGADO com sucesso!</div>'.PHP_EOL;
		} catch (Exception $e) {
			die('['.$this->classPath.'::deletedMessage] - '.  $e->getMessage());
		}
		return $content;
	}

	/*public function listarAlunos($alunos, $turma) {
		$content = '<div><b>Turma: </b>'.$turma->getTurma().' - '.$turma->getPeriodoExtenso().' - '.$turma->getSemestre().'o Semestre'.PHP_EOL;
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
	}*/

	public function alunoForm($aluno, $turma) {
		$content = '<div class="subMenu">'.PHP_EOL;
		$content .= '	<div class="pointyWhenOver actionButton abrirTurma" key="'.$turma->getId().'"><b>'.$turma->getTurma().' - '.$turma->getPeriodoExtenso().' - '.$turma->getSemestre().'o Semestre</b></div>'.PHP_EOL;
		$content .= '	<div class="pointyWhenOver listarAlunos actionButton" key="'.$turma->getId().'"><b>&bull; Listar Alunos &bull;</b></div>'.PHP_EOL;
		$content .= '</div>'.PHP_EOL;
		$content .= '<div>'.PHP_EOL;
		if ($aluno->getId() > 0) {
			$content .= '	<form id="formEditaAluno" enctype="multipart/form-data">'.PHP_EOL;
			$content .= '		<input type="hidden" name="id" id="id" value="'.$aluno->getId().'" />'.PHP_EOL;
			$content .= '		<div class="formTitle">Editar Aluno</div>'.PHP_EOL;
			$content .= '		<div class="pointyWhenOver actionButton" id="addFoto"><b>&bull; Alterar Foto &bull;</b></div>'.PHP_EOL;
			$content .= '		<img id="fotoAluno" name="fotoAluno" src="/Chamada/Application/View/img/'.$aluno->getFoto().'" />'.PHP_EOL;
			$content .= '		<br /><label for="id">Id:</label><input type="text" name="id" id="id" value="'.$aluno->getId().'" disabled="disabled" /><br />'.PHP_EOL;
		} else {
			$content .= '	<form id="formNovoAluno" enctype="multipart/form-data">'.PHP_EOL;
			$content .= '		<div class="formTitle">Novo Aluno</div>'.PHP_EOL;
			$content .= '		<div class="pointyWhenOver actionButton" id="addFoto"><b>&bull; Adicionar Foto &bull;</b></div>'.PHP_EOL;
			$content .= '		<img id="fotoAluno" name="fotoAluno" src="" />'.PHP_EOL;
		}

		$content .= '		<input type="hidden" name="turmaId" id="turmaId" value="'.$turma->getId().'" />'.PHP_EOL;
		$content .= '		<input type="hidden" name="foto" id="foto" value="'.$aluno->getFoto().'" />'.PHP_EOL;

		$content .= '		<label for="nome">Nome:</label><input type="text" name="nome" id="nome" value="'.$aluno->getNome().'" /><br />'.PHP_EOL;
		$content .= '		<label for="ra">RA:</label><input type="text" name="ra" id="ra" value="'.$aluno->getRa().'" /><br />'.PHP_EOL;
		$content .= '		<label for="observacoes">Observacoes:</label><textarea name="observacoes" id="observacoes">'.General::quotes($aluno->getObservacoes()).'</textarea><br />'.PHP_EOL;
		$content .= '		<br /><br /><br /><br />'.PHP_EOL;

		$content .= '		<div class="formButtons">'.PHP_EOL;
		$content .= '			<img id="submit" class="pointyWhenOver" src="/Chamada/Application/View/img/bt_add.png" />'.PHP_EOL;
		$content .= '		</div>'.PHP_EOL;

		$content .= '	</form>'.PHP_EOL;
		$content .= '</div>'.PHP_EOL;

		return $content;
	}

	public function listarAlunos($alunos, $turma) {
		$content = '<div class="subMenu">'.PHP_EOL;
		$content .= '	<div class="pointyWhenOver actionButton abrirTurma" key="'.$turma->getId().'"><b>'.$turma->getTurma().' - '.$turma->getPeriodoExtenso().' - '.$turma->getSemestre().'o Semestre</b></div>'.PHP_EOL;
		$content .= '	<div class="pointyWhenOver actionButton addAluno" key="'.$turma->getId().'"><b>&bull; Novo Aluno &bull;</b></div>'.PHP_EOL;
		$content .= '</div>'.PHP_EOL;
		if (count($alunos) > 0) {
			$content .= $this->resultHeader();
			$content .= '<div class="result_body">'.PHP_EOL;
			foreach ($alunos as $aluno) {
				$content .= '	<div class="return_row new">'.PHP_EOL;
				$content .= '		<div class="result_field abrirAluno" key="'.$aluno->getId().'" style="width: 10%;">'.$aluno->getId().'</div>'.PHP_EOL;
				$content .= '		<div class="result_field abrirAluno alunoNome" key="'.$aluno->getId().'" style="width: 70%; text-align: left; padding-left: 2px;">'.$aluno->getNome().'</div>'.PHP_EOL;
				$content .= '		<div class="result_field apagarAluno" key="'.$aluno->getId().'" style="width: 15%; text-align: center;"><img src="/Chamada/Application/View/img/x.gif" width="12" height="12" />Apagar</div>'.PHP_EOL;
				$content .= '	</div>'.PHP_EOL;
			}
			$content .= '</div>'.PHP_EOL;
		}
		return $content;
	}

	private	function resultHeader() {
		$content	= '<div class="result_header">'.PHP_EOL;
		$content	.= '	<div class="result_header_field" style="width: 10%; text-align: center;">Id</div>'.PHP_EOL;
		$content	.= '	<div class="result_header_field" style="width: 70%; text-align: center;">Nome</div>'.PHP_EOL;
		$content	.= '	<div class="result_header_field" style="width: 15%; text-align: center;">&nbsp;</div>'.PHP_EOL;
		$content	.= '</div>'.PHP_EOL;
		return $content;
	}

}
