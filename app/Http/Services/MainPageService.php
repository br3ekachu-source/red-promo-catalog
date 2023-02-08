<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainPageService {

    private $favoriteProducts;
    private $popularCategories;
    private $searchedProducts;
    private $searchedCategories;
    private $search;

    public function __get($property)
    {
        return $this->$property;
    }

    public function __construct(Request $request)
    {
        $this->favoriteProducts = Auth::user()->products()->with('category')->get();

        $this->popularCategories = DB::table('categories')
        ->join('products', 'categories.id', '=', 'products.category_id')
        ->join('reviews', 'products.id', '=', 'reviews.product_id')
        ->selectRaw('categories.id, categories.name, count(reviews.id) as count_reviews')
        ->groupBy('categories.id')
        ->limit(5)
        ->get();

        if ($request->get('search') != null) {
            $this->search($request->get('search'));
        } else {
            $this->search = null;
            $this->searchedCategories = Category::all();
            $this->searchedProducts = Product::all();
        }
    }

    private function search(string $search) {
        $this->search = $search;
        $this->searchedCategories = Category::where('name', 'LIKE', "%{$search}%")->get();
        $this->searchedProducts = Product::where('name', 'LIKE', "%{$search}%")->get();
    }

}