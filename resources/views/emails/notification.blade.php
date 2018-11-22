@component('mail::message')

<h2>This user: {{$full_name}}, {{$message}} this file: {{$mail_prop}} in this project: {{$project_name}}</h2>

<h2>Thanks,</h2><br>
<h2>{{config('app.name')}}</h2>
@endcomponent
