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

        .form-group {
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 5px;
            display: inline-block;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            box-sizing: border-box;
        }

        .form-control:focus {
            color: #212529;
            background-color: #fff;
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
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
        }

        .btn:hover {
            color: #212529;
            text-decoration: none;
        }
    </style>

    <script>
        /*$(document).ready(function() {
            $('#payment-form').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                        //$('#response-container').html('<pre>' + JSON.stringify(response, null, 2) + '</pre>');
                    },
                    error: function(xhr) {
                        //$('#response-container').html('<pre>' + JSON.stringify(xhr.responseJSON.errors, null, 2) + '</pre>');
                    }
                });
            });
        });*/

    </script>
    @if (Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}", 'Success!', {timeout: 120000});
        </script>
    @endif
    @if (Session::has('failed'))
        <script>
            toastr.error("{{ Session::get('failed') }}", 'Error!', {timeout: 120000});
        </script>
    @endif
</head>

<body class="font-sans antialiased">
<div class="container">
    <div class="row justify-content-center">
        <form action="/deposit" method="post" id="payment-form">
            @csrf
            <div class="form-group">
                <label for="name">Payment method</label>
                <select class="form-control" id="pay-method" name="pay-method">
                    <option value="easymoney">EasyMoney</option>
                    <option value="superwalletz">SuperWalletz</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" placeholder="Insert amount"
                       value="25">
            </div>
            <div class="form-group">
                <label for="currency">Currency</label>
                <select class="form-control" id="currency" name="currency">
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Deposit</button>
            </div>
        </form>
        <div id="response-container" style="margin-top: 20px;"></div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
