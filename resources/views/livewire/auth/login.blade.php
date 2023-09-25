<div>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <div>
            <label class="relative inline-flex items-center cursor-pointer mb-6">
                <input type="checkbox" wire:model="useEmail" class="sr-only peer">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                </div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Use Email</span>
            </label>

            @if ($useEmail)
                <form method="POST" wire:submit.prevent="emailLogin">
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" wire:model="email" required
                            autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" wire:model="password" required
                            autocomplete="current-password" />
                    </div>
                </form>
            @else
                {{-- Phone --}}
                @if ($otpSent === false)
                    <div>
                        <x-label for="phone" value="{{ __('Phone Number (+91)') }}" />
                        <x-input id="phone" class="block mt-1 w-full" type="number" name="phone"
                            wire:model="phone" required autofocus autocomplete="username" />
                    </div>
                @else
                    {{-- Phone readonly --}}
                    <div>
                        <x-label for="phone" value="{{ __('Phone Number (+91)') }}" />
                        <x-input id="phone" class="block mt-1 w-full" type="number" name="phone"
                            wire:model="phone" required autofocus autocomplete="username" readonly />
                    </div>
                    {{-- OTP --}}
                    <div class="mt-4">
                        <x-label for="otp" value="{{ __('OTP') }}" />
                        @if ($otpResent === true)
                            <p class="text-green-500">OTP resent successfully</p>
                        @endif
                        <x-input id="otp" class="block mt-1 w-full" type="number" name="otp" wire:model="otp"
                            required autofocus autocomplete="username" />
                    </div>

                    <div class="py-2 flex">
                        <button class="text-blue-500 hover:text-blue-600 hover:underline disabled:text-gray-500"
                            id="resendOTP" disabled>Resend OTP</button>
                        <button clas="hidden" wire:click="resendOTP" id="resendOTPHIdden"></button>
                        <span>
                            <p id="timer" class="ml-2">20s</p>
                        </span>
                    </div>

                    <script>
                        var timer = 20;
                        var interval = setInterval(function() {
                            timer--;
                            document.getElementById('timer').innerHTML = timer + 's';
                            if (timer === 0) {
                                clearInterval(interval);
                                document.getElementById('resendOTP').removeAttribute('disabled');
                                document.getElementById('timer').innerHTML = '';
                            }
                        }, 1000);

                        // Resend OTP
                        document.getElementById('resendOTP').addEventListener('click', function() {
                            document.getElementById('resendOTPHIdden').click();
                            document.getElementById('resendOTP').setAttribute('disabled', true);
                            timer = 20;
                            var interval = setInterval(function() {
                                timer--;
                                document.getElementById('timer').innerHTML = timer + 's';
                                if (timer === 0) {
                                    clearInterval(interval);
                                    document.getElementById('resendOTP').removeAttribute('disabled');
                                    document.getElementById('timer').innerHTML = '';
                                }
                            }, 1000);
                        });
                    </script>
                @endif
            @endif


            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" wire:model="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            @if ($useEmail)
                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="hover:underline transition text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-button class="ml-4" type="button" wire:click="emailLogin">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            @else
                <div class="flex items-center justify-end mt-4">

                    @if ($otpSent === false)
                        <x-button class="ml-4" wire:click="sendOTP">
                            {{ __('Send OTP') }}
                        </x-button>
                    @else
                        <x-button class="ml-4" wire:click="verifyOTP">
                            {{ __('Verify OTP') }}
                        </x-button>
                    @endif
                </div>

            @endif

            <div class="">
                <a class="hover:underline transition text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            </div>
        </div>
    </x-authentication-card>
</div>
