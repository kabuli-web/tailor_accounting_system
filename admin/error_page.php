<?php
include 'includes/session.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oops! An Error Occurred</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 36px;
            color: #e74c3c;
        }
        p {
            font-size: 18px;
        }
        img {
            width: 500px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Oops! An Error Occurred</h1>
        <img src="./images/monkeys.png" alt="Funny Error Illustration">
        <p><?php echo $_SESSION['error']; ?></p>
        <p>Don't worry, our team of highly trained monkeys is working to fix this!</p>
        <p><a href="index.php">Go back to the homepage</a></p>
    </div>
</body>
</html>