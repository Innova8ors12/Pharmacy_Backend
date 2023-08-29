<x-mail::message>
# Your Account Has Been Created Successfully!

Hello dear {{ $data['name'] }}! Your account has been created successfully, otp for your account
is:

<x-mail::button :url="''">
{{ $data['otp'] }}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
