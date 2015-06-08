<?php
/************************************************************************************
* Name:				Chamada Model													*
* File:				Application\Model\Chamada.php 									*
* Author(s):		Vinas de Andrade												*
*																					*
* Description: 		This is the Chamada's model.									*
*																					*
* Creation Date:	2/04/2015														*
* Version:			1.15.042														*
* License:			http://www.opensource.org/licenses/bsd-license.php BSD			*
*************************************************************************************/

namespace Application\Model;

use SaSeed\General;

class Chamada {

	private $classPath = 'Application\Model\Chamada';

	/*public function home($turmas) {
		$content = '<br />'.PHP_EOL;
		$content .= '<div>'.PHP_EOL;
		$content .= '		Selecione a turma: '.PHP_EOL;
		$content .= '		<select name="turmaId" id="turmaId">'.PHP_EOL;
		$content .= '			<option value="0">selecione a turma...</option>'.PHP_EOL;
		foreach ($turmas as $turma) {
			$content .= '			<option value="'.$turma->getId().'">'
										.$turma->getTurma().' - '.$turma->getPeriodoExtenso()
										.' - '.$turma->getSemestre().'o S</option>'.PHP_EOL;
		}	
		$content .= '		</select>'.PHP_EOL;
		$content .= '</div>'.PHP_EOL;
		return $content;
	}*/

	public function home($turmas, $turmasHoje) {
		$content = '';
		if (count($turmas) > 0) {
			$content	.= '<div class="result_header">'.PHP_EOL;
			$content	.= '	<div class="result_header_field" style="width: 35%; text-align: center;">Turma</div>'.PHP_EOL;
			$content	.= '	<div class="result_header_field" style="width: 15%; text-align: center;">Semestre</div>'.PHP_EOL;
			$content	.= '	<div class="result_header_field" style="width: 33%; text-align: center;">Periodo</div>'.PHP_EOL;
			$content	.= '	<div class="result_header_field" style="width: 15%; text-align: center;">&nbsp;</div>'.PHP_EOL;
			$content	.= '</div>'.PHP_EOL;
			$content .= '<div class="result_body">'.PHP_EOL;
			foreach ($turmas as $turma) {

				$edit = false;
				foreach ($turmasHoje as $hoje) {
					if ($turma->getId() == $hoje['turmaId']) {
						$edit = true;
						break;
					}
				}
				
				if ($edit) {
					$rowSubClass = 'edit';
					$subClass = 'grid';
					$action = '		<div class="result_field grid" key="'.$turma->getId().'" style="width: 15%; text-align: center;"><img src="/Chamada/Application/View/img/notepad.gif" width="12" height="12" />Editar</div>'.PHP_EOL;
				} else {
					$rowSubClass = 'new';
					$subClass = 'chamada';
					$action = '		<div class="result_field chamada" key="'.$turma->getId().'" style="width: 15%; text-align: center;"><img src="/Chamada/Application/View/img/notepad.gif" width="12" height="12" />Chamada</div>'.PHP_EOL;
				}
				
				$content .= '	<div class="return_row '.$rowSubClass.'">'.PHP_EOL;
				$content .= '		<div class="result_field '.$subClass.'" key="'.$turma->getId().'" style="width: 35%;">'.$turma->getTurma().'</div>'.PHP_EOL;
				$content .= '		<div class="result_field '.$subClass.'" key="'.$turma->getId().'" style="width: 15%; text-align: center;">'.$turma->getSemestre().'</div>'.PHP_EOL;
				$content .= '		<div class="result_field '.$subClass.'" key="'.$turma->getId().'" style="width: 33%;">'.$turma->getPeriodoExtenso().'</div>'.PHP_EOL;
				$content .= $action;
				$content .= '	</div>'.PHP_EOL;
			}
			$content .= '</div>'.PHP_EOL;
		}
		return $content;
	}

