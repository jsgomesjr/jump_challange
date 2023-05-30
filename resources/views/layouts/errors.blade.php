<script type="text/javascript" comment="Toast Alert Settings">
    // sobrescreve o padrao de opçoes do toast alert
    window.onload = function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": true,
            "onclick": null,
            "hideDuration": "1000", // tempo de ocutaçao
            "timeOut": "10000", // tempo de exibição
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        // mensagem de alerta ao usuario
        @if (@$errors->any())
            toastr["{{ @$errors->getMessages()['message_type'][0] }}"]("{!! @$errors->getMessages()['message_name'][0] !!}");
        @endif

        // mensagem de alerta ao usuario
        @if (Session::has('message'))
            toastr["{{ Session::get('message')['type'] }}"]("{!! Session::get('message')['get'] !!}");
        @endif

    };
</script>
