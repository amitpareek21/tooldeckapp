<!DOCTYPE html>
<html>
<head>
<title>ToolDeck</title>
@vite('resources/css/app.css')
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-V9M7XLSZ22"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-V9M7XLSZ22');
</script>
<link href="https://cdn.jsdelivr.net/npm/jsoneditor@9/dist/jsoneditor.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jsoneditor@9/dist/jsoneditor.min.js"></script>
</head>

<body class="bg-gray-50">

<header class="bg-white border-b">
<div class="max-w-6xl mx-auto p-4 flex justify-between">
<h1 class="text-xl font-bold">ToolDeck</h1>
<a href="/tools" class="text-blue-600">All Tools</a>
</div>
</header>

<main class="max-w-6xl mx-auto p-6">
@yield('content')
</main>

<footer class="text-center text-gray-500 p-6">
© ToolDeck
</footer>

</body>
</html>