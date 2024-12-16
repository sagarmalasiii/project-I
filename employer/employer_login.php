<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('../img/download.jpg');
            background-size: cover;
            background-position: center;
        }

        .wrapper {
            width: 420px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgb(0, 0, 0, .2);
            color: #fff;
            border-radius: 10px;
            padding: 30px 40px;
        }

        .wrapper h1 {
            font-size: 36px;
            text-align: center;
        }

        .wrapper .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            margin: 30px 0;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            border: 2px solid rgb(255, 255, 255, .2);
            border-radius: 40px;
            font-size: 16px;
            color: #fff;
            padding: 20px 45px 20px 20px;
        }

        .input-box input::placeholder {
            color: #fff;
        }

        .input-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
        }

        .wrapper.remember {
            display: flex;
            font-size: 14.5px;
            margin: -15px 0 15px;
        }

        .remember label input {
            accent-color: #fff;
            margin-right: 3px;
        }

        .wrapper .btn {
            width: 100%;
            height: 45px;
            background-color: #fff;
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgb(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        .wrapper .link {
            font-size: 14.5px;
            text-align: center;
            margin: 20px 0 15px;
        }

        .link a {
            color: #fff;
            text-decoration: none;
            font-weight: 400;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="form">
            <h1>Employer Login</h1>
            <form id="loginForm">
                <div class="input-box">
                    <input type="text" id="username" placeholder="Username" required>
                    <i class='bx bxs-user'></i>
                </div>

                <div class="input-box">
                    <input type="password" id="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>



                <div class="remember">
                    <label><input type="checkbox">Remember me</label>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>
            <div class="link">
                <a href="#" class="text-decoration-none">Forgot Password?</a> |
                <a href="./employer_registration.php" class="text-decoration-none">Not Registered Yet?</a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;


            if (username === '') {
                alert('Username is required.');
                return;
            }

            if (password === '') {
                alert('Password is required.');
                return;
            }



            alert('Form submitted successfully!');
            // Optionally, you can submit the form or send data to a server here
        });
    </script>
</body>

</html>