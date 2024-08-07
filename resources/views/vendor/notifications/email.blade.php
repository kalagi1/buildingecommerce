<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@lang('auth.reset_password_subject')</title>
    <style>
        /* Stil ayarları (isteğe bağlı) */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #2f5f9e;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>@lang('auth.reset_password_intro')</p>
        <p>@lang('auth.reset_password_line1')</p>
        <p>
            <a href="{{ $actionUrl }}" class="button">@lang('auth.reset_password_action')</a>
        </p>
        <p>@lang('auth.reset_password_expiry')</p>
        <p>@lang('auth.reset_password_footer')</p>
        <p>@lang('auth.reset_password_signoff')</p>
        <p>@lang('auth.reset_password_sender')</p>
        <p>@lang('auth.reset_password_url', ['url' => $actionUrl])</p>
    </div>
</body>
</html>
