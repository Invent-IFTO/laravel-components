<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn bg-{$theme}"]) }}" data-method="{{ $method }}"
    onclick="dynamicModal('{{ $url }}','{{ $method }}')">
    {{-- Button content --}}
    @isset($icon) <i class="{{ $icon }}"></i> @endisset
    @isset($label) {{ $label }} @endisset
</button>