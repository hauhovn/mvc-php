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
    <form id="login-form">
        <label for="phone">Phone:</label>
        <input type="phone" name="phone" value="0909009008">
        <label for="password">Password: #0909009009</label>
        <input type="password" name="password" value="0909009009">
        <button type="submit" id="login-btn">Login</button>
    </form>

    <script>
        const loginForm = document.getElementById("login-form");
        const loginBtn = document.getElementById("login-btn");
        loginBtn.onclick = (event) => {
            // Ngăn chặn gửi yêu cầu mặc định
            event.preventDefault(); 

            // Lấy dữ liệu từ form
            var formData = new FormData(loginForm);
            // Add action
            formData.append('action','login');
            // Display the key/value pairs
            for(var pair of formData.entries()) {
            console.log(pair[0]+ ', '+ pair[1]); 
            }
            // Gửi yêu cầu POST đến endpoint đăng nhập
            fetch("/api/user", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                data?.token&&localStorage.setItem('token',data.token);
                alert(data.message); // Hiển thị thông báo thành công hoặc lỗi
            })
            .catch(error => {
                console.error("Lỗi:", error);
                alert("Đã có lỗi xảy ra khi gửi yêu cầu đăng nhập.");
            });
        };
    </script>
</body>
</html>