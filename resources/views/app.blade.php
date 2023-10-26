<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Invest Cubo é a sua plataforma de pesquisa de imóveis de leilão da Caixa Econômica Federal. Descubra oportunidades únicas e invista de forma inteligente.">

    <meta name="keywords" content="imóveis, leilão, Caixa Econômica Federal, investimento, Invest Cubo, pesquisa de imóveis, oportunidades, leilões da Caixa">

    <meta name="author" content="Invest Cubo">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>