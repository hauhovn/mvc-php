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
    .then(response => response.json().then(data => ({ status: response.status, body: data })))
    .then(data => {
        console.log(data); // Xử lý phản hồi từ máy chủ
        alert(data.body.message); // Hiển thị thông báo thành công hoặc lỗi
        // if(data.status==201){window.location.href = "/manager/login";}
    })
    .catch(error => {
        console.error("Lỗi:", error);
        alert("Đã có lỗi xảy ra khi gửi yêu cầu đăng ký.");
    });
};