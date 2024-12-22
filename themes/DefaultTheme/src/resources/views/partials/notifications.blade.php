@if(!auth()->user()->isAdmin())
    @php
        $notifications = auth()->user()->unreadNotifications;
    @endphp
    <li class="dropdown dropdown-notification front-dropdown-notification nav-item show ml-3">
        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="true">
            <i class="mdi mdi-bell-outline"></i>
            <span class="badge badge-pill badge-primary badge-up notifications-count" >{{ $notifications->count() ?: '' }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-media  " >
            <li class="dropdown-menu-header">
                <div class="dropdown-header m-0 p-2">
                    <h4 class="white "><span class='notifications-count' data-count='{{ $notifications->count() }}'>{{ $notifications->count() }}</span>{{ trans('front::messages.header.new-notification') }}</h4>
                </div>
            </li>
            <li class="scrollable-container media-list">
                @foreach ($notifications as $notification)
                    @if($notification->type == 'SendMessage')

                        <a class="d-flex justify-content-between" href="{{ route('front.user.notifications.index') }}">
                            <div class="media d-flex align-items-start">
                                <div class="media-left"><i class="mdi mdi-comment-outline font-medium-5 primary"></i></div>
                                <div class="media-body">
                                    <h6 class="primary media-heading">{{ $notification->data['title'] }}</h6><small
                                        class="notification-text">{{ $notification->data['message'] }}</small>
                                </div><small>
                                    <time class="media-meta">{{ jdate($notification->created_at)->ago() }}</time></small>
                            </div>
                        </a>

                    @endif
                @endforeach
            </li>
            <li class="dropdown-menu-footer">
                <a class="dropdown-item p-1 text-center" href="{{ route('front.user.notifications.index') }}">{{ trans('front::messages.header.show-all-notifications') }}</a>
            </li>
        </ul>
    </li>

@endif
