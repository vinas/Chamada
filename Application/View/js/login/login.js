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

	$.postLogin = function() {
		$.post ("/Chamada/Login/in", $("#loginForm").serialize(), function(res) {
			if (res.response == 0) {
				$.displayTimedErrorMsg(res.message+"<br /><br />");
			} else {
				window.location.replace(res.url);
			}
		}, "json");
	};

});