@extends('front::user.layouts.master')

@push('styles')

@endpush

@section('user-content')
    <!-- Start Content -->
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">



            <div class="row">


                <div class="col-12">
                    <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                        <h2>{{ trans('front::messages.profile.all-message') }}</h2>
                    </div>
                    @if($messages->count())
                    <div class="dt-sl">
                        <div class="table-responsive">
                            <table class="table table-order">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('front::messages.profile.title') }}</th>
                                    <th>{{ trans('front::messages.wallet.history') }}</th>
                                    <th class="text-center">{{ trans('front::messages.wallet.state') }}</th>
                                    <th>{{ trans('front::messages.profile.show') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($messages as $message)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{$message->title}}</td>
                                        <td class="ltr">{{ jdate($message->created_at) }}</td>

                                        <td class="text-center status-div">
                                            @if($message->items()->first()->status == 'seen')
                                                <div class="badge badge-pill badge-success badge-md">seen</div>
                                            @else
                                                <div class="badge badge-pill badge-danger badge-md">unseen</div>
                                            @endif
                                        </td>

                                        <td class="details-link">
                                            <a class="show-history" data-action="{{ route('front.user.messages.show', ['message' => $message]) }}" href="#" onclick="return false;">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                        <div class="col-12">
                            <div class="page dt-sl dt-sn pt-3">
                                <p>{{ trans('front::messages.wallet.there-is-nothing-to-show') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>





        <div class="mt-3">
            {{ $messages->links('front::components.paginate') }}
        </div>

    </div>
    <!-- End Content -->
@endsection
@include('back.partials.plugins', ['plugins' => ['persian-datepicker','jquery.validate']])
@push('scripts')
    <!-- show Modal -->
    <div class="modal fade" id="history-show-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel21">{{ trans('front::messages.profile.message-details') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="history-detail" class="modal-body">


                </div>
            </div>
        </div>
    </div>

    <script src="{{ theme_asset('js/pages/message.js') }}"></script>
@endpush
