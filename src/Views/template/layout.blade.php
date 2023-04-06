<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>

        @include('layouts._css')
        
    </head>

    <body>

        <main>

            <div class="container pb-5">

                <h1>Luna RBAC</h1>

                @yield('content')
                
            </div>
            
        </main>

        @include('layouts._js')        

    </body>

</html>
