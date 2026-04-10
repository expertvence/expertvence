<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>ExpertVence Software</title>
    

    <!-- ✅ FAVICON -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- ✅ Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ✅ Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

    @vite(['resources/js/app.js'])
</head>
<body class="{{ app()->isProduction() ? 'vite-build' : '' }}">

    <div id="app"></div>
</body>
</html>

