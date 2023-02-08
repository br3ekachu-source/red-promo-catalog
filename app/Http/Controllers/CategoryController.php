<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {
        $limit = 10;
        $category = Category::find($id);
        $sort = ['field' => $request->get('sort'), 'type' => $request->get('type')];
        $products = $category->products()
        ->withCount('reviews as count_reviews')
        ->with('category')
        ->with('users');

        switch ($sort['field']) {
            case 'count':
                $products = $products->orderBy('count_reviews', $sort['type'])
                ->paginate($limit)
                ->appends([
                    'sort' => $sort['field'],
                    'type' => $sort['type']
                ]);
                break;
            case 'date':
                $products = $products->orderBy('created_at', $sort['type'])
                ->paginate($limit)
                ->appends([
                    'sort' => $sort['field'],
                    'type' => $sort['type']
                ]);
                break;
            case null:
                $products = $products->paginate($limit);
                break;
        }

        return view('category', ['products' => $products, 'category' => $category, 'sort' => $sort]);
    }
}
