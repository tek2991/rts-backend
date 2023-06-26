<div>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Before continuing, could you verify your mobile number by entering the OTP we just sent to you? If you didn\'t receive the SMS, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'otp-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification OTP has been sent to the mobile number you provided in your profile settings.') }}
            <br>
            {{ Auth::user()->otp }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="">
            @csrf

            <div>
                <x-button type="submit">
                    {{ __('Resend Verification OTP') }}
                </x-button>
            </div>
        </form>

        <div>
            <a href="{{ route('profile.show') }}"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Edit Profile') }}</a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf

                <button type="submit"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-2">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</div>
