<?php

namespace App\Http\Controllers;

use App\Http\Services\MainPageService;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;


class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageInfo = new MainPageService($request);
        return view('main', [ 'pageInfo' => $pageInfo ]);
    }

}
