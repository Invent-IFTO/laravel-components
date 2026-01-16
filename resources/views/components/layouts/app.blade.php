@props(['title' => null])
@extends('adminlte::page')
@section('title', $title)
@section('content_header')<h1>{{ $title ?? '' }}</h1>@stop
@push('css')
    @vite([config('adminlte.laravel_css_path', 'resources/css/app.css'), config('adminlte.laravel_js_path', 'resources/js/app.js')])
@endpush
@section('content')
    {{ $slot }}
    @if(config('invent.suporte_dynamic_modal', false))
        <x-invent::dynamic-modal />
    @endif
    @if(config('invent.suporte_confirme_modal', false))
        <x-invent::confirm-modal />
    @endif
    @stack('modals')
    <x-invent::alert />
@endsection
@section('footer')
    @include('invent::components.layouts.footer')
@endsection