@extends('front.layout.master')
@section('title','iletişim')
@section('bg','https://t4.ftcdn.net/jpg/05/08/77/97/360_F_508779720_mevGw0UiCDurA6A195ayIk5sxaGFwuEu.jpg')

@section('content')



<div class="col-md-8">
    @if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h4>Bizimle iletişime geçebilirsiniz.</h4>
    <div class="my-5">
        <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="post" action="{{route('contact.post')}}">
            @csrf
            <div class="form-floating">
                <input class="form-control" name="name" value="{{old('name')}}" type="text" placeholder="Ad Soyadınız..." required data-sb-validations="required" />
                <label name="name">Ad Soyad</label>
                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
            </div>
            <div class="form-floating">
                <input class="form-control" name="email" value="{{old('email')}}" type="email" required placeholder="Email Adresiniz..." data-sb-validations="required,email" />
                <label name="email">Email Adresi</label>
                <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
            </div>
            <div class="form-floating">
                <select class="form-select" name="topic">
                    <option @if(old('topic')=="Bilgi" ) selected @endif>Bilgi</option>
                    <option @if(old('topic')=="Destek" ) selected @endif>Destek</option>
                    <option @if(old('topic')=="Genel" ) selected @endif>Genel</option>
                </select>
                <label name="topic">Konu</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control"  name="message" placeholder="Mesajınız..." style="height: 12rem" data-sb-validations="required">{{old('message')}}</textarea>
                <label name="message">Mesajınız</label>
                <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
            </div>
            <br />

            <button class="btn btn-primary text-uppercase" type="submit">Gönder</button>
        </form>
    </div>
</div>
<div class="col-md-4">
    <div class="card card-default">
        <div class="card-body">Panel Content</div>
        Adres : BLA BLA BLA
    </div>

</div>

</div>

@endsection