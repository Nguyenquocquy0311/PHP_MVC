<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/public/css/styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #ccc;
        }

        .form {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        .form h2 {
            margin-bottom: 50px;
        }

        .form input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            background-color: #ccc;
        }

        .form button {
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
            margin-right: 20px;
        }

        .form button:hover {
            background-color: #ff8c1a;
        }

        .footer {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="form">
        <h2>SOIOT SYSTEM</h2>
        <form method="POST" action="../controllers/LoginController.php">
            <input type="text" id="username" name="username" required placeholder="Username">
            <br>
            <input type="password" id="password" name="password" required placeholder="Password">
            <br>
            <div class="footer">
                <button type="submit">Login</button>
                <a href="#" style="padding-top: 25px;">or create new account</a>
            </div>
        </form>
        <?php if (isset($_GET['error'])) : ?>
            <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
    </div>
</body>

</html>