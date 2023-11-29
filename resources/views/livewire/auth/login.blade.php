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
                        <div class="relative">
                            <input type="text" id="input-group-pwd" wire:model="password" required
                                autocomplete="current-password"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full pr-10 p-2.5">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    id="password-close" class="w-5 h-5 hidden cursor-pointer">
                                    <path
                                        d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z" />
                                    <path
                                        d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0115.75 12zM12.53 15.713l-4.243-4.244a3.75 3.75 0 004.243 4.243z" />
                                    <path
                                        d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 00-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 016.75 12z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    id="password-open" class="w-5 h-5 cursor-pointer">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd"
                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <script>
                                var passwordClose = document.getElementById('password-close');
                                var passwordOpen = document.getElementById('password-open');
                                var inputGroupPwd = document.getElementById('input-group-pwd');
                                passwordClose.addEventListener('click', function() {
                                    passwordClose.classList.add('hidden');
                                    passwordOpen.classList.remove('hidden');
                                    inputGroupPwd.setAttribute('type', 'text');
                                });
                                passwordOpen.addEventListener('click', function() {
                                    passwordOpen.classList.add('hidden');
                                    passwordClose.classList.remove('hidden');
                                    inputGroupPwd.setAttribute('type', 'password');
                                });
                            </script>
                        </div>
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
                    {{ __('Need an account?') }}
                </a>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <div class="">
                                {!! __('Read the :terms_of_service, :privacy_policy, and :refund_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                    'refund_policy' =>
                                        '<a target="_blank" href="' .
                                        route('refund.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Return & Refund Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif
        </div>
    </x-authentication-card>
</div>
