<?php
    session_start();

    require_once ('./database/connect_database.php');

    if(isset($_SESSION['user_id'])) {
        $sql = "select avatar from user where id = ".$_SESSION['user_id'];
        $user = EXECUTE_RESULT($sql);

        $sql = "SELECT * from NOTIFICATION where status = 'Chưa đọc' and id_user = ".$_SESSION['user_id']." order by created_at desc";
        $notification = EXECUTE_RESULT($sql);

        $now = time();
    }

?>



<!DOCTYPE html>
<html lang="vi" class>
<head>
    <meta charset="utf-8">
    <title>Đọc truyện tranh Manga, Manhua, Manhwa, Comic Online</title>
    <meta name="keyword" content="doc truyen tranh, manga, manhua, manhwa, comic">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <meta name="description" content="Đọc truyện tranh Manga, Manhua, Manhwa, Comic online hay và cập nhật thường xuyên tại TrongCarrot.com">
    <meta property="og:site_name" content="TrongCarrot.com">
    <meta name="Author" content="TrongCarrot.com">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <link rel="stylesheet" href="./css/style-Report.css">
    <link rel="stylesheet" href="./css/topbar.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/breadcrumb.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./Bootstrap/js/bootstrap.js">
    <link rel="stylesheet" href="./Bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <style>
        .form_search {
            width: 500px;
            height: inherit;
        }
    </style>
    <!--header-->
    <header id="top-bar">
        <div class="container-xxl d-flex justify-content-between position-relative">
            <div id="top-bar-left">
                <a class="logo" href="./index.php">
                    <img src="./img/image.png" alt="logo">
                </a>
                <div class="search-bar">
                    <form class="form_search" action="./search.php" method="GET">
                        <input type="text" placeholder="Nhập tên truyện" name="search" id="search-name">
                        <button class="search-button align-content-center">
                        <i class="bi bi-search align-middle" style="font-size: 20px;"></i>
                    </button>
                    </form>
                </div>
            </div>

            <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<style>
                    #chua-dang-nhap {
                        display: none;
                    }
                    </style>';
                } else {
                    echo '<style>
                    #da-dang-nhap {
                        display: none;
                    }
                    </style>';
                }
            ?>

            <div class="top-bar-right" id="chua-dang-nhap">
                <button id="login-button" onclick="location.href='./login.php';">Đăng nhập</a></button>
                <button id="register-button" onclick="location.href='./register.php';">Đăng ký</button>
            </div>
            <!--Da dang nhap-->
            <div class="top-bar-right" id="da-dang-nhap"">
            <div id="notification-button">
                <button onclick="open_list('notification-list'), close_list('account-setting-list')">
                    <i class='bx bx-bell' ></i>
                    <div id="so-thong-bao">
                    <?php
                        if(isset($_SESSION['user_id']) && count($notification) > 0) {
                            echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-family: inherit; font-size: 0.75em;" id="hienthisotb">'.count($notification).'
                                <span class="visually-hidden">unread messages</span>
                            </span>';
                        }
                    ?>
                    </div>
                    
                </button>

                <div id="notification-list">
                    <div id="option-bar">
                        <button id="danh-dau-da-doc" onclick="danh_dau_da_doc()">
                            <i class="bi bi-check-circle"></i>
                            <p>Đánh dấu đã đọc</p>
                        </button>
                        <button onclick="turn_on_off_notifi('noti-btn-i', 'noti-btn-text')">
                            <i class='bx bx-bell-off' id="noti-btn-i"></i>
                            <p id="noti-btn-text">Tắt thông báo</p>
                        </button>
                    </div>

                    <ul id="notification-list-content">
                        <?php
                        if(isset($_SESSION['user_id'])) {
                            $index = 0;
                            foreach ($notification as $item) {
                                $inmoi = "";
                                $time = $item['created_at'];                                                                                                                                                                                                                                                                                                            
                                $time = date_parse_from_format('Y-m-d H:i:s', $time);
                                $time_stamp = mktime($time['hour'],$time['minute'],$time['second'],$time['month'],$time['day'],$time['year']);
                                if(($now - $time_stamp) <= 60*60){
                                    $inmoi = "<span class=\"badge bg-warning text-dark\">Mới</span>";
                                }

                                echo '<li class="notification-box" id="notification-'.$index.'">
                                <a href="'.$item['link'].'">'.$item['content'].$inmoi.'
                                </a>
                                <p><i class="bi bi-clock"></i>'.$item['created_at'].'</p>
                                </li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
                <button id="account-button" onclick="open_list('account-setting-list'), close_list('notification-list')">
                    <img src="
                    <?php
                        if ($user[0]['avatar'] != NULL) echo $user[0]['avatar'];
                        else echo './img/logo.png'
                    ?>
                    ">
                </button>
                <div id="account-setting-list">
                    <a href="./account.php">Quản lý thông tin tài khoản</a>
                    <a href="./mycomic.php">Quản lý truyện đã đăng</a>
                    <a href="./logout.php">Đăng xuất</a>
                </div>
            </div>

            <script>
                function open_list(element_id) {
                    document.getElementById(element_id).classList.toggle("visible");
                }

                function close_list(element_id) {
                    let list = document.getElementById(element_id);
                    if (list.classList.contains("visible"))
                    document.getElementById(element_id).classList.remove("visible");
                }

                function turn_on_off_notifi (element_id_i, element_id_t) {
                    let newtext = document.getElementById(element_id_t);
                    let icon_btn = document.getElementById(element_id_i)
                    if (icon_btn.classList.contains("bi-bell")) {
                        newtext.innerHTML = "Bật thông báo";
                        icon_btn.classList.replace("bi-bell", "bi-bell-fill");
                    } else {
                        newtext.innerHTML = "Tắt thông báo";
                        icon_btn.classList.replace("bi-bell-fill", "bi-bell");
                    }
                }
            </script>
        </div>
    </header>

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
                    <i class='bx bxs-purchase-tag' ></i>
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
                <a href="./follow.php">
                    <i class='bx bxs-heart' ></i>
                    <span class="links_name">Theo dõi</span>
                </a>
                <span class="tooltip">Theo dõi</span>
            </li>
            <li>
                <a href="./history.php">
                    <i class='bx bx-history' ></i>
                    <span class="links_name">Lịch sử đọc</span>
                </a>
                <span class="tooltip">Lịch sử đọc</span>
            </li>
            <li>
                <a href="./feedback.php">
                    <i class='bx bx-mail-send' ></i>
                    <span class="links_name">Phản hồi</span>
                </a>
                <span class="tooltip">Phản hồi</span>
            </li>
            <li  id="btn-light-dark">
                <a>
                    <i class='bx bxs-bulb'></i>
                    <span class="links_name">Bật/Tắt đèn</span>
                </a>
                <span class="tooltip">Bật/Tắt đèn</span>
            </li>   
        </ul>
    </div>

    <div class="container-xxl"  id="content">
    <!-- Thanh breadcrumb --> 
    <div class="contain_nav_breadvrumb">
        <nav  class="nav_breadcrumb" aria-label="Page breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><i class='bx bxs-home'></i></li>
                <li class="breadcrumb-item active">Phản hồi</li>
            </ol>
        </nav>
    </div>
    <!--  -->
    <h2 class="caption">PHẢN HỒI</h2>
    <div class="form-content">
        <form action="./action_feedback.php" method="POST">
            <div class="mb-3 mt-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" id="email" placeholder="Email" name="email">
            </div>
            <div class="mb-3">
                <label for="report" class="form-label">Phản hồi:</label>
                <select class="form-select" id="report" name="type">
                    <option selected disabled value="">Chọn loại phản hồi</option>
                    <option>Lỗi ảnh truyện</option>
                    <option>Báo cáo vi phạm</option>
                    <option>Lỗi trang web</option>
                    <option>Khác</option>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="title" class="form-label">Tiêu đề:</label>
                <input type="text" class="form-control" id="title" placeholder="Tiêu đề" name="title">
              </div>
            <div>
                <label for="comment">Chi tiết:</label>
                <textarea class="form-control" rows="5" id="comment" name="content"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
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
                <p class="footer_foot">&#169 2020 - Bản quyền thuộc về TrongCarrot.com</p>            
            </div>
        </div>
    </footer>
    <script language="JavaScript" src="./js/sidebarType1.js"></script>
</body>
</html>