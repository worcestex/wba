@component('mail::message')
# Introduction

An auction for your lot has ended.
@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent