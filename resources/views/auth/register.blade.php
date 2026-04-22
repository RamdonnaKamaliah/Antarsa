<x-guest-layout>
    <!-- Background wrapper -->
    <div class="min-h-screen bg-[#f0fafa] flex items-center justify-center relative overflow-hidden">

        <!-- Geometric shapes -->
        <div class="fixed top-20 left-24 w-20 h-20 bg-[#4dd6d0] opacity-55 rotate-[20deg] z-0"></div>
        <div class="fixed top-16 right-28 w-14 h-32 bg-[#4dd6d0] opacity-55 -rotate-[15deg] z-0"></div>
        <div class="fixed bottom-40 left-16 w-12 h-12 bg-[#4dd6d0] opacity-55 rotate-[35deg] z-0"></div>
        <div class="fixed top-60 right-48 w-14 h-14 bg-[#4dd6d0] opacity-55 -rotate-[25deg] z-0"></div>
        <!-- Triangle bottom-left -->
        <div class="fixed bottom-36 left-16 z-0"
            style="width:0;height:0;border-left:65px solid transparent;border-right:65px solid transparent;border-bottom:110px solid rgba(77,214,208,0.55);transform:rotate(10deg);">
        </div>
        <!-- Arrow bottom-right -->
        <div class="fixed bottom-48 right-16 z-0"
            style="width:0;height:0;border-top:55px solid transparent;border-bottom:55px solid transparent;border-right:95px solid rgba(77,214,208,0.55);transform:rotate(-5deg);">
        </div>

        <!-- Card -->
        <div class="relative z-10 w-full max-w-md mx-auto bg-white rounded-xl shadow-lg px-12 py-10">

            <!-- Brand -->
            <div class="flex items-center justify-center gap-3 mb-1">
                <div
                    class="w-11 h-11 border-2 border-gray-300 rounded-lg flex items-center justify-center text-gray-500 font-bold text-lg">
                    α
                </div>
                <span class="text-2xl font-bold tracking-[4px] text-[#17b8b2]">ARSA</span>
            </div>

            <!-- Page title -->
            <p class="text-center text-sm font-semibold tracking-[3px] text-[#17b8b2] mb-7">REGISTER</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-600 mb-1">
                        {{ __('Name') }}
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        autocomplete="name" placeholder="Full name"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-[#f7fbfb] text-sm text-gray-700 focus:outline-none focus:border-[#17b8b2] focus:ring-2 focus:ring-[#17b8b2]/20 transition" />
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-600 mb-1">
                        {{ __('Username') }}
                    </label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required
                        autocomplete="username" placeholder="Username"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-[#f7fbfb] text-sm text-gray-700 focus:outline-none focus:border-[#17b8b2] focus:ring-2 focus:ring-[#17b8b2]/20 transition" />
                    @error('username')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600 mb-1">
                        {{ __('Email') }}
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="email" placeholder="email@example.com"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-[#f7fbfb] text-sm text-gray-700 focus:outline-none focus:border-[#17b8b2] focus:ring-2 focus:ring-[#17b8b2]/20 transition" />
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600 mb-1">
                        {{ __('Password') }}
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-[#f7fbfb] text-sm text-gray-700 focus:outline-none focus:border-[#17b8b2] focus:ring-2 focus:ring-[#17b8b2]/20 transition" />
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-1">
                        {{ __('Confirm Password') }}
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password" placeholder="••••••••"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-[#f7fbfb] text-sm text-gray-700 focus:outline-none focus:border-[#17b8b2] focus:ring-2 focus:ring-[#17b8b2]/20 transition" />
                    @error('password_confirmation')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit button -->
                <button type="submit"
                    class="w-full mt-2 py-3 bg-[#17b8b2] hover:bg-[#13a09b] active:scale-[0.98] text-white font-semibold tracking-wide rounded-lg transition text-sm">
                    Register
                </button>

                <!-- Already registered -->
                <p class="text-center mt-4 text-sm text-gray-500">
                    <a href="{{ route('login') }}" class="underline hover:text-[#17b8b2] transition">
                        {{ __('Already registered?') }}
                    </a>
                </p>

            </form>
        </div>
    </div>
</x-guest-layout>
