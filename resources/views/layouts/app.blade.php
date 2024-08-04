<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - InvoiceManagement</title>
    <!-- Local CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .container h1 {
            font-size: 2.5em;
            color: #343a40;
            margin-bottom: 15px;
        }
        .container p {
            font-size: 1.2em;
            color: #495057;
            margin-bottom: 25px;
        }
        .nav-link {
            color: #495057 !important;
        }
        .nav-link:hover {
            color: #0056b3 !important;
        }
        .btn-link {
            color: #007bff;
        }
        .btn-link:hover {
            color: #0056b3;
        }

    </style>
</head>
<body>
    @include('include.navbar')
    {{-- <div > --}}
        @yield('content')
    {{-- </div> --}}

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
       $(document).ready(function() {
        $('#select_all').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('input[name="permissions[]"]').prop('checked', isChecked);
        });

        // إذا كان أحد checkboxes يتم إلغاء تحديده، قم بإلغاء تحديد "Select All"
        $('input[name="permissions[]"]').on('change', function() {
            if (!$(this).is(':checked')) {
                $('#select_all').prop('checked', false);
            } else if ($('input[name="permissions[]"]').length === $('input[name="permissions[]"]:checked').length) {
                $('#select_all').prop('checked', true);
            }
        });
    });
    </script>
</body>
</html>
