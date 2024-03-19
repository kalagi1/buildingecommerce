<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body onload="javascript:moveWindow()">
    <form name="pay_form" method="post" action="https://sanalpos2.ziraatbank.com.tr/fim/est3Dgate">

        <input type="hidden" name="clientid" value="{{$clientid}}"/>
        <input type="hidden" name="callbackurl" value="{{$callbackurl}}"/>
        <input type="hidden" name="amount" value="{{$amount}}"/>
        <input type="hidden" name="Ecom_Payment_Card_ExpDate_Year" value="{{$Ecom_Payment_Card_ExpDate_Year}}"/>
        <input type="hidden" name="Ecom_Payment_Card_ExpDate_Month" value="{{$Ecom_Payment_Card_ExpDate_Month}}"/>
        <input type="hidden" name="currency" value="{{$currency}}"/>
        <input type="hidden" name="hashAlgorithm" value="{{$hashAlgorithm}}"/>
        <input type="hidden" name="hash" value="{{$hash}}"/>
        <input type="hidden" name="islemtipi" value="{{$islemtipi}}"/>
        <input type="hidden" name="lang" value="{{$lang}}"/>
        <input type="hidden" name="oid" value="{{$oid}}"/>
        <input type="hidden" name="okurl" value="{{$okurl}}"/>
        <input type="hidden" name="pan" value="{{$pan}}"/>
        <input type="hidden" name="rnd" value="{{$rnd}}"/>
        <input type="hidden" name="storetype" value="{{$storetype}}"/>
        <input type="hidden" name="taksit" value="{{$taksit}}"/>
        <input type="hidden" name="failurl" value="{{$failurl}}"/>
    </form>
    
    <script type="text/javascript" language="javascript">
        function moveWindow() {
           document.pay_form.submit();
        }
    </script>
</body>
</html>