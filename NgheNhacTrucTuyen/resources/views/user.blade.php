<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
Your name is : <p id="name"></p>
Your email is : <p id="email"></p>
<button id="logout">Đăng Xuất</button>

<script>
    // Lấy thông tin người dùng từ session
    const userId = {{ session('userId') }};
    if (!userId) {
        // Nếu userId không tồn tại, có thể chuyển hướng người dùng đến trang đăng nhập hoặc xử lý khác.
        window.location.href = 'login.blade.php';
    }
</script>

<script>
    // Lấy tham số 'id' từ URL
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    // Gọi API để lấy thông tin người dùng dựa trên userId
    fetch(`http://127.0.0.1:8000/api/user/${userId}`)
        .then(response => response.json())
        .then(data => {
            // Hiển thị thông tin người dùng lên trang
            document.getElementById('name').textContent = `${data.user.username}`;
            document.getElementById('email').textContent = `${data.user.email}`;
        })
        .catch(error => {
            console.error('Lỗi khi lấy thông tin người dùng:', error);
        });

    // Bắt sự kiện click cho nút Đăng Xuất
    const logoutButton = document.getElementById('logout');
    logoutButton.addEventListener('click', () => {
        // Xóa session và chuyển hướng người dùng về trang đăng nhập hoặc trang khác
        window.location.href = 'login.blade.php';
    });
</script>
</body>
</html>
