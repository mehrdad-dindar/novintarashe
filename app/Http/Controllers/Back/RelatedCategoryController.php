<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\RelatedCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RelatedCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:products.stock-notify');
    }

    public function index()
    {
        $categories = Category::latest()->paginate(15);

        return view('back.relatedCategories.index', compact('categories'));

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
            'suggested_category_ids' => 'array',
            'suggested_category_ids.*' => 'exists:categories,id',
            'active' => 'boolean'
        ]);

        // حذف قدیمی‌ها
//        RelatedCategory::where('source_category_id', $sourceCategoryId)->delete();

        // ایجاد جدید
        if ($request->active && $request->suggested_category_ids) {
            foreach ($request->suggested_category_ids as $suggestedId) {
                RelatedCategory::create([
                    'source_category_id' => $sourceCategoryId,
                    'suggested_category_id' => $suggestedId,
                    'active' => true
                ]);
            }
        }

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
}
