<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Dear {{$application->user->name}},</p>
    <p>Thank you for applying for the {{$application->vacancy->job_title}} position at {{$application->vacancy->company->company_name}}. We appreciate the interest you have shown in joining our team and are thrilled to have received your application.</p>
    <p>We are currently reviewing all applications and will be in touch soon to let you know the next steps in our process. Please know that we value the time and effort you took to submit your application and we are excited to learn more about your qualifications.</p>
    <p>Best regards,</p>
    <p>{{$application->vacancy->company->company_name}}</p>
</body>
</html>
