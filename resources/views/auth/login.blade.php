<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center px-4"
        style="background-image: url('assets/background/Animated Shape (19).svg')">

        <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg p-10">
            <div class="py-5 flex items-center justify-center gap-2">
                <img src="{{ asset('assets/logo/logo-arsa.png') }}" alt=""
                    class="w-10 gap-0 bg-white rounded-md border border-gray-300">
                <p
                    class="text-2xl font-semibold text-transparent bg-clip-text bg-linear-to-r from-primary via-blue-600 to-secondary">
                    ARSA
                </p>
            </div>

            <div class="flex items-center justify-center">
                <p class="text-lg uppercase tracking-widest text-primary mb-3" data-aos="fade-right">
                    Login
                </p>
            </div>


            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- email --}}
                <div>
                    <x-input-label for="email" value="Email" class="text-gray-700 font-medium mb-2"></x-input-label>
                    <x-text-input id="email" name="email" type="email" :value="old('email')" required autofocus
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- password --}}
                <div>
                    <x-input-label for="password" value="Password" class="text-gray-700 font-medium mb-2" />
                    <x-text-input id="password" name="password" type="password" required
                        class="mt-1 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between text-sm pt-2">
                    <label class="flex items-center gap-2 text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer">
                        <span>Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-primary hover:text-secondary hover:underline font-medium">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                    class="w-full mt-6 bg-primary hover:bg-secondary py-2 rounded-xl cursor-pointer text-white font-semibold">
                    Login
                </button>


                <div class="flex items-center justify-center">
                    <a href="{{ route('register') }}">
                        <p class="text-md tracking-widest text-primary mb-3" data-aos="fade-right">
                            Tidak punya akun? <span class="hover:underline font-bold">Register</span>
                        </p>
                    </a>
                </div>

            </form>

        </div>

    </div>

</x-guest-layout>
