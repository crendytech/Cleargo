$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function show_toastr(title, message, type) {
    var o, i;
    var icon = '';
    var cls = '';

    if (type === 'success') {
        icon = 'fas fa-check-circle';
        cls = 'success';
    } else {
        icon = 'fas fa-times-circle';
        cls = 'danger';
    }

    $.notify({icon: icon, title: " " + title, message: message, url: ""}, {
        element: "body",
        type: cls,
        allow_dismiss: !0,
        placement: {
            from: 'bottom',
            align: "right"
        },
        offset: {x: 50, y: 60},
        spacing: 10,
        z_index: 1080,
        delay: 2500,
        timer: 2000,
        url_target: "_blank",
        mouse_over: !1,
        animate: {enter: o, exit: i},
        template: '<div class="alert alert-{0} alert-icon alert-group alert-notify bg-{0}-light" data-notify="container" role="alert"><div class="alert-group-prepend alert-content"><span class="alert-group-icon"><i data-notify="icon"></i></span></div><div class="alert-content"><strong data-notify="title">{1}</strong><div data-notify="message">{2}</div></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
    });
}

$(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {

    // alert('asd');
    var title = $(this).data('title');
    var size = ($(this).data('size') === '') ? 'md' : $(this).data('size');
    var url = $(this).data('url');

    var $dialog = $("#commonModal");

    $dialog.find(".modal-title").html(title);
    $dialog.find(".modal-dialog").addClass('modal-' + size);
    $.ajax({
        url: url,
        success: function (data) {


            // alert(data);
            // return false;
            if (data.length) {
                $dialog.find('.modal-body').html(data);
                $("#commonModal").modal('show');
                // common_bind();

                // common_bind_select();
            } else {
                show_toastr('Error', 'Permission denied', 'error');
                $("#commonModal").modal('hide');
            }
        },
        error: function (data) {

            data = data.responseJSON;
            show_toastr('Error', data.error, 'error');
        }
    });
});