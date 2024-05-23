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
                body:formData
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(data => {
                data.body?.token&&setCookie('token',data.body.token,0.24);
                alert(`data.message - success`); // Hiển thị thông báo thành công hoặc lỗi
                if(data.status==201){window.location.href = "/manager/";}
            })
            .catch(error => {
                console.error("Lỗi:", error);
                alert("Đã có lỗi xảy ra khi gửi yêu cầu đăng nhập.");
            });
        };

        function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }