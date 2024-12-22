<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $guarded = ['id'];

    const TYPES = [
        'VERIFY_CODE' => [
            'key'    => 'verify-code',
            'string' => 'کد تایید',
            'method' => 'verifyCode'
        ],
        'USER_CREATED' => [
            'key'    => 'user-created',
            'string' => 'خوش آمدگویی کاربر',
            'method' => 'userCreated'
        ],
        'ORDER_PAID' => [
            'key'    => 'order-paid',
            'string' => 'اطلاع رسانی پرداخت سفارش به مدیر',
            'method' => 'orderPaid'
        ],
        'USER_ORDER_PAID' => [
            'key'    => 'user-order-paid',
            'string' => 'اطلاع رسانی پرداخت سفارش به کاربر',
            'method' => 'userOrderPaid'
        ],
        'USER_ORDER_CONFIRM' => [
            'key'    => 'user-order-confirm',
            'string' => 'اطلاع رسانی تایید سفارش به کاربر',
            'method' => 'userOrderConfirm'
        ],
        'USER_ORDER_SENT' => [
            'key'    => 'user-order-sent',
            'string' => 'اطلاع رسانی ارسال سفارش به کاربر',
            'method' => 'userOrderSent'
        ],
        'WALLET_AMOUNT_DECREASED' => [
            'key'    => 'wallet-amount-decreased',
            'string' => 'اطلاع رسانی کاهش موجودی کیف پول',
            'method' => 'walletAmountDecreased'
        ],
        'WALLET_AMOUNT_INCREASED' => [
            'key'    => 'wallet-amount-decreased',
            'string' => 'اطلاع رسانی افزایش موجودی کیف پول',
            'method' => 'walletAmountIncreased'
        ],
        'SEND_MESSAGE_USERS' => [
            'key'    => 'send-message-users',
            'string' => 'ارسال پبام به کاربران',
            'method' => 'sendMessageUsers'
        ],
        'SEND_HAPPY_BIRTHDAY' => [
            'key'    => 'send-happy-birthday',
            'string' => 'ارسال پبام تبریک تولد به کاربران',
            'method' => 'sendHappyBirthday'
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        foreach (self::TYPES as $type) {
            if ($this->type == $type['key']) {
                return $type['string'];
            }
        }
    }
}
