$('#print-order').click(function () {
    window.print();
});

$('#shipping-status').change(function () {
    var select = this;


    if($(select).val() == 'canceled'){
        Swal.fire({
            title: "آیا مطمئن به لغو سفارش هستید ؟!",
            text: "بعد از لغو مبلغ پرداخت شده به کیف پول کاربر برمیگردد و دیگر قادر به تغییر وضعیت سفارش نیستید.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "بله مطمئنم !",
            cancelButtonText: "لغو"
        }).then((result) => {
            if (result.value) {
                ajaxShippingStatus(select);
            }else {
                $(select).val('pending')
            }
        });
    } else if($(select).val() == 'sent'){
        Swal.fire({
            title: "کد رهگیری ",
            input: "text",
            inputLabel: "کد رهگیری را وارد کنید.",
            showCancelButton: true,
            confirmButtonText: "ذخیره",
            cancelButtonText: "لغو",
            showLoaderOnConfirm: true,
            preConfirm: async (login) => {

            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.value) {
                ajaxShippingStatus(select , result.value);
            }else {
                $(select).val('pending')
            }
        });
    }else{
        ajaxShippingStatus(select);

    }


});


function ajaxShippingStatus(select , tracking_code = null) {
    $.ajax({
        url: $(select).data('action'),
        type: 'POST',
        data: {
            status: $(select).val() ,
            tracking_code: tracking_code ,
        },
        success: function(data) {
            Swal.fire({
                type: 'success',
                title: 'تغییرات با موفقیت ذخیره شد',
                confirmButtonClass: 'btn btn-primary',
                confirmButtonText: 'باشه',
                buttonsStyling: false
            });
        },
        beforeSend: function(xhr) {
            block('#main-card');
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        },
        complete: function() {
            unblock('#main-card');
        }

    });
}
