@extends('front.layout.master')
@section('title',$category->name . ' Kategorisi | '.$articles->total(). ' Yazı Bulundu ..')

@section('content')

<div class="col-md-9 mx-auto">
    @include('front.widgets.postWidget')

</div>
@include('front.widgets.categoryWidget')
@endsection