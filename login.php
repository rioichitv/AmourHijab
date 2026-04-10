<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Masuk - Amour Hijab</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: #e9c7c7;
            margin: 0;
            padding: 0;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            background: #dca7a7;
            padding: 30px 40px 40px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            color: white;
            position: relative;
        }
        h2 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 4px;
            font-size: 28px;
        }
        p.description {
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }
        label {
            display: inline-block;
            width: 100px;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.5px;
            margin-top: 15px;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 110px);
            padding: 12px 20px;
            margin-top: 5px;
            border-radius: 25px;
            border: none;
            font-size: 15px;
            outline: none;
            box-sizing: border-box;
            color: #333;
            display: inline-block;
        }
        input::placeholder {
            color: #999;
            opacity: 1;
            padding-left: 15px;
        }
        .btn-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-top: 30px;
        }
        button {
            width: 100%;
            background: #b86b6b;
            color: white;
            border: none;
            padding: 12px 0;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 10px rgba(0,0,0,0.2);
            transition: background-color 0.3s ease;
        }
        button:hover {
            background: #a05a5a;
        }
        .forgot-password {
            font-size: 12px;
            color: white;
            text-align: right;
            width: calc(100% - 110px);
            margin-top: 5px;
            cursor: pointer;
            text-decoration: underline;
        }
        .register-link {
            font-size: 14px;
            text-align: center;
            margin-top: 15px;
            color: white;
        }
        .register-link a {
            color: white;
            font-weight: 700;
            text-decoration: none;
        }
        .error-messages {
            background: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>MASUK</h2>
        <p class="description">Silahkan lengkapi informasi di kolom yang tersedia:</p>

        <form method="POST" action="otentikasi.php">
            <label for="username">Username :</label>
            <input type="text" id="username" name="username" placeholder="Username" required>

            <label for="password">Kata Sandi :</label>
            <input type="password" id="password" name="password" placeholder="Kata Sandi" required>

            <div class="btn-container">
                <button type="submit">Masuk</button>
                <div class="register-link">Belum punya akun? <a href="register.php">Buat akun</a></div>
            </div>
        </form>
    </div>
</body>
</html>
