<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{

    public function index()
    {
        $sitemapIndex = app()->make('sitemap');

        // **ساخت سایت مپ برای محصولات**
        $productSitemap = app()->make('sitemap');
        $products = Product::published()->latest('updated_at')->get();
        foreach ($products as $product) {
            $productSitemap->add(
                route('front.products.show', ['product' => $product]),
                $product->updated_at->toAtomString(),
                '0.9',
                'daily'
            );
        }
        $productSitemap->store('xml', 'sitemaps/products');

        // **ساخت سایت مپ برای مقالات**
        $postSitemap = app()->make('sitemap');
        $posts = Post::published()->latest('updated_at')->get();
        foreach ($posts as $post) {
            $postSitemap->add(
                route('front.posts.show', ['post' => $post]),
                $post->updated_at->toAtomString(),
                '0.8',
                'weekly'
            );
        }
        $postSitemap->store('xml', 'sitemaps/posts');

        // **ساخت سایت مپ برای صفحات**
        $pageSitemap = app()->make('sitemap');
        $pages = Page::where('published', true)->latest('updated_at')->get();
        foreach ($pages as $page) {
            $pageSitemap->add(
                route('front.pages.show', ['page' => $page]),
                $page->updated_at->toAtomString(),
                '0.7',
                'monthly'
            );
        }
        $pageSitemap->store('xml', 'sitemaps/pages');

        // **ساخت سایت مپ برای دسته‌بندی‌ها**
        $categorySitemap = app()->make('sitemap');
        $categories = Category::whereHas('products')->published()->latest('updated_at')->get();
        foreach ($categories as $category) {
            $categorySitemap->add(
                route('front.products.category-products', $category),
                $category->updated_at->toAtomString(),
                '0.8',
                'weekly'
            );
        }
        $categorySitemap->store('xml', 'sitemaps/categories');

        // **ایجاد sitemap index**
        $sitemapIndex->add(url('sitemaps/products.xml'), now()->toAtomString());
        $sitemapIndex->add(url('sitemaps/posts.xml'), now()->toAtomString());
        $sitemapIndex->add(url('sitemaps/pages.xml'), now()->toAtomString());
        $sitemapIndex->add(url('sitemaps/categories.xml'), now()->toAtomString());

        // ذخیره sitemap index
        $sitemapIndex->store('sitemapindex', 'sitemap');

        return $sitemapIndex->render('sitemapindex');
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
