<div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <th scope="row" style="min-width: 200px;">{{ trans('front::messages.wallet.id') }}</th>
                <td>{{ $message->id }}</td>
            </tr>

            <tr>
                <th scope="row">عنوان</th>
                <td>{{$message->title}}</td>
            </tr>

            <tr>
                <th scope="row">متن پیام</th>
                <td>{{$message->description}}</td>
            </tr>


            <tr>
                <th scope="row">تاریخ</th>
                <td class="ltr">{{ jdate($message->created_at) }}</td>
            </tr>
            <tr>
                <th scope="row">{{ trans('front::messages.wallet.state') }}</th>
                <td>
                    @if($message->items()->first()->status == 'seen')
                        <div class="badge badge-pill badge-success badge-md">seen</div>
                    @else
                        <div class="badge badge-pill badge-danger badge-md">unseen</div>
                    @endif
                </td>
            </tr>



        </tbody>
    </table>
</div>
