<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\Gateway;
use App\Models\Province;
use App\Models\Widget;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $widgets = Widget::detectLang()->with('options')
            ->where('theme', current_theme_name())
            ->where('is_active', true)
            ->orderBy('ordering')
            ->get();

        return view('front::index', compact('widgets'));
    }

    public function checkout()
    {

        $cart     = auth()->user()->cart;
        $message = null ;

        if (!$cart || !$cart->products->count() || !check_cart_quantity()) {
            return redirect()->route('front.cart');
        }

        if (auth()->user()->type == 'colleague' || auth()->user()->type == 'vip' || auth()->user()->gateway_with_check == 'active'){

            $products = $cart->products->where('typeBuy' , '=' , 'onlyCache');
            if ((count($products) ?? 0) > 0) {
                $message = 'محصول های ' ;
                foreach ($products as $product) {
                    $message .= $product->title . ' , ' ;
                }
                $message .= ' را با چک نمیتوانید پرداخت کنید برای فعال شدن پرداخت چک این محصولات را از سبد کالای خود حذف کنید .' ;

                $gateways = Gateway::whereNotIn('key' , ['check1' , 'check2' , 'check3' , 'check4' , 'check5' , 'check6'])->active()->orderBy('ordering')->get();


            }else{
                $gateways = Gateway::active()->orderBy('ordering')->get();
            }

        }else{
            $gateways = Gateway::whereNotIn('key' , ['check1' , 'check2' , 'check3' , 'check4' , 'check5' , 'check6'])->active()->orderBy('ordering')->get();
        }

        $discount_status = check_cart_discount();

        $provinces       = Province::detectLang()->active()->orderBy('ordering')->get();
        $wallet          = auth()->user()->getWallet();
        $carriers        = Carrier::detectLang()->active()->latest()->get();


        return view('front::checkout', compact(
            'provinces',
            'discount_status',
            'gateways',
            'wallet',
            'carriers' ,
            'message'
        ));
    }

    public function getPrices(Request $request)
    {
        $cart = auth()->user()->cart;

        $gatewaySelect = Gateway::where('key' , '=' , $request->gateway)->first() ;

        if ($request->city_id) {
            $request->validate([
                'city_id' => 'required|exists:cities,id',
            ]);
        }

        if ($request->carrier_id) {
            $request->validate([
                'carrier_id' => 'required|exists:carriers,id',
            ]);
        }

        $carriers = Carrier::detectLang()->active()->latest()->get();

        $cart->update([
            'city_id'    => $request->city_id,
            'carrier_id' => $request->carrier_id,
            'gateway_id' => $gatewaySelect->id ?? null,
        ]);


        return [
            'checkout_sidebar'   => view('front::partials.checkout-sidebar' , compact('gatewaySelect'))->render(),

            'carriers_container' => view('front::partials.carriers-container', [
                'cart'           => $cart,
                'carriers'       => $carriers
            ])->render(),
        ];
    }

    public function captcha()
    {
        return response(['captcha' => captcha_src('flat')]);
    }
}
