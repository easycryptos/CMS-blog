$(document).ready(function () {
	//home main slider
	$('#home-slider').slick({
		autoplay: true,
		autoplaySpeed: 4900,
		slidesToShow: 4,
		slidesToScroll: 1,
		infinite: true,
		speed: 200,
		rtl: rtl,
		swipeToSlide: true,
		lazyLoad: 'progressive',
		prevArrow: $('#home-slider-nav .prev'),
		nextArrow: $('#home-slider-nav .next'),
		responsive: [
			{
				breakpoint: 2000,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
	});
	//home boxed slider
	$('#home-slider-boxed').slick({
		autoplay: true,
		autoplaySpeed: 4900,
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: true,
		speed: 200,
		rtl: rtl,
		swipeToSlide: true,
		lazyLoad: 'progressive',
		prevArrow: $('#home-slider-boxed-nav .prev'),
		nextArrow: $('#home-slider-boxed-nav .next'),
	});
	//random post slider
	$('#random-slider').slick({
		autoplay: true,
		autoplaySpeed: 4900,
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: true,
		speed: 200,
		rtl: rtl,
		lazyLoad: 'progressive',
		prevArrow: $('#random-slider-nav .prev'),
		nextArrow: $('#random-slider-nav .next'),
	});
	//post details additional images slider
	$('#post-details-slider').slick({
		autoplay: false,
		autoplaySpeed: 4900,
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: false,
		speed: 200,
		rtl: rtl,
		adaptiveHeight: true,
		lazyLoad: 'progressive',
		prevArrow: $('#post-details-slider-nav .prev'),
		nextArrow: $('#post-details-slider-nav .next'),
	});
});
$(window).load(function () {
	$("#post-details-slider").css('opacity', '1');
});
//redirect onclik
$(document).on('click', '.redirect-onclik', function () {
	var url = $(this).attr('data-url');
	window.location.href = url;
});

//update token
$("form").submit(function () {
	$("input[name='" + csfr_token_name + "']").val($.cookie(csfr_cookie_name));
});

//mobile memu
$(document).on('click', '.btn-open-mobile-nav', function () {
	document.getElementById("navMobile").style.width = "280px";
	$('#overlay_bg').show();
});
$(document).on('click', '.btn-close-mobile-nav', function () {
	document.getElementById("navMobile").style.width = "0";
	$('#overlay_bg').hide();
});
$(document).on('click', '#overlay_bg', function () {
	document.getElementById("navMobile").style.width = "0";
	$('#overlay_bg').hide();
});

//scroll to top
$(window).scroll(function () {
	if ($(this).scrollTop() > 100) {
		$('.scrollup').fadeIn();
	} else {
		$('.scrollup').fadeOut();
	}
});
$('.scrollup').click(function () {
	$("html, body").animate({scrollTop: 0}, 700);
	return false;
});

// Search Modal
$("[data-toggle='modal-search']").click(function () {
	//if click open
	$('body').toggleClass('search-open');
	return false;
});

$(".modal-search .s-close").click(function () {
	//close modal
	$('body').removeClass('search-open');
	return false;
});
//mobile menu search
$(document).on('click', '#search_button', function () {
	$('body').toggleClass('search-open');
});
$(document).on('click', '#mobile_search_button', function () {
	$('body').toggleClass('search-open');
});
$(document).on('click', '.modal-search .s-close', function () {
	$('body').removeClass('search-open');
});


//show slider navigation on hover
$(document).ready(function () {
	$('#home-slider').hover(
		function () {
			$("#home-slider .owl-nav").css({"display": "block"});
		},

		function () {
			$("#home-slider .owl-nav").css({"display": "none"});
		}
	);

	$('#first-tmp-home-slider').hover(
		function () {
			$("#first-tmp-home-slider .owl-nav").css({"display": "block"});
		},

		function () {
			$("#first-tmp-home-slider .owl-nav").css({"display": "none"});
		}
	);
});

//add att to iframe
$(document).ready(function () {
	$('iframe').attr("allowfullscreen", "");
});

//add reaction
function add_reaction(post_id, reaction) {
	var data = {
		post_id: post_id,
		reaction: reaction,
		"sys_lang_id": sys_lang_id
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$.ajax({
		method: "POST",
		url: base_url + "home_controller/save_reaction",
		data: data
	}).done(function (response) {
		document.getElementById("reactions_result").innerHTML = response
	})
}

//view poll results
function view_poll_results(a) {
	$("#poll_" + a + " .question").hide();
	$("#poll_" + a + " .result").show()
}

//view poll option
function view_poll_options(a) {
	$("#poll_" + a + " .result").hide();
	$("#poll_" + a + " .question").show()
}

//poll
$(document).ready(function () {
	var a;
	$(".poll-form").submit(function (d) {
		d.preventDefault();
		if (a) {
			a.abort()
		}
		var b = $(this);
		var c = b.find("input, select, button, textarea");
		var f = b.serializeArray();
		f.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
		var e = $(this).attr("data-form-id");
		a = $.ajax({url: base_url + "home_controller/add_vote", type: "post", data: f,});
		a.done(function (g) {
			c.prop("disabled", false);
			if (g == "required") {
				$("#poll-required-message-" + e).show();
				$("#poll-error-message-" + e).hide();
			} else if (g == "voted") {
				$("#poll-error-message-" + e).show();
				$("#poll-required-message-" + e).hide();
			} else {
				document.getElementById("poll-results-" + e).innerHTML = g;
				$("#poll_" + e + " .result").show();
				$("#poll_" + e + " .question").hide()
			}
		})
	})
});

$(document).ready(function () {
	//make registered comment
	$("#make_comment_registered").submit(function (event) {
		event.preventDefault();
		var form_values = $(this).serializeArray();
		var data = {};
		var submit = true;
		$(form_values).each(function (i, field) {
			if ($.trim(field.value).length < 1) {
				$("#make_comment_registered [name='" + field.name + "']").addClass("is-invalid");
				submit = false;
			} else {
				$("#make_comment_registered [name='" + field.name + "']").removeClass("is-invalid");
				data[field.name] = field.value;
			}
		});
		data['limit'] = $('#post_comment_limit').val();
		data['sys_lang_id'] = sys_lang_id;
		data[csfr_token_name] = $.cookie(csfr_cookie_name);
		if (submit == true) {
			$.ajax({
				type: "POST",
				url: base_url + "home_controller/add_comment_post",
				data: data,
				success: function (response) {
					var obj = JSON.parse(response);
					if (obj.type == 'message') {
						document.getElementById("message-comment-result").innerHTML = obj.message;
					} else {
						document.getElementById("comment-result").innerHTML = obj.message;
					}
					$("#make_comment_registered")[0].reset();
				}
			});
		}

	});

	//make comment
	$("#make_comment").submit(function (event) {
		event.preventDefault();
		var form_values = $(this).serializeArray();
		var data = {};
		var submit = true;
		$(form_values).each(function (i, field) {
			if ($.trim(field.value).length < 1) {
				$("#make_comment [name='" + field.name + "']").addClass("is-invalid");
				submit = false;
			} else {
				$("#make_comment [name='" + field.name + "']").removeClass("is-invalid");
				data[field.name] = field.value;
			}
		});
		data['limit'] = $('#post_comment_limit').val();
		data['sys_lang_id'] = sys_lang_id;
		data[csfr_token_name] = $.cookie(csfr_cookie_name);

		if (is_recaptcha_enabled == true) {
			if (typeof data['g-recaptcha-response'] === 'undefined') {
				$('.g-recaptcha').addClass("is-recaptcha-invalid");
				submit = false;
			} else {
				$('.g-recaptcha').removeClass("is-recaptcha-invalid");
			}
		}

		if (submit == true) {
			$('.g-recaptcha').removeClass("is-recaptcha-invalid");
			$.ajax({
				type: "POST",
				url: base_url + "home_controller/add_comment_post",
				data: data,
				success: function (response) {
					var obj = JSON.parse(response);
					if (obj.type == 'message') {
						document.getElementById("message-comment-result").innerHTML = obj.message;
					} else {
						document.getElementById("comment-result").innerHTML = obj.message;
					}
					if (is_recaptcha_enabled == true) {
						grecaptcha.reset();
					}
					$("#make_comment")[0].reset();
				}
			});
		}
	});

});

//make registered subcomment
$(document).on('click', '.btn-subcomment-registered', function () {
	var comment_id = $(this).attr("data-comment-id");
	var data = {
		"sys_lang_id": sys_lang_id
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$("#make_subcomment_registered_" + comment_id).ajaxSubmit({
		beforeSubmit: function () {
			var form = $("#make_subcomment_registered_" + comment_id).serializeArray();
			var comment = $.trim(form[0].value);
			if (comment.length < 1) {
				$(".form-comment-text").addClass("is-invalid");
				return false;
			} else {
				$(".form-comment-text").removeClass("is-invalid");
			}
		},
		type: "POST",
		url: base_url + "home_controller/add_comment_post",
		data: data,
		success: function (response) {
			var obj = JSON.parse(response);
			if (obj.type == 'message') {
				document.getElementById("message-subcomment-result-" + comment_id).innerHTML = obj.message;
			} else {
				document.getElementById("comment-result").innerHTML = obj.message;
			}
			$('.visible-sub-comment form').empty();
		}
	})
});

//make subcomment
$(document).on('click', '.btn-subcomment', function () {
	var comment_id = $(this).attr("data-comment-id");
	var data = {
		"sys_lang_id": sys_lang_id
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	data['limit'] = $('#post_comment_limit').val();
	var form_id = "#make_subcomment_" + comment_id;
	$(form_id).ajaxSubmit({
		beforeSubmit: function () {
			var form_values = $("#make_subcomment_" + comment_id).serializeArray();
			var submit = true;
			$(form_values).each(function (i, field) {
				if ($.trim(field.value).length < 1) {
					$(form_id + " [name='" + field.name + "']").addClass("is-invalid");
					submit = false;
				} else {
					$(form_id + " [name='" + field.name + "']").removeClass("is-invalid");
					data[field.name] = field.value;
				}
			});

			if (is_recaptcha_enabled == true) {
				if (typeof data['g-recaptcha-response'] === 'undefined') {
					$(form_id + ' .g-recaptcha').addClass("is-recaptcha-invalid");
					submit = false;
				} else {
					$(form_id + ' .g-recaptcha').removeClass("is-recaptcha-invalid");
				}
			}

			if (submit == false) {
				return false;
			}
		},
		type: "POST",
		url: base_url + "home_controller/add_comment_post",
		data: data,
		success: function (response) {
			if (is_recaptcha_enabled == true) {
				grecaptcha.reset();
			}
			var obj = JSON.parse(response);
			if (obj.type == 'message') {
				document.getElementById("message-subcomment-result-" + comment_id).innerHTML = obj.message;
			} else {
				document.getElementById("comment-result").innerHTML = obj.message;
			}
			$('.visible-sub-comment form').empty();
		}
	})
});

//load more comment
function load_more_comment(post_id) {
	var limit = parseInt($("#post_comment_limit").val());
	var data = {
		"post_id": post_id,
		"limit": limit,
		"sys_lang_id": sys_lang_id
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$("#load_comment_spinner").show();
	$.ajax({
		type: "POST",
		url: base_url + "home_controller/load_more_comment",
		data: data,
		success: function (response) {
			setTimeout(function () {
				$("#load_comment_spinner").hide();
				document.getElementById("comment-result").innerHTML = response;
			}, 1000)
		}
	});
}

//delete comment
function delete_comment(comment_id, post_id, message) {
	swal({
		text: message,
		icon: "warning",
		buttons: true,
		dangerMode: true
	}).then(function (willDelete) {
		if (willDelete) {
			var limit = parseInt($("#post_comment_limit").val());
			var data = {
				"id": comment_id,
				"post_id": post_id,
				"limit": limit,
				"sys_lang_id": sys_lang_id
			};
			data[csfr_token_name] = $.cookie(csfr_cookie_name);
			$.ajax({
				type: "POST",
				url: base_url + "home_controller/delete_comment_post",
				data: data,
				success: function (response) {
					document.getElementById("comment-result").innerHTML = response;
				}
			});
		}
	});
}

//show comment box
function show_comment_box(comment_id) {
	$('.visible-sub-comment').empty();
	var limit = parseInt($("#post_comment_limit").val());
	var data = {
		"comment_id": comment_id,
		"limit": limit,
		"sys_lang_id": sys_lang_id
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$.ajax({
		type: "POST",
		url: base_url + "home_controller/load_subcomment_box",
		data: data,
		success: function (response) {
			$('#sub_comment_form_' + comment_id).append(response);
		}
	});
}

//hide cookies warning
function hide_cookies_warning() {
	$(".cookies-warning").hide();
	var data = {};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$.ajax({
		type: "POST",
		url: base_url + "home_controller/cookies_warning",
		data: data,
		success: function (response) {
		}
	});
}

//select site color
$(document).on('click', '.visual-color-box', function () {
	var date_color = $(this).attr('data-color');
	$('.visual-color-box').empty();
	$(this).html('<i class="icon-check"></i>');
	$('#input_user_site_color').val(date_color);
});

//upload product image update page
$(document).on('change', '#Multifileupload', function () {
	var MultifileUpload = document.getElementById("Multifileupload");
	if (typeof (FileReader) != "undefined") {
		var MultidvPreview = document.getElementById("MultidvPreview");
		MultidvPreview.innerHTML = "";
		var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
		for (var i = 0; i < MultifileUpload.files.length; i++) {
			var file = MultifileUpload.files[i];
			var reader = new FileReader();
			reader.onload = function (e) {
				var img = document.createElement("IMG");
				img.height = "100";
				img.width = "100";
				img.src = e.target.result;
				img.id = "Multifileupload_image";
				MultidvPreview.appendChild(img);
				$("#Multifileupload_button").show();
			}
			reader.readAsDataURL(file);
		}
	} else {
		alert("This browser does not support HTML5 FileReader.");
	}

});

$(document).ready(function () {
	$('.validate_terms').submit(function (e) {
		if (!$(".checkbox_terms_conditions").is(":checked")) {
			e.preventDefault();
			$('.custom-checkbox .checkbox-icon').addClass('is-invalid');
		} else {
			$('.custom-checkbox .checkbox-icon').removeClass('is-invalid');
		}
	});
});

$("#form_validate").validate();
