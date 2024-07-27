<!DOCTYPE html>
<html>
<head>
    <title>Loan Notification</title>
</head>
<body>
    <h1>Loan Notification</h1>
    <p>Dear {{ $loan->user->name }},</p>
    <p>You have successfully borrowed the book "{{ $loan->book->title }}" on {{ $loan->loan_date }}.</p>
    <p>Thank you for using our library services!</p>
</body>
</html>
