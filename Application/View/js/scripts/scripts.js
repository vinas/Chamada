$(document).on("ready", function() {

	$("#LogMeIn").on("click", function() {
		$.postLogin();
		return false;
	});

	$(document).on("submit", "#loginForm", function() {
		$.postLogin();
		return false;
	});

	$(document).on("keypress", "#password", function(e) {
		if (e.charCode == 13) $.postLogin();
	});

	$(document).on("submit", "#formNovaTurma", function() {
		$.post ("/Chamada/Turmas/salvarTurma", $(this).serialize(), function(res) {
			$.displayTimedContent($("#messageBox"), res.message, 2000);
		}, "json");
		$("#formNovaTurma")[0].reset();
		return false;
	});

	$(document).on("submit", "#formEditaTurma", function() {
		$.post ("/Chamada/Turmas/editarTurma", $(this).serialize(), function(res) {
			$.displayTimedContent($("#messageBox"), res.message, 2000);
			$("#listarTurmas").click();
		}, "json");
		$("#formEditaTurma")[0].reset();
		return false;
	});

	$(document).on("submit", "#formNovoAluno", function() {
		$.post ("/Chamada/Alunos/salvarAluno", $(this).serialize(), function(res) {
			$.displayTimedContent($("#messageBox"), res.message, 2000);
		}, "json");
		$("#formNovoAluno")[0].reset();
		return false;
	});

	$(document).on("submit", "#formEditaAluno", function() {
		$.post ("/Chamada/Alunos/salvarAluno", $(this).serialize(), function(res) {
			$.displayTimedContent($("#messageBox"), res.message, 2000);
			$.loadJsonToContainer("/Chamada/Alunos/listarAlunos", $("#turmaId").val());
		}, "json");
		return false;
	});

	$("#LogMeOff").on("click", function() {
		window.location.replace("/Chamada/Login/out");
	});

	$(document).on("click", ".apagarTurma", function() {
		$.post ("/Chamada/Turmas/apagarTurma", {turmaId: $(this).attr("key")}, function(res) {
			$.displayTimedContent($("#messageBox"), res.message, 2000);
			$.displayAnimatedContent($("#container"), res.content);
		}, "json");
	});

	$(document).on("click", ".apagarAluno", function() {
		$.post ("/Chamada/Alunos/apagarAluno", {id: $(this).attr("key")}, function(res) {
			$.displayTimedContent($("#messageBox"), res.message, 2000);
			$.displayAnimatedContent($("#container"), res.content);
		}, "json");
	});

	$(document).on("change", "#turmaId", function() {
		$.loadToContainer("/Chamada/Chamada/fazerChamada", $(this).val());
	});

	$(document).on("click", "#alunoContainer #veio", function() {
		$.processaPresenca();
	});

	$(document).on("click", "#alunoContainer #naoVeio", function() {
		$.processaFalta();
	});

	$.processaPresenca = function() {
		$.setPresence(
			$("#idTurma").val(),
			$("#alunoContainer #idAluno").val()
		);
		$.loadStudent();
	};

	$.processaFalta = function() {
		$.setAbsence(
			$("#idTurma").val(),
			$("#alunoContainer #idAluno").val()
		);
		$.loadStudent();
	};

	$.setPresence = function(idTurma, idAluno) {
		$.post ("/Chamada/Chamada/darPresenca", {
			idAluno: idAluno,
			idTurma: idTurma
		}, function(res) {
			console.log(res);
		}, "json");
	};

	$.setAbsence = function(idTurma, idAluno) {
		$.post ("/Chamada/Chamada/darFalta", {
			idAluno: idAluno,
			idTurma: idTurma
		}, function(res) {
			console.log(res);
		}, "json");
	};

	$.swapLayersContent = function() {
		$("#alunoContainer").html($("#preAlunoContainer").html());
		$("#preAlunoContainer").html("");
	};

	$.loadBkgLayer = function() {
		idAluno = $.getNextStudenId();
		if (idAluno != "") {
			$.reorganizePilhaArray();
			$.post ("/Chamada/Alunos/carregarAluno", {
				idAluno: idAluno
			}, function(res) {
				if (res.response == 1) {
					$("#preAlunoContainer").html(res.content);
				} else {
					console.log(res.console);
				}
			}, "json");
		}
	};

	$.displayTimedContent = function(obj, content, msecs) {
		$.displayAnimatedContent(obj, content);
		setTimeout(function() {
			obj.hide(200);
		}, msecs);
	};

	$.displayAnimatedContent = function(obj, content, msecs) {
		obj.hide();
		obj.html(content);
		if (!msecs) msecs = 400;  
		obj.show(400);
	};

	$.getNextStudenId = function() {
		pilha = $("#pilhaTurma").val();
		pos = pilha.indexOf(",");
		if (pos > -1) {
			return pilha.substring(0, pos);
		} else if (pilha.length > 0) {
			return pilha;
		}
		return false;
	};

	$.reorganizePilhaArray = function() {
		pilha = $("#pilhaTurma").val();
		pos = pilha.indexOf(",");
		if (pos < 0) {
			$("#pilhaTurma").val("");
		} else {
			$("#pilhaTurma").val(pilha.substring(pos + 1));
		}
	};

	$.loadStudent = function() {
		if ($("#preAlunoContainer #idAluno").val()) {
			$.swapLayersContent();
			$.loadBkgLayer();
		} else {
			$("#preAlunoContainer").html("");
			$("#alunoContainer").html("");
			alert("acabou a chamada");
		}
	};

	$.postLogin = function() {
		$.post ("/Chamada/Login/in", $("#loginForm").serialize(), function(res) {
			if (res.response == 0) {
				$.displayTimedErrorMsg(res.message+"<br /><br />");
			} else {
				window.location.replace(res.url);
			}
		}, "json");
	};

	$.displayTimedErrorMsg = function(message) {
		msecs = 3000;
		obj = $("#messageBox");
		$("#messageBox").css("color", "#cd0303")
		$.displayTimedContent(obj, message, msecs);
		setTimeout(function() {
			obj.css("color", "#000");
		}, msecs);
	};

});