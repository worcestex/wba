@component('mail::message')
# Introduction

Congratulations! You've Won!

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent