@extends('adminlte::components.form.input-group-component')

{{-- Set errors bag internallly --}}

@php($setErrorsBag($errors ?? null))

{{-- Set input group item section --}}

@section('input_group_item')

{{-- Input --}}

<div class="row">
    @foreach ($themes as $theme)
        <div class="col-4 col-md-2 mb-3 m-3">
            <div class="theme-box border rounded text-center position-relative p-3 bg-{{ $theme }}" style=" width: 100%; height: 50px; cursor: pointer; transition: transform 0.2s;" data-theme="{{ $theme }}">
                @if ($getOldValue($errorKey, $attributes->get('value')) === $theme)
                    <i class="fas fa-check-circle check-icon" style="position: absolute;
                        top: 5px;
                        right: 5px;
                        font-size: 1.5rem;"></i>
                @endif
            </div>
            <div class="text-center mt-2 font-weight-bold">
                {{ ucfirst($theme) }}
            </div>
        </div>
    @endforeach
</div>
<input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ $getOldValue($errorKey, $attributes->get('value')) }}">

@overwrite


@once
    @push('css')
        <style>
            .check-icon {}
        </style>
    @endpush
    @push('js')
        <script>
            document.querySelectorAll('.theme-box').forEach(box => {
                box.addEventListener('mouseover', () => {
                    box.style.transform = 'scale(1.15)';
                });
                box.addEventListener('mouseout', () => {
                    box.style.transform = 'scale(1)';
                });
                box.addEventListener('click', function () {
                    document.querySelectorAll('.theme-box .check-icon').forEach(icon => icon.remove());
                    const icon = document.createElement('i');
                    icon.classList.add('fas', 'fa-check-circle', 'check-icon');
                    icon.style="position: absolute; top: 5px; right: 5px; font-size: 1.5rem;";
                    this.appendChild(icon);
                    document.getElementById('selectedTheme').value = this.dataset.theme;
                });
            });
        </script>
    @endpush
@endonce