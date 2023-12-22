<?php
    session_start();


    require_once ('./database/connect_database.php');

    $user = [];

    if(isset($_SESSION['user_id'])) {
        $sql = "select avatar, account_name from user where id = ".$_SESSION['user_id'];
        $user = EXECUTE_RESULT($sql);

        $sql = "SELECT * from NOTIFICATION where status = 'Chưa đọc' and id_user = ".$_SESSION['user_id']." order by created_at desc";
        $notification = EXECUTE_RESULT($sql);

        $now = time();
    }

    $comic_id = 0;
    if(isset($_GET['comic'])) {
        $comic_id = (int)$_GET['comic'];
    }
    else {
        header("Location: ./");
        die();
    }

    $sql = "select cm.id, cm.coverphoto, cm.id_user, cm.name, cm.author, cm.status, cm.total_view, cm.total_chapter, cm.detail, cm.created_at, cm.updated_at, count(fl.id_user) follow from comic cm left join follow fl on cm.id = fl.id_comic where cm.id = ".$comic_id." group by cm.id";
    $comic = EXECUTE_RESULT($sql);

    if(is_null($comic[0]['id'])) {
        header("Location: ./");
        die();
    }

    $sql = "select * from tag_comic tm join tag tg on tm.id_tag = tg.id where id_comic = ".$comic_id;
    $theloai = EXECUTE_RESULT($sql);

    $sql = "select * from chapter where status='Đã duyệt' and id_comic = ".$comic_id;
    $chapter = EXECUTE_RESULT($sql);
?>


