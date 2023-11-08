// Đăng nhập
const loginForm = document.querySelector('.form-container.sign-in form');
loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const email = loginForm.querySelector('input[type="email"]').value;
    const password = loginForm.querySelector('input[type="password"]').value;

    // Gửi yêu cầu POST đến API đăng nhập
    fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email: email,
            password: password,
        }),
    })
        .then(response => response.json())
        .then(data => {
            // Xử lý kết quả từ API đăng nhập ở đây
            if (data.message === 'Login Success') {
                // Đăng nhập thành công, chuyển hướng đến trang user.blade.php với tham số id
                const userId = data.id;
                window.location.href = `../views/user.blade.php`;
            } else {
                // Xử lý lỗi đăng nhập
                console.error('Đăng nhập không thành công:', data.message);
            }
        })
        .catch(error => {
            console.error('Đăng nhập không thành công:', error);
        });
});
    // Đăng ký
    const registerForm = document.querySelector('.form-container.sign-up form');
    registerForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const name = registerForm.querySelector('input[placeholder="Name"]').value;
    const email = registerForm.querySelector('input[type="email"]').value;
    const password = registerForm.querySelector('input[type="password"]').value;

    // Gửi yêu cầu POST đến API đăng ký
    fetch('http://127.0.0.1:8000/api/register', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
},
    body: JSON.stringify({
    username: name,
    email: email,
    password: password
}),
})
    .then(response => response.json())
    .then(data => {
    // Xử lý kết quả từ API đăng ký ở đây
})
    .catch(error => {
    console.error('Đăng ký không thành công:', error);
});
});

    // Quên mật khẩu
    const forgotForm = document.querySelector('.form-container.forgot form');
    forgotForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const email = forgotForm.querySelector('input[type="email"]').value;

    // Gửi yêu cầu POST đến API quên mật khẩu
    fetch('/api/forgot', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
},
    body: JSON.stringify({
    email: email
}),
})
    .then(response => response.json())
    .then(data => {
    // Xử lý kết quả từ API quên mật khẩu ở đây
})
    .catch(error => {
    console.error('Quên mật khẩu không thành công:', error);
});
});
