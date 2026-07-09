<!DOCTYPE html>
<html>
<head>
    <title>Registration Successful</title>
    <style>
        .success-container {
            max-width: 500px;
            margin: 100px auto;
            text-align: center;
            padding: 40px;
            background: #f9f9f9;
            border-radius: 10px;
        }
        .success-icon {
            font-size: 80px;
            color: #4CAF50;
        }
        .btn-home {
            display: inline-block;
            padding: 10px 30px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✓</div>
        <h1>Registration Successful!</h1>
        <p>Your registration has been completed successfully.</p>
        <p>We have sent a confirmation email to your registered email address.</p>
        <a href="<?= base_url() ?>" class="btn-home">Go to Home</a>
    </div>
</body>
</html>