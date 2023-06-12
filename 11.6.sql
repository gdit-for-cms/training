-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th6 11, 2023 lúc 04:37 PM
-- Phiên bản máy phục vụ: 5.7.24
-- Phiên bản PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `intern`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_page` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `position`
--

INSERT INTO `position` (`id`, `name`, `description`, `access_page`) VALUES
(1, 'BrSE', 'La ky su cau noi cua cong ty', 'home'),
(4, 'Developer', '', 'home'),
(5, 'Internship', '', 'home'),
(12, 'Team Lead', '', 'home'),
(13, 'Tester', '', 'home'),
(19, 'leader', '', 'home,project');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room`
--

INSERT INTO `room` (`id`, `name`, `description`) VALUES
(1, 'PHP', 'PHP is an amazing and popular language!\r\n\r\nIt is powerful enough to be at the core of the biggest blogging system on the web (WordPress)!\r\nIt is deep enough to run large social networks!\r\nIt is also easy enough to be a beginner\'s first server side language!'),
(2, 'Front end', 'Welcome to Introduction to Front-End Development, the first course in the Meta Front-End Developer program.  \r\n\r\nThis course is a good place to start if you want to become a web developer. You will learn about the day-to-day responsibilities of a web developer and get a general understanding of the core\'s and underlying technologies that power the internet. You will learn how front-end developers create websites and applications that work well and are easy to maintain. '),
(3, 'AI', ''),
(4, 'BO', ''),
(5, '.NET', 'The .NET Framework (pronounced as \"dot net\") is a proprietary software framework developed by Microsoft that runs primarily on Microsoft Windows. It was the predominant implementation of the Common Language Infrastructure (CLI) until being superseded by the cross-platform .NET project.'),
(16, 'Java', 'Java is a high-level, class-based, object-oriented programming language that is designed to have as few implementation dependencies as possible. It is a general-purpose programming language intended to let programmers write once, run anywhere (WORA), meaning that compiled Java code can run on all platforms that support Java without the need to recompile.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_answer`
--

CREATE TABLE `tbl_answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_answer`
--

INSERT INTO `tbl_answer` (`id`, `question_id`, `content`, `order`) VALUES
(1, 1, 'はい', 1),
(2, 1, 'いいえ', 2),
(3, 1, 'わからない', 3),
(4, 2, 'はい', 1),
(5, 2, 'いいえ', 2),
(6, 3, 'はい', 1),
(7, 3, 'いいえ', 2),
(8, 3, 'わからない', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_answer_disable`
--

CREATE TABLE `tbl_answer_disable` (
  `id` int(11) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `disabled_answer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_answer_disable`
--

INSERT INTO `tbl_answer_disable` (`id`, `answer_id`, `disabled_answer_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_answer_step`
--

CREATE TABLE `tbl_answer_step` (
  `id` int(11) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `step_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_answer_step`
--

INSERT INTO `tbl_answer_step` (`id`, `answer_id`, `step_id`, `order`) VALUES
(1, 2, '1-3', 1),
(2, 3, '1-4', 1),
(3, 4, '1-1', 1),
(4, 4, '1-2', 2),
(5, 4, '1-3', 3),
(6, 5, '1-2', 1),
(7, 5, '1-3', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `param_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `name`, `class`, `param_name`, `link`, `parent_category`) VALUES
(1, 'お悔やみ', 'okuyami', 'okuyami', NULL, NULL),
(2, '婚姻', 'konnin', 'konnin', NULL, NULL),
(3, 'マイナンバー', 'mynumber', 'mynumber', NULL, NULL),
(4, '申請したい・申請中の方', 'mynumber_apply', 'mynumber_apply', '/url-to-page.html', 3),
(5, '現在お持ちの方', 'mynumber_owned', 'mynumber_owned', '/url-to-page.html', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_question`
--

CREATE TABLE `tbl_question` (
  `id` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_answer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `multi_flg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required_flg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_question`
--

INSERT INTO `tbl_question` (`id`, `content`, `parent_answer_id`, `category_id`, `multi_flg`, `required_flg`) VALUES
(1, '亡くなった方は世帯主でしたか', NULL, 1, '0', '1'),
(2, '亡くなった方の世帯員で15歳以上の方は2人以上いますか', 1, 1, '0', '1'),
(3, '亡くなった方は公的年金（国民年金、厚生年金、共済年金）に加入又は受給していましたか', NULL, 1, '0', '1'),
(4, '亡くなった方の加入していた健康保険を教えてください', NULL, 1, '0', '1'),
(5, '亡くなった方の健康保険の扶養になっていた方はいらっしゃいますか', 4, 1, '0', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_step_master`
--

CREATE TABLE `tbl_step_master` (
  `step_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `step_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_limit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `belongings` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `application_window` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reception_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_information` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_step_master`
--

INSERT INTO `tbl_step_master` (`step_id`, `category_id`, `step_name`, `summary`, `time_limit`, `belongings`, `person`, `application_window`, `reception_time`, `contact_information`) VALUES
('1-1', 1, '結果1-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1-2', 1, '結果1-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1-3', 2, '結果1-3', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1-4', 3, '結果1-4', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1-5', 1, '結果1-5', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2-1', 1, '結果2-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2-2', 1, '結果2-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2-3', 1, '結果2-3', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('2-4', 1, '結果2-4', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `test.test`
--

CREATE TABLE `test.test` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `test.test`
--

INSERT INTO `test.test` (`id`, `name`, `description`) VALUES
(1, 'sadfs', 'fsadfsdfsadf'),
(2, 'fsadf', 'sadfsadfasdf'),
(3, 'sd/fsdf/', '/fdsa/fdsf/');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_image` mediumtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `token`, `role_id`, `room_id`, `position_id`, `gender`, `avatar_image`) VALUES
(8, 'Vạn Yên Bằng', 'admin1@gmail.org', '123456', NULL, 1, 1, 5, 'male', 'ckfinder/userfiles/images/avatars/8_2022-11-04_07-07-33_man (3).png'),
(10, 'Khiếu Anh Ðức', 'admin2@gmail.org', '123456', NULL, 1, 16, 4, 'female', NULL),
(14, 'Nhữ Phúc Lâm', 'user1@gmail.ftp', '123123', NULL, 2, 3, 5, '', ''),
(15, 'Giáp Nhật Nam', 'user2@gmail.ftp', '123123', NULL, 2, 1, 5, '', NULL),
(16, 'Lý Xuân Quý', 'user3@gmail.ftp', '123123', NULL, 2, 5, 5, '', NULL),
(17, 'Lãnh Ðức Tâm', 'user4@gmail.ftp', '123123', NULL, 2, 5, 13, '', NULL),
(19, 'Bạch Triều Thành', 'user5@gmail.ftp', '123123', NULL, 2, 3, 13, '', NULL),
(20, 'Thào Thanh Thuận', 'user6@gmail.ftp', '123123', NULL, 2, 1, 13, '', NULL),
(21, 'Công Thành Danh', 'user7@gmail.ftp', '123123', NULL, 2, 3, 4, '', NULL),
(22, 'Đồ Phú Hùng', 'user8@gmail.ftp', '123123', NULL, 2, 3, 4, '', NULL),
(23, 'Vòng Vũ Minh', 'user9@gmail.ftp', '123123', NULL, 2, 5, 4, '', NULL),
(24, 'Cù Tấn Nam', 'user10@gmail.ftp', '123123', NULL, 2, 1, 4, '', NULL),
(25, 'Thẩm Xuân Quý', 'user11@gmail.ftp', '123123', NULL, 2, 5, 4, '', NULL),
(32, 'Bạc Bá Tùng', 'user12@gmail.ftp', '123123', NULL, 2, 5, 4, '', NULL),
(35, 'Tri Quang Thuận', 'user13@gmail.ftp', '123123', NULL, 2, 5, 12, '', NULL),
(36, 'Đăng Xuân Thuyết', 'user14@gmail.ftp', '123123', NULL, 2, 1, 4, '', NULL),
(38, 'Từ Quốc Bình', 'user15@gmail.ftp', '123123', NULL, 2, 1, 4, '', NULL),
(39, 'Đào Anh Duy', 'user16@gmail.ftp', '123123', NULL, 2, 5, 1, '', NULL),
(40, 'Cung Ðại Hành', 'user17@gmail.ftp', '123123', NULL, 2, 3, 12, '', NULL),
(41, 'Quản Quang Hùng', 'user18@gmail.ftp', '123123', NULL, 2, 1, 12, '', NULL),
(42, 'Đới Trường Long', 'user19@gmail.ftp', '123123', NULL, 2, 16, 5, '', NULL),
(43, 'Cù Trường Nhân', 'user20@gmail.ftp', '123123', NULL, 2, 16, 13, '', NULL),
(44, 'Kha Ðình Sang', 'user21@gmail.ftp', '123123', NULL, 2, 3, 1, '', NULL),
(45, 'Liễu Danh Thành', 'user22@gmail.ftp', '123123', NULL, 2, 1, 1, '', NULL),
(46, 'Bùi Bá Thiện', 'user23@gmail.ftp', '123123', NULL, 2, 16, 13, '', NULL),
(47, 'Hồng Trường Kỳ', 'user24@gmail.ftp', '123123', NULL, 2, 3, 1, '', NULL),
(48, 'Chung Hữu Hùng', 'user25@gmail.ftp', '123123', NULL, 2, 16, 4, '', NULL),
(49, 'Bình Trí Hùng', 'user26@gmail.ftp', '123123', NULL, 2, 1, 1, '', NULL),
(50, 'Quang Hồ Nam', 'user27@gmail.ftp', '123123', NULL, 2, 16, 4, '', NULL),
(51, 'Tôn Xuân Phúc', 'user28@gmail.ftp', '123123', NULL, 2, 16, 4, '', NULL),
(52, 'Phạm Thuận Toàn', 'user29@gmail.ftp', '123123', NULL, 2, 16, 12, '', NULL),
(53, 'Danh Tuấn Thành', 'user30@gmail.ftp', '123123', NULL, 2, 5, 1, '', NULL),
(54, 'Chế Long Vịnh', 'user31@gmail.ftp', '123123', NULL, 2, 16, 1, '', NULL),
(55, 'Tinh Phú Ân', 'user32@gmail.ftp', '123123', NULL, 2, 16, 1, '', NULL),
(56, 'Thập Đức Cao', 'user33@gmail.ftp', '123123', NULL, 2, 2, 5, '', NULL),
(57, 'Tô Trung Chính', 'user34@gmail.ftp', '123123', NULL, 2, 2, 13, '', NULL),
(58, 'Bàng Khánh Duy', 'user35@gmail.ftp', '123123', NULL, 2, 2, 13, '', NULL),
(59, 'Châu Trọng Kiên', 'user36@gmail.ftp', '123123', NULL, 2, 2, 4, '', NULL),
(60, 'Ngọc Sơn Lâm', 'user37@gmail.ftp', '123123', NULL, 2, 2, 4, '', NULL),
(61, 'Văn Duy Quang', 'user38@gmail.ftp', '123123', NULL, 2, 2, 4, '', NULL),
(62, 'Thân Quốc Tiến', 'user39@gmail.ftp', '123123', NULL, 2, 2, 4, '', NULL),
(63, 'Hầu Quang Vinh', 'user40@gmail.ftp', '123123', NULL, 2, 2, 12, '', NULL),
(64, 'Bùi Trường Chinh', 'user41@gmail.ftp', '123123', NULL, 2, 2, 1, 'male', NULL),
(67, 'Nghia. Nguyen Huu', 'luffy.1999tm@gmail.org', 'Nguyen99+', NULL, 2, 16, 19, 'male', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `tbl_answer`
--
ALTER TABLE `tbl_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Chỉ mục cho bảng `tbl_answer_disable`
--
ALTER TABLE `tbl_answer_disable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answer_id` (`answer_id`),
  ADD KEY `disabled_answer_id` (`disabled_answer_id`);

--
-- Chỉ mục cho bảng `tbl_answer_step`
--
ALTER TABLE `tbl_answer_step`
  ADD PRIMARY KEY (`id`),
  ADD KEY `step_id` (`step_id`),
  ADD KEY `answer_id` (`answer_id`);

--
-- Chỉ mục cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_question`
--
ALTER TABLE `tbl_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `tbl_step_master`
--
ALTER TABLE `tbl_step_master`
  ADD PRIMARY KEY (`step_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `test.test`
--
ALTER TABLE `test.test`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `CK_role_user` (`role_id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `CK_room_user` (`room_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT cho bảng `tbl_answer`
--
ALTER TABLE `tbl_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `tbl_answer_disable`
--
ALTER TABLE `tbl_answer_disable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `tbl_answer_step`
--
ALTER TABLE `tbl_answer_step`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `tbl_question`
--
ALTER TABLE `tbl_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `test.test`
--
ALTER TABLE `test.test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tbl_answer`
--
ALTER TABLE `tbl_answer`
  ADD CONSTRAINT `tbl_answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `tbl_question` (`id`);

--
-- Các ràng buộc cho bảng `tbl_answer_disable`
--
ALTER TABLE `tbl_answer_disable`
  ADD CONSTRAINT `tbl_answer_disable_ibfk_1` FOREIGN KEY (`answer_id`) REFERENCES `tbl_answer` (`id`),
  ADD CONSTRAINT `tbl_answer_disable_ibfk_2` FOREIGN KEY (`disabled_answer_id`) REFERENCES `tbl_answer` (`id`);

--
-- Các ràng buộc cho bảng `tbl_answer_step`
--
ALTER TABLE `tbl_answer_step`
  ADD CONSTRAINT `tbl_answer_step_ibfk_1` FOREIGN KEY (`step_id`) REFERENCES `tbl_step_master` (`step_id`),
  ADD CONSTRAINT `tbl_answer_step_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `tbl_answer` (`id`);

--
-- Các ràng buộc cho bảng `tbl_question`
--
ALTER TABLE `tbl_question`
  ADD CONSTRAINT `tbl_question_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`);

--
-- Các ràng buộc cho bảng `tbl_step_master`
--
ALTER TABLE `tbl_step_master`
  ADD CONSTRAINT `tbl_step_master_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`);

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `CK_position_user` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`),
  ADD CONSTRAINT `CK_role_user` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `CK_room_user` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
