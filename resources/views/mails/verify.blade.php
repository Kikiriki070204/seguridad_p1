@extends('layouts.layout')

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-16 lg:px-6">
        <figure class="max-w-screen-md mx-auto">
            <blockquote>
                <p class="text-4xl font-bold text-gray-900 dark:text-white">Tu código es el siguiente: </p>
            </blockquote>
            <blockquote class="font-bold">
                <p class="text-4xl font-bold text-gray-900 dark:text-white">{{$code}} </p>
            </blockquote>
        </figure>
    </div>
</section>
@endsection