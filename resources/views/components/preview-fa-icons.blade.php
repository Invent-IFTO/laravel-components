<x-adminlte.form.input :name="$name" :label="$label" :attributes="$attributes" class="preview-fa-icons" :id="$id"
    oninput="updateIconPreview(this)">
    <x-slot name="appendSlot">
        <div class="input-group-text px-5 icon-preview"><i class=""></i></div>
    </x-slot>
</x-adminlte.form.input>
@once
@push('js')
    <script>
        function updateIconPreview(input) {
            const preview = input.nextElementSibling.querySelector('.icon-preview>i');
            if (input && preview) {
                preview.className = input.value || 'fas fa-question text-2xl';
                input.setAttribute('data-value', input.value);
            }
        }
        setInterval(function () {
            const inputs = document.querySelectorAll('input.preview-fa-icons');
            inputs.forEach(input => {
                if (input.getAttribute('data-value') != input.value) {
                    input.setAttribute('data-value', input.value);
                    updateIconPreview(input);
                }
            })
        }, 200);


    </script>
    @endonce
@endpush