<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - Halcon Logistics' : 'Halcon Logistics' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    <script>
        toastr.options = {
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "progressBar": true
        };
    </script>
    @stack('extra_css')
</head>

<body class="bg-gray-50 text-gray-900">
    <main>
        @yield('content')
    </main>

    @php
        $successMessage = Session::get('success');
        $errorMessage = Session::get('error');
        $warningMessage = Session::get('warning');
        $infoMessage = Session::get('info');
        $validationErrors = $errors->all();
    @endphp

    @if ($successMessage)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.success('{{ addslashes($successMessage) }}', 'Success!', { closeButton: true, tapToDismiss: false });
            });
        </script>
    @endif

    @if ($errorMessage)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.error('{{ addslashes($errorMessage) }}', 'Error!', { closeButton: true, tapToDismiss: false });
            });
        </script>
    @endif

    @if ($warningMessage)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.warning('{{ addslashes($warningMessage) }}', 'Warning!', { closeButton: true, tapToDismiss: false });
            });
        </script>
    @endif

    @if ($infoMessage)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.info('{{ addslashes($infoMessage) }}', 'Information', { closeButton: true, tapToDismiss: false });
            });
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    toastr.error('{{ addslashes($error) }}', 'Validation Error', { closeButton: true, tapToDismiss: false });
                });
            </script>
        @endforeach
    @endif

    @stack('extra_scripts')
</body>

</html>