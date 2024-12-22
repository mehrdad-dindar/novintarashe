// validate form with jquery validation plugin
jQuery('#messages-create-form').validate({
    rules: {
        'title': {
            required: true,
        },
        'description': {
            required: true,
        },
    },
});



$('#messages-create-form').submit(function(e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                if (data.status=="error"){
                    toastr.error(data.message);
                }
                if (data=="success"){
                    window.location.href = BASE_URL + "/messages";
                }

            },
            beforeSend: function(xhr) {
                block('#main-card');
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function() {
                unblock('#main-card');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

});
$('.users').select2ToTree({
    rtl: true,
    width: '100%'
});

$('input[name=sms]').click(function () {
    if ($('input[name=sms]').is(':checked')) {
        $('#pattern-code-div').removeClass('d-none')
    }else {
        $('#pattern-code-div').addClass('d-none')
    }
});

$('.add-variable-item').click(function() {
    $('#variables').append(` <div class='variable-item row'>
                                                <div class='col-5 '>
                                                    <div class='form-group'>
                                                        <label>اسم متغییر</label>
                                                        <input type="text" class="form-control ltr valid"  name="variables[]"  aria-invalid="false" placeholder='code'>
                                                    </div>
                                                </div>
                                                <div class='col-5'>
                                                    <div class='form-group'>
                                                        <label>مقدار</label>
                                                        <input type="text" class="form-control  valid"  name="values[]"  aria-invalid="false" placeholder='12345'>
                                                    </div>
                                                </div>
                                                <div class='col-2'>
                                                    <button type="button" class=" btn btn-flat-danger waves-effect waves-light remove-variable-item custom-padding" style="margin-top: 35px !important;">حذف</button>
                                                </div>
                                            </div>`);

    $('.remove-variable-item').click(function() {
        $(this).parents('.variable-item').remove();
    })
})

$('.remove-variable-item').click(function() {
    $(this).parents('.variable-item').remove();
})

$(document).on('click', '.btn-delete', function () {
    $('#messages-delete-form').attr('action', $(this).data('action'));
    $('#messages-delete-form').data('id', $(this).data('review'));
});

$('#messages-delete-form').submit(function (e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            //remove review tr
            $(
                '#review-' + $('#messages-delete-form').data('id') + '-tr'
            ).remove();

            toastr.success('پیام با موفقیت حذف شد.');

            reloadDiv('.list-reviews');
        },
        beforeSend: function (xhr) {
            block('#main-card');
            xhr.setRequestHeader(
                'X-CSRF-TOKEN',
                $('meta[name="csrf-token"]').attr('content')
            );
        },
        complete: function () {
            unblock('#main-card');
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
