@extends('layouts.app')

@section('title', __('رئيسية الموقع'))

@section('content')
    <p><h3 class="mb-5">الإعلانات الأكثر تفضيلًا :</h3>
    @include('partials.ads')

@endsection
