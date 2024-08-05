<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #ffffff; margin: 0; padding: 0; width: 100%; }
        .container { max-width: 600px; margin: 0 auto; padding: 25px; }
        .header { text-align: center; padding-bottom: 25px; }
        .header img { max-width: 200px; height: auto; }
        .body { background-color: #ffffff; border: 1px solid #e8e5ef; border-radius: 2px; padding: 32px; }
        .footer { text-align: center; padding: 32px; color: #b0adc5; font-size: 12px; }
        .button { display: inline-block; padding: 10px 20px; font-size: 16px; font-weight: bold; color: #ffffff; background-color: #1d72b8; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="https://emlaksepette.com">
                <img src="https://emlaksepette.com/images/emlaksepettelogo.png" alt="Emlak Sepette Logo">
            </a>
        </div>

        <div class="body">
            <h1>{{ $subject }}</h1>
            {!! $content !!}
        </div>

        <div class="footer">
            © 2024 Emlak Sepette. Tüm hakları saklıdır.
        </div>
    </div>
</body>
</html>
