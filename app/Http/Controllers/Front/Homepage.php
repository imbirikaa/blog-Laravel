<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


//==========Models
use App\Models\Category;
use App\Models\Article;

class Homepage extends Controller
{
    public function index()
    {
        $data['categories'] = Category::inRandomOrder()->get();
        $data['articles'] = Article::orderBy('created_at', 'DESC')->paginate(2);
        $data['articles']->withPath(url('sayfa'));
        return view('front.homepage', $data);
    }

    public function single($cat,$slug)
    {
        $cate = Category::whereSlug($cat)->first() ?? abort(403, 'Böyle bir Kategori BULUNAMADI !');
        $arc = Article::whereSlug($slug)->whereCategory($cate->id)->first() ?? abort(403, 'Böyle bir yazı BULUNAMADI !');

        $arc->increment('hit');

        $data['article'] = $arc;
        $data['categories'] = Category::inRandomOrder()->get();
        return view('front.single', $data);
    }

    public function category($slug){
        $cate = Category::whereSlug($slug)->first() ?? abort(403, 'Böyle bir Kategori BULUNAMADI !');
        $data ['category'] = $cate;
        $data['articles'] = Article::whereCategory($cate->id)->orderBy('created_at', 'DESC')->paginate(1);
        $data['categories'] = Category::inRandomOrder()->get();


        return view('front.category', $data);

    }
}
