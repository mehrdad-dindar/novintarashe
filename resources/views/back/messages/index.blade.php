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
                                    <li class="breadcrumb-item">مدیریت پیام ها
                                    </li>

                                    <li class="breadcrumb-item active">ارسال پیام
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- Description -->
                <section id="description" class="card">
                    <div class="card-header">
                        <h4 class="card-title"> ارسال پیام جدید</h4>
                    </div>

                    <div id="main-card" class="card-content">
                        <div class="card-body">
                            <div class="card-body">
                                <form id="messages-create-form" action="{{ route('admin.messages.store') }}">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 offset-md-3 col-12">
                                            <div class="form-group">
                                                <label>عنوان</label>
                                                <input type="text" class="form-control" name="title" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class='row'>
                                        <div class="col-md-6 offset-md-3 col-12">
                                            <div class="form-group">
                                                <label>کاربر مربوطه(اگر این فیلد را خالی بگذارید،پیام به همه کاربران ارسال می شود)</label>
                                                <select id="users" name="users[]" class="form-control users" multiple>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{$user->fullname .' (id=>'.$user->id.' mobile=>'.$user->mobile.')'}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3 col-12">
                                            <div class="form-group">
                                                <label>توضیحات</label>
                                                <textarea class="form-control" name="description" rows="2" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-6 offset-md-3 col-12">
                                                <div class='row'>
                                                    <fieldset class="checkbox col-md-3">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input type="checkbox" name="email" value="1" >
                                                            <span class="vs-checkbox">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                            <span>ایمیل</span>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="checkbox col-md-3">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input type="checkbox" name="sms" value="1" >
                                                            <span class="vs-checkbox">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                            <span>پیامک</span>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="checkbox col-md-3">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input type="checkbox" name="notification" value="1" >
                                                            <span class="vs-checkbox">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                            <span>نوتیفیکیشن</span>
                                                        </div>
                                                    </fieldset>
                                                   {{-- <fieldset class="checkbox col-md-3">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input type="checkbox" name="popup" value="1" >
                                                            <span class="vs-checkbox">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                            <span>پاپ آپ</span>
                                                        </div>
                                                    </fieldset>--}}
                                                </div>
                                            </div>
                                    </div>

                                    <div id='pattern-code-div' class='row mt-3 d-none'>

                                        <div class="col-md-6 offset-md-3 col-12">
                                            <div class="col-12">
                                                <div class="alert alert-info mt-1 alert-validation-msg" role="alert">
                                                    <i class="feather icon-info ml-1 align-middle"></i>
                                                    <span>پیامک فقط با پترن ارسال می شود، عنوان و توضیحات در پیامک درج نمی شود.</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>کد پترن برای ارسال پیام</label>
                                                <input type="text" class="form-control ltr " value='{{option('user_message_pattern_code')}}' name="user_message_pattern_code" >
                                            </div>
                                            <h6>اگر کد پترن شما داری متغییر می باشد، روی <button type='button' class='btn btn-outline-primary waves-effect waves-light add-variable-item' style='padding: 5px;'><i class="feather icon-plus"></i>افزودن متغییر</button> کیلک کنید.</h6>

                                        <div id='variables' class='mt-2'>
                                          {{--  <div class='variable-item row'>
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
                                            </div>--}}
                                        </div>
                                            <div class="col-12">
                                                <div class="alert alert-info mt-1 alert-validation-msg" role="alert">
                                                    <i class="feather icon-info ml-1 align-middle"></i>
                                                    <span>در صورتی که متغییر شما دارای پترن نمی باشد، حتما پترن های موجو را حذف کنید تا پیام ارسال شود.</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">ارسال پیام</button>
                                        </div>
                                    </div>
                                </form>



                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="list-reviews">
                @if($messages->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">پیام های ارسال شده</h4>
                        </div>
                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>عنوان</th>
                                            <th>متن</th>
                                            <th class="text-center">تاریخ</th>
                                            <th class="text-center">وضعیت</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($messages as $message)
                                            <tr id="review-{{ $message->id }}-tr">
                                                <td class="text-center">
                                                    {{ $message->id }}
                                                </td>
                                                <td style="max-width: 200px">
                                                    <span class="d-inline-block">{{ $message->title }}</span>
                                                </td>
                                                <td style="max-width: 200px">
                                                    <span class="d-inline-block">{{ $message->description }}</span>
                                                </td>
                                                <td class="text-center">
                                                    {{ jdate($message->created_at) }}
                                                </td>
                                                <td class="text-center">
                                                    @if($message->status_send == 'pending')
                                                        <div class="badge badge-pill badge-warning badge-md">منتظر ارسال</div>
                                                    @elseif($message->status_send == 'sent')
                                                        <div class="badge badge-pill badge-success badge-md">ارسال شده</div>
                                                    @else
                                                        <div class="badge badge-pill badge-danger badge-md">ارسال نشده</div>
                                                    @endif
                                                </td>

                                                <td class="text-center text-nowrap">
                                                    <a href="{{ route('admin.messages.show',$message) }}"  class="btn btn-success waves-effect waves-light show-review">مشاهده</a>
                                                    <button data-review="{{ $message->id }}" data-action="{{ route('admin.messages.destroy',$message) }}" type="button" class="btn btn-danger waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                @else
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">پیام های ارسال شده
                            </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-text">
                                    <p>چیزی برای نمایش وجود ندارد!</p>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
                {{ $messages->appends(request()->all())->links() }}
            </div>
            <!--/ Description -->

        </div>
    </div>


    {{-- delete post modal --}}
    <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    با حذف نظر دیگر قادر به بازیابی آن نخواهید بود.
                </div>
                <div class="modal-footer">
                    <form action="#" id="messages-delete-form">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله حذف شود</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@include('back.partials.plugins', ['plugins' => ['jquery.validate']])
@push('scripts')
    <script src="{{ asset('back/assets/js/pages/messages/create.js') }}?v=2"></script>
@endpush
