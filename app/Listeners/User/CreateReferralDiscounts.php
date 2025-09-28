<?php

namespace App\Listeners\User;

use App\Models\Discount;
use App\Models\Referral;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateReferralDiscounts implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(Registered $event)
    {
        $user  = $event->user;
        $owner = $user->referral;

        if (!$owner) {
            return;
        }

        $discountType = option('user_refrral_gift_discount_type', 'percent');
        $ownerDiscountId = null;

        if (option('user_refrral_gift_type') === "discount_code") {
            $ownerDiscount = $this->createDiscount(
                "تخفیف کد معرف",
                random_code(),
                $discountType,
                option('owner_refrral_amount', 0),
                "کد تخفیف برای معرفی کاربر {$user->fullname}",
                $owner->id
            );
            $ownerDiscountId = $ownerDiscount->id;
        }

        $userDiscount = $this->createDiscount(
            "تخفیف کد معرف",
            random_code(),
            $discountType,
            option('user_refrral_amount', 0),
            "کد تخفیف برای ثبت کد معرف",
            $user->id
        );

        Referral::create([
            'owner_discount_id' => $ownerDiscountId,
            'user_discount_id'  => $userDiscount->id,
            'owner_id'          => $owner->id,
            'user_id'           => $user->id,
        ]);
    }

    private function createDiscount($title, $code, $type, $amount, $description, $userId): Discount
    {
        $discount = Discount::create([
            'title'       => $title,
            'code'        => $code,
            'type'        => $type,
            'amount'      => $amount,
            'description' => $description,
            'quantity'    => 1,
            'start_date'  => now(),
            'end_date'    => now()->addDays(90),
        ]);

        $discount->users()->attach([$userId]);

        return $discount;
    }
}
