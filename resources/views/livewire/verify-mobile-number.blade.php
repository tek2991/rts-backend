<div>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Before continuing, could you verify your mobile number by entering the OTP we just sent to you? If you didn\'t receive the SMS, we will gladly send you another.') }}
    </div>

    @if ($otpSent == true)
        @php
            $mobile_number = Auth::user()->mobile_number;
            $mobile_number = substr($mobile_number, 0, 2) . '*****' . substr($mobile_number, 7);
        @endphp
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification OTP has been sent to ' . $mobile_number) }}
        </div>
    @endif

    @if (Auth::user()->otp)
        <form wire:submit.prevent="submit">
            <div>
                <x-label for="otp" value="{{ __('OTP') }}" />
                @error('otp')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
                <x-input id="otp" class="block mt-1 w-full" type="text" name="otp" wire:model="otp" required
                    maxlength="6" autofocus autocomplete="" autofocus autocomplete="" />
            </div>

            <x-button class="mt-4" wire:click="submit">
                {{ __('Submit') }}
            </x-button>
        </form>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <div>
            <button wire:click="sendOTP"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Resend Verification OTP') }}
            </button>
        </div>

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
