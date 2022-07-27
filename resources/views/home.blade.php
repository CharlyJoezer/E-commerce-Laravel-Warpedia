@extends('template.template')
@section('content')
<div class="box-carousel">
    <div class="carousel" id="carousel">
        <img class="carousel-slide1" id="carousel-slide1" src="asset/slide1.webp" alt="">
        <div class="carousel-button-box" id="carousel-button-box">
            <img id="carousel-left-button" src="asset/carousel-left-button.webp" alt="">
            <img id="carousel-right-button" src="asset/carousel-right-button.webp" alt="">
        </div>
    </div>
    <div class="promo-image">
        <img src="asset/promo-image1.webp" alt="">
        <img src="asset/promo-image2.webp" alt="">
    </div>
</div>


@endsection