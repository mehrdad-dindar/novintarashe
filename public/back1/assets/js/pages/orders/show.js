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
    }else{
        ajaxShippingStatus(select);

    }


});


function ajaxShippingStatus(select) {
    $.ajax({
        url: $(select).data('action'),
        type: 'POST',
        data: {
            status: $(select).val()
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
