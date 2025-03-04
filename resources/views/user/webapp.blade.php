<html>
<head>
<script src="https://telegram.org/js/telegram-web-app.js?56"></script>
</head>
<body>

<script>
let webapp = window.Telegram.WebApp;
let initData = webapp.initData;

window.location.href = '{{ $domain }}/signin?' + initData;
console.log(webapp);
</script>

</body>
</html>