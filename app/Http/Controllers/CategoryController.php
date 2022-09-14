<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategoryAjax(Request $request){
        if($request->ajax())
        {
            if($request->id > 0)
            {
                $category = \App\Domain\Product::where('id', '<', $request->id)
                    ->orderBy('id', 'DESC')
                    ->get();
            }
            else
            {
                $category = \App\Domain\Product::orderBy('id', 'DESC')
                    ->get();
            }
            $output = '';
            $last_id = '';

            echo $output;
        }
    }

    public function getCityAjax(Request $request){
        if($request->ajax())
        {
            if($request->id > 0)
            {
                $city = \App\Domain\Product::where('id', '<', $request->id)
                    ->orderBy('id', 'DESC')
                    ->get();
            }
            else
            {
                $city = \App\Domain\Product::orderBy('id', 'DESC')
                    ->get();
            }
            $output = '';
            $last_id = '';

            echo $output;
        }
    }
}
