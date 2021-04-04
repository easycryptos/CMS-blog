/*
*------------------------------------------------------------------------------------------
* IMAGES
*------------------------------------------------------------------------------------------
*/
var image_type = 'main';
//update images
$('#image_file_manager').on('show.bs.modal', function (e) {
    var data_image_type = $(e.relatedTarget).attr('data-image-type');
    image_type = data_image_type;
});

//select image
$(document).on('click', '#image_file_manager .file-box', function () {
    $('#image_file_manager .file-box').removeClass('selected');
    $(this).addClass('selected');
    var file_id = $(this).attr('data-file-id');
    var file_path = $(this).attr('data-file-path');
    if (image_type == 'editor') {
        file_path = $(this).attr('data-file-path-editor');
    }
    $('#selected_img_file_id').val(file_id);
    $('#selected_img_file_path').val(file_path);
    $('#btn_img_delete').show();
    $('#btn_img_select').show();
});

//refresh images
function refresh_images() {
    var data = {};
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/get_images",
        data: data,
        success: function (response) {
            document.getElementById("image_file_upload_response").innerHTML = response;
        }
    });
}

//delete image file
$(document).on('click', '#image_file_manager #btn_img_delete', function () {
    var file_id = $('#selected_img_file_id').val();
    $('#img_col_id_' + file_id).remove();
    var data = {
        "file_id": file_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);

    $.ajax({
        type: "POST",
        url: base_url + "file_controller/delete_image_file",
        data: data,
        success: function (response) {
            $('#btn_img_delete').hide();
            $('#btn_img_select').hide();
        }
    });
});

//select image file
$(document).on('click', '#image_file_manager #btn_img_select', function () {
    select_image();
});

//select image file on double click
$(document).on('dblclick', '#image_file_manager .file-box', function () {
    select_image();
});

function select_image() {
    var file_id = $('#selected_img_file_id').val();
    var img_url = $('#selected_img_file_path').val();

    if (image_type == 'additional') {
        var image = '<div class="additional-item additional-item-' + file_id + '"><img class="img-additional" src="' + base_url + img_url + '" alt="">' +
            '<input type="hidden" name="additional_post_image_id[]" value="' + file_id + '">' +
            '<a class="btn btn-sm btn-delete-additional-image" data-value="' + file_id + '">' +
            '<i class="fa fa-times"></i> ' +
            '</a>' +
            '</div>';
        $('.additional-image-list').append(image);
    } else if (image_type == 'video_thumbnail') {
        $('input[name=post_image_id]').val(file_id);
        $('#selected_image_file').attr('src', base_url + img_url);
        if ($("#video_thumbnail_url").length) {
            $('#video_thumbnail_url').val('');
        }
    } else if (image_type == 'editor') {
        tinymce.activeEditor.execCommand('mceInsertContent', false, '<p><img src="' + base_url + img_url + '" alt=""/></p>');
    } else {
        var image = '<div class="post-select-image-container">' +
            '<img src="' + base_url + img_url + '" alt="">' +
            '<a id="btn_delete_post_main_image" class="btn btn-danger btn-sm btn-delete-selected-file-image">' +
            '<i class="fa fa-times"></i> ' +
            '</a>' +
            '</div>';
        document.getElementById("post_select_image_container").innerHTML = image;
        $('input[name=post_image_id]').val(file_id);
        $('#selected_image_file').css('margin-top', '15px');
    }

    $('#image_file_manager').modal('toggle');
    $('#image_file_manager .file-box').removeClass('selected');
    $('#btn_img_delete').hide();
    $('#btn_img_select').hide();
}

//load more images
jQuery(function ($) {
    $('#image_file_manager .file-manager-content').on('scroll', function () {
        var search = $("#input_search_image").val().trim();
        if (search.length < 1) {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                var min = 0;
                $('#image_file_upload_response .file-box').each(function () {
                    var value = parseInt($(this).attr('data-file-id'));
                    if (min == 0) {
                        min = value;
                    }
                    if (value < min) {
                        min = value;
                    }
                });
                var data = {
                    'min': min
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "file_controller/load_more_images",
                    data: data,
                    success: function (response) {
                        setTimeout(function () {
                            $("#image_file_upload_response").append(response);
                        }, 100);
                    }
                });
            }
        }
    })
});

