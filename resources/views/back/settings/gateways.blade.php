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
                                    <li class="breadcrumb-item active">درگاه های پرداخت
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
                        <div class="card-body">
                            <form id="gateway-form" action="{{ route('admin.settings.gateways') }}" method="POST">
                                @csrf

                                @foreach($gateways as $gateway)
                                    @include('back.settings.partials.gateways._form', ['gateway' => $gateway])
                                    @if(!$loop->last)
                                        <hr>
                                    @endif
                                @endforeach

                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->

            </div>
        </div>
    </div>
@endsection

@include('back.partials.plugins', ['plugins' => ['jquery.validate']])

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/settings/gateways.js') }}?v=2"></script>
@endpush
