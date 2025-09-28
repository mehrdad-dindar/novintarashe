<?php

namespace App\Listeners;

use App\Events\OrderPaid as EventsOrderPaid;
use App\Models\Sms;
use App\Models\User;
use App\Notifications\Order\OrderPaid as NotificationsOrderPaid;
use App\Notifications\Sms\OrderPaidSms;
use App\Services\Sms\SmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class OrderPaid
{
    /**
     * Handle the event.
     *
     * @param  OrderPaid  $event
     * @return void
     */
    public function handle(EventsOrderPaid $event)
    {
        $order = $event->order;

        foreach ($order->items as $item) {
            if ($item->product) {
                $sell = $item->product->sell + $item->quantity;

                $item->product()->update([
                    'sell' => $sell
                ]);
            }
        }

        $admins = User::whereIn('level', ['admin', 'creator'])->get();
        Notification::send($admins, new NotificationsOrderPaid($order));

        if (option('sms_on_order_paid', 'off') === 'on') {
            $smsService = new SmsService(
                option('admin_mobile_number'),
                [
                    'order_id' => $order->id
                ],
                Sms::TYPES['ORDER_PAID'],
                null
            );

            $smsService->sendSms();
        }

        if (option('user_sms_on_order_paid', 'off') === 'on') {
            $type = Sms::TYPES['USER_ORDER_PAID'] ;
            $data = [
                'name' => $order->user->full_name,
                'order_id' => $order->id,
                'phone' => option('info_tel'),
                'link' => asset('').'order/'.$order->id,

            ];
            $smsService = new SmsService(
                $order->user->username,
                $data ,
                $type,
                $order->user_id
            );

            $smsService->sendSms();
//            Notification::send($order->user, new OrderPaidSms($order));
        }
    }
}
