@component('mail::message')
# Introduction

The body of your message. <br>
From: {{$name}} <br>
Email: {{$email}} <br>

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent