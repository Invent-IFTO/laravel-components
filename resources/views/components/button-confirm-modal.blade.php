<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-{$theme}"]) }} data-url="{{ $url }}"
    data-method="{{ $method }}" data-toggle="confirm-modal" title="{{ $title }}" data-title="{{ $title }}"
    data-icon="{{ $icon }}" data-theme="{{ $theme }}" data-confirm-label="{{ $confirmLabel }}"
    data-confirm-theme="{{ $confirmTheme }}" data-confirm-icon="{{ $confirmIcon }}"
    data-confirm-message="{{ $message }}" @if(isset($input)) data-input="{{ $input }}" @endif onclick="confirmModal(this)">
    {{-- Button content --}}
    @isset($icon) <i class="{{ $icon }}"></i> @endisset
    @isset($label) {{ $label }} @endisset
</button>