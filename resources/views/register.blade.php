@extends('layouts.layout')

@section('header')
<script async src="https://www.google.com/recaptcha/api.js"></script>
<title>
    Registrate
  </title>
@endsection

@section('content')
<section class="items-center mb-10">
    <div class="py-4 px-2 mx-auto max-w-2xl  bg-white border border-gray-200 rounded-lg shadow-sm">
    <h2 class="mb-6 text-center text-xl font-bold text-gray-900 dark:text-white text-center">Crea una nueva cuenta</h2>
        <form method="POST" action="store" class="max-w-md mx-auto">
            @csrf
            <div class="relative z-0 w-full mb-5 group">
            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tu nombre</label>
            <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="" required>
            </div>
            @if($errors->has('username'))
            <span class="font-medium text-red-800">{{ $errors->first('username') }}</span>
            @endif 

            <div class="relative z-0 w-full mb-5 group">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo electrónico</label>
            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
            </div>
          
            <div class="relative z-0 w-full mb-5 group">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
            </div>
            @if($errors->has('password'))
            <span class="font-medium text-red-800">{{ $errors->first('password') }}</span>
            @endif 

            <div class="g-recaptcha mt-6 mb-2" data-sitekey={{config('services.recaptcha.key')}}></div>
            @if($errors->has('g-recaptcha-response'))
            <span class="font-medium text-red-800 mb-2">{{ $errors->first('g-recaptcha-response') }}</span>
            @endif 
            @if($errors->has('recaptcha'))
            <span class="font-medium text-red-800 mb-2">{{ $errors->first('g-recaptcha-response') }}</span>
            @endif 

            <hr>

            <button type="submit" class="mt-2 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrarse</button>
            <br>
            <span class="font-medium">¿Ya tienes una cuenta? <a href="/login" class="font-semibold text-blue-800">Inicia sesión</a></span>
            
        </form>
        
    </div>
</section>

@endsection