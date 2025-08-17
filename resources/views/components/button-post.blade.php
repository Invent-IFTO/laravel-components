<form action="{{ $action }}" method="{{ $method }}">
    @isset($laravel_method)
        @method($laravel_method)
    @endisset
    @if($csrf)
        @csrf
    @endif
    <button type="submit" {{ $attributes->merge(['class' => "btn btn-$theme"]) }}>
        {{ $slot }}
    </button>
    @foreach($hiddens as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach
</form>