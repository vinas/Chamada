$(document).on("ready", function() {

	$("#addTurma").on("click", function() {
		$.loadToContainer("/Chamada/Turmas/novaTurma");
	});

	$(document).on("click", ".addAluno", function() {
		$.loadToContainer("/Chamada/Alunos/novoAluno", $(this).attr("key"));
	});

	$("#listarTurmas").on("click", function() {
		$.loadJsonToContainer("/Chamada/Turmas/listarTurmas");
	});

	$(document).on("click", ".listarAlunos", function() {
		$.loadJsonToContainer("/Chamada/Alunos/listarAlunos", $(this).attr("key"));
	});

	$(document).on("click", ".abrirTurma", function() {
		$.loadToContainer("/Chamada/Turmas/abrirTurma", $(this).attr("key"));
	});

	$(document).on("click", "#chamada", function() {
		$.loadToContainer("/Chamada/Chamada/");
	});

	$(document).on("click", ".abrirAluno", function() {
		$.loadJsonToContainer("/Chamada/Alunos/abrirAluno", $(this).attr("key"));
	});


	$.loadToContainer = function(url, key) {
		if (key) {
			key = {key: key};
		}
		$.post (url, key, function(res) {
			if (res.response == 0) {
				$("#messageBox").html(res.message);
			} else {
				$("#container").html(res);
			}
		});
	};

	$.loadJsonToContainer = function(url, key) {
		if (key) {
			key = {key: key};
		}
		$.post (url, key, function(res) {
			if (res.response == 0) {
				$("#messageBox").html(res.message);
			} else {
				$("#container").html(res.content);
			}
		}, "json");
	};
});
