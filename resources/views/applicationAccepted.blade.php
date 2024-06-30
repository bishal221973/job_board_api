<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <p>Dear {{ $application->user->name }},</p>
    <p>
        We are happy to inform you that after careful consideration, we are pleased to offer you the position of {{$application->vacancy->job_title}} at {{$application->vacancy->company->company_name}}! We were impressed by your skills, experience, and passion for {{$application->vacancy->job_title}}, and we
        believe you would be a fantastic fit for our team.
    </p>
    <p>Best regards,</p>
    <p>{{ $application->vacancy->company->company_name }}</p>
</body>

</html>
