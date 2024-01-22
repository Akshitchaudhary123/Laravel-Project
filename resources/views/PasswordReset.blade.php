<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Reset</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 20px auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      color: #333333;
    }

    p {
      color: #555555;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #3498db;
      color: #ffffff;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Password Reset</h1>
    <p>Hello {{$username}},</p>
    <p>We received a request to reset your password. Click the button below to reset it:</p>

    <a href="{{$token}}" class="btn">Reset Password</a>

    <p>If you didn't request a password reset, you can ignore this email.</p>
    <p>Thanks,<br>Your App Team</p>
  </div>

</body>
</html>
