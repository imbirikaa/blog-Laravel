<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\str;
use Illuminate\Support\Facades\File;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'DESC')->get();
        return view('Back.articles.index', compact('articles'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('Back.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jped,png,jpg|max:2048',
        ]);

        $article = new Article;
        $article->title = $request->title;
        $article->content = $request->content;
        $article->category = $request->category;
        $article->slug = str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = str::slug($request->title) . '.' . $request->image->getClientOriginalExtension(); //
            $request->image->move(public_path('uploads'), $imageName);
            $article->image = 'uploads/' . $imageName;
        }
        $article->save();

        return redirect()->route('admin.makaleler.index')->with('success', 'Makale Başarıyla Oluşturuldu .');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('Back.articles.update', compact('categories', 'article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jped,png,jpg|max:2048',
        ]);

        $article = Article::findORFail($id);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->category = $request->category;
        $article->slug = str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = str::slug($request->title) . '.' . $request->image->getClientOriginalExtension(); //
            $request->image->move(public_path('uploads'), $imageName);
            $article->image = 'uploads/' . $imageName;
        }
        $article->save();

        return redirect()->route('admin.makaleler.index')->with('success', 'Makale Başarıyla Güncellendi .');
    }

    public function switch(Request $request)
    {

        $arc = Article::findORFail($request->id);
        $arc->status = $arc->status == 0 ? 1 : 0;
        $arc->save();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function delete($id) {
        Article::destroy($id);
        return redirect()->route('admin.makaleler.index')->with('success', 'Makale Başarıyla Silindi.');
    }
    public function trashed(){
        $articles = Article::onlyTrashed()->orderBy('deleted_at', 'DESC')->get();
        return view('Back.articles.trashed', compact('articles'));
    }
    public function harddelete($id){
        $arc = Article::onlyTrashed()->find($id);
        if(File::exists($arc->image)){
            File::delete(public_path($arc->image));  // delete the file from directory.  //
        }
        die;
        $arc->forceDelete();
        return redirect()->route('admin.makaleler.index')->with('success', 'Makale Başarıyla Silindi.');
    }
    public function recover(string $id)
    {
        Article::onlyTrashed()->where('id', $id)->restore();
        return redirect()->back()->with('success', 'Makale Başarıyla Geri Getirildi.');
    }
    public function destroy(string $id)
    {
        return $id;
    }
}
