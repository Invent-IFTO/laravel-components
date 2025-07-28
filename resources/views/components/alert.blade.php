@if(count($alerts))
    @once
        @push('js')

            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function () {
                    @foreach($alerts as $type => $alert)
                        flasher.{{$type}}('{{$alert}}', '{{__(ucfirst($type))}}');
                    @endforeach
                            });
            </script>
        @endpush
    @endonce
@endif