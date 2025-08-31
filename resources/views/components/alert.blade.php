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
                        @foreach($alerts as $type => $alert)
                            toastr.{{$type}}('{{$alert}}', '{{__(ucfirst($type))}}');
                        @endforeach
                                                } else if (typeof flasher !== 'undefined') {

                        @foreach($alerts as $type => $alert)
                            flasher.{{$type}}('{{$alert}}', '{{__(ucfirst($type))}}');
                        @endforeach
                                                }

                });
            </script>
        @endpush
    @endonce
@endif