<?php

namespace Themes\DefaultTheme\src;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\RelatedCategory;
use App\Models\Link;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once(__DIR__ . '/helpers.php');

        // set config file
        if ($this->app['config']->get('front') === null) {
            $this->app['config']->set('front', require __DIR__ . '/../config/general.php');
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // load routes

        Route::group([
            'middleware' => ['web'],
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });

        foreach (config('app.locales') as $locale => $options) {
            Route::group([
                'middleware' => ['web'],
                'prefix'     => $locale,
                'as'     => $locale . '.',
            ], function () {
                $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
            });
        }

        // load views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'front');

        // load translations
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'front');

        // share with views
        if (!$this->app->runningInConsole()) {
            $this->viewComposer();
        }
    }

    private function viewComposer()
    {
        // SHARE WITH SPECIFIC VIEW


        view()->composer(['front::partials.footer'], function ($view) {

            $footer_links     = config('front.linkGroups', []);
            $links            = Link::detectLang()->orderBy('ordering')->get();

            $view->with(compact('footer_links', 'links'));
        });

        view()->composer(['front::partials.menu.menu', 'front::partials.mobile-menu.menu'], function ($view) {


            $productcats = Cache::rememberForever('front.productcats', function () {
                return Category::detectLang()->published()->whereNull('category_id')
                    ->orderBy('ordering')
                    ->where('type', 'productcat')
                    ->getWithChilds();
            });

            $postcats    = Category::detectLang()->published()->where('type', 'postcat')->whereNull('category_id')->orderBy('ordering')->get();
            $menus       = Menu::detectLang()->whereNull('menu_id')->orderBy('ordering')->get();

            $view->with(compact('productcats', 'postcats', 'menus'));
        });

        view()->composer(['front::posts.partials.sidebar'], function ($view) {

            $latest_posts = Post::detectLang()->where('published', true)->latest()->take(6)->get();

            $view->with(compact('latest_posts'));
        });

        view()->composer(['front::user.layouts.master'], function ($view) {
            $user = auth()->user();
            $recommended_products = collect();

            if ($user && $user->orders()->exists()) {
                $purchased_category_ids = $user->orders()
                    ->with('items.product.category:id,title')
                    ->get()
                    ->pluck('items')
                    ->flatten()
                    ->pluck('product.category.id')
                    ->filter()
                    ->unique()
                    ->values()
                    ->toArray();
                if (!empty($purchased_category_ids)) {
                    $suggested_category_ids = Cache::remember('related_categories_map', 3600, function () {
                        return RelatedCategory::active()
                            ->pluck('suggested_category_id', 'source_category_id')
                            ->groupBy('source_category_id')
                            ->map->pluck('suggested_category_id')
                            ->toArray();
                    });

                    $target_category_ids = [];

                    foreach ($purchased_category_ids as $category_id) {
                        if (isset($suggested_category_ids[$category_id])) {
                            $target_category_ids = array_merge($target_category_ids, $suggested_category_ids[$category_id]);
                        }
                    }

                    $target_category_ids = array_unique($target_category_ids);

                    if (!empty($target_category_ids)) {
                        $excluded_product_ids = $user->orders()
                            ->with('items')
                            ->get()
                            ->pluck('items')
                            ->flatten()
                            ->pluck('product_id')
                            ->toArray();

                        $recommended_products = Product::detectLang()
                            ->where('published', true)
                            ->available()
                            ->whereHas('category', function ($query) use ($target_category_ids) {
                                $query->whereIn('categories.id', $target_category_ids);
                            })
                            ->when(!empty($excluded_product_ids), function ($query) use ($excluded_product_ids) {
                                $query->whereNotIn('id', $excluded_product_ids);
                            })
                            ->inRandomOrder()
                            ->limit(10)
                            ->get();
                    }
                }
            }

            if ($recommended_products->isEmpty()) {
                $recommended_products = Cache::remember('random_products_home', 600, function () {
                    return Product::detectLang()
                        ->where('published', true)
                        ->available()
                        ->inRandomOrder()
                        ->limit(10)
                        ->get();
                });
            }

            $view->with(compact('user', 'recommended_products'));
        });

        view()->composer(['front::partials.cart', 'front::partials.checkout-sidebar', 'front::checkout', 'front::cart'], function ($view) {
            $cart = get_cart();
            $view->with('cart', $cart);
        });
    }
}
