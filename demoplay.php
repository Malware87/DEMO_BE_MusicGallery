<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trình phát nhạc đơn giản</title>
    <style>
        /* CSS styling here */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Danh sách bài hát</h1>
    <table>
        <tr>
            <th>Tên bài hát</th>
            <th>Tên tác giả</th>
        </tr>
        <?php
        // Kết nối CSDL ở đây (sử dụng $mysqli)
        require 'connect.php'; // Sử dụng require nếu kết nối CSDL là bắt buộc
        ?>
        <?php
        // Truy vấn danh sách bài hát
        $query = "SELECT * FROM songs";
        $result = $mysqli->query($query);

        while ($row = $result->fetch_assoc()) {
            echo "<tr class='song-row' data-src=\"{$row['file_path']}\">";
            echo "<td>{$row['title']}</td>";
            echo "<td>{$row['artist']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <audio id="music-player" controls>
        <source src="" type="audio/mpeg">
    </audio>

    <script>
        const songRows = document.querySelectorAll(".song-row");
        const musicPlayer = document.getElementById("music-player");

        songRows.forEach(row => {
            row.addEventListener("click", function() {
                const songSrc = this.getAttribute("data-src");
                musicPlayer.src = songSrc;
                musicPlayer.load();
                musicPlayer.play();
            });
        });
    </script>
</body>

</html>