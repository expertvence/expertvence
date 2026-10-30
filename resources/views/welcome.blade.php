<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">

    <title>ExpertVence Software</title>
    

    <!-- ✅ FAVICON -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- ✅ Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ✅ Font Awesome & Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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

