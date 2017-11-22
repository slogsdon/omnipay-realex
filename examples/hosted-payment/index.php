<!DOCTYPE html>
<html>
<head>
    <title>HPP Lightbox Demo</title>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/rxp-js.js"></script>
    <script>
    // get the HPP JSON from the server-side SDK
        $(document).ready(function () {
            $.getJSON("/request.php", function (resp) {
                RealexHpp.setHppUrl(resp.url);
                RealexHpp.init("payButtonId", "/response.php", resp.data);
            });
        });
    </script>
</head>
<body>
<button type="button" id="payButtonId">Checkout Now</button>
</body>
</html>
