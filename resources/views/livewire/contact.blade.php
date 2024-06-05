<div>
	<form wire:submit.prevent="store">
		<div class=" mt-5">
			<label
				class="block uppercase tracking-wide text-grey-darker text-gray-600 text-lg font-bold mb-2"
				for="email"> {{__('Email Address')}} </label> <input type="text"
				name="email" wire:model.debounce.365ms="email"
				placeholder="{{__('Enter Your Email address')}}"
				class="border p-3 rounded form-input focus:outline-none w-full shadow-md focus:shadow-lg transition duration-150 ease-in-out"
				value="{{old('email')}}"> @error('email')
			<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
			@enderror
		</div>

		<div class=" mt-5">
			<label
				class="block uppercase tracking-wide text-grey-darker text-gray-600 text-lg font-bold mb-2">
				{{__('Your message')}} </label>
			<textarea name="body" id="" cols="10" rows="6"
				wire:model.debounce.365ms="body"
				placeholder="{{__('Enter Your Message')}}"
				class="border p-2 mt-3 w-full form-textarea shadow-md focus:outline-none focus:shadown-lg transition duration-150 ease-in-out rounded-sm">{{old('body')}}</textarea>
			@error('body')
			<p class="text-red-700 font-semibold mt-2">{{$message}}</p>
			@enderror
		</div>

		<button type="submit" data-sitekey="{{env('CAPTCHA_SITE_KEY')}}"
			data-callback='handle' data-action='submit'
			class="g-recaptcha some-button-style">Submit</button>
	</form>
</div>
<script src="https://www.google.com/recaptcha/api.js?render={{env('CAPTCHA_SITE_KEY')}}"></script>
<script>
    function handle(e) {
        grecaptcha.ready(function () {
            grecaptcha.execute('{{env('CAPTCHA_SITE_KEY')}}', {action: 'submit'})
                .then(function (token) {
                    @this.set('captcha', token);
                });
        })
    }
</script>
