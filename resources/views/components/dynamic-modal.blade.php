<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-{$theme}"]) }} data-url="{{ $url }}"
    data-method="{{ $method }}" data-toggle="dynamic-modal" data-title="{{ $title }}" data-icon="{{ $icon }}"
    data-theme="{{ $theme }}">
    {{-- Button content --}}
    @isset($icon) <i class="{{ $icon }}"></i> @endisset
    @isset($label) {{ $label }} @endisset
</button>


@once
    @push('js')

        <x-adminlte-modal id="dynamic_modal" title="{{ $title }}" size="lg" theme="{{$theme}}" icon="fas fa-wallet" v-centered
            static-backdrop scrollable icon="{{ $icon }}">

            <x-slot name="footerSlot">

                <x-adminlte-button theme="secondary" class="mr-auto" label="Cancelar" data-dismiss="modal" />

                <div class="action-buttons" style="display:none;">
                    <x-adminlte-button icon="fas fa-eraser" theme="warning" label="Limpar" id="dynamic_modal_form_reset" />
                    <x-adminlte-button icon="fas fa-save" theme="primary" label="Salvar" id="dynamic_modal_form_submit" />
                    <div class="loading text-center">
                        <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                            <span class="sr-only">Carregando...</span>
                        </div>
                    </div>

                    <div class="error text-center">
                        <i class="fas fa-exclamation-triangle text-danger fa-5x"></i>
                        <div class="text-danger" role="alert">
                            Ocorreu um erro ao carregar o conteúdo. Por favor, tente novamente.
                        </div>
                    </div>
                </div>
            </x-slot>
        </x-adminlte-modal>
        <script>
            $('button[data-toggle="dynamic-modal"]').on('click', function () {
                const url = $(this).data('url');
                const method = $(this).data('method') || 'get';
                const title = $(this).data('title');
                const icon = $(this).data('icon');
                const theme = $(this).data('theme');
                const modal = $('#dynamic_modal');
                const loading = $('#dynamic_modal .loading');
                const error = $('#dynamic_modal .error');
                const actionButtons = $('.action-buttons');
                const body = $('#dynamic_modal .modal-body');
                const header = modal.find('.modal-header');
                const header_title = header.find('.modal-title');
                const setBody = function (component) {
                    const e = component.clone();
                    body.html("");
                    body.append(e);
                    e.show();
                }
                const toggleTheme = function (element, theme) {
                    // Remove todas as classes bg-*
                    element.removeClass(function (index, className) {
                        return (className.match(/\bbg-\S+/g) || []).join(' ');
                    });
                    // Adiciona a nova classe bg-*
                    if (theme)
                        element.addClass("bg-" + theme);
                }
                header_title.html("");
                if (title) {
                    if (icon) {
                        const i = $('<i>').attr('class', icon);
                        header_title.append(i);
                    }
                    header_title.append(" " + title);
                }

                toggleTheme(header, theme);

                // Reset form
                loading.hide();
                error.hide();
                actionButtons.hide();
                modal.modal('show');

                setBody(loading);


                $.ajax({
                    url: url,
                    method: method,
                    success: function (data) {
                        body.html(data);
                        const form = $('#dynamic_modal form');
                        loading.hide();
                        if (form[0]) {
                            actionButtons.show();
                            $('#dynamic_modal_form_submit').on('click', function () {
                                form.submit();
                            });
                            $('#dynamic_modal_form_reset').on('click', function () {
                                form[0].reset();
                            });
                        }

                    },
                    error: function () {
                        setBody(error);
                    }
                });
            });
        </script>
    @endpush
@endonce