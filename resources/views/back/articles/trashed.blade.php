@extends ('back.layouts.master')
@section('title','Silinen Makaleler')
@section('content')
<div class="card shadow mb-4">

    <div class="d-flex justify-content-between card-header py-3 align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        <h6 class="m-0 font-weight-bold text-primary"><strong>{{$articles->count()}}</strong> Makale Bulundu. 
        <a href="{{route('admin.makaleler.index')}}" class="btn btn-primary btn-sm">Aktif Makaleler</a>
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
                            <a href="{{route('admin.recover.article',$arc->id)}}" title="Geri al" class="btn btn-sm btn-primary"><i class="fa fa-recycle"></i> </a>
                            <a href="{{route('admin.hard.delete.article',$arc->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> </a>
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