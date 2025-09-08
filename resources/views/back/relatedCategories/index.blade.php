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
                            <ol class="breadcrumb no-border">
                                <li class="breadcrumb-item">مدیریت</li>
                                <li class="breadcrumb-item active">پیشنهادهای مرتبط با دسته‌ها</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                @if($categories->count())
                    <section class="card">
{{--                        <div class="card-header">--}}
{{--                            <h4 class="card-title">تنظیم پیشنهادهای مرتبط با دسته‌ها</h4>--}}
{{--                        </div>--}}
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">تنظیم پیشنهادهای مرتبط با دسته‌ها</h4>
                            <input type="text" id="search-category" class="form-control"
                                   style="width: 250px;" placeholder="جستجو دسته...">
                        </div>

                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th style="width: 10%">فعال</th>
                                        <th style="width: 30%">دسته محصول</th>
                                        <th style="width: 50%">دسته‌های پیشنهادی</th>
                                        <th style="width: 10%">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody id="category-table-body">
                                        @include('back.relatedCategories.partials.table')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    <div id="pagination-links" class="card-body pagination-container">
                        {{ $categories->appends(['q' => request()->get('q')])->links() }}
                    </div>
                @else
                    <div class="alert alert-info">هیچ دسته‌بندی موجود نیست.</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('back/assets/css/select2/select2.min.css') }}" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }
        .save-btn[disabled] {
            opacity: 0.65;
            pointer-events: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('back/app-assets/js/core/libraries/jquery.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            let $tableBody = $('#category-table-body');
            const $paginationContainer = $('#pagination-links');
            const $searchInput = $('#search-category');

            // تابع بارگذاری داده‌ها با query و page
            function loadCategories(query = '', page = 1) {
                // نمایش وضعیت بارگذاری
                $tableBody.html('<tr><td colspan="4" class="text-center">در حال بارگذاری...</td></tr>');

                // ساخت URL با query و page
                let url = "{{ route('admin.related-categories.search') }}";
                const params = new URLSearchParams();
                if (query) params.append('q', query);
                if (page > 1) params.append('page', page);
                if (params.toString()) {
                    url += '?' + params.toString();
                }

                $.get(url, function (response) {
                    // جایگزینی جدول
                    const $newTbody = $(response.html);
                    if ($newTbody.is('tbody')) {
                        $tableBody.replaceWith($newTbody);
                        $tableBody = $('#category-table-body'); // اگر id تغییر کرد، دوباره اشاره کن
                    } else {
                        $tableBody.html($newTbody);
                    }

                    // جایگزینی صفحه‌بندی
                    $paginationContainer.html(response.pagination);

                    // فعال‌سازی مجدد Select2
                    reinitSelect2();
                })
                    .fail(function (xhr) {
                        $tableBody.html('<tr><td colspan="4" class="text-center text-danger">خطا در بارگذاری داده‌ها.</td></tr>');
                        console.error(xhr);
                    });
            }

            // فعال‌سازی مجدد Select2
            function reinitSelect2() {
                $('.select2-suggested').select2({
                    placeholder: 'دسته‌های پیشنهادی را انتخاب کنید...',
                    allowClear: true,
                    width: '100%'
                });
            }

            // --- جستجوی لحظه‌ای ---
            let typingTimer;
            $searchInput.on('keyup', function () {
                const value = $(this).val().trim();
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => loadCategories(value), 500);
            });

            // --- صفحه‌بندی با event delegation ---
            $(document).on('click', '#pagination-links a', function (e) {
                e.preventDefault();

                const href = $(this).attr('href');
                const url = new URL(href);
                const page = url.searchParams.get('page') || 1;
                const query = $searchInput.val().trim();

                loadCategories(query, page);
            });

            // --- ذخیره تنظیمات ---
            $(document).on('click', '.save-btn', function () {
                const btn = $(this);
                const catId = btn.data('category-id');
                const isActive = $(`.toggle-active[data-id="${catId}"]`).is(':checked');
                const suggestions = $(`.select2-suggested[data-category-id="${catId}"]`).val() || [];

                const originalText = btn.text();
                btn.html(btn.data('loading')).prop('disabled', true);

                $.ajax({
                    url: "{{ route('admin.related-categories.update', '') }}/" + catId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        active: isActive ? 1 : 0,
                        suggested_category_ids: suggestions
                    },
                    success: function (response) {
                        toastr.success(response.message || 'تنظیمات ذخیره شد.');
                        btn.text(originalText).prop('disabled', false);
                    },
                    error: function (xhr) {
                        let msg = 'خطا در ذخیره سازی.';
                        if (xhr.responseJSON?.errors) {
                            msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(msg, 'خطا', { timeOut: 5000, closeButton: true });
                        btn.text(originalText).prop('disabled', false);
                    }
                });
            });

            reinitSelect2();
        });
    </script>
@endpush
