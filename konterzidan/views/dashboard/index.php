
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['user'])) {
    return header('Location: http://localhost:8080/konterzidan/views/login/login.php' );
}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="index.css">
    <title>Konter Zidan</title>
</head>

<body>
    <section>
        <header class="container">
            <div class="page-header">
                <div class="logo">
                    <a href="">Konter Zidan</a>
                </div>
                <input type="checkbox" id="click">
    
                <label for="click" class="mainicon">
                    <div class="menu">
                        <i class='bx bx-menu'></i>
                    </div>
                </label>
                <ul>
                    <li><a href="#" style="--navAni:1"></a></li>
                    <li><a href="#"  class="active" style="--navAni:2">Home</a></li>
                    <?php if ($_SESSION['user']['rolee'] == 'admin' || $_SESSION['user']['rolee'] == 'owner') {?>
                    <li><a href="../user/index.php" style="--navAni:4">User</a></li>
                    <?php } ?>
                    <li><a href="#" style="--navAni:5"></a></li>
                    <?php if ($_SESSION['user']['rolee'] == 'admin' || $_SESSION['user']['rolee'] == 'owner') {?>
                    <li><a href="../barang/index.php" style="--navAni:6">Barang</a></li>
                    <?php } ?>
                    <li><a href="#" style="--navAni:7"></a></li>
                    <?php if ($_SESSION['user']['rolee'] == 'cashier' || $_SESSION['user']['rolee'] == 'owner') { ?>
                    <li><a href="../penjualan/index.php" style="--navAni:8">Transaksi</a></li>
                    <?php } ?>
                    <li><a href="#" style="--navAni:9"></a></li>
                    <li><a href="#" style="--navAni:10">Contact</a></li>
                    <li><a href="#" style="--navAni:11"></a></li>
                    <li><a href="../login/login.php" style="--navAni:12">Log Out</a></li>   

                </ul>
                <label class="mode">
                    <input type="checkbox" id="darkModeToggle">
                    <i class='bx bxs-moon'></i>
                </label>
            </div>
        </header>
    
        <div class="container">
            <div class="main">
                <div class="detail">
                    <h3>Hi, Welcome to</h3>
                    <h1><span style="color:#52489C;">Konter</span> Zidan</h1> 
                    <p> We're here provide various high quality electronic goods.
                    </p>  
                    <div class="social">
                        <a href="https://www.linkedin.com/in/vikash-web-dev/" style="--socialAni:1"><i class='bx bxl-linkedin'></i></a>
                        <a href="https://www.instagram.com/begezidann/" style="--socialAni:2"><i class='bx bxl-instagram'></i></a>
                        <a href="https://github.com/begezidaann" style="--socialAni:3"><i class='bx bxl-github'></i></a>
                        <a href="https://www.youtube.com/@bangzy389" style="--socialAni:4"><i class='bx bxl-youtube'></i></a>
                    </div>
                </div>
                <div class="images">
                    <img src="imglogo.jpg" alt="" class="img-w">
                </div>
            </div>
        </div>
    </section>

    <script>
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;
        const isDarkMode = localStorage.getItem('darkMode') === 'enabled';
        if (isDarkMode) {
            body.classList.add('dark-mode');
            darkModeToggle.checked = true;
        }
        darkModeToggle.addEventListener('change', () => {
            if (darkModeToggle.checked) {
                body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', 'disabled');
            }
        });
    </script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>