<!DOCTYPE html>
<html lang="vi" class>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="./css/topbar.css">
    <link rel="stylesheet" type="text/css" href="./css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="./css/story-list-style.css">
    <link rel="stylesheet" type="text/css" href="./css/breadcrumb.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
    <link rel="stylesheet" type="text/css" href="./css/style-Storywall.css">
    <link rel="stylesheet" type="text/css" href="./css/style-DT.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
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
            max-width: 500px;
            height: inherit;
        }
    </style>
    <!--header-->
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
        
    <button class="btntop" id="btntop">
        <i class='bx bx-send bx-rotate-270'></i>
    </button>


    <div class="container-xxl" id="content">
        <!-- Thanh breadcrumb --> 
        <div class="contain_nav_breadvrumb">
            <nav  class="nav_breadcrumb" aria-label="Page breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page"><i class='bx bxs-home'></i></li>
                    <li class="breadcrumb-item active"><?php echo $comic[0]['name']; ?></li>
                </ol>
            </nav>
        </div>

        <div class="banner">
            <img src="<?php echo $comic[0]['coverphoto']; ?>" alt="<?php echo $comic[0]['name']; ?>" id="banner-1-img">
            <div class="banner-info">
                <h1 class="banner-info-title"><?php echo $comic[0]['name']; ?></h1>
                <p class="banner-info-detail">Tình trạng truyện: <?php echo $comic[0]['status']; ?></p>
                <p class="banner-info-detail">Lượt xem: <?php echo $comic[0]['total_view']; ?></p>
                <p class="banner-info-detail">Lượt theo dõi: <?php echo $comic[0]['follow']; ?></p>
                <div class="banner-info-category">
                    <?php
                        foreach($theloai as $item) {
                            echo '<button class="category btn-outline-primary" onclick="location.href=\'./typecomic.php?tagid'.$item['id'].'=on\';">'.$item['name'].'</button>';
                        }
                    ?>
                </div>
                <div class="list-btn-contain">
                    <?php
                        echo '<button class="list-btn" style="width: fit-content;" onclick="location.href=\'./action_follow.php?cm='.$comic_id;

                        if(isset($_SESSION['user_id'])) {
                            $ktra = EXECUTE_RESULT("select id, count(*) total from follow where id_comic= ".$comic_id." and id_user=".$_SESSION['user_id']);
                            if($ktra[0]['total']) {
                                echo '&id='.$ktra[0]['id'].'\'"><i class=\'bx bxs-heart\'></i> Đang theo dõi</button>';
                            }
                            else echo '&id=-1&name='.$user[0]['account_name'].'\'"><i class=\'bx bxs-heart\'></i> Theo dõi</button>';
                        }
                        else echo '&id=-1\'"><i class=\'bx bxs-heart\'></i> Theo dõi</button>';
                    ?>
                    <button class="list-btn" 
                        <?php
                            if(count($chapter) == 0) {
                                echo 'style="display: none;" ';
                            }
                            echo 'onclick="location.href=\'./read.php?comic='.$comic_id.'&chapter=1\'"';
                        ?>                    
                    ><i class='bx bxs-book-open'></i> Đọc từ đầu</button>
                </div>
                <p class="banner-info-detail"><?php echo $comic[0]['detail']; ?> </p>
            </div>
        </div>

        <h2 class="caption">DANH SÁCH CHƯƠNG</h2>

        <div class="row workspace">
            <div class="listchapter">
                <ul class="col">
                    <?php
                        foreach ($chapter as $item) {
                            echo '<li class="chapteritem">
                            <a href="./read.php?comic='.$comic_id.'&chapter='.$item['index'].'" class="col mb-10">Chương '.$item['index'].': '.$item['name'].'</a>
                            <p class="date-upload col-2">'.$item['updated_at'].'</p>
                        </li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>


    <!--Bình luận-->
    <div class="container-xxl" id="comment-area">
        <h2 class="caption">BÌNH LUẬN</h2>
        <!--nhap binh luan-->
        <div class="comment comment-input" id="comment-0" style="display: inline-block;">
            <div class="comment-info">
                <a class="user-avt"><img src=
                    "<?php
                        if(isset($_SESSION['user_id'])) {
                            echo $user[0]['avatar'];
                        }
                        else {
                            echo "./img/logo.png";
                        }
                    ?>"
                ></a>
                <p class="user-name">
                    <?php
                        if(isset($_SESSION['user_id'])) {
                            echo $user[0]['account_name'];
                        }
                        else {
                            echo "taikhoan";
                        }
                    ?>
                </p>
            </div>
            <form id="user-comment-0" name="comment" method="POST" action="./action_postcomment.php">
                <textarea name="content" placeholder="Bình luận..."></textarea>
                <input type="text" name="id_replay" value="<?php echo '-1'; ?>" style="display: none;">
                <input type="text" name="id_comic" value="<?php echo $comic_id; ?>" style="display: none;">
                <input type="text" name="user_comic" value="<?php echo $comic[0]['id_user']; ?>" style="display: none;">
                <input type="text" name="link" value="./comic.php?comic=<?php echo $comic_id; ?>" style="display: none;">
                <input type="text" name="account" value="<?php echo $user[0]['account_name']; ?>" style="display: none;">
                <input type="submit"  class="send-cmt">
            </form>
        </div>
        
        <?php
            function print_comment($id_cm, $comic_id, $id_us_comic, $user) {
                $sql = "select cm.id idm, cm.id_user, cm.content, cm.created_at, us.id, us.account_name, us.avatar from comment cm join user us on cm.id_user = us.id ";
                if($id_cm == -1 ) $sql = $sql." where cm.id_reply is null and cm.id_comic = ".$comic_id." order by cm.created_at desc";
                else $sql = $sql." where cm.id_reply = ".$id_cm." and cm.id_comic = ".$comic_id." order by cm.created_at desc";
                $comment_ = EXECUTE_RESULT($sql);
                foreach($comment_ as $item) {
                    echo '<div class="comment" id="comment-'.$item['idm'].'">
                    <div class="comment-info">
                        <a class="user-avt"><img src="'.$item['avatar'].'"></a>
                        <a class="user-name">'.$item['account_name'].'</a>
                        <p class="comment-time">'.$item['created_at'].'</p>
                    </div>
                    <div class="comment-content">
                        <p>'.$item['content'].'</p>
                    </div>
                    <div class="comment-reaction">
                        <button class="bi ';
                        if(isset($_SESSION['user_id'])) {
                            $ktra = EXECUTE_RESULT("select count(*) total from like_comment where id_comment = ".$item['idm']." and id_user = ".$_SESSION['user_id']);
                            if($ktra[0]['total'] != 0)
                                echo 'bi-suit-heart-fill" type="button" id="like-comment-'.$item['idm'].'" onclick="thump_up('.$item['idm'].', '.$_SESSION['user_id'].', \''.$user[0]['account_name'].'\', '.$item['id_user'].', '.$comic_id.')"> Đã thích</button>';
                            else 
                                echo 'bi-suit-heart" type="button" id="like-comment-'.$item['idm'].'" onclick="thump_up('.$item['idm'].', '.$_SESSION['user_id'].', \''.$user[0]['account_name'].'\', '.$item['id_user'].', '.$comic_id.')"> Thích</button>';
                        }
                        else
                            echo 'bi-suit-heart"  type="button" id="like-comment-'.$item['idm'].'"> Thích</button>';
                        
                        echo '<button class="bi bi-reply" type="button" onclick="reply_comment('.$item['idm'].')"> Phản hồi</button>
                    </div>';
                    
                    print_comment($item['idm'], $comic_id, $id_us_comic, $user);

                    echo '<!--đây là reply 1 cmt-->
                    <div class="comment comment-input" id="comment-'.$item['idm'].'-reply">
                        <div class="comment-info">
                            <a class="user-avt"><img src="';
                    
                    if(isset($_SESSION['user_id'])) echo $user[0]['avatar'];
                    else echo './img/logo.png';
                    
                    echo '"></a>
                            <a class="user-name">';
                            
                    if(isset($_SESSION['user_id'])) echo $user[0]['account_name'];
                    else echo 'taikhoan';
    
                    echo '</a>   
                        </div>
                        <form id="user-comment-0" name="comment" method="POST" action="./action_postcomment.php">
                            <textarea name="content" placeholder="Bình luận..."></textarea>
                            <input type="text" name="id_replay" value="'.$item['idm'].'" style="display: none;">
                            <input type="text" name="link" value="./comic.php?comic='.$comic_id.'" style="display: none;">
                            <input type="text" name="id_usreplay" value="'.$item['id_user'].'" style="display: none;">
                            <input type="text" name="id_comic" value="'.$comic_id.'" style="display: none;">
                            <input type="text" name="account" value="'.$user[0]['account_name'].'" style="display: none;">
                            <input type="text" name="user_comic" value="'.$id_us_comic.'" style="display: none;">
                            <input type="submit"  class="send-cmt">
                        </form>
                        <button class="close-cmt btn btn-danger delete-button" type="button">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>';
                }
            }

            print_comment(-1, $comic_id, $comic[0]['id_user'], $user);
        ?>


        <script>
            function reply_comment(button) {
                document.getElementById("comment-"+button+"-reply").classList.toggle("d-inline-block")
            }
            function close_comment(button) {
                document.getElementById("comment-"+button+"-reply").classList.toggle("d-inline-block")
            }
            function execute_query(query) {
                $data = "query";
                $.ajax({
                    url : "action_query.php",
                    type : "post",
                    dataType:"text",
                    data : {
                        data: $data,
                        query : $query
                    },
                    success : function (result){}
                });
            }
            function thump_up(id_cm, user, name, us_cm, cm) {
                let like = document.getElementById("like-comment-"+id_cm);
                if (like.classList.contains("bi-suit-heart"))
                {
                    like.classList.replace("bi-suit-heart", "bi-suit-heart-fill")
                    like.innerHTML=" Đã thích"
                    $query = "insert into like_comment (id_comment, id_user) values ('"+id_cm+"', '"+user+"')"
                    execute_query($query)
                    $query = "insert into notification (id_user, type, content, link) values ('"+us_cm+"', 'Thích bình luận', '"+name+" đã thích bình luận của bạn.', './comic.php?comic="+cm+"')"
                    execute_query($query)
                }
                else {
                    like.classList.replace("bi-suit-heart-fill", "bi-suit-heart")
                    like.innerHTML=" Thích"
                    $query = "delete from like_comment where id_comment="+id_cm+" and id_user="+user
                    execute_query($query)
                }
            }
        </script>
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
                <p class="footer_foot">&#169 2020 - Bản quyền thuộc về</p> 
            </div>
        </div>
    </footer>
    <script language="JavaScript" src="./js/jsheader.js"></script>
    <script language="JavaScript" src="./js/sidebarType1.js"></script>
</body>
</html>
