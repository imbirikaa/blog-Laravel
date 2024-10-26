@extends ('back.layouts.master')
@section('title','Tüm Makaleler')
@section('content')
<div class="card shadow mb-4">

    <div class="d-flex justify-content-between card-header py-3 align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        <h6 class="m-0 font-weight-bold text-primary"><strong>{{$articles->count()}}</strong> Makale Bulundu. 
        <a href="{{route('admin.trashed.article')}}" class="btn btn-warning btn-sm"> <i class="fa fa-trash"></i>Silinen Makaleler</a>
    </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Fotoğraf</th>
                        <th>Makale Başlığı</th>
                        <th>kategori</th>
                        <th>Hit</th>
                        <th>Oluşturma Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($articles as $arc)
                    <tr>
                        <td>
                            <img src="{{asset($arc->image)}}" width="200" alt="">
                        </td>
                        <td>{{$arc->title}}</td>
                        <td>{{$arc->getCategory->name}}</td>
                        <td>{{$arc->hit}}</td>
                        <td>{{$arc->created_at->diffForHumans()}}</td>
                        <td>
                            <input type="checkbox" class="switch" article-id="{{$arc->id}}" data-offstyle="danger" data-onstyle="success" data-on="Aktif" data-off="Pasif" @if($arc->status==1) checked @endif data-toggle="toggle">
                        </td>
                        <td>
                            <a href="{{route('single',[$arc->getCategory->slug,$arc->slug])}}" target="_blank" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> </a>
                            <a href="{{route('admin.makaleler.edit',$arc->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i> </a>
                            <a href="{{route('admin.delete.article',$arc->id)}}" title="Sil" class="btn btn-sm btn-danger    "><i class="fa fa-times"></i> </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(function() {
        $('.switch').change(function() {
            id = $(this)[0].getAttribute('article-id');
            statu = $(this).prop('checked');
            $.get("{{route('admin.switch')}}",{id:id,statu:statu}, function(data, status){

                console.log(data);

            });
        });
    });
</script>

@endsection