@if(count($alerts))
    @once
        @push('js')

            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function () {

                    if (typeof toastr !== 'undefined') {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        @foreach($alerts as $alert)
                            toastr.{{$alert['type']}}('{{$alert['message']}}', '{{__(ucfirst($alert['type']))}}');
                        @endforeach
                     } else if (typeof flasher !== 'undefined') {

                        @foreach($alerts as $alert)
                            flasher.{{$alert['type']}}('{{$alert['message']}}', '{{__(ucfirst($alert['type']))}}');
                        @endforeach
                    }

                });
            </script>
        @endpush
    @endonce
@endif