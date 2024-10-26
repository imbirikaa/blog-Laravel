@extends ('back.layouts.master')
@section('title','Tüm Kategoriler')
@section('content')

<div class="row">



    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('admin.category.create')}}">
                    @csrf
                    <div class="form-group">
                        <label>Kategori Adı</label>
                        <input type="text" class="form-control" name="category" required />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Oluştur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kategori Adı</th>
                                <th>Makale Sayısı</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($categories as $cat)
                            <tr>
                                <td>{{$cat->name}}</td>
                                <td>{{$cat->articleCount()}}</td>
                                <td>
                                    <input type="checkbox" class="switch" cat-id="{{$cat->id}}" data-offstyle="danger" data-onstyle="success" data-on="Aktif" data-off="Pasif" @if($cat->status==1) checked @endif data-toggle="toggle">
                                </td>
                                <td>
                                    <a class="btn btn-sm edit-click btn-primary" cat-id="{{$cat->id}}" title="Kategori Duzenle"> <i class="fa fa-edit"></i></a>
                                    <a class="btn btn-sm remove-click btn-danger" cat-id="{{$cat->id}}" cat-name="{{$cat->name}}" cat-count = "{{$cat->articleCount()}}" title="Kategori Sil"> <i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- EDIT Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kategoriyi Düzenle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('admin.category.update')}}">
                    @csrf
                    <div class="form-group">
                        <label>Kategori Adı</label>
                        <input id="category" type="text" name="category" class="form-control" required>
                        <input type="hidden" name="id" id="category_id"/>
                    </div>
                    <div class="form-group">
                        <label>Kategori Slug</label>
                        <input id="slug" type="text" name="slug" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-success">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- REMOVE Modal -->
<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kategoriyi Sil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="body" class="modal-body">
                <div id="articleAlert" class="alert alert-danger"></div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <form action="{{route('admin.category.delete')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="deleteid"/>
                        <button type="submit" id="deletebtn" class="btn btn-danger">Sil</button>
                    </form>
                </div>
            </form>
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
        $('.remove-click').click(function() {
            id = $(this)[0].getAttribute('cat-id');
            count = $(this)[0].getAttribute('cat-count');
            name = $(this)[0].getAttribute('cat-name');

            if(id==1){
                $('#articleAlert').html(name + ' Kategorisi sabit kategoridir. Silinen diğer kategorilere ait makaleler bu kategoriye eklenecektir ');
                $('#body').show();
                $('#deletebtn').hide();
                $('#removeModal').modal();
                return;
            }
            
            
            $('#deleteid').val(id);
            $('#deletebtn').show();
            $('#articleAlert').html('');
            $('#body').hide();
            if(count > 0)
            {
                $('#articleAlert').html('Bu Kategoriye ait ' + count + ' makale Bulunmaktadır. Silmek istediğinize Emin misiniz ?!');
                $('#body').show();
        }
        $('#removeModal').modal();
        });
        $('.switch').change(function() {
            id = $(this)[0].getAttribute('cat-id');
            statu = $(this).prop('checked');
            $.get("{{route('admin.category.switch')}}", {
                id: id,
                statu: statu
            }, function(data, status) {

                console.log(data);
            });
        });
        $('.edit-click').click(function() {
            id = $(this)[0].getAttribute('cat-id');
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.category.getData') }}',

                data: {id: id},
                success: function(data) {
                    console.log(data);
                    $('#category').val(data.name);
                    $('#slug').val(data.slug);
                    $('#category_id').val(data.id);
                    $('#editModal').modal();
                }
            });
        });
        
    });
</script>

@endsection