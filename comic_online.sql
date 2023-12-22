-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 21, 2023 lúc 08:12 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `comic_online`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chapter`
--

CREATE TABLE `chapter` (
  `id` int(11) NOT NULL,
  `id_comic` int(11) NOT NULL,
  `index` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `total_page` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL CHECK (`status` in ('Chờ duyệt','Đã duyệt')),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bẫy `chapter`
--
DELIMITER $$
CREATE TRIGGER `ins_bf_chapter` BEFORE INSERT ON `chapter` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
    SET NEW.updated_at = NOW();
    SET NEW.status = 'Chờ duyệt';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `up_af_chapter` AFTER UPDATE ON `chapter` FOR EACH ROW BEGIN
	DECLARE _id_comic INT DEFAULT 0;
	DECLARE _status VARCHAR(30);
    DECLARE _sochap INT DEFAULT 0;

    SET _id_comic = NEW.id_comic;
    SET _status = NEW.status;
    
    IF _status = 'Đã duyệt' THEN
        SELECT COUNT(*) INTO _sochap FROM chapter chap WHERE chap.id_comic = _id_comic and chap.status='Đã duyệt';
        UPDATE comic SET total_chapter = _sochap, updated_at = NOW() WHERE id = _id_comic;
    END IF;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comic`
--

CREATE TABLE `comic` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `author` varchar(50) DEFAULT NULL,
  `id_user` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT NULL CHECK (`status` in ('Đã hoàn thành','Đang tiến hành','Tạm ngưng','Chờ duyệt')),
  `coverphoto` varchar(200) DEFAULT NULL,
  `total_view` int(11) DEFAULT NULL,
  `id_country` int(11) DEFAULT NULL,
  `total_chapter` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `detail` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comic`
--

INSERT INTO `comic` (`id`, `name`, `author`, `id_user`, `status`, `coverphoto`, `total_view`, `id_country`, `total_chapter`, `rating`, `detail`, `created_at`, `updated_at`) VALUES
(19, 'Hừng Đông', 'Nocturne', '1', 'Đã hoàn thành', './upload/comic/coverphoto/Hừng_Đông_1703184867.jpg', 0, NULL, 0, 0, 'Cách biệt tuổi lớn, ai không thích thể loại này có thể bỏ qua.', '2023-12-22 01:52:45', '2023-12-22 01:54:27');

--
-- Bẫy `comic`
--
DELIMITER $$
CREATE TRIGGER `ins_bf_comic` BEFORE INSERT ON `comic` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
    SET NEW.updated_at = NOW();
    SET NEW.status = 'Chờ duyệt';
    SET NEW.total_view = 0;
    SET NEW.rating = 0.0;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `id_reply` int(11) DEFAULT NULL,
  `id_comic` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bẫy `comment`
--
DELIMITER $$
CREATE TRIGGER `ins_bf_comment` BEFORE INSERT ON `comment` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
    SET NEW.updated_at = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `country`
--

INSERT INTO `country` (`id`, `name`) VALUES
(1, 'Việt Nam'),
(2, 'Nhật Bản'),
(3, 'Trung Quốc'),
(4, 'Châu Âu'),
(5, 'Hàn Quốc');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bẫy `feedback`
--
DELIMITER $$
CREATE TRIGGER `ins_bf_feedback` BEFORE INSERT ON `feedback` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
    SET NEW.updated_at = NOW();
    SET NEW.status = 'Đã nhận';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `follow`
--

CREATE TABLE `follow` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_comic` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bẫy `follow`
--
DELIMITER $$
CREATE TRIGGER `ins_bf_follow` BEFORE INSERT ON `follow` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `like_comment`
--

