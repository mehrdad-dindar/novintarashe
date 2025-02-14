@extends('back.layouts.master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb no-border">
                                    <li class="breadcrumb-item">مدیریت
                                    </li>
                                    <li class="breadcrumb-item">تنظیمات
                                    </li>
                                    <li class="breadcrumb-item active">تنظیمات دیگر
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- users edit start -->
                <section class="users-edit">
                    <div class="card">
                        <div id="main-card" class="card-content">
                            <div class="card-body">
                                <div class="tab-content">
                                    <form id="others-form" action="{{ route('admin.settings.others') }}" method="POST">
                                        <h4 class="mt-2">تنظیمات قیمت ها</h4>
                                        <div class="row">
                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>انتخاب ارز پیش فرض</label>
                                                    <select name="default_currency_id" class="form-control">
                                                        <option value="">تومان (پیش فرض)</option>
                                                        @foreach ($currencies as $currency)
                                                            <option value="{{ $currency->id }}" {{ option('default_currency_id') == $currency->id ? 'selected' : '' }}>{{ $currency->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>گرد کردن</label>
                                                    <select name="default_rounding_amount" class="form-control">
                                                        <option value="no" {{ option('default_rounding_amount', 'no') == 'no' ? 'selected' : '' }}>خیر</option>
                                                        <option value="100" {{ option('default_rounding_amount') == 100 ? 'selected' : '' }}>100 ریال</option>
                                                        <option value="1000" {{ option('default_rounding_amount') == 1000 ? 'selected' : '' }}>1000 ریال</option>
                                                        <option value="10000" {{ option('default_rounding_amount') == 10000 ? 'selected' : '' }}>10000 ریال</option>
                                                        <option value="100000" {{ option('default_rounding_amount') == 100000 ? 'selected' : '' }}>100000 ریال</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>نحوه گرد کردن</label>
                                                    <select name="default_rounding_type" class="form-control">
                                                        <option value="close" {{ option('default_rounding_type', 'close') == 'close' ? 'selected' : '' }}>نزدیک</option>
                                                        <option value="up" {{ option('default_rounding_type') == 'up' ? 'selected' : '' }}>رو به بالا</option>
                                                        <option value="down" {{ option('default_rounding_type') == 'down' ? 'selected' : '' }}>رو به پایین</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mt-2 d-flex flex-sm-row flex-column justify-content-end" data-toggle="modal" data-target="#Apply_currency_to_all_products">
                                                    <button type="button" class="btn btn-primary glow waves-effect waves-light">اعمال ارز رو همه محصولات</button>
                                                </div>
                                            </div>

                                        </div>

                                        <h4 class="mt-2">تنظیمات فاکتور سفارشات</h4>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <fieldset class="form-group">
                                                    <label for="">لوگو</label>
                                                    <div class="custom-file">
                                                        <input type="file" accept="image/*" name="factor_logo" class="custom-file-input">
                                                        <label class="custom-file-label" for="">{{ option('factor_logo') }}</label>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-3">
                                                <label>عنوان فاکتور</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="factor_title" class="form-control" value="{{ option('factor_title', option('info_site_title')) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>فروشنده</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="factor_seller_name" class="form-control" value="{{ option('factor_seller_name') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>شناسه ملی</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="factor_national_code" class="form-control" value="{{ option('factor_national_code') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>شناسه ثبت</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="factor_registeration_id" class="form-control" value="{{ option('factor_registeration_id') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>شماره اقتصادی</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="factor_economical_number" class="form-control" value="{{ option('factor_economical_number') }}">
                                                </div>
                                            </div>

                                        </div>

                                        <h4 class="mt-2">تنظیمات مربوط به کاربران</h4>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>اعتبار هدیه ثبت نام کاربر</label>
                                                <div class="input-group mb-75">
                                                    <input type="number" name="user_register_gift_credit" class="form-control" min="0" value="{{ option('user_register_gift_credit', 0) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>فعال کردن امکان معرفی افراد</label>
                                                <div class="input-group mb-75">
                                                    <select name="user_refrral_enable" class="form-control">
                                                        @if (option('user_refrral_enable') == 'false')
                                                            <option value="true">بله</option>
                                                            <option value="false" selected>خیر</option>
                                                        @elseif(option('user_refrral_enable') == 'true')
                                                            <option value="true" selected>بله</option>
                                                            <option value="false">خیر</option>
                                                        @else
                                                            <option value="true">بله</option>
                                                            <option value="false" selected>خیر</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>هدیه فرد معرفی کننده</label>
                                                <div class="input-group mb-75">
                                                    <select name="user_refrral_gift_type" class="form-control">
                                                            <option value="discount_code" {{option('user_refrral_gift_type') == "discount_code" ? 'selected' : ''}}>ارسال کد تخفیف</option>
                                                            <option value="wallet" {{option('user_refrral_gift_type') == "wallet" ? 'selected' : ''}}>ارسال به کیف پول</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>نوع تخفیف</label>
                                                    <select id="user_refrral_gift_discount_type" class="form-control" name="user_refrral_gift_discount_type">
                                                        <option value="percent" {{option('user_refrral_gift_discount_type') == "percent" ? 'selected' : ''}}>درصد</option>
                                                        <option value="amount" {{option('user_refrral_gift_discount_type') == "amount" ? 'selected' : ''}}>مبلغ</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="discount_type_percent {{option('user_refrral_gift_discount_type') == "percent" ? '' : 'd-none'}}"> مقدار تخفیف معرفی کننده به درصد</label>
                                                <label class="discount_type_amount {{option('user_refrral_gift_discount_type') == "amount" ? '' : 'd-none'}}"> مقدار تخفیف معرفی کننده به مبلغ({{currencyTitle()}})</label>
                                                <div class="input-group mb-75">
                                                    <input type="number" name="owner_refrral_amount" class="form-control" min="0" value="{{ option('owner_refrral_amount', 0) }}">
                                                </div>

                                            </div>

                                            <div class="col-md-3">

                                                <label class="discount_type_percent {{option('user_refrral_gift_discount_type') == "percent" ? '' : 'd-none'}}"> مقدار تخفیف معرفی شونده به درصد</label>
                                                <label class="discount_type_amount {{option('user_refrral_gift_discount_type') == "amount" ? '' : 'd-none'}}"> مقدار تخفیف معرفی شونده به مبلغ({{currencyTitle()}})</label>
                                                <div class="input-group mb-75">
                                                    <input type="number" name="user_refrral_amount" class="form-control" min="0" value="{{ option('user_refrral_amount', 0) }}">
                                                </div>

                                            </div>

                                            <div class="col-md-3">

                                                <label class="">حداقل مبلغ خرید برای دریافت هدیه({{currencyTitle()}})</label>
                                                <div class="input-group mb-75">
                                                    <input type="number" name="minimum_amount_gift" class="form-control" min="0" value="{{ option('minimum_amount_gift', 0) }}">
                                                </div>

                                            </div>

                                            <div class="col-md-3">

                                                <label class="">حداقل خرید تعداد محصول برای دریافت هدیه</label>
                                                <div class="input-group mb-75">
                                                    <input type="number" name="minimum_product_gift" class="form-control" min="1" max="10" value="{{ option('minimum_product_gift', 1) }}">
                                                </div>

                                            </div>

                                            <div class="col-12">
                                                <hr>
                                            </div>

                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>نمایش قیمت برای همه</label>
                                                    <select name="show_price_all_user" class="form-control">
                                                        @for($i=1;$i<=10;$i++)
                                                            <option value="fldTipFee{{$i}}" {{ option('show_price_all_user', 'fldTipFee1') == 'fldTipFee'.$i ? 'selected' : '' }}>
                                                                @if("fldTipFee".$i=="fldTipFee1")
                                                                    fldTipFee{{$i}} (قیمت اصلی)
                                                                    @elseif("fldTipFee".$i=="fldTipFee2")
                                                                        fldTipFee{{$i}} (تخفیف ها)

                                                                    @else
                                                                        fldTipFee{{$i}}
                                                                    @endif
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>نمایش قیمت برای کاربران عادی</label>
                                                    <select name="show_price_normal_user" class="form-control">
                                                        @for($i=1;$i<=10;$i++)
                                                            <option value="fldTipFee{{$i}}" {{ option('show_price_normal_user', 'fldTipFee1') == 'fldTipFee'.$i ? 'selected' : '' }}>
                                                                @if("fldTipFee".$i=="fldTipFee1")
                                                                    fldTipFee{{$i}} (قیمت اصلی)
                                                                    @elseif("fldTipFee".$i=="fldTipFee2")
                                                                        fldTipFee{{$i}} (تخفیف ها)

                                                                    @else
                                                                        fldTipFee{{$i}}
                                                                    @endif
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>نمایش قیمت برای همکاران</label>
                                                    <select name="show_price_colleague" class="form-control">
                                                        @for($i=1;$i<=10;$i++)
                                                        <option value="fldTipFee{{$i}}" {{ option('show_price_colleague', 'fldTipFee1') == 'fldTipFee'.$i ? 'selected' : '' }}>
                                                            @if("fldTipFee".$i=="fldTipFee1")
                                                                fldTipFee{{$i}} (قیمت اصلی)
                                                                @elseif("fldTipFee".$i=="fldTipFee2")
                                                                    fldTipFee{{$i}} (تخفیف ها)

                                                                @else
                                                                fldTipFee{{$i}}
                                                            @endif
                                                        </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>نمایش قیمت برای کاربران ویژه</label>
                                                    <select name="show_price_vip" class="form-control">
                                                        @for($i=1;$i<=10;$i++)
                                                        <option value="fldTipFee{{$i}}" {{ option('show_price_vip', 'fldTipFee1') == 'fldTipFee'.$i ? 'selected' : '' }}>
                                                            @if("fldTipFee".$i=="fldTipFee1")
                                                                fldTipFee{{$i}} (قیمت اصلی)
                                                                @elseif("fldTipFee".$i=="fldTipFee2")
                                                                    fldTipFee{{$i}} (تخفیف ها)

                                                                @else
                                                                fldTipFee{{$i}}
                                                            @endif
                                                        </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>


                                        </div>

                                        <h4 class="mt-2">تنظیمات مربوط Api دریافت محصولات از حسابداری</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Api Key</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="get_product_apikey" class="form-control text-right dir-ltr" value="{{ option('get_product_apikey') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class='row mt-1'>
                                                    <div class="mr-2 d-flex flex-sm-row flex-column justify-content-end mt-1" data-toggle="modal" data-target="#get-all-product-modal">
                                                        <button type="button" class="btn btn-primary glow">دریافت همه محصولات</button>
                                                    </div>
                                                    <div class="mr-2 d-flex flex-sm-row flex-column justify-content-end mt-1" data-toggle="modal" data-target="#get-new-product-modal">
                                                        <button type="button" class="btn btn-primary glow">دریافت محصولات جدید</button>
                                                    </div>
                                                    <div class=" d-flex flex-sm-row flex-column justify-content-end mt-1" data-toggle="modal" data-target="#get-update-product-modal">
                                                        <button type="button" class="btn btn-primary glow">دریافت تغییرات محصولات</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="alert alert-info mt-1 alert-validation-msg" role="alert">
                                                    <i class="feather icon-info ml-1 align-middle"></i>
                                                    <span>دریافت محصولات جدید به صورت خودکار در ساعت 24 هر شب انجام می شود.</span>
                                                </div>
                                                <div class="alert alert-info mt-1 alert-validation-msg" role="alert">
                                                    <i class="feather icon-info ml-1 align-middle"></i>
                                                    <span>دریافت تغییرات محصولات به صورت خودکار در ساعت 24 هر شب انجام می شود.</span>
                                                </div>
                                            </div>


                                        </div>

                                        <h4 class="mt-2">تنظیمات pusher</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>PUSHER_APP_ID</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="PUSHER_APP_ID" class="form-control ltr" value="{{ config('broadcasting.connections.pusher.app_id') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>PUSHER_APP_KEY</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="PUSHER_APP_KEY" class="form-control ltr" value="{{ config('broadcasting.connections.pusher.key') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>PUSHER_APP_SECRET</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="PUSHER_APP_SECRET" class="form-control ltr" value="{{ config('broadcasting.connections.pusher.secret') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>PUSHER_APP_CLUSTER</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="PUSHER_APP_CLUSTER" class="form-control ltr" value="{{ config('broadcasting.connections.pusher.options.cluster') }}">
                                                </div>
                                            </div>

                                        </div>


                                        <h4 class="mt-2">تنظیمات Mail</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Transport</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="transport" class="form-control ltr" value="{{ config('mail.mailers.smtp.transport') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>MAIL_HOST</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="MAIL_HOST" class="form-control ltr" value="{{ config('mail.mailers.smtp.host') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>MAIL_PORT</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="MAIL_PORT" class="form-control ltr" value="{{ config('mail.mailers.smtp.port') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>MAIL_USERNAME</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="MAIL_USERNAME" class="form-control ltr" value="{{ config('mail.mailers.smtp.username') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>MAIL_PASSWORD</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="MAIL_PASSWORD" class="form-control ltr" value="{{ config('mail.mailers.smtp.password') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>MAIL_ENCRYPTION</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="MAIL_ENCRYPTION" class="form-control ltr" value="{{ config('mail.mailers.smtp.encryption') }}">
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                                <button type="submit" class="btn btn-primary glow">ذخیره تغییرات</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->

            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="get-all-product-modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                   دریافت همه محصولات  ممکن است زمان بر باشد. (حداقل زمان 10 دقیقه).
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.settings.others.GetAllProductAccounting') }}" id="get-all-product-form">
                        @csrf
                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله دریافت شود</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="get-new-product-modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                   دریافت محصولات جدید ممکن است چند دقیقه زمان بر باشد.
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.settings.others.GetNewProductAccounting') }}" id="get-new-product-form">
                        @csrf
                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله دریافت شود</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="get-update-product-modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                   دریافت تغییرات محصولات  ممکن است زمان بر باشد. (حداقل زمان 10 دقیقه)
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.settings.others.GetUpdateAccounting') }}" id="get-update-product-form">
                        @csrf
                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله دریافت شود</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="Apply_currency_to_all_products" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                   اعمال ارز رو همه محصولات، قیمت همه محصولات را تغییر می دهد.
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.settings.others.apply_currency_products') }}" id="Apply_currency_to_all_products_form">
                        @csrf
                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله اعمال شود</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@include('back.partials.plugins', ['plugins' => ['jquery.validate']])

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/settings/others.js') }}"></script>
@endpush
