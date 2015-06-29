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
			$.displayTimedAlert($("#messageBox"), res.message, 2000);
		}, "json");
		$("#formNovaTurma")[0].reset();
		return false;
	});

	$(document).on("submit", "#formEditaTurma", function() {
		$.post ("/Chamada/Turmas/editarTurma", $(this).serialize(), function(res) {
			$.displayTimedAlert($("#messageBox"), res.message, 3000);
			$("#listarTurmas").click();
		}, "json");
		$("#formEditaTurma")[0].reset();
		return false;
	});

	$(document).on("submit", "#formNovoAluno", function() {
		$.post ("/Chamada/Alunos/salvarAluno", $(this).serialize(), function(res) {
			$.displayTimedAlert($("#messageBox"), res.message, 2000);
		}, "json");
		$("#formNovoAluno")[0].reset();
		$("#fotoAluno").attr("src", "");
		return false;
	});

	$(document).on("submit", "#formEditaAluno", function() {
		$.post ("/Chamada/Alunos/salvarAluno", $(this).serialize(), function(res) {
			$.displayTimedAlert($("#messageBox"), res.message, 3000);
			$.loadJsonToContainer("/Chamada/Alunos/listarAlunos", $("#turmaId").val());
		}, "json");
		return false;
	});

	$("#LogMeOff").on("click", function() {
		window.location.replace("/Chamada/Login/out");
	});

	$(document).on("click", ".apagarTurma", function() {
		$.post ("/Chamada/Turmas/apagarTurma", {turmaId: $(this).attr("key")}, function(res) {
			$.displayTimedAlert($("#messageBox"), res.message, 2000);
			$.displayAnimatedContent($("#container"), res.content);
		}, "json");
	});

	$(document).on("click", ".apagarAluno", function() {
		if (confirm("Deseja realmente APAGAR o(a) aluno(a)\n" + $(this).prev().html() + "?")) {
			$.post ("/Chamada/Alunos/apagarAluno", {id: $(this).attr("key")}, function(res) {
				$.displayTimedContent($("#messageBox"), res.message, 2000);
				$.displayAnimatedContent($("#container"), res.content);
			}, "json");
		}
	});

	$(document).on("change", "#turmaId", function() {
		$.loadToContainer("/Chamada/Chamada/fazerChamada", $(this).val());
	});

	$(document).on("click", ".chamada", function() {
		$.loadToContainer("/Chamada/Chamada/fazerChamada", $(this).attr("key"));
	});

	$(document).on("click", ".editChamada", function() {
		$.post ("/Chamada/Chamada/gridChamada", 
		{key: $(this).attr("key")},
		function(res) {
			if (res.response == 0) {
				$.displayAnimatedContent($("#messageBox"), res.message);
			} else {
				$.displayAnimatedContent($("#container"), res.content);
				setTimeout(function() {
					$("#dataChamadaTurma").mask("99/99/9999", {placeholder:"dd/mm/aaaa"});
				}, 500);
			}
		}, "json");
	});

	$(document).on("click", ".editChamadaAluno", function() {
		$.post ("/Chamada/editChamadaAluno",{
			key: $(this).attr("key"),
			date: $(this).attr("date")
		}, function(res) {
			if (res.response == 0) {
				$.displayAnimatedContent($("#messageBox"), res.message);
			} else {
				$.displayAnimatedContent($("#container"), res.content);
			}
		}, "json");
	});

	$(document).on("click", "#alunoContainer #veio", function() {
		$.processaPresenca();
	});

	$(document).on("click", "#alunoContainer #naoVeio", function() {
		$.processaFalta();
	});

	$(document).on("click", ".mudarData", function() {
		$(this).hide();
		$(".dataChamadaTurma").show();
		$("#dataChamadaTurma").focus();
	});

	$(document).on("focusout", "#dataChamadaTurma", function() {
		$.dataChamadaTurma();
	});

	$(document).on("keypress", "#dataChamadaTurma", function(e) {
		if (e.keyCode == 13) {
			$.dataChamadaTurma();
		}
	});

	$.dataChamadaTurma = function() {
		$(".dataChamadaTurma").hide();
		$("#mudarData").show();
	};

	$.salvarObservacao = function(idAluno, obs) {
		$.post ("/Chamada/Alunos/salvarObservacao", {obs: obs, idAluno: idAluno});

	};

	$.processaPresenca = function() {
		idAluno = $("#alunoContainer #idAluno").val();
		obs = $("#alunoContainer #obsAluno").val();
		$.salvarObservacao(idAluno, obs);
		$.setPresence($("#idTurma").val(), idAluno);
		$.loadStudent(true);
	};

	$.processaFalta = function() {
		idAluno = $("#alunoContainer #idAluno").val();
		obs = $("#alunoContainer #obsAluno").val();
		$.salvarObservacao(idAluno, obs);
		$.setAbsence($("#idTurma").val(), idAluno);
		$.loadStudent(false);
	};

	$.setPresence = function(idTurma, idAluno) {
		$.post ("/Chamada/Chamada/darPresenca", {
			idAluno: idAluno,
			idTurma: idTurma
		}, function(res) {
			//console.log(res);
		}, "json");
	};

	$.setAbsence = function(idTurma, idAluno) {
		$.post ("/Chamada/Chamada/darFalta", {
			idAluno: idAluno,
			idTurma: idTurma
		}, function(res) {
			//console.log(res);
		}, "json");
	};

	$.swapLayersContent = function() {
		$("#alunoContainer").html($("#preAlunoContainer").html());
		$("#preAlunoContainer").html("");
	};

	$.loadStudent = function(presente) {
		if ($("#preAlunoContainer #idAluno").val()) {
			margin = (presente) ? 200 : 0;
			$("#alunoContainer").animate({
				"margin-left": margin,
				"opacity": 0
			}, 300, function() {
				$("#alunoContainer").css("margin-left", 100);
				$.swapLayersContent();
				$.loadBkgLayer();
				$("#alunoContainer").animate({
					"opacity": 100
				}, 300);
			});
		} else {
			$("#preAlunoContainer").html("").hide();
			$("#alunoContainer").html("").hide();
			alert("acabou a chamada");
			$.loadToContainer("/Chamada/Chamada/");
		}
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

	$.displayTimedAlert = function(obj, content, msecs) {
		$.displayAnimatedAlert(obj, content);
		setTimeout(function() {
			obj.slideUp(200);
		}, msecs);
	};

	$.displayTimedContent = function(obj, content, msecs) {
		$.displayAnimatedContent(obj, content);
		setTimeout(function() {
			obj.slideUp(200);
		}, msecs);
	};

	$.displayAnimatedContent = function(obj, content, msecs) {
		if (!msecs) msecs = 400;
		obj.slideUp(200);
		setTimeout(function() {
			obj.html(content).slideDown(msecs);
		}, 200);
	};

	$.displayAnimatedAlert = function(obj, content, msecs) {
		if (!msecs) msecs = 400;
		obj.hide(200);
		setTimeout(function() {
			obj.html(content).show(msecs);
		}, 200);
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