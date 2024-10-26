<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('back.categories.index', compact('categories'));
    }
    public function switch(Request $request)
    {
        $cat = Category::findOrFail($request->id);
        $cat->status = $cat->status == 0 ? 1 : 0;
        $cat->save();
    }
    public function create(Request $request)
    {
        $isExist = Category::whereSlug(str::slug($request->category))->first();
        if ($isExist) {
            return redirect()->back()->with('error', $request->category . ' isimde zaten bir kategori var.');
        }
        $cat = new Category;
        $cat->name = $request->category;
        $cat->slug = str::slug($request->category);
        $cat->save();
        return redirect()->back()->with('success', 'Kategori Başarıyla Oluşturuldu.');
    }
    public function update(Request $request)
    {
        $isSlug = Category::whereSlug(str::slug($request->slug))->whereNotIn('id',[$request->id])->first();
        $isName = Category::whereName($request->category)->whereNotIn('id',[$request->id])->first();
        if ($isSlug or $isName) {
            return redirect()->back()->with('error', $request->category . ' isimde zaten bir kategori var.');
        }
        
        $cat = Category::find($request->id);
        $cat->name = $request->category;
        $cat->slug = str::slug($request->slug);
        $cat->save();
        return redirect()->back()->with('success', 'Kategori Başarıyla Güncellendi.');
    }
    public function delete(Request $request){
        $cat = Category::findOrFail($request->id);
        if($cat->id == 1){

            return redirect()->back()->with('error', 'Bu Kategori Silinemez.');
        }
        if($cat->articleCount() > 0){
            Article::where('category',$cat->id)->update(['category'=> 1]);
        }
        $cat->delete();
        return redirect()->back()->with('success', 'Kategori Başarıyla Silindi.');
    }
    public function getData(Request $request)
    {
        $cat = Category::findOrFail($request->id);
        return response()->json($cat);
    }
}
