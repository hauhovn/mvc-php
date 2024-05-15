<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
       body {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
     }   
    #login-form {
        padding: 16px;
        display: flex;
        flex-direction: column;
        background-color: antiquewhite;
    }
    #login-form input {
        margin-bottom: 16px;
    }
    </style>
</head>
<body>
    <form action="login" method="POST" id="login-form">
        <label for="phone">Phone:</label>
        <input type="phone" name="phone" value="0909009009">
        <label for="password">Password:</label>
        <input type="password" name="password" value="0909009009">
        <button type="submit" id="login-btn">Login</button>
    </form>
</body>
</html>