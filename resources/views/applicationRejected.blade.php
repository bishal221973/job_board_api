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
    I wanted to personally reach out to you regarding the status of your application for the {{$application->vacancy->job_title}} position at {{$application->vacancy->company->company_name}}. We appreciate the time and effort you took to apply for this role and to share your qualifications with us.

After careful consideration, I regret to inform you that we will not be moving forward with your application at this time. While your skills and experience are impressive, we have decided to pursue other candidates whose qualifications better fit the needs of our team at this time.
    <p>Best regards,</p>
    <p>{{ $application->vacancy->company->company_name }}</p>
</body>

</html>
