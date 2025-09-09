<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\RelatedCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class RelatedCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:products.stock-notify');
    }

    public function index()
    {
        $categories = Category::orderBy('title')->paginate(2);

        $allCategories = Cache::remember('all_categories', 3600, function() {
            return Category::get(['id', 'title']);
        });

        return view('back.relatedCategories.index', compact('categories', 'allCategories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RelatedCategory  $relatedCategory
     * @return Response
     */
    public function show(RelatedCategory $relatedCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RelatedCategory  $relatedCategory
     * @return Response
     */
    public function edit(RelatedCategory $relatedCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RelatedCategory  $relatedCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $sourceCategoryId)
    {
        $request->validate([
            'suggested_category_ids' => 'nullable|array',
            'suggested_category_ids.*' => 'exists:categories,id',
            'active' => 'required|boolean'
        ]);

        // حذف تمام رابطه‌های قبلی
        RelatedCategory::where('source_category_id', $sourceCategoryId)->delete();

        // اگر فعال باشد و دسته‌هایی انتخاب شده باشد، ایجاد کن
        if ($request->active && !empty($request->suggested_category_ids)) {
            foreach ($request->suggested_category_ids as $suggestedId) {
                // جلوگیری از خود-ارجاع (اختیاری ولی بهتره)
                if ($suggestedId == $sourceCategoryId) {
                    continue;
                }

                RelatedCategory::create([
                    'source_category_id' => $sourceCategoryId,
                    'suggested_category_id' => $suggestedId,
                    'active' => true
                ]);
            }
        }
        Cache::forget('related_categories_map');
        return response()->json([
            'message' => 'تنظیمات با موفقیت ذخیره شد.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RelatedCategory  $relatedCategory
     * @return Response
     */
    public function destroy(RelatedCategory $relatedCategory)
    {
        //
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $categories = Category::with('suggestedCategories')
        ->when($query, function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%");
            if (is_numeric($query)) {
                $q->orWhere('id', $query);
            }
        })
            ->orderBy('title')
            ->paginate(2);


        $allCategories = Cache::remember('all_categories', 3600, function () {
            return Category::orderBy('title')->get(['id', 'title']);
        });

        return response()->json([
            'html' => view('back.relatedCategories.partials.table', compact('categories', 'allCategories'))->render(),
            'pagination' => (string) $categories->appends(['q' => $query])->links()
        ]);
    }

}
