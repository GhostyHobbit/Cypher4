<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mb-5">
            <!-- Remember Me -->
            <div class="block my-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded bg-background-light  border-gray-700 text-accent_purple shadow-sm focus:ring-accent_purple focus:ring-offset-accent" name="remember">
                    <span class="ms-2 text-sm text-text-default">{{ __('Remember me') }}</span>
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-400 hover:text-text-default rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent_purple" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <x-primary-button class="w-full">
            {{ __('Log in') }}
        </x-primary-button>
        <div class="w-full text-center mt-4">
            <a class="underline text-sm text-text-default hover:text-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent_purple dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                {{ __('Don\'t have an account? Click here to register') }}
            </a>
        </div>
    </form>
</x-guest-layout>
