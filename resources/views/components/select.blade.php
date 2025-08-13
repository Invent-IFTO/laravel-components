@extends('adminlte::components.form.input-group-component')

{{-- Set errors bag internallly --}}

@php($setErrorsBag($errors ?? null))

{{-- Set input group item section --}}

@section('input_group_item')

{{-- Select --}}
<select id="{{ $id }}" name="{{ $name }}" {{ $attributes->merge(['class' => $makeItemClass()]) }}>
    @if(isset($placeholder) && !$attributes->has('multiple'))
        <option disabled selected value="">{{$placeholder}}</option>
    @endif
    @if($slot->isEmpty())
        @foreach($options as $item_value => $item_label)
            <option value="{{ $item_value }}" @selected($isSelected($item_value))>
                {{ $item_label }}
            </option>
        @endforeach
    @else
        {{ $slot }}
    @endif
</select>

@overwrite



{{-- Add plugin initialization and configuration code --}}
@section('additional')
    @if($errors->any() && $enableOldSupport)
        @push('js')
            <script>
                $(() => {
                    let oldOptions = @json(collect($getOldValue($errorKey)));
                    $('#{{ $id }} option').each(function () {
                        let value = $(this).val() || $(this).text();
                        $(this).prop('selected', oldOptions.includes(value));
                    });
                });
            </script>
        @endpush
    @endif

    @if($selectDinamic())
        @push('js')
            <script>
                $(document).ready(function () {
                    if ({{ $preloadSelect}}) {
                        let value = $("#{{ $controlSelectId }}").val()
                        selectDinamic("#{{ $id }}", "{{ $dinamycSelectUrl }}", value, '{{$value}}');
                    }
                });

                $("#{{ $controlSelectId }}").change(function () {
                    let value = $("#{{ $controlSelectId }}").val()
                    selectDinamic("#{{ $id }}", "{{ $dinamycSelectUrl }}", value, {{ $value }});
                })
            </script>
        @endpush
    @endif


@endsection