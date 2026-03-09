<x-mail::message>
# Verify your email

Hi {{ $user->name }},

Your Tagydes verification code is:

<x-mail::panel>
# {{ $code }}
</x-mail::panel>

This code expires in **5 minutes**. Do not share it with anyone.

If you did not create a Tagydes account, you can safely ignore this email.

Thanks,
The Tagydes Team
</x-mail::message>