	public function chamada($turma, $alunos, $listaAlunos) {
		$pilhaTurma = false;
		$totAlunos = count($listaAlunos);
		$content = '<br />'.PHP_EOL;
		$content .= '<div>'.PHP_EOL;
		$content .= '	<div><b>'.$turma->getTurma().' - '.$turma->getPeriodoExtenso()
							.' - '.$turma->getSemestre().'o S</b></div>'.PHP_EOL;
		$content .= '	<br />'.PHP_EOL;

		$content .= '		<input type="hidden" id="idTurma" name="idTurma" value="'.$turma->getId().'"/>'.PHP_EOL;

		if ($totAlunos > 0) {
			for ($i = 2; $i < $totAlunos; $i++) {
				$pilhaTurma .= ($pilhaTurma) ? ',' . $listaAlunos[$i]->getId() : $listaAlunos[$i]->getId();
			}
			$content .= '		<input type="hidden" id="pilhaTurma" name="pilhaTurma" value="'.$pilhaTurma.'"/>'.PHP_EOL;

			if (isset($alunos[1])) {
				$content .= '	<div id="preAlunoContainer" class="alunoContainer">'.PHP_EOL;
				$content .= '		<input type="hidden" id="idAluno" name="idAluno" value="'.$alunos[1]->getId().'"/>'.PHP_EOL;
				$content .= '		<img src="/Chamada/Application/View/img/'.$alunos[1]->getFoto().'" width="320" height="240" />'.PHP_EOL;
				$content .= '		<div id="nomeAluno" class="formTitle"><b>'.$alunos[1]->getNome().'</b></div>'.PHP_EOL;
				$content .= '		<textarea id="obsAluno" class="obsAluno">'.$alunos[1]->getObservacoes().'</textarea>'.PHP_EOL;
				$content .= '		<img id="naoVeio" class="pointyWhenOver salvarObservacao" src="/Chamada/Application/View/img/bt_cancel.png" />'.PHP_EOL;
				$content .= '		<img id="veio" class="pointyWhenOver salvarObservacao" src="/Chamada/Application/View/img/bt_add.png" />'.PHP_EOL;
				$content .= '		<br />'.PHP_EOL;
				$content .= '	</div>'.PHP_EOL;
			}
			$content .= '	<div id="alunoContainer" class="alunoContainer">'.PHP_EOL;
			$content .= '		<input type="hidden" id="idAluno" name="idAluno" value="'.$alunos[0]->getId().'"/>'.PHP_EOL;
			$content .= '		<img src="/Chamada/Application/View/img/'.$alunos[0]->getFoto().'" width="320" height="240" />'.PHP_EOL;
			$content .= '		<div id="nomeAluno" class="formTitle"><b>'.$alunos[0]->getNome().'</b></div>'.PHP_EOL;
			$content .= '		<textarea id="obsAluno" class="obsAluno">'.$alunos[0]->getObservacoes().'</textarea>'.PHP_EOL;
			$content .= '		<img id="naoVeio" class="pointyWhenOver salvarObservacao" src="/Chamada/Application/View/img/bt_cancel.png" />'.PHP_EOL;
			$content .= '		<img id="veio" class="pointyWhenOver salvarObservacao" src="/Chamada/Application/View/img/bt_add.png" />'.PHP_EOL;
			$content .= '		<br />'.PHP_EOL;
			$content .= '	</div>'.PHP_EOL;
		} else {
			$content .= '	<div>Não ha alunos nessa turma</div>'.PHP_EOL;
		}

	
		$content .= '</div>'.PHP_EOL;
		return $content;
	}

	public function alunoLayer($aluno) {
		$content = '';
		$content .= '		<input type="hidden" id="idAluno" name="idAluno" value="'.$aluno->getId().'"/>'.PHP_EOL;
		$content .= '		<img src="/Chamada/Application/View/img/'.$aluno->getFoto().'" width="320" height="240" />'.PHP_EOL;
		$content .= '		<div id="nomeAluno" class="formTitle"><b>'.$aluno->getNome().'</b></div>'.PHP_EOL;
		$content .= '		<textarea id="obsAluno" class="obsAluno">'.$aluno->getObservacoes().'</textarea>'.PHP_EOL;
		$content .= '		<img id="naoVeio" class="pointyWhenOver salvarObservacao" src="/Chamada/Application/View/img/bt_cancel.png" />'.PHP_EOL;
		$content .= '		<img id="veio" class="pointyWhenOver salvarObservacao" src="/Chamada/Application/View/img/bt_add.png" />'.PHP_EOL;
		$content .= '		<br />'.PHP_EOL;
		return $content;
	}

}
