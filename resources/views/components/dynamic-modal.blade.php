@once
    @prepend('js')
        <x-adminlte-modal id="dynamic_modal_error" v-centered>
            <div class="text-center">
                <i class="fas fa-exclamation-triangle text-danger fa-5x"></i>
                <div class="text-danger" role="alert">
                    Ocorreu um erro ao carregar o conteúdo. Por favor, tente novamente.
                </div>
            </div>
            <x-slot:footerSlot>
                <x-adminlte-button theme="secondary" class="ml-auto" :label="__('Close')" data-dismiss="modal" />
            </x-slot:footerSlot>
        </x-adminlte-modal>
        <!-- Modal -->
        <div class="modal fade" id="dynamic_modal_loading" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background-color:transparent; border:none; box-shadow: none;">
                    <div class="modal-body">
                        <div class="text-center p-5">
                            <div class="spinner-border text-primary" role="status" style="width: 5rem; height: 5rem;">
                                <span class="sr-only">Carregando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endprepend
    @push('js')
        <script>
            function dynamicModal(url, method = "get") {
                const modalOpen = $('.modal.show');
                if (modalOpen.length) {
                    modalOpen.modal('hide');
                }
                const loading = $('#dynamic_modal_loading');
                const error = $('#dynamic_modal_error');
                let container_modals = $('#container_modals').length ? $('#container_modals') : $('body');
                loading.one('shown.bs.modal', function () {
                    $.ajax({
                        url: url,
                        method: method,
                        success: function (data) {
                            loading.modal("hide");
                            const result = $(data);
                            const modal = result.filter('.modal').add(result.find('.modal')).first();
                            if (modal.length) {
                                container_modals.append(result);
                                result.find('form').each(function (index, form) {
                                    if (url && !form.querySelector('[name="dynamic_modal_url"]')) {
                                        const inputUrl = document.createElement('input');
                                        inputUrl.type = 'hidden';
                                        inputUrl.name = 'dynamic_modal_url';
                                        inputUrl.value = url;
                                        form.appendChild(inputUrl);
                                    }

                                    if (method && !form.querySelector('[name="dynamic_modal_method"]')) {
                                        const inputMethod = document.createElement('input');
                                        inputMethod.type = 'hidden';
                                        inputMethod.name = 'dynamic_modal_method';
                                        inputMethod.value = method;
                                        form.appendChild(inputMethod);
                                    }
                                });
                                modal.on('hidden.bs.modal', function () {
                                    $(this).remove();
                                });
                                modal.modal('show');
                            }
                        },
                        error: function () {
                            loading.modal("hide");
                            error.modal("show");
                        }
                    });
                });
                loading.modal("show");
            }
            @if($errors->any() && old('dynamic_modal_url', false) && old('dynamic_modal_method', false))
                document.addEventListener("DOMContentLoaded", function () {
                    dynamicModal('{{ old("dynamic_modal_url") }}', '{{ old("dynamic_modal_method") }}')
                });
            @endif
        </script>
    @endpush
@endonce