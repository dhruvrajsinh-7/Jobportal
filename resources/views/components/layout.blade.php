<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Laravel Job Board</title>
    <link rel="stylesheet" href="../public/css/app.js">
    <script src="../public/js/app.js"></script>
    @vite(['public/css/app.css', 'public/js/app.js'])
</head>

<body
    class="from-10% via-30% to-90% mx-auto mt-10 max-w-2xl bg-gradient-to-r from-indigo-100 via-sky-100 to-emerald-100 text-slate-700">
    <nav class="mb-8 flex justify-between text-lg font-medium">
        <ul class="flex space-x-2">
            <li>
                <a href="{{ route('jobs.index') }}">Home</a>
            </li>
        </ul>
        <ul class="flex space-x-2">
            @auth
                <li>
                    <a href="{{ route('my-application.index') }}">
                        {{ auth()->user()->name ?? 'Anynomus' }}:Application
                    </a>
                </li>
                <li>
                    <a href="{{ route('my-jobs.index') }}">My jobs</a>
                </li>
                <li>
                    <form method="POST" action="{{ route('auth.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <button>Logout</button>
                    </form>
                </li>
            @else
                <li>
                    <a href="{{ route('auth.create') }}">Sign in</a>
                </li>
            @endauth
        </ul>
    </nav>
    @if (session()->has('success'))
        <div class=" bg-green-100 border border-l-4 border-green-400 text-green-700 px-4 py-3 rounded relative"
            role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session()->get('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class=" bg-green-100 border border-l-4 border-red-400 text-red-700 px-4 py-3 rounded relative"
            role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session()->get('error') }}</span>
        </div>
    @endif
    {{ $slot }}
</body>

</html>
