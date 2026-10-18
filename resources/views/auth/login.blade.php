<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | NDC INV</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data class="bg-white font-poppins">
<div class="flex min-h-screen w-full flex-wrap items-center justify-center bg-[linear-gradient(-135deg,#fcfaf9,#fff)] p-[15px]">
    <div class="flex w-[700px] max-w-full flex-wrap justify-between overflow-hidden rounded-[10px] border border-olive-dark bg-white p-5 shadow-[10px_10px_10px_#646400] md:px-[60px] md:pt-[30px] md:pb-[25px] md:pl-[30px]">

        <div x-data="tilt" @mousemove="move" @mouseleave="reset"
             class="m-auto w-[160px] p-2.5 md:m-0 md:w-[200px] md:pt-5">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="max-w-full p-[5px] transition-transform duration-300 ease-out" :style="style">
        </div>

        <form method="POST" action="{{ route('login') }}" class="w-full md:w-[380px]">
            @csrf
            <span class="block w-full pb-[15px] text-center font-poppins text-2xl leading-tight font-medium text-olive-dark">
                LOGIN &gt;&gt; NDC INV
            </span>

            <div class="relative z-[1] mb-2.5 w-full text-center">
                @if ($errors->any())
                    <div class="alert alert-danger !mb-0 text-sm" x-data x-init="setTimeout(() => $el.remove(), 3000)">{{ $errors->first() }}</div>
                @endif
                @if (session('status'))
                    <div class="alert alert-info !mb-0 text-sm" x-data x-init="setTimeout(() => $el.remove(), 3000)">{{ session('status') }}</div>
                @endif
            </div>

            <div class="relative z-[1] mb-2 w-full">
                <input class="input100 block h-10 w-full rounded-[25px] bg-[#e6e6e6] pr-5 pl-[60px] font-poppins text-[15px] leading-[1.4] text-olive-dark outline-none"
                       type="text" name="email" value="{{ old('email') }}" placeholder="Email/User Name ***" autofocus required>
                <span class="focus-input100 absolute bottom-0 left-0 -z-[1] block h-full w-full rounded-[25px] text-[rgba(111,120,68,.8)]"></span>
                <span class="symbol-input100 pointer-events-none absolute bottom-0 left-0 flex h-full w-full items-center rounded-[25px] pl-[35px] text-[15px] text-olive transition-all duration-400">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </span>
            </div>

            <div class="relative z-[1] mb-2 w-full">
                <input class="input100 block h-10 w-full rounded-[25px] bg-[#e6e6e6] pr-5 pl-[60px] font-poppins text-[15px] leading-[1.4] text-olive-dark outline-none"
                       type="password" name="password" placeholder="Password ***" required>
                <span class="focus-input100 absolute bottom-0 left-0 -z-[1] block h-full w-full rounded-[25px] text-[rgba(111,120,68,.8)]"></span>
                <span class="symbol-input100 pointer-events-none absolute bottom-0 left-0 flex h-full w-full items-center rounded-[25px] pl-[35px] text-[15px] text-olive transition-all duration-400">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                </span>
            </div>

            <div class="flex w-full flex-wrap justify-center pt-2">
                <button class="flex h-10 w-full items-center justify-center rounded-[25px] bg-olive p-[5px] font-montserrat text-base leading-normal font-bold text-white uppercase transition-all duration-400 hover:bg-olive-dark">
                    LOGIN
                </button>
            </div>
        </form>

        <div class="w-full pt-10 text-center font-poppins text-[15px] text-[#212529]">
            Copyright {{ date('Y') }} &copy; <a href="javascript:void(0)" class="text-army underline">NDC</a> | Unauthorized access is strictly prohibited.<br>
        </div>
    </div>
</div>
<script>
    // jQuery "tilt" effect from the reference login page, re-done with Alpine.
    document.addEventListener('alpine:init', () => {
        Alpine.data('tilt', () => ({
            style: '',
            move(e) {
                const r = this.$el.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - 0.5;
                const y = (e.clientY - r.top) / r.height - 0.5;
                this.style = `transform: perspective(300px) rotateX(${(-y * 40).toFixed(2)}deg) rotateY(${(x * 40).toFixed(2)}deg) scale(1.1)`;
            },
            reset() { this.style = ''; },
        }));
    });
</script>
</body>
</html>
