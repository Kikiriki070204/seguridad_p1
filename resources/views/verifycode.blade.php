@extends('layouts.layout')
<script>
</script>


@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="mx-auto max-w-screen-sm text-center">
            <h1 class="mb-4 text-4xl tracking-tight font-extrabold lg:text-9xl text-primary-600 dark:text-primary-500">¡Verifica tu inicio de sesión!</h1>
                    
        <form class="max-w-sm mx-auto" method="POST" action="/verifycode">
        @csrf    
        <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">Ingresa el código que hemos enviado a tu correo</p>
            <div class="relative">
                <input type="text" id="code" name="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
            </div>
            <button type="submit" class="inline-flex text-white bg-gray-600 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-primary-900 my-4">Verificar</button>
        </form>

        </div>   
    </div>
</section>
@endsection