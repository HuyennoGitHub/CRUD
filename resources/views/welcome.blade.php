<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CRUD-Laravel-VueJS</title>
        <!-- <link href="css/app.css" ref="stylesheet"> -->
        <link rel="stylesheet" href="css/app.css">
        <script type="module" scr="./js/app.js" defer></script>
        
    </head>
    <body>
        <div id="app"></div>
        <script src="{{mix('js/app.js')}}"></script>
    </body>
</html>
