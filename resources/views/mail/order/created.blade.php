@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
