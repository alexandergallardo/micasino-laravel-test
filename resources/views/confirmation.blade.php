<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Fonts -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <style>
        .container {
            width: 100%;
            font-family: sans-serif;
            max-width: 960px;
            margin: 50px auto;
            padding: 0 20px;
        }

        label {
            margin-bottom: 5px;
            display: inline-block;
        }

        .btn {
            cursor: pointer;
            display: inline-block;
            font-weight: 400;
            color: #ddd;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: gray;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1.4rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            text-decoration: none;
        }

        .btn:hover {
            color: #212529;
            text-decoration: none;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="font-sans antialiased">
<div class="container">
    <div class="row justify-content-center">
        <h1>Confirmation</h1>
        <p>Transaction ID: {{ session('transaction_id') }}</p>
        <p>Status: {{ session('status') }}</p>
        <p>Message: {{ session('message') }}</p>
        <div class="form-group">
            <a type="button" class="btn btn-primary" href="/">Go to payment form</a>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
