@extends ('back.layouts.master')
@section('title',$article->title . ' güncelle')
@section('content')
<div class="card shadow mb-4">

    <div class="d-flex justify-content-between card-header py-3 align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </div>
        @endif
        <form method="post" action="{{route('admin.makaleler.update',$article->id)}}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label>Makale Başlığı:</label>
                <input type="text" name="title" value="{{$article->title}}" class="form-control" required></input>
            </div>
            <div class="form-group">
                <label>Makale Kategori:</label>
                <select name="category" class="form-control" required>
                    <option value="">Seçim Yapınız</option>
                    @foreach($categories as $category)
                    <option @if($article->category==$category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Makale Fotoğrafı :</label><br>
                <img src="{{asset($article->image)}}" class="rounded img-thumbnail" width="300" alt="">
                <input type="file" name="image" class="form-control"></input>
            </div>
            <div class="form-group">
                <label>Makale İçeriği:</label>
                <textarea id="editor" name="content" class="form-control" rows="4" required>{{$article->content}}</textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Makaleyi Güncelle</button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editor').summernote({
            height: 300,

        });
    });
</script>
@endsection