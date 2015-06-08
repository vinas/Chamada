$(document).on("ready", function() {

	$(document).on("click", "#novaTurma", function() {
		$.loadToContainer("/Chamada/Turmas/novaTurma");
	});

	$(document).on("click", ".addAluno", function() {
		$.loadToContainer("/Chamada/Alunos/novoAluno", $(this).attr("key"));
	});

	$("#listarTurmas").on("click", function() {
		$.selectThis($(this));
		$.loadJsonToContainer("/Chamada/Turmas/listarTurmas");
	});

	$(document).on("click", ".listarAlunos", function() {
		$.loadJsonToContainer("/Chamada/Alunos/listarAlunos", $(this).attr("key"));
	});

	$(document).on("click", "#submit", function() {
		form = $(this).closest('form');
		form.submit();
	});

	$(document).on("click", ".abrirTurma", function() {
		$.loadToContainer("/Chamada/Turmas/abrirTurma", $(this).attr("key"));
	});

	$(document).on("click", "#chamada", function() {
		$.selectThis($(this));
		$.loadToContainer("/Chamada/Chamada/");
	});

	$(document).on("click", ".abrirAluno", function() {
		$.loadJsonToContainer("/Chamada/Alunos/abrirAluno", $(this).attr("key"));
	});

	$.selectThis = function(menuItem) {
		$("#mainMenu div").attr("class", "pointyWhenOver bigText menuItemOff");
		menuItem.attr("class", "pointyWhenOver bigText menuItemOn");
	};

	$.loadToContainer = function(url, key) {
		if (key) {
			key = {key: key};
		}
		$.post (url, key, function(res) {
			if (res.response == 0) {
				$.displayAnimatedContent($("#messageBox"), res.message);
			} else {
				$.displayAnimatedContent($("#container"), res);
			}
		});
	};

	$.loadJsonToContainer = function(url, key) {
		if (key) {
			key = {key: key};
		}
		$.post (url, key, function(res) {
			if (res.response == 0) {
				$.displayAnimatedContent($("#messageBox"), res.message);
			} else {
				$.displayAnimatedContent($("#container"), res.content);
			}
		}, "json");
	};
});
