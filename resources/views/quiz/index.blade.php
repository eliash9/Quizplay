<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset ('img/logo.png') }}">
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/uicons-regular-straight/css/uicons-regular-straight.css'>
    <title>Play Quiz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="bg-gradient-to-r bg-blue-2F308B">
    <nav id="navbar"
        class="flex flex-wrap items-center justify-between w-full space-x-4 py-4 px-5 md:px-10 text-lg text-black-1E1E1E bg-white-fafafa mt-0 z-10 top-0">
        <svg xmlns="http://www.w3.org/2000/svg" id="menu-button"
            class="h-6 w-6 cursor-pointer md:hidden block text-black-1E1E1E shadow-lg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <div class="hidden space-x-4 bg-transparent md:bg-transparent w-full md:flex md:justify-between md:items-center md:w-auto"
            id="menu">
            <a class="flex items-center no-underline transform duration-200 hover:no-underline hover:opacity-80"
                href="{{ url('/pelajar') }}">
                <span
                    class="self-center md:text-4xl text-3xl text-blue-1081E8 font-signika font-bold whitespace-nowrap transition-colors duration-300 transform">Quiz
                    Play</span>
            </a>
            <ul class="pt-4 md:flex md:justify-between md:pt-0 text-base text-black font-semibold">
                <li>
                    <a class="xl:p-4 md:p-2 py-2 block no-underline opacity-50 duration-300 transform hover:opacity-100 hover:text-underline"
                        href="{{ url('/pelajar') }}">Home</a>
                </li>
            </ul>
        </div>
        <div class="flex md:flex-row space-x-2">
            @auth
            <h2 class="font-sans font-semibold text-center text-black text-lg">
                {{auth()->user()->username}}
            </h2>
            <a href="{{ url('logout') }}"
                class="group relative flex w-auto justify-center rounded-full bg-black duration-200 hover:bg-gray-400 text-blue-2F308B font-semibold text-sm px-2 py-1">
                Logout
            </a>
            @endauth
        </div>
    </nav>
    <section class="py-10 overflow-hidden">
        <div class="container mx-auto flex justify-center">
            <div class="py-2 w-full px-5 space-y-5 rounded-xl"> 
                <h1>Quiz Wizard</h1>
                <form method="post" action="{{ route('quizz.submit') }}">
                    @csrf

                    @foreach($pertanyaans as $index => $pertanyaan)
                    <div class="card my-3">
                        <div class="card-header">
                            <h5 class="card-title">Pertanyaan {{ $index + 1 }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $pertanyaan->pertanyaan }}</p>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="pertanyaans[{{ $pertanyaan->id }}]"
                                    value="1" id="jawaban_{{ $index }}_benar">
                                <label class="form-check-label" for="jawaban_{{ $index }}_benar">Benar</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="pertanyaans[{{ $pertanyaan->id }}]"
                                    value="0" id="jawaban_{{ $index }}_salah">
                                <label class="form-check-label" for="jawaban_{{ $index }}_salah">Salah</label>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
                </form>

            </div>
        </div>
    </section>
    {{ View::make('footer') }}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>