<!--
    ma hoa mat khau
-->

<?php
    session_start();


    require_once ('./database/connect_database.php');


    if(isset($_SESSION['user_id'])) {
        $sql = "select * from user ur join login lg on ur.id = lg.id_user where id = ".$_SESSION['user_id'];
        $user = EXECUTE_RESULT($sql);

        $sql = "SELECT * from NOTIFICATION where status = 'Chưa đọc' and id_user = ".$_SESSION['user_id']." order by created_at desc";
        $notification = EXECUTE_RESULT($sql);

        $now = time();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head itemscope="itemscope" itemtype="http://schema.org/WebSite">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Đọc truyện tranh Manga, Manhua, Manhwa, Comic online hay và cập nhật thường xuyên tại TrongCarrot.com">
        <meta property="og:site_name" content="TrongCarrot.com">
        <meta name="Author" content="TrongCarrot.com">
        <meta name="keyword" content="doc truyen tranh, manga, manhua, manhwa, comic">
        <title>Đọc truyện tranh Manga, Manhua, Manhwa, Comic Online</title>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF"
        crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="./css/topbar.css">
        <link rel="stylesheet" type="text/css" href="./css/sidebar.css">
        <link rel="stylesheet" type="text/css" href="./css/style-QLTTTK.css">
        <link rel="stylesheet" type="text/css" href="./css/breadcrumb.css">
        <link rel="stylesheet" type="text/css" href="./css/footer.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ"
        crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style id="global-styles-inline-css" type="text/css">
    </style>
    <link rel="stylesheet" id="fonts-roboto-css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700"
        type="text/css" media="all">
    <link rel="stylesheet" id="fontsawesome-css" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css"
        type="text/css" media="all">
    <link rel="stylesheet" id="theme-light-css" href="./css/header.css" type="text/css" media="all">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style type="text/css">
    @media only screen and (max-width: 769px) {

        .header-area,
        a#east_logout {
            background: linear-gradient(90deg, rgba(242,242,143,1) 0%, rgba(246,164,121,1) 35%, rgba(252,119,49,1) 100%);
        }
    }

    @media only screen and (max-width: 769px) {}
    </style>
    <style type="text/css" id="wp-custom-css">
    #primary-menu .container .logo img {
        width: 100%;
        height: auto;
    }

    .logo img {
        max-height: 100px;
        margin-top: -20px;
    }
    </style>

    <script language="javascript">
    function danh_dau_da_doc() {
        $data = "danh-dau-da-doc";
        $.ajax({
            url: "notification.php",
            type: "post",
            dataType: "text",
            data: {
                data: $data
            },
            success: function(result) {
                $('#notification-button').html(result);
            }
        });
    }
    </script>
    <script data-cfasync="false" async="" type="text/javascript"></script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalPageSDKES6.js?v=151605" async="">
    </script>
    <link rel="stylesheet" href="https://onesignal.com/sdks/OneSignalSDKStyles.css?v=2">
    </head>
    <body>
        <style>
            .form_search {
                width: 500px;
                height: inherit;
            }
            #luu-anh-dai-dien {
                position: absolute;
                cursor: pointer;
                top: 20px;
                left: 20px;
                width: 300px;
                height: 35px;
                background:#C4C4C4;
                border-radius: 5px;
                font-weight: bold;
            }
        </style>
    <header id="masthead" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
            <?php
                    if (isset($_SESSION['user_id'])) {
                        echo '<style>
                        #chua-dang-nhap {
                            display: none;
                        }
                        </style>';
                    } else {
                        echo '<style>
                        #da-dang-nhap, #da-duoc-dang-nhap {
                            display: none;
                        }
                        </style>';
                    }
            ?>
        <div class="header-area mobile-area">
            <div class="container">
                <div class="btnmenu"><span class="fa fa-bars"></span></div>
                <div class="logo-area">
                    <div itemscope="itemscope" itemtype="http://schema.org/Brand" class="site-branding logox">
                        <h1 class="logo">
                            <a title="Trồng cà rốt" itemprop="url" href="./index.php"><img src="./img/image.png"
                                    alt="Trồng cà rốt" data-src="./img/image.png" decoding="async"
                                    class="lazyload" data-eio-rwidth="3000" data-eio-rheight="757"><noscript><img src='./img/image.png'
                                        alt='Trồng cà rốt' data-eio="l" /></noscript><span
                                    class="hdl">Trồng cà rốt</span></a>
                        </h1>
                        <meta itemprop="name" content="Trồng cà rốt">
                    </div>
                </div>
                <div class="theme switchmode"> <label class="switch"><input type="checkbox"> <span
                            class="slider round"></span></label> <span class="text"><i class="fas fa-sun"></i> / <i
                            class="fas fa-moon"></i></span></div>
                <div class="accont">
                    <a href="./login.php" class="showlogin" id="east_logout"><span class="fa fa-user"></span></a>
                </div>
                <div class="btnsearch"><a class="aresp search-resp"><i class="fa fa-search"></i></a></div>
            </div>
        </div>
        <div id="primary-menu" class="mm">
            <div class="mobileswl">
                <div class="accont">
                    <a href="./login.php" class="showlogin" id="east_logout"><span class="fa fa-user"></span></a>
                </div>
                <div class="switch"> <span class="inner-switch"><i class="fas fa-moon" aria-hidden="true"></i></span>
                </div>
            </div>
            <div class="container">
                <div class="header-area desktop-area">
                    <div class="btnmenu"><span class="fa fa-bars"></span></div>
                    <div class="logo-area">
                        <div itemscope="itemscope" itemtype="http://schema.org/Brand" class="site-branding logox">
                            <h1 class="logo">
                                <a title="Trồng cà rốt" itemprop="url" href="./index.php">
                                    <img src="./img/image.png" alt="Trồng cà rốt" data-src="./img/image.png" decoding="async"
                                        class=" ls-is-cached lazyloaded" data-eio-rwidth="3000" data-eio-rheight="757">
                                    <noscript>
                                        <img src='./img/image.png' alt='Trồng cà rốt' data-eio="l" />
                                    </noscript>
                                    <span class="hdl">Trồng cà rốt</span>
                                </a>
                            </h1>
                            <meta itemprop="name" content="Trồng cà rốt">
                        </div>
                    </div>
                    <div class="theme switchmode"> <label class="switch"><input type="checkbox"> <span
                                class="slider round"></span></label> <span class="text"><i class="fas fa-sun"></i> / <i
                                class="fas fa-moon"></i></span></div>
                    <div class="accont">
                        <a href="./login.php" class="showlogin" id="east_logout"><span class="fa fa-user"></span></a>
                    </div>
                    <div class="search_desktop">
                        <form action="./search.php" id="form" method="get">
                            <input id="s" type="text" placeholder="Search..." name="search" autocomplete="off">
                            <button type="submit" id="submit" class="search-button"><span
                                    class="fa fa-search"></span></button>
                        </form>
                        <div class="live-search ltr" style="display: none;"></div>
                    </div>
                    <div class="btnsearch"><a class="aresp search-resp"><i class="fa fa-search"></i></a></div>
                </div>
                <nav id="site-navigation" role="navigation" itemscope="itemscope"
                    itemtype="http://schema.org/SiteNavigationElement">
                    <ul id="menu-trang-chu" class="menu">
                        <li id="menu-item-65"
                            class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-65">
                            <a href="./index.php" aria-current="page"><span itemprop="name">Trang
                                    chủ</span></a>
                        </li>
                        <li id="menu-item-68"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-68"><a
                                href="https://www.facebook.com/profile.php?id=100094511888265&mibextid=LQQJ4d"><span itemprop="name">Facebook</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="search_responsive">
            <form method="get" id="form-search-resp" class="form-resp-ab" action="./search.php"> <input type="text"
                    placeholder="Search..." name="s" id="ms" value="" autocomplete="off"> <button type="submit"
                    class="search-button"><span class="fa fa-search"></span></button></form>

        </div>
    </header>
    <script type="text/javascript"
        src="./js/header.js"
        id="front-script-js"></script>

        <!-- Thanh công cụ -->  
        <div class="sidebar">
        <div class="logo-detail" style="background-color: #f8edf5;">
            <i class='bx bx-menu' id="btn-menu"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="./">
                    <i class='bx bxs-home'></i>
                    <span class="links_name">Trang chủ</span>
                </a>
                <span class="tooltip">Trang chủ</span>
            </li>
            <li>
                <a href="./typecomic.php">
                    <i class='bx bxs-purchase-tag'></i>
                    <span class="links_name">Thể loại</span>
                </a>
                <span class="tooltip">Thể loại</span>
            </li>
            <li>
                <a href="./updated.php">
                    <i class='bx bxs-hourglass'></i>
                    <span class="links_name">Mới cập nhật</span>
                </a>
                <span class="tooltip">Mới cập nhật</span>
            </li>
            <li>
                <a href="./following.php">
                    <i class='bx bxs-heart'></i>
                    <span class="links_name">Theo dõi</span>
                </a>
                <span class="tooltip">Theo dõi</span>
            </li>
            <li>
                <a href="./history.php">
                    <i class='bx bx-history'></i>
                    <span class="links_name">Lịch sử đọc</span>
                </a>
                <span class="tooltip">Lịch sử đọc</span>
            </li>
            <li id="btn-light-dark">
                <a>
                    <i class='bx bxs-bulb'></i>
                    <span class="links_name">Bật/Tắt đèn</span>
                </a>
                <span class="tooltip">Bật/Tắt đèn</span>
            </li>
            <li id="chua-dang-nhap">
                <a href="./login.php">
                    <i class='bx bx-log-in'></i>
                    <span class="links_name">Đăng Nhập</span>
                </a>
                <span class="tooltip">Đăng nhập</span>
            </li>
            
            <li id="chua-dang-nhap">
                <a href="./register.php">
                    <i class='bx bxs-user-plus'></i>
                    <span class="links_name">Đăng Ký</span>
                </a>
                <span class="tooltip">Đăng ký</span>
            </li>
            
            
            <li id="da-dang-nhap">
                <a href="./account.php">
                    <i class='bx bxs-user-detail'></i>
                    <span class="links_name">Quản lý thông tin tài khoản</span>
                </a>
                <span class="tooltip">Quản lý thông tin tài khoản</span>
            </li>
            
            
            <li id="da-dang-nhap">
                <a href="./mycomic.php">
                    <i class='bx bxs-folder-plus'></i>
                    <span class="links_name">Quản lý truyện đã đăng</span>
                </a>
                <span class="tooltip">Quản lý truyện đã đăng</span>
            </li>
            
            
            <li id="da-dang-nhap">
                <a href="./logout.php">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Đăng xuất</span>
                </a>
                <span class="tooltip">Đăng xuất</span>
            </li>
        </ul>
    </div>
        <!--QLTTTK-->
        <div class="contentQLTK container-xxl" id="content">
            <div class="contain_nav_breadvrumb">
                <nav  class="nav_breadcrumb" aria-label="Page breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><i class='bx bxs-home'></i></li>
                        <li class="breadcrumb-item">Quản lý tài khoản</li>
                    </ol>
                </nav>
            </div>

            <div>
            <h1 class="caption">QUẢN LÝ THÔNG TIN TÀI KHOẢN</h1>
            <!--account-info-->
            <div class="account-info" id="acc-info">

                <div class="input-img" style="display: block; position: relative;">
                    
                    <img id="avatar-profile" src="
                        <?php
                            if ($user[0]['avatar'] != NULL) echo $user[0]['avatar'];
                            else echo './img/logo.png'
                        ?>" alt="avatar" id="acc-avatar">
                    <label for="file-input">
                        <i class="bi bi-camera-fill"></i>
                    </label>
                    <form id="abcnabx-avatar" method="POST" action="./update_photo.php" enctype="multipart/form-data">
                        <input type="file" class="form-select" class="form-control" aria-label="file example" id="file-input" name="file-input" style="display: none;">
                        <input type="submit" value="Cập nhật" id="luu-anh-dai-dien" style="display:none;">
                    </form>
                </div>

                <script>
                    document.getElementById("file-input").onchange = function () {
                        document.getElementById('luu-anh-dai-dien').setAttribute('style', 'display: inline-block');
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            // get loaded data and render thumbnail.
                            document.getElementById("avatar-profile").src = e.target.result;
                        };

                        // read the image file as a data URL.
                        reader.readAsDataURL(this.files[0]);
                    };

                </script>


                <!--account info detail-->
                <form class="account-info-detail" id="acc-info-detail" action="./update_info.php" method="POST">

                    <input type="text" class="form-control" name="accout" aria-label="Disabled input example" readonly value="<?php echo $user[0]['username']?>" id="acc-username">
                    <input type="text" class="form-control" name="username" placeholder="Tên người dùng" id="acc-name" value="<?php echo $user[0]['account_name']?>">
                    <input type="email" class="form-control" name="gmail" placeholder="Email" id="acc-email" value="<?php echo $user[0]['email']?>">
                    <div class="container d-flex flex-row justify-content-between" style="padding: 0;">
                        <input type="date" class="form-control" name="dateofbith" placeholder="Ngày sinh" id="acc-dob" value="<?php echo $user[0]['dateofbirth']?>">
                        <select class="form-select" style="max-width: 400px;" name="sex" id="acc-sex">
                            <option selected disabled value="">Chọn giới tính</option>

                            <?php
                                if($user[0]['sex'] == "Nam") {
                                    echo '<option selected>Nam</option>
                                    <option>Nữ</option>
                                    <option>Khác</option>';
                                }
                                else if($user[0]['sex'] == "Nữ") {
                                    echo '<option>Nam</option>
                                    <option selected>Nữ</option>
                                    <option>Khác</option>';
                                }
                                    else if($user[0]['sex'] == "Khác") {
                                            echo '<option>Nam</option>
                                            <option>Nữ</option>
                                            <option selected>Khác</option>';
                                        }
                                        else {
                                            echo '<option>Nam</option>
                                            <option>Nữ</option>
                                            <option>Khác</option>';
                                        }
                            ?>

                        </select>
                    </div>
                    <input type="text" class="form-control" name="id" placeholder="<?php echo $user[0]['id']?>" readonly id="acc-uid">
                    <input type="url" class="form-control" name="facebook" placeholder="Facebook" id="acc-fb" value="<?php echo $user[0]['facebook']?>">
                    <input type="submit" value="Cập nhật">
                </form>

                <!--change-password-->
                <script type="text/javascript">
                    function validateForm() {
                        $password = $('#inputPassword1').val();
                        $confimpass = $('#inputPassword2').val();
                        if($password != $confimpass) {
                            alert("Mật khẩu không khớp")
                            return false
                        }
                        return true
                    }
                </script>

                <div class="change-password container d-flex flex-column" id="c-password">
                <form method="POST" action="./update_password.php" onsubmit="return validateForm();">
                    <input type="password" class="form-control" required="true" id="inputPassword0" name="current_pass" placeholder="Mật khẩu hiện tại" minlength="6">
                    <input type="password" class="form-control" required="true" id="inputPassword1" name="new_passI" placeholder="Nhập mật khẩu mới" minlength="6">
                    <input type="password" class="form-control" required="true" id="inputPassword2" name="new_passII" placeholder="Nhập lại mật khẩu mới" minlength="6">
                    <button class="btn-outline-primary">Đổi mật khẩu</button>
                </form>
                </div>
                
            </div>
            </div>
        </div>

        <footer class="site_footer">
            <div class="Grid" >
                <div class="Grid_row">
                 <div class="Grid_Column">
                     
                     <h5 class="footer_heading" >About Us</h5>                  
                     <ul class="footer_list">
                         <li class="footer_item">
                             <a href="" class="footer_item_link">Đọc truyện miễn phí</a></li>
                         <li class="footer_item">
                             <a href="" class="footer_item_link">Hỗ trợ cho anh em đồng bào</a></li>
                         <li class="footer_item">
                             <a href="" class="footer_item_link">Tạo môi trường giao lưu</a></li>
                          <li class="footer_item">
                             <a href="" class="footer_item_link">Báo cáo</a></li>
                     </ul>
                     </div>
         
                 <div class="Grid_Column">
                     <h5 class="footer_heading">Contact Us</h5>
                     <ul class="footer_list">
                         <li class="footer_item">
                             <a href="" class="footer_item_link">Email: Trongcarrot@gmail.com</a> </li>
                          <li class="footer_item">
                                 <a href="" class="footer_item_link">Liên hệ QC</a></li>
                         <li class="footer_item">
                             <a a href="" class="footer_item_link">Telephone Contact</a></li>
                         <li class="footer_item">
                            <a href="" class="footer_item_link"> <address>
                                Địa chỉ
                             </address></a>
                         </li>
                         
                     </ul>
                 </div>
                </div>             
            </div>
             <div class="footer_bottom">
                 <div class="Grid">
              
                     <p class="footer_foot">&#169 2020 - Bản quyền thuộc về </p>
                 
                 </div>
             </div>
         </footer>
         <script language="JavaScript" src="./js/jsheader.js"></script>
         <script language="JavaScript" src="./js/sidebarType1.js"></script>
    </body>   
</html>