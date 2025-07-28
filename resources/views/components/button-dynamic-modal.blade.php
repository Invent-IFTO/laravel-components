<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-{$theme}"]) }}" data-method="{{ $method }}"
    onclick="dynamicModal('{{ $url }}','{{ $method }}')">
    {{-- Button content --}}
    @isset($icon) <i class="{{ $icon }}"></i> @endisset
    @isset($label) {{ $label }} @endisset
</button>