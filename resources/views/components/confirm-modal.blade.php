@once
    @prepend('js')
        <x-adminlte-modal id="confirm-modal" title="Confirme Modal" size="lg" theme="secondary" class="text-center"
            icon="fas fa-exclamation" v-centered static-backdrop scrollable>
            modal-body
            <x-slot name="footerSlot">
                <x-adminlte-button theme="secondary" class="mr-auto" label="Cancelar" data-dismiss="modal" data-bs-dismiss="modal" />
                <form>
                    @csrf
                    @method('get')
                    <x-adminlte-button type="submit" icon="fas fa-check" theme="primary" label="Confirmar" />
                </form>
            </x-slot>
        </x-adminlte-modal>
    @endprepend
    @push('js')
        <script>
            function confirmModal(target) {
                const url = $(target).data('url');
                const method = $(target).data('method') || 'get';
                const title = $(target).data('title');
                const icon = $(target).data('icon');
                const theme = $(target).data('theme');
                const placeholder = $(target).data('placeholder');
                const modal = $('#confirm-modal');
                const actionButtons = modal.find('.modal-footer');
                const body = modal.find('.modal-body');
                const header = modal.find('.modal-header');
                const header_title = header.find('.modal-title');
                const confirm_button = modal.find('button[type="submit"]');
                const confirm_label = $(target).data('confirm-label') || 'Confirmar';
                const confirm_theme = $(target).data('confirm-theme') || theme;
                const confirm_icon = $(target).data('confirm-icon') || 'fas fa-check';
                const confirm_message = $(target).data('confirm-message') || 'Você tem certeza que deseja realizar esta ação?';
                const form = modal.find('form');
                const laravel_method = form.find('input[name="_method"]');
                const input = $(target).data('input');


                form.attr('action', url);
                form.attr('method', (method.toLowerCase == 'get') ? "get" : "post");
                laravel_method.val(method);
                confirm_button.html('<i class="' + confirm_icon + '"></i> ' + confirm_label);
                const setBody = function (component) {
                    body.html(component);
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
                toggleTheme(confirm_button, confirm_theme);
                const text = $(`<div class="form-group"><div class="input-group"><label>${confirm_message}</label></div></div>`);
                confirm_button.off('click');
                if (input) {
                    const form_group = text.first();
                    const inputValue = $('<input>')
                        .attr('type', 'text')
                        .attr('name', 'confirm')
                        .attr('value', '')
                        .addClass('form-control')
                        .attr('placeholder', placeholder);
                    inputValue.on('keyup', function (e) {
                        if (e.key == 'Enter') {
                            confirm_button.trigger('click');
                        }
                    });

                    const feedback = $('<span>').attr('class', 'invalid-feedback text-left text-bold')
                        .text('placeholder');
                    form_group.append(inputValue);
                    form_group.append(feedback);
                    confirm_button.on('click', function (e) {
                        e.preventDefault();
                        console.log(inputValue.val(), input);
                        if (inputValue.val() !== input) {
                            inputValue.addClass('is-invalid');
                            form_group.find('.invalid-feedback').show();
                        } else {
                            form.submit();
                            inputValue.removeClass('is-invalid');
                            form_group.find('.invalid-feedback').hide();

                        }
                    });
                }
                setBody(text);
                modal.css('z-index',1100);
                modal.modal('show');
                
            }
        </script>
    @endpush
@endonce