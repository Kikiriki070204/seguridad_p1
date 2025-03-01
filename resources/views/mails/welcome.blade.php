@extends('layouts.layout')

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="py-8 lg:py-16 mx-auto max-w-screen-xl px-4">
        <h2 class="mb-8 lg:mb-16 text-3xl font-extrabold tracking-tight leading-tight text-center text-gray-900 dark:text-white md:text-4xl">¡Gracias por registrarte!</h2>
        <div class="items-center gap-8 text-gray-500 sm:gap-12 md:grid-cols-3 lg:grid-cols-6 dark:text-gray-400">
            <a href="{{$signedURL}}" class="flex justify-center items-center">
                Haz click aquí para registrarte                      
            </a>
        </div>
    </div>
</section>
@endsection