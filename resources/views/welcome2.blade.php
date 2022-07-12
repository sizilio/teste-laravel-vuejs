<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste Laravel</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>
<body>

<div id="app">
    '{{ message }}'
</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            message: 'Olá Vue!'
        }
    })
</script>

</body>
</html>
