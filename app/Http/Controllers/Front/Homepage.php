<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


//==========Models
use App\Models\Category;
use App\Models\Article;
use App\Models\Page;
use App\Models\Contact;

class Homepage extends Controller
{
    public function __construct()
    {
        view()->share('pages', Page::orderBy('order', 'ASC')->get());
        view()->share('categories', Category::inRandomOrder()->get());
    }
    public function index()
    {

        $data['articles'] = Article::orderBy('created_at', 'DESC')->paginate(2);
        $data['articles']->withPath(url('sayfa'));
        return view('front.homepage', $data);
    }

    public function single($cat, $slug)
    {
        $cate = Category::whereSlug($cat)->first() ?? abort(403, 'Böyle bir Kategori BULUNAMADI !');
        $arc = Article::whereSlug($slug)->whereCategory($cate->id)->first() ?? abort(403, 'Böyle bir yazı BULUNAMADI !');

        $arc->increment('hit');

        $data['article'] = $arc;

        return view('front.single', $data);
    }

    public function category($slug)
    {
        $cate = Category::whereSlug($slug)->first() ?? abort(403, 'Böyle bir Kategori BULUNAMADI !');
        $data['category'] = $cate;
        $data['articles'] = Article::whereCategory($cate->id)->orderBy('created_at', 'DESC')->paginate(1);



        return view('front.category', $data);
    }

    public function page($slug)
    {
        $page = Page::whereSlug($slug)->first() ?? abort(403, 'Böyle bir Sayfa BULUNAMADI !');
        $data['page'] = $page;

        return view('front.page', $data);
    }
    public function contact()
    {

        return view('front.contact');
    }
    public function contactPost(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'topic' => 'required',
            'message' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contact')->withErrors($validator)->withInput();
        }
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->topic = $request->topic;
        $contact->message = $request->message;
        $contact->save();
        return redirect()->route('contact')->with('success', 'Mesajınız bize iletildi. Teşekkür ederiz :) ');
    }
}
