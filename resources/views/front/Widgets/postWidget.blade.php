@if(count($articles))
<!-- Post preview-->
@foreach($articles as $arc)
<div class="post-preview">
    <a href="{{route('single',[$arc->getCategory->slug , $arc->slug])}}">
        <h2 class="post-title">{{$arc->title}}</h2>
        <img src="{{asset($arc->image)}}" alt="" style="width: 800px; height: 400px;">
        <h3 class="post-subtitle">{!!Str::limit($arc->content,80)!!}</h3>
    </a>
    <p class="post-meta">
        Category :
        <a href="{{route('category',$arc->getCategory->slug)}}">{{$arc->getCategory->name}} </a>
        <span class="float-end">{{$arc->created_at->diffForHumans()}}</span>
    </p>

</div>
<!-- Divider-->
@if(!$loop->last)
<hr class="my-4" />
@endif
@endforeach
<!-- Divider-->
<div class="d-flex justify-content-center">
    {{ $articles->links() }}
</div>
@else
<div class="alert alert-danger text-center">
    <h1>Bu Kategoriye ait yazı BULUNAMADI !</h1>
</div>
@endif