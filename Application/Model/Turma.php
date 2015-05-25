<?php
/************************************************************************************
* Name:				Turma Model														*
* File:				Application\Model\Turma.php 									*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the Turma's model.										*
*																					*
* Creation Date:	14/04/2015														*
* Version:			1.15.0414														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

namespace Application\Model;

class Turma {

	private $classPath = 'Application\Model\Turma';

	public function savedMessage($turma) {
		$content = '';
		try {
			$content .= '<br /><div>O turma <b>"'.$turma->getTurma().' - '.$turma->getPeriodoExtenso().
				' - '.$turma->getSemestre().'o S</b>" foi ADICIONADA com sucesso!</div>'.PHP_EOL;
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

	public function deletedMessage($turma) {
		$content = '';
		try {
			$content .= '<div>O turma <b>"'.$turma->getTurma().' - '.$turma->getPeriodoExtenso().
				' - '.$turma->getSemestre().'o S</b>" foi APAGADA com sucesso!</div>'.PHP_EOL;
		} catch (Exception $e) {
			die('['.$this->classPath.'::deletedMessage] - '.  $e->getMessage());
		}
		return $content;
	}

	public function turmaForm($turma) {
		$content = '<br />'.PHP_EOL;
		$content .= '<div>'.PHP_EOL;
		if ($turma->getId() > 0) {
			$content .= '	<form id="formEditaTurma">'.PHP_EOL;
			$content .= '		<input type="hidden" name="id" id="id" value="'.$turma->getId().'" />'.PHP_EOL;
			$content .= '		<div class="title">Editar turma</div>'.PHP_EOL;
		} else {
			$content .= '	<form id="formNovaTurma">'.PHP_EOL;
			$content .= '		<div class="title">Nova turma</div>'.PHP_EOL;
		}
		$content .= '		<label for="turma">Turma:</label><input type="text" name="turma" id="turma" value="'.$turma->getTurma().'" /><br />'.PHP_EOL;
		$content .= '		<label for="semestre">Semestre:</label>'.PHP_EOL;
		$content .= '		<select name="semestre" id="semestre">'.PHP_EOL;
		$content .= '			<option value="1" '.(($turma->getSemestre() == 1) ? 'selected="selected"' : ' ').'>1</option>'.PHP_EOL;
		$content .= '			<option value="2" '.(($turma->getSemestre() == 2) ? 'selected="selected"' : ' ').'>2</option>'.PHP_EOL;
		$content .= '			<option value="3" '.(($turma->getSemestre() == 3) ? 'selected="selected"' : ' ').'>3</option>'.PHP_EOL;
		$content .= '			<option value="4" '.(($turma->getSemestre() == 4) ? 'selected="selected"' : ' ').'>4</option>'.PHP_EOL;
		$content .= '			<option value="5" '.(($turma->getSemestre() == 5) ? 'selected="selected"' : ' ').'>5</option>'.PHP_EOL;
		$content .= '			<option value="6" '.(($turma->getSemestre() == 6) ? 'selected="selected"' : ' ').'>6</option>'.PHP_EOL;
		$content .= '			<option value="7" '.(($turma->getSemestre() == 7) ? 'selected="selected"' : ' ').'>7</option>'.PHP_EOL;
		$content .= '			<option value="8" '.(($turma->getSemestre() == 8) ? 'selected="selected"' : ' ').'>8</option>'.PHP_EOL;
		$content .= '		</select>'.PHP_EOL;
		$content .= '		<br />'.PHP_EOL;
		$content .= '		<label for="periodo">Periodo:</label>'.PHP_EOL;
		$content .= '		<select name="periodo" id="periodo">'.PHP_EOL;
		$content .= '			<option value="1" '.(($turma->getPeriodo() == 1) ? 'selected="selected"' : ' ').'>Diurno</option>'.PHP_EOL;
		$content .= '			<option value="2" '.(($turma->getPeriodo() == 2) ? 'selected="selected"' : ' ').'>Noturno</option>'.PHP_EOL;
		$content .= '		</select>'.PHP_EOL;
		$content .= '		<br /><br /><br /><br />'.PHP_EOL;
		$content .= '		<div class="formButtons">'.PHP_EOL;
		$content .= '			<img id="submit" class="pointyWhenOver" src="/Chamada/Application/View/img/bt_add.png" />'.PHP_EOL;
		$content .= '		</div>'.PHP_EOL;
		$content .= '	</form>'.PHP_EOL;
		$content .= '</div>'.PHP_EOL;

		return $content;
	}

	public function listarTurmas($turmas) {
		$content = '<div class="subMenu">'.PHP_EOL;
		$content .= '	<div class="pointyWhenOver" id="novaTurma"><b>+ Adicionar Nova turma</b></div>'.PHP_EOL;
		$content .= '</div>'.PHP_EOL;
		if (count($turmas) > 0) {
			$content .= $this->resultHeader();
			foreach ($turmas as $turma) {
				$content .= '<div class="return_row">'.PHP_EOL;
				$content .= '	<div class="result_field abrirTurma" key="'.$turma->getId().'" style="width: 35%;">'.$turma->getTurma().'</div>'.PHP_EOL;
				$content .= '	<div class="result_field abrirTurma" key="'.$turma->getId().'" style="width: 15%; text-align: center;">'.$turma->getSemestre().'</div>'.PHP_EOL;
				$content .= '	<div class="result_field abrirTurma" key="'.$turma->getId().'" style="width: 33%;">'.$turma->getPeriodoExtenso().'</div>'.PHP_EOL;
				$content .= '	<div class="result_field chamada" key="'.$turma->getId().'" style="width: 15%; text-align: center;"><img src="/Chamada/Application/View/img/notepad.gif" width="12" height="12" />Chamada</div>'.PHP_EOL;
				/*$content .= '<div class="pointyWhenOver addAluno" key="'.$turma->getId().'"><b>(Add Aluno)</b></div>'.PHP_EOL;
				$content .= '		<div class="pointyWhenOver listarAlunos" key="'.$turma->getId().'"><b>(Listar Alunos)</b></div>'.PHP_EOL;
				$content .= '		<div class="pointyWhenOver abrirTurma" key="'.$turma->getId().'"><b>(Editar)</b></div>'.PHP_EOL;
				$content .= '		<div class="pointyWhenOver apagarTurma" key="'.$turma->getId().'"><b>(Excluir - X)</b></div>'.PHP_EOL;*/
				$content .= '	</div>'.PHP_EOL;
				$content .= '</div><br />'.PHP_EOL;
			}
		}
		return $content;
	}

	private	function resultHeader() {
		$content	= '<div class="result_header">'.PHP_EOL;
		$content	.= '	<div class="result_header_field" style="width: 35%; text-align: center;">Turma</div>'.PHP_EOL;
		$content	.= '	<div class="result_header_field" style="width: 15%; text-align: center;">Semestre</div>'.PHP_EOL;
		$content	.= '	<div class="result_header_field" style="width: 33%; text-align: center;">Periodo</div>'.PHP_EOL;
		$content	.= '	<div class="result_header_field" style="width: 15%; text-align: center;">&nbsp;</div>'.PHP_EOL;
		$content	.= '</div><br />'.PHP_EOL;
		return $content;
	}
}
