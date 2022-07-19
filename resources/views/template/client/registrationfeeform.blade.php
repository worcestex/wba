@component('mail::message')
# Introduction

Thnaks for registering to bid. <br>
From: {{$name}} <br>
Email: {{$email}} <br>

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent