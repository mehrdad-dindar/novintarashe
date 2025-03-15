<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{

    public function index()
{
    $sitemap = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

    // افزودن لینک‌های ثابت
    $urls = [
        ['loc' => url('/'), 'changefreq' => 'daily', 'priority' => '1.0'],
        ['loc' => url('/contact'), 'changefreq' => 'weekly', 'priority' => '0.8'],
    ];

    // افزودن لینک‌های محصولات
    $products = Product::published()->latest('updated_at')->get();
    foreach ($products as $product) {
        $urls[] = [
            'loc' => route('front.products.show', ['product' => $product]),
            'changefreq' => 'daily',
            'priority' => '0.9',
            'lastmod' => $product->updated_at->toAtomString()
        ];
    }

    // افزودن لینک‌های مقالات
    $posts = Post::published()->latest('updated_at')->get();
    foreach ($posts as $post) {
        $urls[] = [
            'loc' => route('front.posts.show', ['post' => $post]),
            'changefreq' => 'weekly',
            'priority' => '0.8',
            'lastmod' => $post->updated_at->toAtomString()
        ];
    }

    // افزودن لینک‌های صفحات
    $pages = Page::where('published', true)->latest('updated_at')->get();
    foreach ($pages as $page) {
        $urls[] = [
            'loc' => route('front.pages.show', ['page' => $page]),
            'changefreq' => 'monthly',
            'priority' => '0.7',
            'lastmod' => $page->updated_at->toAtomString()
        ];
    }

    // افزودن دسته‌بندی‌های محصولات
    $categories = Category::whereHas('products')->published()->latest('updated_at')->get();
    foreach ($categories as $category) {
        $urls[] = [
            'loc' => route('front.products.category-products', $category),
            'changefreq' => 'weekly',
            'priority' => '0.8',
            'lastmod' => $category->updated_at->toAtomString()
        ];
    }

    // افزودن لینک‌ها به `sitemap.xml`
    foreach ($urls as $urlData) {
        $url = $sitemap->addChild('url');
        $url->addChild('loc', htmlspecialchars($urlData['loc']));
        $url->addChild('changefreq', $urlData['changefreq']);
        $url->addChild('priority', $urlData['priority']);
        if (isset($urlData['lastmod'])) {
            $url->addChild('lastmod', $urlData['lastmod']);
        }
    }

    // ذخیره سایت‌مپ در `storage`
    $filePath = public_path('sitemap.xml');
    $sitemap->asXML($filePath);

    return response($sitemap->asXML(), 200)->header('Content-Type', 'application/xml');
}


    public function index_old()
    {
        $sitemap = app()->make('sitemap');
        $sitemap->setCache('laravel.sitemap', 60); // کش به مدت 60 دقیقه

        if (!$sitemap->isCached()) {

            // **افزودن لینک‌های ثابت**
            $sitemap->add(URL::to('/'), now()->toAtomString(), '1.0', 'daily');
            //$sitemap->add(URL::to('/about'), now()->toAtomString(), '0.8', 'weekly');
            $sitemap->add(URL::to('/contact'), now()->toAtomString(), '0.8', 'weekly');

            // **افزودن همه پست‌ها**
            $posts = Post::published()->latest('updated_at')->get();
            foreach ($posts as $post) {
                $sitemap->add(
                    route('front.posts.show', ['post' => $post]),
                    $post->updated_at->toAtomString(),
                    '0.9',
                    'weekly'
                );
            }

            // **افزودن همه صفحات**
            $pages = Page::where('published', true)->latest('updated_at')->get();
            foreach ($pages as $page) {
                $sitemap->add(
                    route('front.pages.show', ['page' => $page]),
                    $page->updated_at->toAtomString(),
                    '0.8',
                    'monthly'
                );
            }

            // **افزودن همه محصولات**
            $products = Product::published()->latest('updated_at')->get();
            foreach ($products as $product) {
                $sitemap->add(
                    route('front.products.show', ['product' => $product]),
                    $product->updated_at->toAtomString(),
                    '0.9',
                    'daily'
                );
            }

            // **افزودن دسته‌بندی‌های محصولات**
            $categories = Category::whereHas('products')->published()->latest('updated_at')->get();
            foreach ($categories as $category) {
                $sitemap->add(
                    route('front.products.category-products', $category),
                    $category->updated_at->toAtomString(),
                    '0.9',
                    'weekly'
                );
            }
        }

        // ذخیره **همه داده‌ها** در `sitemap.xml`
        $sitemap->store('xml', 'sitemap');

        return $sitemap->render('xml');
    }

    public function posts()
    {
        $sitemap = app()->make('sitemap');
        $sitemap->setCache('laravel.sitemap.posts', 60);

        if (!$sitemap->isCached()) {
            $posts = Post::published()->latest('updated_at')->get();
            foreach ($posts as $post) {
                $sitemap->add(
                    route('front.posts.show', ['post' => $post]),
                    $post->updated_at,
                    '0.9',
                    'weekly'
                );
            }
        }
        $sitemap->store('xml', public_path('sitemap-posts.xml'));
        return $sitemap->render('xml');
    }

    public function pages()
    {
        $sitemap = app()->make('sitemap');
        $sitemap->setCache('laravel.sitemap.pages', 60);

        if (!$sitemap->isCached()) {
            $pages = Page::where('published', true)->latest('updated_at')->get();
            foreach ($pages as $page) {
                $sitemap->add(
                    route('front.pages.show', ['page' => $page]),
                    $page->updated_at,
                    '0.9',
                    'weekly'
                );
            }
        }
        $sitemap->store('xml', public_path('sitemap-pages.xml'));
        return $sitemap->render('xml');
    }

    public function products()
    {
        $sitemap = app()->make('sitemap');
        $sitemap->setCache('laravel.sitemap.products', 60);

        if (!$sitemap->isCached()) {
            $products = Product::published()->latest('updated_at')->get();
            foreach ($products as $product) {
                $sitemap->add(
                    route('front.products.show', ['product' => $product]),
                    $product->updated_at,
                    '0.9',
                    'daily'
                );
            }
        }
        $sitemap->store('xml', public_path('sitemap-products.xml'));
        return $sitemap->render('xml');
    }

    public function category_products()
    {
        $sitemap = app()->make('sitemap');
        $sitemap->setCache('laravel.sitemap.category_products', 60);

        if (!$sitemap->isCached()) {
            $categories = Category::whereHas('products')->published()->latest('updated_at')->get();

            foreach ($categories as $category) {
                $sitemap->add(
                    route('front.products.category-products', $category),
                    $category->updated_at,
                    '0.9',
                    'daily'
                );
            }
        }
        $sitemap->store('xml', public_path('sitemap-category-products.xml'));
        return $sitemap->render('xml');
    }
}
