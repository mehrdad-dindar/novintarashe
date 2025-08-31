$(document).ready(function () {

    // فعال/غیرفعال کردن فیلدها بر اساس چک‌باکس
    $(document).on('change', '#gateway-form input[type="checkbox"][data-gateway]', function () {
        let id = $(this).data('gateway');
        let inputs = $(`#gateway-form [data-parent="${id}"]`);

        if ($(this).prop('checked')) {
            inputs.prop('disabled', false);
        } else {
            inputs.prop('disabled', true);
        }
    });

    // تریگر اولیه
    $('#gateway-form input[type="checkbox"][data-gateway]').trigger('change');

    // اعتبارسنجی jQuery Validate
    $('#gateway-form').validate();

    // ارسال Ajax
    $('#gateway-form').submit(function (e) {
        e.preventDefault();

        if ($(this).valid()) {
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function (data) {
                    if (data === 'success') {
                        Swal.fire({
                            type: 'success', // نگه داشتن ساختار قدیمی
                            title: 'تغییرات با موفقیت ذخیره شد',
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: 'باشه',
                            buttonsStyling: false,
                        });
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'خطایی رخ داد',
                            text: 'لطفا دوباره تلاش کنید',
                        });
                    }
                },
                beforeSend: function (xhr) {
                    block('#main-card');
                    xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                },
                complete: function () {
                    unblock('#main-card');
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
});
