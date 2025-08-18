@props(['year'=> config('invent.developer.year', date('Y')), 'now'=>date('Y')])
<div class="container-fluid">
    <div class="row">
        <div class="col">
            &copy;{{ $year }} @if( $year != $now) - {{$now}} @endif  {{ config('app.name') }} By: <a href="{{ config('invent.developer.site') }}">{{config('invent.developer.name')}}</a>
        </div>
        <div class="col text-right mr-2">{{__('Version')}}: {{ config('invent.version') }}</div>
    </div>
</div>