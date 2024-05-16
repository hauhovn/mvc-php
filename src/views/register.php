<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
    #register-form {
        padding: 16px;
        display: flex;
        flex-direction: column;
        background-color: antiquewhite;
    }
    #register-form input {
        margin-bottom: 16px;
    }
    </style>
</head>
<body>
    <form id="register-form">
        <label for="phone">Phone:</label>
        <input type="phone" name="phone" value="0909009009">
        <label for="frist-name">First name:</label>
        <input type="text" name="first_name" value="Tony">
        <label for="last-name">Last name:</label>
        <input type="text" name="last_name" value="Chopper">
        <label for="password">Password:</label>
        <input type="password" name="password" value="0909009009">
        <button type="submit" id="register-btn">Register</button>
    </form>
</body>
    <script>
        const registerForm =document.getElementById("register-form");
        const registerBtn =document.getElementById("register-btn");
        registerBtn.onclick = (event) => {
            // Ngăn chặn gửi yêu cầu mặc định
            event.preventDefault(); 

            // Lấy dữ liệu từ form
            var formData = new FormData(registerForm);
            // Add action
            formData.append('action','register');

            // Gửi yêu cầu POST đến endpoint đăng nhập
            fetch("/api/user", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Xử lý phản hồi từ máy chủ
                alert(data.message); // Hiển thị thông báo thành công hoặc lỗi
            })
            .catch(error => {
                console.error("Lỗi:", error);
                alert("Đã có lỗi xảy ra khi gửi yêu cầu đăng ký.");
            });
        };
    </script>
</html>