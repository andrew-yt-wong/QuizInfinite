$("#quizpage").addClass("active");
$(".quiz-title").on("click", function() {
	$(".question").css("border-left", "none");
	$(this).css("border-left", "10px solid #4066E0");
});

$("#quiz-title").focus(function() {
	$(this).css("outline", "none");
	$(this).select();
	$("#titlehr").css("border-color", "#663399");
});

$("#quiz-title").blur(function() {
	$("#titlehr").css("border-color", "lightgrey");
});

$("#quiz-desc").focus(function() {
	$(this).css("outline", "none");
	$(this).select();
	$("#deschr").css("border-color", "#663399");
});

$("#quiz-desc").blur(function() {
	$("#deschr").css("border-color", "lightgrey");
});

$("#page").on("focus", ".question-name", function() {
	$(this).css("outline", "none");
	$(this).select();
	$(this).next().css("border-color", "#663399");
});

$("#page").on("blur", ".question-name", function() {
	$(this).next().css("border-color", "lightgrey");
});

$("#page").on("focus", ".option-input", function() {
	$(this).css("outline", "none");
	$(this).select();
	$(this).next().next().css("border-color", "#663399");
});

$("#page").on("blur", ".option-input", function() {
	$(this).next().next().css("border-color", "lightgrey");
});

$("#page").on("click", ".question", function() {
	$(".question").css("border-left", "none");
	$(".quiz-title").css("border-left", "none");
	$(this).css("border-left", "10px solid #4066E0");
});

$("#page").on("click", ".dropdown-item", function() {
	$(this).parent().prev().html($(this).html());
	let $options = $(this).parent().parent().parent().parent().next().next().children();
	if ($options.length == 0) {
		if ($(this).html() == "<i class=\"fas fa-grip-lines\" aria-hidden=\"true\"></i> Short Answer") {
			$(this).parent().parent().parent().parent().next().next().next().css("display", "none");
			$(this).parent().parent().parent().parent().next().next().css("display", "none");
			$(this).parent().parent().parent().parent().next().css("display", "block");
		}
		else {
			$(this).parent().parent().parent().parent().next().css("display", "none");
			$(this).parent().parent().parent().parent().next().next().css("display", "block");
			$(this).parent().parent().parent().parent().next().next().next().css("display", "inline-block");
		}
	}
	for (let i = 0; i < $options.length; ++i) {
		let $label = $($options.get(i)).children(":first");
		$(this).parent().parent().parent().parent().next().css("display", "none");
		$(this).parent().parent().parent().parent().next().next().css("display", "block");
		$(this).parent().parent().parent().parent().next().next().next().css("display", "inline-block");
		if ($(this).html() == "<i class=\"far fa-dot-circle\" aria-hidden=\"true\"></i> Multiple Choice")
			$label.html("<i class=\"far fa-circle\"></i>");
		else if ($(this).html() == "<i class=\"fas fa-check-square\" aria-hidden=\"true\"></i> Checkboxes")
			$label.html("<i class=\"far fa-square\"></i>");
		else if ($(this).html() == "<i class=\"fas fa-caret-square-down\" aria-hidden=\"true\"></i> Dropdown")
			$label.html("<i class=\"far fa-caret-square-down\"></i>");
		else {
			$(this).parent().parent().parent().parent().next().next().next().css("display", "none");
			$(this).parent().parent().parent().parent().next().next().css("display", "none");
			$(this).parent().parent().parent().parent().next().css("display", "block");
		}
	}
});

$("#page").on("click", ".add-option", function() {
	let type = $(this).prev().prev().prev().find(".dropdownMenuButton").html();

	let div = document.createElement("div");
	$(div).addClass("option");

	let label = document.createElement("label");
	let input = document.createElement("input");
	let i = document.createElement("i");
	let hr = document.createElement("hr");

	if (type == "<i class=\"far fa-dot-circle\" aria-hidden=\"true\"></i> Multiple Choice")
		$(label).html("<i class=\"far fa-circle\"></i>");
	else if (type == "<i class=\"fas fa-check-square\" aria-hidden=\"true\"></i> Checkboxes")
		$(label).html("<i class=\"far fa-square\"></i>");
	else if (type == "<i class=\"fas fa-caret-square-down\" aria-hidden=\"true\"></i> Dropdown")
		$(label).html("<i class=\"far fa-caret-square-down\"></i>");

	$(input).addClass("option-input")
	$(input).attr("type", "text");
	$(input).attr("placeholder", "Option");
	$(input).attr("value", "Option");

	$(i).addClass("fas fa-times delete-option");

	$(div).append(label);
	$(div).append(input);
	$(div).append(i);
	$(div).append(hr);

	$(this).prev().append(div);
});

$(".add-question").on("click", function() {
	$(this).prev().append(
		"<div class=\"question\">" +
			"<div class=\"row\">" +
				"<div class=\"col-lg-7 col-md-8 col-sm-12\">" +
					"<input type=\"text\" class=\"question-name\" placeholder=\"Question\" value=\"Untitled Question\" name=\"question-name\">" +
					"<hr/>" +
				"</div>" +
				"<div class=\"col-lg-5 col-md-4 col-sm-12\">" +
					"<div class=\"dropdown\">" +
						"<button class=\"btn dropdown-toggle dropdownMenuButton\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><i class=\"far fa-dot-circle\"></i> Multiple Choice</button>" +
						"<div class=\"dropdown-menu\">" +
							"<div class=\"dropdown-item\"><i class=\"fas fa-grip-lines\"></i> Short Answer</div>" +
							"<div class=\"dropdown-item\"><i class=\"far fa-dot-circle\"></i> Multiple Choice</div>" +
							"<div class=\"dropdown-item\"><i class=\"fas fa-check-square\"></i> Checkboxes</div>" +
							"<div class=\"dropdown-item\"><i class=\"fas fa-caret-square-down\"></i> Dropdown</div>" +
						"</div>" +
					"</div>" +
				"</div>" +
			"</div>" +
			"<div class=\"short-answer\">" +
				"<label>Short Answer</label>" +
				"<hr/>" +
			"</div>" +
			"<div class=\"option-list\">" +
				"<div class=\"option\">" +
					"<label><i class=\"far fa-circle\"></i></label>" +
					"<input type=\"text\" class=\"option-input\" placeholder=\"Option\" value=\"Option\"/>" +
					"<i class=\"fas fa-times delete-option\"></i>" +
					"<hr/>" +
				"</div>" +
			"</div>" +
			"<i class=\"fas fa-plus-square add-option\"></i>\n" +
			"<i class=\"fas fa-trash delete-question\"></i>" +
		"</div>");
});

$("#page").on("click", ".delete-question", function() {
	$(this).parent().remove();
});

$("#page").on("click", ".delete-option", function() {
	$(this).parent().remove();
});