//search image
$(document).on('input', '#input_search_image', function () {
    var search = $(this).val().trim();
    var data = {
        "search": search
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/search_image_file",
        data: data,
        success: function (response) {
            if (search.length > 1) {
                document.getElementById("image_file_upload_response").innerHTML = response;
            } else {
                refresh_images();
            }

        }
    });
});

/*
*------------------------------------------------------------------------------------------
* FILES
*------------------------------------------------------------------------------------------
*/
//select file
$(document).on('click', '#file_manager .file-box', function () {
    $('#file_manager .file-box').removeClass('selected');
    $(this).addClass('selected');
    var file_id = $(this).attr('data-file-id');
    var file_name = $(this).attr('data-file-name');
    $('#selected_file_id').val(file_id);
    $('#selected_file_name').val(file_name);
    $('#btn_file_delete').show();
    $('#btn_file_select').show();
});

//delete file
$(document).on('click', '#file_manager #btn_file_delete', function () {
    var file_id = $('#selected_file_id').val();
    $('#file_col_id_' + file_id).remove();
    var data = {
        "file_id": file_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/delete_file",
        data: data,
        success: function (response) {
            $('#btn_file_delete').hide();
            $('#btn_file_select').hide();
        }
    });
});

//select file button
$(document).on('click', '#file_manager #btn_file_select', function () {
    select_file();
});

//select file on double click
$(document).on('dblclick', '#file_manager .file-box', function () {
    select_file();
});

//select file
function select_file() {
    var file_id = $('#selected_file_id').val();
    var file_name = $('#selected_file_name').val();
    var file = '<div id="file_' + file_id + '" class="item">\n' +
        '<input type="hidden" name="post_selected_file_id[]" value="' + file_id + '">\n' +
        '<div class="left">\n' +
        '<i class="fa fa-file"></i>\n' +
        '</div>\n' +
        '<div class="center">\n' +
        '<span>' + file_name + '</span>\n' +
        '</div>\n' +
        '<div class="right">\n' +
        '<a href="javascript:void(0)" class="btn btn-sm btn-delete-selected-file" data-value="' + file_id + '"><i class="fa fa-times"></i></a></p>\n' +
        '</div>\n' +
        '</div>';
    $('.post-selected-files').append(file);
    $('#file_manager').modal('toggle');
    $('#file_manager .file-box').removeClass('selected');
    $('#btn_file_delete').hide();
    $('#btn_file_select').hide();
}

//refresh files
function refresh_files() {
    var data = {};
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/get_files",
        data: data,
        success: function (response) {
            document.getElementById("file_upload_response").innerHTML = response;
        }
    });
}

//load more files
jQuery(function ($) {
    $('#file_manager .file-manager-content').on('scroll', function () {
        var search = $("#input_search_file").val().trim();
        if (search.length < 1) {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                var min = 0;
                $('#file_upload_response .file-box').each(function () {
                    var value = parseInt($(this).attr('data-file-id'));
                    if (min == 0) {
                        min = value;
                    }
                    if (value < min) {
                        min = value;
                    }
                });
                var data = {
                    'min': min
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "file_controller/load_more_files",
                    data: data,
                    success: function (response) {
                        setTimeout(function () {
                            $("#file_upload_response").append(response);
                        }, 100);
                    }
                });
            }
        }
    })
});

//search file
$(document).on('input', '#input_search_file', function () {
    var search = $(this).val().trim();
    var data = {
        "search": search
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/search_file",
        data: data,
        success: function (response) {
            if (search.length > 1) {
                document.getElementById("file_upload_response").innerHTML = response;
            } else {
                refresh_files();
            }
        }
    });
});
