jQuery('#register-form').validate({
    rules: {
        'first_name': {
            required: true,
        },
        'last_name': {
            required: true,
        },
        'email': {
            required: true,
            email: true,
        },
        'username': {
            required: true,
        },
        'national_code': {
            required: true,
            digits: true, // فقط اعداد
            maxlength: 10,
            minlength: 10
        },

        'password': {
            required: true,
            minlength: 8
        },

        'password_confirmation': {
            required: true,
            equalTo: "#password"
        },
    },
});


// $('#register-form').submit(function (e) {
//     e.preventDefault();

//     if ($(this).valid()) {
//         var formData = new FormData(this);

//         $.ajax({
//             url: $(this).attr('action'),
//             type: 'POST',
//             data: formData,
//             success: function (data) {
//                 if (data == 'success') {
//                     toastr.success('ثبت نام شما با موفقیت انجام شد.', '', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });

//                     setTimeout(() => {
//                         window.location.href = redirect_url;
//                     }, 2000);
//                 }
//             },
//             beforeSend: function (xhr) {
//                 block('.form-ui');
//                 xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
//             },
//             complete: function () {
//                 unblock('.form-ui');
//             },
//             cache: false,
//             contentType: false,
//             processData: false
//         });
//     }
// });

$('#register-form').submit(function (e) {
    e.preventDefault();

    if ($(this).valid()) {
        let token = $('meta[name="csrf-token"]').attr('content');

        let data = {
            _token: token,
            first_name: $('input[name="first_name"]').val(),
            last_name: $('input[name="last_name"]').val(),
            email: $('input[name="email"]').val(),
            username: $('input[name="username"]').val(),
            national_code: $('input[name="national_code"]').val(),
            password: $('input[name="password"]').val(),
            password_confirmation: $('input[name="password_confirmation"]').val(),
            captcha: $('input[name="captcha"]').val(),
        };

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: data,
            success: function (data) {
                if (data == 'success') {
                    toastr.success('ثبت نام شما با موفقیت انجام شد.', '', {
                        positionClass: 'toast-bottom-left',
                        containerId: 'toast-bottom-left'
                    });

                    setTimeout(() => {
                        window.location.href = redirect_url;
                    }, 2000);
                }
            },
             beforeSend: function (xhr) {
                block('.form-ui');
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function () {
                unblock('.form-ui');
            },error: function (xhr) {

    $('.error-message').remove();

    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
        const errors = xhr.responseJSON.errors;

        $.each(errors, function (field, messages) {
            const input = $(`[name="${field}"]`);
            const message = messages[0];
            input.after(`<span class="error-message text-danger d-block mt-1">${message}</span>`);
        });

        // پیام کلی (اختیاری)
        if (xhr.responseJSON.message) {
            toastr.error(xhr.responseJSON.message);
        }

        // ریفرش کپچا (اگه کپچا هم هست)
        $('.captcha').attr('src', '/captcha/default?' + Math.random());
    } else {
        toastr.error("خطایی در ارسال اطلاعات رخ داده است.");
    }
}
        });
    }
});
$.validator.addMethod(
    "regex",
    function (value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    },
    "لطفا یک مقدار معتبر وارد کنید"
);
