<x-mail::message>
# Forget Password Request

Hello {{ $data['name'] }},

We received a request to reset the password for the Stripe account associated with {{ $data['email'] }}.

# OTP : {{ $data['otp'] }}



Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
