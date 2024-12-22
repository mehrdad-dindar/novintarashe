<?php

namespace App\Services\Sms;

use App\Contracts\SmsContract;
use App\Contracts\SmsNotificationContract;
use Exception;
use Melipayamak\MelipayamakApi;

class MelipayamakSms extends SmsService implements SmsContract, SmsNotificationContract
{
    public function send()
    {
        $method = $this->method();
        $data   = $this->$method();

        $input_data   = $data['input_data'];
        $mobile       = $this->mobile();
        $bodyId       = $data['bodyId'];

        try {
            $username  = option('MELIPAYAMAK_PANEL_USERNAME');
            $password  = option('MELIPAYAMAK_PANEL_PASSWORD');
            $api       = new MelipayamakApi($username, $password);
            $sms       = $api->sms('soap');
            $to        = $mobile;
            $text      = implode(';', $input_data);
            $response  = $sms->sendByBaseNumber($text, $to, $bodyId);

            $message = json_encode($response);
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        return $message;
    }

    public function verifyCode()
    {
        return [
            'bodyId'       => option('user_verify_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['code']
            ],
        ];
    }

    public function userCreated()
    {
        return [
            'bodyId'       => option('user_register_pattern_code_melipayamak'),
            'input_data'   => [
                '0'   => $this->data['fullname'],
                '1'   => $this->data['username'],
            ],
        ];
    }

    public function orderPaid()
    {
        return [
            'bodyId'       => option('order_paid_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['order_id']
            ],
        ];
    }
    public function userOrderConfirm()
    {
        return [
            'bodyId'       => '238232',
            'input_data'   => [
                '0' => $this->data['user_name'] ,
                '1' => $this->data['order_id']
            ],
        ];
    }

    public function userOrderSent()
    {
        return [
            'bodyId'       => '238237',
            'input_data'   => [
                '0' => $this->data['tracking_code'] ,
            ],
        ];
    }

    public function userOrderPaid()
    {
        return [
            'bodyId'       => '238234', //option('user_order_paid_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['user_name'],
                '1' => $this->data['order_id']
            ],
        ];
    }

    public function walletAmountDecreased()
    {
        return [
            'bodyId'       => option('wallet_decrease_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['amount']
            ],
        ];
    }

    public function walletAmountIncreased()
    {
        return [
            'bodyId'       => option('wallet_increase_pattern_code_melipayamak'),
            'input_data'   => [
                '0' => $this->data['amount']
            ],
        ];
    }

    public function sendMessageUsers()
    {
        return [
            'bodyId' => option('user_message_pattern_code'),
            'input_data'   =>  $this->data,
        ];
    }
    public function sendHappyBirthday()
    {
        return [
            'pattern_code' => option('happy_birthday_pattern_code_melipayamak'),
            'input_data'   => [
                '0'   => $this->data['fullname'],
            ],
        ];
    }
}
