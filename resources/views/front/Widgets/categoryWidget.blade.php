@isset($categories)
<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            Kategoriler
        </div>
        <div class="list-group">
        @foreach($categories as $cat)   
        
        <li class="list-group-item ">
            
                <a class="@if(Request::segment(2)==$cat->slug) text-danger @endif" @if(Request::segment(2)!=$cat->slug) href="{{route('category',$cat->slug)}}" @endif >{{$cat->name}}</a>
                <span class="badge bg-danger text-white float-end rounded-2">{{$cat->articleCount()}}</span>
            </li>
            @endforeach  

        </div>
    </div>
</div>

@endisset