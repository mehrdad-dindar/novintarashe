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
                        <div class="card-header">
                            <h4 class="card-title">تنظیم پیشنهادهای مرتبط با دسته‌ها</h4>
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
                                    <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" class="toggle-active"
                                                           data-id="{{ $category->id }}"
                                                        {{ $category->hasActiveRelatedSuggestions() ? 'checked' : '' }}>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check"><i class="feather icon-check"></i></span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>({{ $category->id }})</strong> {{ $category->title }}
                                            </td>
                                            <td>
                                                <select class="form-control select2-suggested"
                                                        data-category-id="{{ $category->id }}"
                                                        multiple="multiple"
                                                        style="width: 100%;">
                                                    @foreach($categories as $related)
                                                        @if($related->id === $category->id) @continue @endif
                                                        <option value="{{ $related->id }}"
                                                            {{ in_array($related->id, $category->getSuggestedCategoryIds()) ? 'selected' : '' }}>
                                                            {{ $related->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                        class="btn btn-sm btn-primary save-btn"
                                                        data-category-id="{{ $category->id }}"
                                                        data-loading="<span class='spinner-border spinner-border-sm'></span> درحال ذخیره سازی                 ...">
                                                    ذخیره
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    {{ $categories->links() }}
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
            // فعال‌سازی Select2 برای تمام سلکت‌ها
            $('.select2-suggested').select2({
                placeholder: 'دسته‌های پیشنهادی را انتخاب کنید...',
                allowClear: true,
                width: '100%'
            });

            // عملیات ذخیره با Ajax
            $('.save-btn').on('click', function () {
                const button = $(this);
                const categoryId = button.data('category-id');
                const isActive = $(`.toggle-active[data-id="${categoryId}"]`).is(':checked');
                const suggestedIds = $(`.select2-suggested[data-category-id="${categoryId}"]`).val() || [];

                // وضعیت دکمه
                const originalText = button.text();
                button.html(button.data('loading')).prop('disabled', true);

                $.ajax({
                    url: "{{ route('admin.related-categories.update', '') }}/" + categoryId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        active: isActive ? 1 : 0,
                        suggested_category_ids: suggestedIds
                    },
                    success: function (response) {
                        toastr.success(response.message || 'تنظیمات ذخیره شد.');
                        button.text(originalText).prop('disabled', false);
                    },
                    error: function (xhr) {
                        let msg = 'خطا در ذخیره.';
                        if (xhr.responseJSON?.errors) {
                            msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(msg, 'خطا', { timeOut: 5000, closeButton: true });
                        button.text(originalText).prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush
