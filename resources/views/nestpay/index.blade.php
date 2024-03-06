<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form method="post" action="{{ route('3d.payment') }}">
        @csrf
        {{-- <input type="hidden" name="clientid" value="190300000"/>
        <input type="hidden" name="storetype" value="3d_pay_hosting" />
        <input type="hidden" name="storekey" value="190933121" />
        {{-- <input type="hidden" name="hash" value="iej6cPOjDd4IKqXWQEznXWqLzLI=" /> 
        <input type="hidden" name="islemtipi" value="Auth" />
        <input type="hidden" name="amount" value="91.96" />
        <input type="hidden" name="currency" value="949" />
        <input type="hidden" name="oid" value="1291899411421" />
        <input type="hidden" name="okUrl" value="http://buildingecommerce.test/payment/success"/>
        <input type="hidden" name="failUrl" value="http://buildingecommerce.test/payment/fail" />
        <input type="hidden" name="callbackurl" value="http://buildingecommerce.test/payment/callback" />
        <input type="hidden" name="lang" value="tr" />
        <input type="hidden" name="rnd" value="asdf" />
        <input type="hidden" name="pan" value="4546711234567894">
        <input type="hidden" name="Ecom_Payment_Card_ExpDate_Year" value="26" >
        <input type="hidden" name="Ecom_Payment_Card_ExpDate_Month" value="12"> --}}
        <input type="submit" value="Ödemeyi Tamamla"/> 
    </form>
    
</body>
</html>