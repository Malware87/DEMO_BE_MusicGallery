<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>Music</title>
    <script>
        const session_id = @json(session('SESSION'));
        if(session_id != null && session_id != undefined ){
            window.location.href = `user?id=${session_id}`;
        }
    </script>
</head>

<body>

<div class="container" id="container">
    <div class="form-container sign-up">
        <form>
            <h1>Create Account</h1>
            <div class="social-icons">
                <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
            <span>or use your email for registeration</span>
            <input type="text" placeholder="Name">
            <input type="email" placeholder="Email">
            <input type="password" placeholder="Password">
            <button>Sign Up</button>
        </form>
    </div>
    <div class="form-container sign-in">
        <form>
            <h1>Sign In</h1>
            <div class="social-icons">
                <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                <a href="#" class an="icon"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
            <span>or use your email password</span>
            <input type="email" placeholder="Email">
            <input type="password" placeholder="Password">
            <a href="#">Forget Your Password?</a>
            <button>Sign In</button>
        </form>
    </div>
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h1>Welcome Back!</h1>
                <p>Enter your personal details to use all site features</p>
                <button class="hidden" id="login">Sign In</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Hello, Friend!</h1>
                <p>Register with your personal details to use all site features</p>
                <button class="hidden" id="register">Sign Up</button>
            </div>
        </div>
    </div>
</div>

<script>
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');

    registerBtn.addEventListener('click', () => {
        container.classList.add("active");
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove("active");
    });

    // Đăng nhập
    const loginForm = document.querySelector('.form-container.sign-in form');
    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = loginForm.querySelector('input[type="email"]').value;
        const password = loginForm.querySelector('input[type="password"]').value;

        // Gửi yêu cầu POST đến API đăng nhập
        fetch('{{ route('login') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                    // Đăng nhập thành công, chuyển hướng đến trang user và gán SESSION
                    const userId = data.id;
                    window.location.href = `user?id=${userId}`;
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
        fetch('{{ route('register') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
        fetch('{{ route('forgot') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
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

</script>
</body>

</html>