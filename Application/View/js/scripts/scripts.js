$(document).on("ready", function() {

	$("#LogMeIn").on("click", function() {
		$.post ("/Chamada/Login/in", $("#loginForm").serialize(), function(res) {
			if (res.response == 0) {
				$("#messageBox").html(res.message);
			} else {
				window.location.replace(res.url);
			}
		}, "json");
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
	}

});