CREATE TABLE `like_comment` (
  `id_comment` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `like_comment`
--

INSERT INTO `like_comment` (`id_comment`, `id_user`, `created_at`) VALUES
(11, 0, '2021-11-25 23:34:05'),
(11, 3, '2021-11-26 00:40:26'),
(19, 3, '2021-11-26 00:43:06'),
(9, 2, '2021-11-26 00:43:33'),
(3, 2, '2021-11-26 00:43:36'),
(37, 3, '2021-11-26 12:59:09'),
(17, 3, '2021-11-26 20:30:19');

--
-- Bẫy `like_comment`
--
DELIMITER $$
CREATE TRIGGER `ins_bf_like_comment` BEFORE INSERT ON `like_comment` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login`
--

CREATE TABLE `login` (
  `id_user` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` char(50) NOT NULL,
  `isadmin` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `login`
--

INSERT INTO `login` (`id_user`, `username`, `password`, `isadmin`, `created_at`, `updated_at`) VALUES
(1, 'admin', '123456', 0, '2021-11-18 11:32:05', '2021-11-18 11:32:05');

--
-- Bẫy `login`
--
DELIMITER $$
CREATE TRIGGER `ins_bf_login` BEFORE INSERT ON `login` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
    SET NEW.updated_at = NOW();
    SET NEW.isadmin = 0;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `link` varchar(200) DEFAULT '#',
  `status` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bẫy `notification`
--
DELIMITER $$
CREATE TRIGGER `ins_bf_notification` BEFORE INSERT ON `notification` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
    SET NEW.status = 'Chưa đọc';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `other_name_comic`
--

CREATE TABLE `other_name_comic` (
  `id_comic` int(11) NOT NULL,
  `other_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `id_chapter` int(11) NOT NULL,
  `index` int(11) NOT NULL,
  `link_page` varchar(500) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bẫy `page`
--
DELIMITER $$
CREATE TRIGGER `ins_bf_page` BEFORE INSERT ON `page` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
    SET NEW.updated_at = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `readed`
--

CREATE TABLE `readed` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_chapter` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `readed`
--

INSERT INTO `readed` (`id`, `id_user`, `id_chapter`, `created_at`, `updated_at`) VALUES
(26, 3, 1, '2021-11-26 18:13:55', '2021-11-26 18:13:55'),
(27, 3, 1, '2021-11-26 18:14:22', '2021-11-26 18:14:22'),
(28, 3, 1, '2021-11-26 18:14:37', '2021-11-26 18:14:37'),
(29, 3, 1, '2021-11-26 18:14:50', '2021-11-26 18:14:50'),
(30, 3, 1, '2021-11-26 18:17:08', '2021-11-26 18:17:08'),
(31, 3, 1, '2021-11-26 18:17:24', '2021-11-26 18:17:24'),
(32, 3, 2, '2021-11-26 20:30:12', '2021-11-26 20:30:12'),
(33, 3, 1, '2021-11-26 20:30:43', '2021-11-26 20:30:43'),
(34, 3, 1, '2021-11-26 20:31:39', '2021-11-26 20:31:39'),
(35, 2, 1, '2021-11-26 20:36:55', '2021-11-26 20:36:55'),
(36, 3, 1, '2021-12-01 10:22:51', '2021-12-01 10:22:51'),
(37, 3, 1, '2021-12-01 19:51:35', '2021-12-01 19:51:35'),
(38, 3, 2, '2021-12-01 19:51:52', '2021-12-01 19:51:52'),
(39, 3, 12, '2021-12-01 19:51:58', '2021-12-01 19:51:58'),
(40, 3, 1, '2021-12-01 19:52:02', '2021-12-01 19:52:02'),
(41, 3, 2, '2021-12-01 19:52:03', '2021-12-01 19:52:03'),
(42, 3, 12, '2021-12-01 19:52:04', '2021-12-01 19:52:04'),
(43, 3, 2, '2021-12-01 19:52:05', '2021-12-01 19:52:05'),
(44, 3, 1, '2021-12-01 20:11:47', '2021-12-01 20:11:47'),
(45, 1, 1, '2023-12-22 01:05:20', '2023-12-22 01:05:20');

--
-- Bẫy `readed`
--
DELIMITER $$
CREATE TRIGGER `ins_bf_readed` BEFORE INSERT ON `readed` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
    SET NEW.updated_at = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Adventure'),
(3, 'Comedy'),
(4, 'Detective'),
(5, 'Demon'),
(6, 'Drama'),
(7, 'Fantasy'),
(8, 'Harem'),
(9, 'Mafia'),
(10, 'Magic'),
(11, 'Romance'),
(12, 'School life'),
(13, 'Shounen'),
(14, 'Sport');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tag_comic`
--

CREATE TABLE `tag_comic` (
  `id_comic` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tag_comic`
--

INSERT INTO `tag_comic` (`id_comic`, `id_tag`) VALUES
(1, 1),
(1, 6),
(2, 6),
(3, 3),
(3, 4),
(3, 6),
(3, 7),
(3, 10),
(3, 12),
(4, 8),
(4, 10),
(5, 11),
(5, 12),
(6, 1),
(6, 4),
(6, 9),
(18, 1),
(18, 4),
(18, 6),
(19, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `email` char(100) DEFAULT NULL,
  `sex` varchar(5) DEFAULT NULL CHECK (`sex` in ('Nam','Nữ','Khác')),
  `facebook` varchar(200) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `account_name`, `email`, `sex`, `facebook`, `avatar`, `dateofbirth`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'Nam', '', '', '2021-11-16', '2021-11-18 11:29:14', '2021-11-18 11:29:14');

--
-- Bẫy `user`
--
DELIMITER $$
CREATE TRIGGER `ins_bf_user` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
    SET NEW.created_at = NOW();
    SET NEW.updated_at = NOW();
END
$$
DELIMITER ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uni_chap_id` (`id_comic`,`index`);

--
-- Chỉ mục cho bảng `comic`
--
ALTER TABLE `comic`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `login`
--
ALTER TABLE `login`
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Chỉ mục cho bảng `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `other_name_comic`
--
ALTER TABLE `other_name_comic`
  ADD PRIMARY KEY (`id_comic`,`other_name`);

--
-- Chỉ mục cho bảng `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uni_page_id` (`id_chapter`,`index`);

--
-- Chỉ mục cho bảng `readed`
--
ALTER TABLE `readed`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tag_comic`
--
ALTER TABLE `tag_comic`
  ADD PRIMARY KEY (`id_comic`,`id_tag`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chapter`
--
ALTER TABLE `chapter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT cho bảng `comic`
--
ALTER TABLE `comic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT cho bảng `readed`
--
ALTER TABLE `readed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
