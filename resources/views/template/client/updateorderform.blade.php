@component('mail::message')
# Introduction

The body of your message. <br>
Status: {{$status}} <br>
Email: {{$email_text}} <br>


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent