$(document).ready(function() {

    $('#others-form').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        if ($('select[name=user_refrral_enable]').val()=="true") {

            if ($('#user_refrral_gift_discount_type').val() == "percent") {

                if ($('input[name=owner_refrral_amount]').val() > 100) {
                    Swal.fire({
                        type: 'error',
                        title: 'مقدار تخفیف صحیح نمی باشد',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false,
                    });
                    return false;
                }
            }
        }else {
            $('input[name=owner_refrral_amount]').val(' ')
            $('input[name=user_refrral_amount]').val(' ')
        }

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                Swal.fire({
                    type: 'success',
                    title: 'تغییرات با موفقیت ذخیره شد',
                    confirmButtonClass: 'btn btn-primary',
                    confirmButtonText: 'باشه',
                    buttonsStyling: false,
                })
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
    });

    $('#get-all-product-form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            success: function(data) {
                $('#get-all-product-modal').modal('hide');
                $('body').css('padding-right','0');
                if (data==="success"){
                    Swal.fire({
                        type: 'success',
                        title: 'همه محصولات در صورت تکراری نبودن به صورت خودکار وارد می شود (حداقل زمان 10 دقیقه)',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false,
                    })
                }else if (data==="error-time"){
                    Swal.fire({
                        type: 'error',
                        title: 'در هر 24 ساعت فقط یک بار میتوانید از این گزینه استفاده کنید.',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false,
                    })
                }
                else {
                    Swal.fire({
                        type: 'error',
                        title: 'مشکلی برای میزبان پیش آمده است، یا Api Key صحیح نمی باشد',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false,
                    })
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
    });

    $('#get-new-product-form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            success: function(data) {
                $('#get-new-product-modal').modal('hide');
                $('body').css('padding-right','0');
                if (data==="success"){
                    Swal.fire({
                        type: 'success',
                        title: 'محصولات جدید در صورت وجود داشتن به صورت خودکار وارد می شود.',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false,
                    })
                }else {
                    Swal.fire({
                        type: 'error',
                        title: 'مشکلی برای میزبان پیش آمده است، یا Api Key صحیح نمی باشد',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false,
                    })
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
    });

    $('#get-update-product-form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            success: function(data) {
                $('#get-update-product-modal').modal('hide');
                $('body').css('padding-right','0');
                if (data==="success"){
                Swal.fire({
                    type: 'success',
                    title: 'تغییرات محصولات در صورت وجود داشتن به صورت خودکار بروزرسانی می شود (حداقل زمان 10 دقیقه)',
                    confirmButtonClass: 'btn btn-primary',
                    confirmButtonText: 'باشه',
                    buttonsStyling: false,
                })
                }else {
                    Swal.fire({
                        type: 'error',
                        title: 'مشکلی برای میزبان پیش آمده است، یا Api Key صحیح نمی باشد',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false,
                    })
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
    });

    $('#Apply_currency_to_all_products_form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            success: function(data) {
                $('#Apply_currency_to_all_products').modal('hide');
                $('body').css('padding-right','0');
                if (data==="success"){
                    Swal.fire({
                        type: 'success',
                        title: 'تغییر ارز در فروشگاه به زودی اعمال می شود',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false,
                    })
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
    });
});


$('#user_refrral_gift_discount_type').on('change', function () {
    switch ($(this).val()) {
        case 'percent': {
            $('.discount_type_amount').addClass('d-none');
            $('.discount_type_percent').removeClass('d-none');
            break;
        }
        case 'amount': {
            $('.discount_type_amount').removeClass('d-none');
            $('.discount_type_percent').addClass('d-none');
            break;
        }
    }
});

$('#user_refrral_gift_discount_type').trigger('change');
