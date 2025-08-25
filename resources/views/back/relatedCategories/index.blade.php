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
                                    <li class="breadcrumb-item">مدیریت</li>
                                    <li class="breadcrumb-item active">پیشنهادهای مرتبط با دسته‌ها</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                @if($categories->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست دسته‌های مرتبط</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th>وضعیت</th>
                                            <th>دسته محصول</th>
                                            <th>دسته‌های پیشنهادی</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($categories as $category)
                                            <tr id="related_category_row_{{ $category->id }}">
                                                <form
                                                    id="form-related-category-{{ $category->id }}"
                                                    action="{{ route('admin.related-categories.update', $category->id) }}"
                                                    method="POST"
                                                    class="related-category-form"
                                                >
                                                    @csrf
                                                    @method('PUT')

                                                    <td>
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input
                                                                type="checkbox"
                                                                name="active"
                                                                value="1"
                                                                {{ old("active.$category->id", $category->hasActiveRelatedSuggestions()) ? 'checked' : '' }}
                                                            >
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>{{ "(".$category->id.") ".$category->title }}</td>
                                                    <td>
                                                        <select
                                                            class="form-control select2-related w-100"
                                                            name="suggested_category_ids[]"
                                                            multiple="multiple"
                                                        >
                                                            @foreach($categories as $related)
                                                                @if($related->id === $category->id) @continue @endif
                                                                <option
                                                                    value="{{ $related->id }}"
                                                                    {{ in_array($related->id, old("suggested_category_ids.$category->id", $category->getSuggestedCategoryIds())) ? 'selected' : '' }}
                                                                >
                                                                    {{ $related->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            type="submit"
                                                            class="btn btn-success waves-effect waves-light submit-btn">
                                                            ثبت
                                                        </button>
                                                    </td>
                                                </form>
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
                            <h4 class="card-title">لیست دسته‌های مرتبط</h4>
                        </div>
                        <div class="card-body">
                            <p>چیزی برای نمایش وجود ندارد!</p>
                        </div>
                    </section>
                @endif

                {{ $categories->links() }}
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
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('back/app-assets/js/core/libraries/jquery.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.select2-related').select2({
                placeholder: 'دسته‌های پیشنهادی را انتخاب کنید...',
                allowClear: true
            });

            $('.related-category-form').on('submit', function (e) {
                e.preventDefault();

                const form = $(this);
                toastr.warning( 'در حال ذخیره اطلاعات ...');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        toastr.success(response.message || 'اطلاعات با موفقیت ذخیره شد.');
                    },
                    error: function (xhr) {
                        let msg = 'خطا در ذخیره اطلاعات.';
                        if (xhr.responseJSON?.errors) {
                            msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(msg, 'خطا', { timeOut: 5000, closeButton: true });
                    }
                });
            });
        });
    </script>
@endpush
