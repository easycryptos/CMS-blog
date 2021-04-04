//update token
$("form").submit(function () {
	$("input[name='" + csfr_token_name + "']").val($.cookie(csfr_cookie_name));
});

//datatable
$(document).ready(function () {
	$('#cs_datatable').DataTable({
		"order": [[0, "desc"]],
		"aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]]
	});
});

$(function () {
	$('#tags_1').tagsInput({width: 'auto'});
});

//Flat red color scheme for iCheck
$('input[type="checkbox"].flat-orange, input[type="radio"].flat-orange').iCheck({
	checkboxClass: 'icheckbox_flat-orange',
	radioClass: 'iradio_flat-orange'
});
$('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
	checkboxClass: 'icheckbox_flat-blue',
	radioClass: 'iradio_flat-blue'
});
$('input[type="checkbox"].square-purple, input[type="radio"].square-purple').iCheck({
	checkboxClass: 'icheckbox_square-purple',
	radioClass: 'iradio_square-purple',
	increaseArea: '20%' // optional
});

function get_sub_categories(val) {
	var data = {
		"parent_id": val
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);

	$.ajax({
		type: "POST",
		url: base_url + "category_controller/get_sub_categories",
		data: data,
		success: function (response) {
			$('#subcategories').children('option:not(:first)').remove();
			$("#subcategories").append(response);
		}
	});
}

function get_top_categories_by_lang(val) {
	var data = {
		"lang_id": val
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);

	$.ajax({
		type: "POST",
		url: base_url + "category_controller/get_top_categories_by_lang",
		data: data,
		success: function (response) {
			$('#categories').children('option:not(:first)').remove();
			$('#subcategories').children('option:not(:first)').remove();
			$("#categories").append(response);
		}
	});
}

function get_albums_by_lang(val) {
	var data = {
		"lang_id": val
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);

	$.ajax({
		type: "POST",
		url: base_url + "gallery_controller/gallery_albums_by_lang",
		data: data,
		success: function (response) {
			$('#albums').children('option:not(:first)').remove();
			$("#albums").append(response);
		}
	});
}

function get_categories_by_albums(val) {
	var data = {
		"category_id": val
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);

	$.ajax({
		type: "POST",
		url: base_url + "category_controller/gallery_categories_by_album",
		data: data,
		success: function (response) {
			$('#categories').children('option:not(:first)').remove();
			$("#categories").append(response);
		}
	});
}

function set_as_album_cover(val) {
	var data = {
		"image_id": val
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);

	$.ajax({
		type: "POST",
		url: base_url + "gallery_controller/set_as_album_cover",
		data: data,
		success: function (response) {
			location.reload();
		}
	});
}

function get_menu_links_by_lang(val) {
	var data = {
		"lang_id": val
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);

	$.ajax({
		type: "POST",
		url: base_url + "admin_controller/get_menu_links_by_lang",
		data: data,
		success: function (response) {
			$('#parent_links').children('option:not(:first)').remove();
			$("#parent_links").append(response);
		}
	});
}

//datetimepicker
$(function () {
	$('#datetimepicker').datetimepicker({
		format: 'YYYY-MM-DD HH:mm:ss'
	});
});

$('#cb_scheduled').on('ifChecked', function () {
	$("#date_published_content").show();
	$("#input_date_published").prop('required', true);
});
$('#cb_scheduled').on('ifUnchecked', function () {
	$("#date_published_content").hide();
	$("#input_date_published").prop('required', false);
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
$(document).on('change', '#ckMultifileupload', function () {
	var MultifileUpload = document.getElementById("ckMultifileupload");
	if (typeof (FileReader) != "undefined") {
		var MultidvPreview = document.getElementById("ckMultidvPreview");
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
/*
*
* Video Upload Functions
*
* */

$("#video_embed_code").on("change keyup paste", function () {
	var embed_code = $("#video_embed_code").val();
	$("#video_preview").attr('src', embed_code);

	if ($("#video_embed_code").val() == '') {
		$("#selected_image_file").attr('src', '');
	}
});


function get_video_from_url() {

	var url = $("#video_url").val();

	if (url) {
		var data = {
			"url": url,
		};

		data[csfr_token_name] = $.cookie(csfr_cookie_name);

		$.ajax({
			type: "POST",
			url: base_url + "post_controller/get_video_from_url",
			data: data,
			success: function (response) {
				$("#video_embed_code").html(response);
				if (response != "Invalid Url") {
					$("#video_embed_preview").attr('src', response);
					$("#video_embed_preview").show();
				}
			}
		});

		$.ajax({
			type: "POST",
			url: base_url + "post_controller/get_video_thumbnail",
			data: data,
			success: function (response) {
				$("#video_thumbnail_url").val(response);
				$("#selected_image_file").attr('src', response);
			}
		});
	}
}

$("#video_thumbnail_url").on("change keyup paste", function () {
	var url = $("#video_thumbnail_url").val();
	$("#selected_image_file").attr('src', url);
	$('input[name="post_image_id"]').val('');
});

//reset file input
function reset_file_input(id) {
	$(id).val('');
	$(id + "_label").html('');
	$(id + "_button").hide();
}

//reset preview image
function reset_preview_image(id) {
	$(id).val('');
	$(id + "_image").remove();
	$(id + "_button").hide();
}

//delete post video
function delete_post_video(post_id) {

	var data = {
		"post_id": post_id,
	};

	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$.ajax({
		type: "POST",
		url: base_url + "post_controller/delete_post_video",
		data: data,
		success: function (response) {
			document.getElementById("post_selected_video").innerHTML = " ";
			$(".btn-delete-post-video").hide();
		}
	});
}


//check all checkboxes
$("#checkAll").click(function () {
	$('input:checkbox').not(this).prop('checked', this.checked);
});

//show hide delete button
$('.checkbox-table').click(function () {
	if ($(".checkbox-table").is(':checked')) {
		$(".btn-table-delete").show();
	} else {
		$(".btn-table-delete").hide();
	}
});

//delete selected posts
function delete_selected_posts(message) {
	swal({
		text: message,
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then(function (willDelete) {
		if (willDelete) {
			var post_ids = [];

			$("input[name='checkbox-table']:checked").each(function () {
				post_ids.push(this.value);
			});
			var data = {
				'post_ids': post_ids,
			};
			data[csfr_token_name] = $.cookie(csfr_cookie_name);
			$.ajax({
				type: "POST",
				url: base_url + "post_controller/delete_selected_posts",
				data: data,
				success: function (response) {
					location.reload();
				}
			});
		}
	});
};

//approve selected comments
function approve_selected_comments() {
	var comment_ids = [];
	$("input[name='checkbox-table']:checked").each(function () {
		comment_ids.push(this.value);
	});
	var data = {
		'comment_ids': comment_ids,
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$.ajax({
		type: "POST",
		url: base_url + "admin_controller/approve_selected_comments",
		data: data,
		success: function (response) {
			location.reload();
		}
	});
};

//delete selected comments
function delete_selected_comments(message) {
	swal({
		text: message,
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then(function (willDelete) {
		if (willDelete) {
			var comment_ids = [];
			$("input[name='checkbox-table']:checked").each(function () {
				comment_ids.push(this.value);
			});
			var data = {
				'comment_ids': comment_ids,
			};
			data[csfr_token_name] = $.cookie(csfr_cookie_name);
			$.ajax({
				type: "POST",
				url: base_url + "admin_controller/delete_selected_comments",
				data: data,
				success: function (response) {
					location.reload();
				}
			});
		}
	});
};

//delete post main image
$(document).on('click', '#btn_delete_post_main_image', function () {
	var content = '<a class="btn-select-image" data-toggle="modal" data-target="#image_file_manager" data-image-type="main">' +
		'<div class="btn-select-image-inner">' +
		'<i class="fa fa-image"></i>' +
		'<button class="btn">' + txt_select_image + '</button>' +
		'</div>' +
		'</a>';
	document.getElementById("post_select_image_container").innerHTML = content;
	$("#post_image_id").val('');
	$("#input_image_url").val('');
});

//delete post main image database
$(document).on('click', '#btn_delete_post_main_image', function () {
	var content = '<a class="btn-select-image" data-toggle="modal" data-target="#image_file_manager" data-image-type="main">' +
		'<div class="btn-select-image-inner">' +
		'<i class="fa fa-image"></i>' +
		'<button class="btn">' + txt_select_image + '</button>' +
		'</div>' +
		'</a>';
	document.getElementById("post_select_image_container").innerHTML = content;
	$("#post_image_id").val('');
	$("#input_image_url").val('');
});

$("#input_image_url").on("change keyup paste", function () {
	var url = $("#input_image_url").val();
	var image = '<div class="post-select-image-container">' +
		'<img src="' + url + '" alt="">' +
		'<a id="btn_delete_post_main_image" class="btn btn-danger btn-sm btn-delete-selected-file-image">' +
		'<i class="fa fa-times"></i> ' +
		'</a>' +
		'</div>';
	document.getElementById("post_select_image_container").innerHTML = image;
	$('#selected_image_file').css('margin-top', '15px');
});

$(document).on('click', '#btn_delete_post_main_image_database', function () {
	var data = {
		"post_id": $(this).attr('data-post-id')
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$.ajax({
		type: "POST",
		url: base_url + "post_controller/delete_post_main_image",
		data: data,
		success: function (response) {
			var content = '<a class="btn-select-image" data-toggle="modal" data-target="#image_file_manager" data-image-type="main">' +
				'<div class="btn-select-image-inner">' +
				'<i class="fa fa-image"></i>' +
				'<button class="btn">' + txt_select_image + '</button>' +
				'</div>' +
				'</a>';
			document.getElementById("post_select_image_container").innerHTML = content;
			$("#post_image_id").val('');
			$("#input_image_url").val('');
		}
	});
});

$('.increase-count').each(function () {
	$(this).prop('Counter', 0).animate({
		Counter: $(this).text()
	}, {
		duration: 1000,
		easing: 'swing',
		step: function (now) {
			$(this).text(Math.ceil(now));
		}
	});
});

//select site color
$(document).on('click', '.visual-color-box', function () {
	var date_color = $(this).attr('data-color');
	$('.visual-color-box').empty();
	$(this).html('<i class="fa fa-check"></i>');
	$('#input_user_site_color').val(date_color);
});


//confirm user email
function confirm_user_email(id) {
	var data = {
		'id': id,
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$.ajax({
		type: "POST",
		url: base_url + "admin_controller/confirm_user_email",
		data: data,
		success: function (response) {
			location.reload();
		}
	});
};

//delete item
function delete_item(url, id, message) {
	swal({
		text: message,
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then(function (willDelete) {
		if (willDelete) {
			var data = {
				'id': id,
			};
			data[csfr_token_name] = $.cookie(csfr_cookie_name);
			$.ajax({
				type: "POST",
				url: base_url + url,
				data: data,
				success: function (response) {
					location.reload();
				}
			});
		}
	});
};

//ban user
function ban_user(id, message, option) {
	swal({
		text: message,
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then(function (willDelete) {
		if (willDelete) {
			var data = {
				'id': id,
				'option': option
			};
			data[csfr_token_name] = $.cookie(csfr_cookie_name);
			$.ajax({
				type: "POST",
				url: base_url + "admin_controller/ban_user_post",
				data: data,
				success: function (response) {
					location.reload();
				}
			});
		}
	});
};

//delete additional image
$(document).on('click', '.btn-delete-additional-image', function () {
	var item_id = $(this).attr("data-value");
	$('.additional-item-' + item_id).remove();

});

//delete additional image from database
$(document).on('click', '.btn-delete-additional-image-database', function () {
	var item_id = $(this).attr("data-value");
	$('.additional-item-' + item_id).remove();
	var data = {
		"file_id": item_id
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$.ajax({
		type: "POST",
		url: base_url + "post_controller/delete_post_additional_image",
		data: data,
		success: function (response) {
		}
	});
});

//delete selected file
$(document).on('click', '.btn-delete-selected-file', function () {
	var item_id = $(this).attr("data-value");
	$('#file_' + item_id).remove();
});

//delete selected file from database
$(document).on('click', '.btn-delete-selected-file-database', function () {
	var item_id = $(this).attr("data-value");
	$('#post_selected_file_' + item_id).remove();
	var data = {
		"id": item_id
	};
	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$.ajax({
		type: "POST",
		url: base_url + "post_controller/delete_post_file",
		data: data,
		success: function (response) {
		}
	});
});

//delete video image
function delete_video_image(post_id) {
	var data = {
		"post_id": post_id,
	};

	data[csfr_token_name] = $.cookie(csfr_cookie_name);
	$.ajax({
		type: "POST",
		url: base_url + "post_controller/delete_post_main_image",
		data: data,
		success: function (response) {

			$('.btn-delete-main-img').hide();
			$("#selected_image_file").attr('src', '');
			$("#video_thumbnail_url").val('');

			document.getElementById("post_selected_video").innerHTML = " ";
			$(".btn-delete-post-video").hide();
		}
	});
}

/*
*
* Video Upload Functions
*
* */

$("#video_embed_code").on("change keyup paste", function () {
	var embed_code = $("#video_embed_code").val();
	$("#video_preview").attr('src', embed_code);

	if ($("#video_embed_code").val() == '') {
		$("#selected_image_file").attr('src', '');
	}
});


function get_video_from_url() {
	var url = $("#video_url").val();
	if (url) {
		var data = {
			"url": url,
		};
		data[csfr_token_name] = $.cookie(csfr_cookie_name);
		$.ajax({
			type: "POST",
			url: base_url + "post_controller/get_video_from_url",
			data: data,
			success: function (response) {
				var obj = JSON.parse(response);
				if (obj.video_embed_code) {
					$("#video_embed_code").html(obj.video_embed_code);
					$("#video_embed_preview").attr('src', obj.video_embed_code);
					$("#video_embed_preview").show();
				}
				if (obj.video_thumbnail) {
					$("#video_thumbnail_url").val(obj.video_thumbnail);
					$("#selected_image_file").attr('src', obj.video_thumbnail);
				}
			}
		});
	}
}

$("#video_thumbnail_url").on("change keyup paste", function () {
	var url = $("#video_thumbnail_url").val();
	$("#selected_image_file").attr('src', url);
	$('input[name="post_image_id"]').val('');
});


$(document).ajaxStop(function () {

	$('input[type="checkbox"].square-purple, input[type="radio"].square-purple').iCheck({
		checkboxClass: 'icheckbox_square-purple',
		radioClass: 'iradio_square-purple',
		increaseArea: '20%' // optional
	});

	$('#cb_scheduled').on('ifChecked', function () {
		$("#date_published_content").show();
		$("#input_date_published").prop('required', true);
	});
	$('#cb_scheduled').on('ifUnchecked', function () {
		$("#date_published_content").hide();
		$("#input_date_published").prop('required', false);
	});

});



