<x-guest-layout>
    <div class="loginMain">
        <div class="form-Imgsection">
            <img class="signupImg" src="{{asset ('images/signupImg.svg')}}" />
        </div>
        <div class="form-section">
            <x-jet-authentication-card>
                <x-slot name="logo">
                    <!-- <x-jet-authentication-card-logo /> -->
                    <img src="{{asset ('images/logo.svg')}}" />
                </x-slot>

                <x-jet-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('password.update') }}" class="loginForm">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="block">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-jet-button class="btn-login">
                            {{ __('Reset Password') }}
                        </x-jet-button>
                    </div>
                </form>
            </x-jet-authentication-card>
        </div>
    </div>
    
</x-guest-layout>
