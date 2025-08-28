<x-mail::message>
# {{ $inviterName }} has invited you to collaborate on "{{ $projectName }}"

You can click the button below to accept the invitation and start collaborating.

<x-mail::button :url="$url">
    Accept invite
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
