/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50137
Source Host           : localhost:3306
Source Database       : sg_db

Target Server Type    : MYSQL
Target Server Version : 50137
File Encoding         : 65001

Date: 2013-12-18 21:39:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `advs`
-- ----------------------------
DROP TABLE IF EXISTS `advs`;
CREATE TABLE `advs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_name` varchar(50) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `url_path` varchar(500) DEFAULT '#Click vào đây để thay đổi đường dẫn ảnh',
  `status` tinyint(4) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '1',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of advs
-- ----------------------------
INSERT INTO `advs` VALUES ('1', '22c44.jpg', '1', 'google.com.vn', '1', '1', 'Công ty cổ phần lưới điện thông minh', 'vi');
INSERT INTO `advs` VALUES ('2', '22de5.jpg', '2', '#Click vào đây để thay đổi đường dẫn ảnh', '1', '1', 'Title', 'vi');
INSERT INTO `advs` VALUES ('3', '23799.png', '1', '#Click vào đây để thay đổi đường dẫn ảnh', '1', '3', 'Title', 'vi');
INSERT INTO `advs` VALUES ('4', '2379d.jpg', '2', '#Click vào đây để thay đổi đường dẫn ảnh', '1', '3', 'Title', 'vi');
INSERT INTO `advs` VALUES ('5', '237a1.png', '3', '#Click vào đây để thay đổi đường dẫn ảnh', '1', '3', 'Title', 'vi');
INSERT INTO `advs` VALUES ('6', '237a5.jpg', '4', '#Click vào đây để thay đổi đường dẫn ảnh', '1', '3', 'Title', 'vi');

-- ----------------------------
-- Table structure for `categories`
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `position` tinyint(2) DEFAULT NULL,
  `css` varchar(50) DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `lang` varchar(20) DEFAULT 'vi',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'Máy cắt', '0', '1', '', '', '', '', 'vi');
INSERT INTO `categories` VALUES ('5', 'Thiết bị cảnh báo', '0', '2', '', '', '', '', 'vi');
INSERT INTO `categories` VALUES ('6', 'Cầu trì tự rơi', '0', '3', '', '', '', '', 'vi');
INSERT INTO `categories` VALUES ('7', 'Chống sét', '0', '4', '', '', '', '', 'vi');
INSERT INTO `categories` VALUES ('8', 'Biến điện áp', '0', '5', '', '', '', '', 'vi');
INSERT INTO `categories` VALUES ('9', 'Biến dòng', '0', '6', '', '', '', '', 'vi');
INSERT INTO `categories` VALUES ('10', 'Scada', '0', '7', '', '', '', '', 'vi');
INSERT INTO `categories` VALUES ('11', 'Hệ thống giám sát điều khiểu từ xa', '0', '8', '', '', '', '', 'vi');

-- ----------------------------
-- Table structure for `configuration`
-- ----------------------------
DROP TABLE IF EXISTS `configuration`;
CREATE TABLE `configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_email` varchar(100) DEFAULT NULL,
  `order_email` varchar(100) DEFAULT NULL,
  `meta_title` varchar(500) DEFAULT NULL,
  `meta_keywords` varchar(500) DEFAULT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `favicon` varchar(100) DEFAULT NULL,
  `news_per_page` smallint(6) DEFAULT NULL,
  `products_per_page` smallint(6) DEFAULT NULL,
  `news_side_per_page` smallint(6) DEFAULT NULL,
  `products_side_per_page` smallint(6) DEFAULT NULL,
  `image_per_page` smallint(6) DEFAULT NULL,
  `google_tracker` varchar(1000) DEFAULT NULL,
  `webmaster_tracker` varchar(200) DEFAULT NULL,
  `order_email_content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of configuration
-- ----------------------------
INSERT INTO `configuration` VALUES ('1', 'cuongdt90@gmail.com', '0', 'Công ty Cổ phần Lưới điện Thông minh', 'Công ty Cổ phần Lưới điện Thông minh', 'Công ty Cổ phần Lưới điện Thông minh', null, '10', '12', '3', '10', '0', '', '', '<table style=\"width: 100%; border: solid 5px #ccc;\" border=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td style=\"padding: 10px;\">\r\n<table style=\"width: 100%;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr style=\"background-color: #339900;\">\r\n<td width=\"200\" align=\"center\" valign=\"middle\"><a href=\"{domain_name}\" target=\"_blank\"> <img style=\"margin-left: 10px; margin-top: 10px;\" src=\"http://www.mrsach.de/images/news/logo.png\" border=\"0\" alt=\"\" width=\"149\" height=\"105\" /></a><br /><br /></td>\r\n<td>\r\n<p style=\"margin-left: 160px; color: white; font-size: 14px;\"><em>Địa chỉ</em>: 6 Trần Nhân Tông - Hai Bà Trưng - Hà Nội<br /> <em>ĐT</em>: 0988888888</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"min-height: 10px;\"></td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Kính gửi quý khách <strong>{receiver}</strong>,<br /> Quý khách đã gửi đơn hàng số <strong>{order_id}</strong> đến {domain_name} vào lúc <em>{time}</em> ngày <em>{date}</em>.                     <br />Chúng tôi sẽ tiến hành xác minh lại và sẽ liên lạc với quý khách trong thời gian sớm nhất<br /> Thông tin các đặt hàng mà quý khách đặt hàng như sau:<br /> Người mua: <strong>{receiver}</strong> - Địa chỉ: <strong>{address}, {district}, {city}</strong> - ĐT: <strong>{phone}</strong><br /> Danh sách mặt hàng:<br /> {all_product}                                                                                    <em> </em></p>\r\n<p><em>Lưu ý: <br /> <span style=\"line-height: 18px; color: red;\"> - Đơn đặt hàng này được lập một cách <strong>tự động</strong> ngay sau khi quý khách thực                         hiện lệnh đặt hàng. Trong một vài trường hợp Email này không phản ánh chính xác                         những thông tin về sản phẩm mà chúng tôi cung cấp. Thông tin chính xác hơn sẽ được                         <strong>nhân viên bán hàng sẽ gọi điện thông báo lại cho quý khách</strong> và xác nhận                         đơn hàng này. Vì vậy nội dung Email này không thể được lấy để làm bằng chứng để                         chứng tỏ rằng chúng tôi đã đồng ý mọi giao dịch về hàng hoá, giá cả, chi phí như                         thông tin ở trên. Quý khách hãy yên tâm, nhân viên bán hàng sẽ liên hệ với quý khách                         trong thời gian sớm nhất.<br /> </span> </em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"min-height: 10px;\"></td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<h1>MR SẠCH</h1>\r\n<strong>Địa chỉ : </strong>6 Trần Nhân Tông - Hai Bà Trưng - Hà Nội 				<br /> <strong>ĐT : </strong>0988888888 				<br /> <strong>Email : </strong>mrsach@gmail.com 				<br /> <strong>Website : </strong>www.mrsach.com.vn</td>\r\n</tr>\r\n</tbody>\r\n</table>');

-- ----------------------------
-- Table structure for `keywords`
-- ----------------------------
DROP TABLE IF EXISTS `keywords`;
CREATE TABLE `keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(256) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of keywords
-- ----------------------------

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(256) NOT NULL,
  `url_path` varchar(512) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `position` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) DEFAULT '1',
  `css` varchar(50) DEFAULT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=134 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES ('1', 'Trang chủ', '/', '500', '1', '1', '', 'vi');
INSERT INTO `menus` VALUES ('3', 'Thêm sản phẩm', '/dashboard/products/add', '55', '2', '1', '', 'vi');
INSERT INTO `menus` VALUES ('4', 'Danh sách sản phẩm', '/dashboard/products', '55', '3', '1', '', 'vi');
INSERT INTO `menus` VALUES ('11', 'Danh mục sản phẩm', '/dashboard/products/categories', '55', '4', '1', '', 'vi');
INSERT INTO `menus` VALUES ('14', 'Tin tức', '/dashboard/news', '500', '3', '1', '', 'vi');
INSERT INTO `menus` VALUES ('16', 'Giới thiệu', '/gioi-thieu.htm', '0', '3', '1', '', 'vi');
INSERT INTO `menus` VALUES ('17', 'Sản phẩm', '/san-pham', '0', '4', '1', '', 'vi');
INSERT INTO `menus` VALUES ('19', 'Liên hệ', '/lien-he', '0', '8', '1', '', 'vi');
INSERT INTO `menus` VALUES ('38', 'Hệ thống Menu', '#', '100', '4', '1', '', 'vi');
INSERT INTO `menus` VALUES ('39', 'Menu trang chủ', '/dashboard/menu', '38', '1', '1', '', 'vi');
INSERT INTO `menus` VALUES ('40', 'Menu quản trị', '/dashboard/menu-admin', '38', '2', '1', '', 'vi');
INSERT INTO `menus` VALUES ('43', 'Hỗ trợ trực tuyến', '/dashboard/supports', '101', '1', '1', '', 'vi');
INSERT INTO `menus` VALUES ('45', 'Danh mục tin tức', '/dashboard/news/categories', '14', '2', '1', '', 'vi');
INSERT INTO `menus` VALUES ('46', 'Banner', '#', '101', '2', '1', '', 'vi');
INSERT INTO `menus` VALUES ('47', 'Banner trang chủ', '/dashboard/advertisements/slide', '46', '1', '1', '', 'vi');
INSERT INTO `menus` VALUES ('124', 'Tư vấn kỹ thuật', '#', '0', '6', '1', '', 'vi');
INSERT INTO `menus` VALUES ('49', 'Khách hàng', '/dashboard/advertisements/partners', '46', '3', '1', '', 'vi');
INSERT INTO `menus` VALUES ('50', 'Trang thông tin', '/dashboard/pages', '101', '3', '1', '', 'vi');
INSERT INTO `menus` VALUES ('55', 'Sản phẩm', '/dashboard/products', '500', '2', '1', '', 'vi');
INSERT INTO `menus` VALUES ('62', 'Đăng tin tức', '/dashboard/news/add', '14', '1', '1', '', 'vi');
INSERT INTO `menus` VALUES ('86', 'Thông tin Cá nhân', '#', '100', '1', '1', '', 'vi');
INSERT INTO `menus` VALUES ('87', 'Đổi mật khẩu', '/dashboard/users/change-password', '86', '1', '1', '', 'vi');
INSERT INTO `menus` VALUES ('94', 'Trang chủ', '/', '0', '1', '1', '', 'vi');
INSERT INTO `menus` VALUES ('98', 'Tin tức', '/tin-tuc-n1', '0', '2', '1', '', 'vi');
INSERT INTO `menus` VALUES ('99', 'Cấu hình chung', '/dashboard/system_config', '100', '2', '1', '', 'vi');
INSERT INTO `menus` VALUES ('100', 'Cấu hình hệ thống', '#', '500', '6', '1', '', 'vi');
INSERT INTO `menus` VALUES ('101', 'Thông tin trang chủ', '#', '500', '4', '1', '', 'vi');
INSERT INTO `menus` VALUES ('132', 'Recruitment', '#', '0', '15', '1', '', 'en');
INSERT INTO `menus` VALUES ('131', 'Technical consultancy', '#', '0', '14', '1', '', 'en');
INSERT INTO `menus` VALUES ('130', 'Services', '#', '0', '13', '1', '', 'en');
INSERT INTO `menus` VALUES ('129', 'Products', '/en/products', '0', '12', '1', '', 'en');
INSERT INTO `menus` VALUES ('128', 'About us', '#', '0', '11', '1', '', 'en');
INSERT INTO `menus` VALUES ('118', 'Dịch vụ ', '#', '0', '5', '1', '', 'vi');
INSERT INTO `menus` VALUES ('133', 'Contact', '/en/contact', '0', '16', '1', '', 'en');
INSERT INTO `menus` VALUES ('125', 'Tuyển dụng', '#', '0', '7', '1', '', 'vi');
INSERT INTO `menus` VALUES ('126', 'Home', '/en', '0', '9', '1', '', 'en');
INSERT INTO `menus` VALUES ('127', 'News', '#', '0', '10', '1', '', 'en');
INSERT INTO `menus` VALUES ('123', 'Đơn vị sản phẩm', '/dashboard/units', '55', '5', '1', '', 'vi');

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `summary` varchar(512) DEFAULT NULL,
  `content` text,
  `created_date` datetime DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `viewed` int(11) DEFAULT '0',
  `thumbnail` varchar(500) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `tags` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `lang` varchar(20) DEFAULT 'vi',
  PRIMARY KEY (`id`),
  KEY `FK_news_categories` (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('3', 'Nam Phi có nhà máy quang năng đầu tiên', 'Nam Phi đã giới thiệu nhà máy điện quang năng được xây dựng tại OR Tambo (Wattville, thành phố Ekurhuleni), có khả năng sản xuất khoảng 200 kW điện qua các tấm pin quang điện trên diện tích 2.500 m². Đây là nhà máy quang năng đầu tiên và duy nhất tại quốc gia này, có khả năng cung cấp điện cho khoảng 133 hộ gia đình.', '<p>Nam Phi đã giới thiệu nhà máy điện quang năng được xây dựng tại OR Tambo (Wattville, thành phố Ekurhuleni), có khả năng sản xuất khoảng 200 kW điện qua các tấm pin quang điện trên diện tích 2.500 m². Đây là nhà máy quang năng đầu tiên và duy nhất tại quốc gia này, có khả năng cung cấp điện cho khoảng 133 hộ gia đình.</p>\r\n<p><img style=\"border: 0pxpx solid black;\" src=\"http://www.sg.de/images/news/namphi1.jpg\" border=\"0px\" alt=\"\" width=\"470\" height=\"353\" /> <br /> Nhà máy điện mặt trời được tạo thành từ các tấm pin mặt trời gắn kết thành chuỗi trên một cấu trúc thép, nó sử dụng công nghệ chuyên sâu như nền đất nện, tường lõi ngô, mái nhà xanh...<br /> <br /> Thị trưởng thành phố Ekurhuleni Mondli Gungubele cho biết, điện được sản xuất từ nhà máy quang năng này sẽ hòa vào lưới điện bằng máy biến tầng 18 và một thiết bị kết nối.<br /> <br /> \"Chúng tôi đang dự kiến dùng một cáp 300 mét nối từ thiết bị kết nối kết hợp, đặt vào một rãnh cáp và kéo tới lưới điện”. Ngoài ra, sẽ có các bóng đèn LED và các pin quang điện riêng phục vụ chiếu sáng, giúp giảm khả năng bị trộm vào ban đêm.<br /> <br /> Máy biến tần được đặt trong nhà lưu trữ, nhằm trực tiếp biến đổi dòng điện thành dòng điện xoay chiều, có thể hòa vào lưới điện thành phố.<br /> <br /> Ông cho biết, các tấm pin quang năng có thể sử dụng được từ 20 - 25 năm, thậm chí là lâu hơn nữa nếu được bảo quản đúng cách.<br /> <br /> Khi được hỏi, liệu quang năng có hoạt động vào ban đêm và trong điều kiện thời tiết nhiều mây hay không, Giám đốc dự án Tshilidzi Thenga cho biết: \"Cái hay của pin quang điện được sử dụng tại nhà máy quang điện Leeupan là chúng vẫn có thể tạo ra điện ngay cả trong thời tiết nhiều mây”.<br /> <br /> Sự ra mắt của các dự án năng lượng tái tạo phù hợp với Chiến lược Năng lượng Ekurhuleni. Trong đó, xác định việc tích cực xúc tiến năng lượng xanh là chìa khóa để mở ra một tương lai bền vững cho đô thị.<br /> <br /> Ông Gungubele cho biết, thành phố này đã cam kết thúc đẩy các công nghệ phát thải ít carbon. Quang năng là một biểu hiện cho thấy sự chăm lo cho con người, cải thiện điều kiện sống của người dân: \"Nhà máy quang năng này cũng báo hiệu những điều lớn hơn tới với thành phố của chúng tôi”.<br /> <br /> \"Xét về mặt tiết kiệm tiêu thụ điện năng, tận dụng mặt trời để giữ gìn trái đất xanh, giữ gìn sức khỏe của con người, công nghệ này chính là tương lai. Nó sẽ đi một bước dài trong việc giúp những người nghèo giảm các chi phí điện năng”. Theo Năng lượng Việt Nam</p>', '2012-12-14 14:40:49', '1', '5', 'http://www.sg.de/images/news/thumbnails/namphi1.jpg', null, '', '', '', '', 'vi');
INSERT INTO `news` VALUES ('4', 'Pin mặt trời hoạt động tốt ở vùng tuyết rơi', 'Trong khi một lớp tuyết tạm thời bao phù các tấm pin mặt trời và khiến chúng ngừng hoạt động, điều này không hề kéo dài, thậm chí ở các những vùng tuyết rơi dày nhất.', '<p>Trong khi một lớp tuyết tạm thời bao phù các tấm pin mặt trời và khiến chúng ngừng hoạt động, điều này không hề kéo dài, thậm chí ở các những vùng tuyết rơi dày nhất.<br /> <br /> Nhà nghiên cứu Joshua Pearce  tại Đại học Công nghệ Michigan cho biết “Thỉnh thoảng, tuyết còn có tác dụng tích cực tới pin mặt trời. Nó có thể khiến tấm pin tạo ra nhiều điện năng hơn theo cách mà nó giúp những người trượt tuyết có làn da rám nắng trong những ngày đông đầy nắng.\"</p>\r\n<p> </p>\r\n<p style=\"text-align: center;\"><img src=\"http://www.sg.de/images/news/Dan_Pin_MT_tren_mai_nha.JPG\" alt=\"\" width=\"491\" height=\"366\" /></p>\r\n<p>Trong nghiên cứu mới, các nhà khoa học tại St. Lawrence College và Queen’s University, cùng với một nhóm 20 đối tác khác đã nghiên cứu ảnh hưởng của tuyết tại phòng thí nghiệm Open Solar Outdoors Test Field.</p>\r\n<p><br /> “Họ tạo ra một mô-đun trên máy tính để ước tính xem với những lượng tuyết bao phủ khác nhau và với các loại pin mặt trời khác nhau, sản lượng năng lượng tạo ra sẽ giảm đi như thế nào. Sau đó, họ điều chỉnh và so sánh mô hình mẫu của họ với các số liệu từ rất nhiều trang trại năng lượng mặt trời lớn đang hoạt động tại Ontario.”</p>\r\n<p><br /> Các nhà khoa học Pearce và R. W. Andrews đã đưa ra một bài viết dựa trên nghiên cứu này mang tên “Ước tính về hiệu suất năng lượng của hệ thống quang điện do ảnh hưởng của tuyết rơi”. Bài viết này được đăng trên tạp chí Photovoltaic Specialists Conference, số 38 năm 2012.</p>', '2012-12-14 14:35:35', '1', '5', 'http://www.sg.de/images/news/thumbnails/Dan_Pin_MT_tren_mai_nha.JPG', null, '', '', '', '', 'vi');
INSERT INTO `news` VALUES ('5', 'Sắp sản xuất được năng lượng hạt nhân từ nước biển', 'Các nhà khoa học tin rằng nghiên cứu 40 năm ròng về phương pháp sản xuất năng lượng hạt nhân từ Urani trong nước biển sắp cho kết quả.', '<p>Các nhà khoa học tin rằng nghiên cứu 40 năm ròng về phương pháp sản xuất năng lượng hạt nhân từ Urani trong nước biển sắp cho kết quả.</p>\r\n<p style=\"margin: 0px; padding: 0px 0px 10px; border: 0px; outline: 0px; font-size: 13px; vertical-align: baseline; background-color: #ffffff; font-family: Verdana, Geneva, sans-serif; line-height: 17.149999618530273px;\">Theo Hội Hóa học Hoa Kỳ, ước tính có ít nhất khoảng 4 tỷ tấn urani trong nước biển và nước biển có thể góp phần tăng sản lượng năng lượng hạt nhân. Đây là ý tưởng được trình bày tại Hội nghị và triển lãm quốc gia Hoa Kỳ lần thứ 244 ở Philadelphia.</p>\r\n<p style=\"margin: 0px; padding: 0px 0px 10px; border: 0px; outline: 0px; font-size: 13px; vertical-align: baseline; background-color: #ffffff; font-family: Verdana, Geneva, sans-serif; line-height: 17.149999618530273px;\"><span style=\"line-height: 17.149999618530273px;\">Tiến sĩ Robin D. Rogers, tác giả của nghiên cứu này cho biết đại dương là nguồn trữ urani lớn hơn tất cả những mỏ urani trên cạn có thể khai thác được. Vấn đề ở chỗ, nồng độ chất này rất thấp nên chi phí chiết xuất sẽ cao.</span></p>\r\n<p style=\"text-align: center; margin: 0px; padding: 0px 0px 10px; border: 0px; outline: 0px; font-size: 13px; vertical-align: baseline; background-color: #ffffff; font-family: Verdana, Geneva, sans-serif; line-height: 17.149999618530273px;\"><img style=\"border: 0pxpx solid black;\" src=\"http://www.sg.de/images/news/22812_KHCN_Uranium-500x373.jpg\" border=\"0px\" alt=\"\" width=\"500\" height=\"373\" /></p>\r\n<p style=\"text-align: justify; margin: 0px; padding: 0px 0px 10px; border: 0px; outline: 0px; font-size: 13px; vertical-align: baseline; background-color: #ffffff; font-family: Verdana, Geneva, sans-serif; line-height: 17.149999618530273px;\"> </p>\r\n<p class=\"wp-caption-text\" style=\"margin: 0px; padding: 0px 0px 10px; border: 0px; outline: 0px; font-size: 0.8em; vertical-align: baseline; background-color: transparent; color: #222222; width: auto; line-height: normal; font-family: verdana, arial, sans-serif; text-align: center;\">Đại dương có trữ lượng Urani dồi dào (Shutterstock)</p>\r\n<p style=\"margin: 0px; padding: 0px 0px 10px; border: 0px; outline: 0px; vertical-align: baseline; line-height: 17.149999618530273px; text-align: start;\">Phân tích kinh tế của Tiến sỹ Erich Schneider cho Bộ Năng lượng Hoa Kỳ (DOE) so sánh khai thác urani từ nước biển với các phương pháp khai thác quặng urani cho thấy, các kỹ thuật được DOE tài trợ có thể khai thác lượng urani nhiều gấp 2 lần so với sản lượng ở Nhật vào cuối thập niên 90. Vì vậy, chi phí sản xuất sẽ giảm đi gần 50% so với công nghệ của Nhật.</p>\r\n<p style=\"margin: 0px; padding: 0px 0px 10px; border: 0px; outline: 0px; vertical-align: baseline; line-height: 17.149999618530273px; text-align: start;\">Tuy vậy, chiết xuất urani từ nước biển vẫn đắt hơn nhiều so với khai thác quặng. Cũng theo TS. Schneider, hiện không chắc chắn được về trữ lượng urani trên cạn nên khó có thể lập kế hoạch sản xuất dài hạn. Vì vậy, nếu khai thác urani từ nước biển thì sẽ khắc phục được hạn chế này đồng thời còn giảm một số tổn thất môi trường mà khai thác quặng gây ra như nước thải.</p>\r\n<p><strong>Theo thiennhien.net</strong></p>', '2012-12-14 14:40:38', '1', '4', 'http://www.sg.de/images/news/thumbnails/22812_KHCN_Uranium-500x373.jpg', null, '', '', '', '', 'vi');
INSERT INTO `news` VALUES ('6', 'Sử dụng năng lượng tiết kiệm và hiệu quả: Trông người để ngẫm đến ta', 'Sử dụng năng lượng tiết kiệm và hiệu quả là một trong những vấn đề được nhiều nước quan tâm và thực hiện thành công. Đây là bài học kinh nghiệm vô cùng bổ ích cho Việt Nam, tạo đà cho bước chuyển từ nhận thức đến hành động.', '<p>Kinh nghiệm thế giới<br /> <br /> Tại Cộng hòa Pháp, Chính phủ đã ban hành chính sách sử dụng năng lượng hiệu quả và phát triển năng lượng tái tạo với 4 mục tiêu chính: Bảo đảm an ninh; cung cấp năng lượng; đấu tranh chống biến đổi khí hậu; nâng cao tính cạnh tranh của nền kinh tế thông qua tiết kiệm năng lượng; tạo công ăn việc làm, đặc biệt trong lĩnh vực xây dựng và năng lượng tái tạo.<br /> <br /> Đối với khu vực tòa nhà – nơi tiêu thụ năng lượng nhiều nhất (chiếm 42,5%) và thải ra 23% khí thải gây hiệu ứng nhà kính, Chính phủ Pháp đã ban hành quy định bắt buộc phải đánh giá hiện trạng hiệu suất sử dụng năng lượng đối với các hoạt động bán và cho thuê nhà. Trong các tòa nhà, nếu sử dụng các thiết bị có hiệu quả năng lượng cao, người sử dụng sẽ được khấu trừ thuế ở mức tương đương từ 25% - 40% chi phí thiết bị và được khấu trừ ở mức 50% nếu mua các thiết bị sử dụng năng lượng tái tạo.</p>\r\n<p><img src=\"http://www.sg.de/images/news/nuoc_phap2.jpg\" alt=\"\" width=\"600\" height=\"400\" /><br /> Hệ thống truyền thông của Pháp được phân cấp tới 26 cơ quan đại diện cấp vùng, với mục đích truyền tải thông tin một cách tốt nhất, nhanh nhất tới đối tượng cần tác động. Đó là cách duy nhất để tạo ra thay đổi trong hành vi, không chỉ đối với chuyên gia năng lượng, mà còn đối với các tác nhân kinh tế, truyền thông, giáo dục và xã hội dân sự. Hiện đã có 200 điểm Thông tin Năng lượng do 350 chuyên gia tư vấn phụ trách, với hơn một triệu lượt người được thông tin miễn phí hàng năm.<br /> <br /> Trong khi đó, tại Thái Lan đã thành lập một quỹ riêng (ENCON) chuyên tài trợ cho các hoạt động nâng cao hiệu quả năng lượng. Với nguồn thu khoảng 50 triệu USD/năm, ENCON cho phép tài trợ nhiều hoạt động khác nhau như: Thông tin, tuyên truyền, tăng cường năng lực, triển khai các dự án trọng điểm, hỗ trợ kỹ thuật, tài chính, xây dựng quy chuẩn và tiêu chuẩn, khuyến khích phát triển các loại năng lượng thay thế cho dầu lửa…<br /> <br /> Quỹ ENCON còn rót vốn cho một quỹ lưu động có tên gọi Energy Conservation Promotion Fund (ECP). Quỹ này được dành cho mục đích khuyến khích các ngân hàng cấp tín dụng ưu đãi cho các dự án sử dụng hiệu quả năng lượng. Các khoản vay do ngân hàng chấp thuận, có thể lên tới 1,2 triệu USD cho một dự án, lãi suất dưới 4%/năm và thời hạn hoàn vốn là 7 năm. Vụ Phát triển các loại năng lượng thay thế và hiệu quả năng lượng Thái Lan là đơn vị hỗ trợ về mặt kỹ thuật.<br /> <br /> Bên cạnh đó, hơn 4.900 tòa nhà và nhà máy tiêu hao nhiều năng lượng ở Thái Lan còn chịu sự điều tiết của một loạt các quy định như, quy định bắt buộc chỉ định một người phụ trách về năng lượng; công bố hàng tháng mức tiêu hao năng lượng; xây dựng các mục tiêu về sử dụng năng lượng hiệu quả và kế hoạch hành động cụ thể; tiến hành đầu tư, quy định bắt buộc về theo dõi kết quả tiết kiệm.</p>\r\n<p> </p>\r\n<p>Chính phủ Pháp yêu cầu phải đánh giá hiện trạng hiệu suất sử dụng năng lượng đối với các tòa nhà. (Ảnh minh họa)</p>\r\n<p><br /> Còn với Việt Nam…<br /> <br /> Kinh tế Việt Nam đang tăng trưởng, nhu cầu năng lượng, đặc biệt là, nhu cầu về điện cho sản xuất và sử dụng ngày càng tăng. Dự báo nhu cầu năng lượng của cả nền kinh tế và các ngành sản xuất, dịch vụ sẽ tăng khoảng 22 – 25%/năm. Mặc dù đã triển khai nhiều dự án lớn nhằm xây dựng các nhà máy điện, song Chính phủ vẫn đang gặp rất nhiều khó khăn trong việc đối phó với tình trạng thiếu điện như hiện nay.<br /> <br /> Kể từ khi các văn bản về sử dụng năng lượng tiết kiệm và hiệu quả được ban hành, nhận thức của cộng đồng về sử dụng năng lượng tiết kiệm, hiệu quả đã dần dần được nâng lên. Tuy nhiên, năng lực để triển khai các cơ chế hỗ trợ, giám sát và thực hiện còn yếu, sự phối hợp giữa các cơ quan trung ương và địa phương chưa được tốt. Giá năng lượng quá thấp, không khuyến khích người tiêu dùng tiết kiệm. Các biện pháp xử phạt còn chưa đủ tính răn đe và thiếu đồng bộ.<br /> <br /> Trong nhân dân cũng như đối với doanh nghiệp, ý thức sử dụng năng lượng tiết kiệm và hiệu quả còn hạn chế. Vì thế, Việt Nam không thể chỉ dừng lại ở đầu tư nhằm tăng cường năng lực sản xuất năng lượng, mà cần nỗ lực để cải thiện hiệu quả năng lượng, đặc biệt là trong việc quản lý sử dụng năng lượng sẽ cho hiệu suất cao hơn so với việc xây dựng các đơn vị sản xuất mới.<br /> <br /> Tiềm năng tiết kiệm năng lượng còn rất lớn trong tất cả các lĩnh vực của nền kinh tế như: Thiết kế nhà, quản lý và quy hoạch thành phố, tổ chức giao thông, hiện đại hóa các công cụ công nghiệp, hệ thống biểu giá cho năng lượng tái tạo… Chỉ trên cơ sở huy động toàn bộ các tác nhân trong mọi lĩnh vực cùng tiết kiệm và sử dụng năng lượng hiệu quả, dưới hình thức này hay hình thức khác, mới có thể hướng đến sự phát triển bền vững cho cả cộng đồng.<br /> <br /> Chính vì vậy, các chính sách hiệu quả năng lượng thành công nhất chính là các chính sách kết hợp phát minh đổi mới kỹ thuật, cơ cấu lại tổ chức và thay đổi hành vi.</p>', '2012-12-14 14:40:20', '1', '2', 'http://www.sg.de/images/news/thumbnails/nuoc_phap2.jpg', null, '', '', '', '', 'vi');
INSERT INTO `news` VALUES ('7', 'Những công trình năng lượng mặt trời lớn nhất thế giới', 'Hạn chế phụ thuộc vào năng lượng hóa thạch, đẩy mạnh sử dụng năng lượng tái tạo nhằm bảo vệ môi trường, là xu hướng chung của các quốc gia trên thế giới.', '<p>Tòa nhà Sun and the Moon Altar (Trung Quốc)</p>\r\n<p><img src=\"http://www.sg.de/images/news/Toa_nha_Sun-Moon_Altar_TQ.jpg\" alt=\"\" width=\"600\" height=\"391\" /></p>\r\n<p>Tòa nhà có mái rộng 75.000 m2, xòe rộng như một chiếc quạt, tọa lạc tại thành phố Đức Châu, tỉnh Sơn Đông, Tây Bắc Trung Quốc. Không sử dụng năng lượng hóa thạch, đây là công trình kiến trúc xanh, kết hợp nhiều nguồn năng lượng tái tạo khác nhau và áp dụng các biện pháp tiết kiệm năng lượng. Tường và mái nhà sử dụng vật liệu cách nhiệt, có thể làm giảm 30% điện năng tiêu thụ. Kết cấu thép bên trong của tòa nhà cũng chỉ sử dụng bằng 1% so với lượng thép sử dụng để xây dựng sân vận động “Tổ chim” (nơi đã tổ chức Olympic 2008) tại Trung Quốc.<br /> <br /> Tòa nhà được chia thành nhiều khu vực như: Trung tâm triển lãm, phòng nghiên cứu khoa học, hội trường lớn và một khách sạn. Toàn bộ năng lượng phục vụ cho các hoạt động diễn ra trong tòa nhà được cung cấp bởi các tấm pin năng lượng mặt trời.<br /> <br /> Tòa nhà được coi là một điển hình trong việc tìm kiếm nguồn năng lượng mới thay thế cho năng lượng hóa thạch đang gây ô nhiễm nghiêm trọng tại đất nước này.</p>\r\n<p>Sân vận động World Games (Đài Loan)</p>\r\n<p><img src=\"http://www.sg.de/images/news/World_Games.jpg\" alt=\"\" width=\"600\" height=\"291\" /></p>\r\n<p> </p>\r\n<p>Khác với các sân vận động khép kín trên thế giới, World Games có kết cấu mở. Với kiểu dáng bán xoắn ốc, nó giống như một con rồng đang cuộn mình khi nhìn từ trên cao xuống.<br /> <br /> Với sức chứa 55.000 khán giả, tọa lạc trên một khu đất với diện tích 19 hecta ở thành phố Cao Hùng (Kaohsiung), mái sân rộng 14.155 m2, được tích hợp 8.844 tấm pin năng lượng mặt trời và có thể sản xuất khoảng 1,4 triệu kWh điện/năm, đủ để cung cấp điện cho 3.300 bóng đèn, 2 màn hình tivi khổng lồ và hệ thống phát thanh trong sân. Vào những thời điểm World Games không hoạt động, 80% dân cư khu vực xung quanh có thể sử dụng nguồn điện này.<br /> <br /> Việc sử dụng nguồn năng lượng từ sân vận động World Games đã giúp giảm thiểu được 660 tấn CO2 thải vào khí quyển.<br /> <br /> Nhà máy điện mặt trời PS20 (Tây Ban Nha)</p>\r\n<p><img src=\"http://www.sg.de/images/news/PS20.jpg\" alt=\"\" width=\"600\" height=\"400\" /></p>\r\n<p>PS20 bao gồm 1.255 tấm gương lớn có thể di chuyển được (còn gọi là kính định nhật), nằm xung quanh một tháp tích trữ năng lượng khổng lồ, gần thành phố Sevilla, Tây Ban Nha. Mỗi kính định nhật rộng hơn 350 m2 và tổng diện tích kính bao phủ toàn bộ khu vực là khoảng 155.000 m2.<br /> <br /> Trong một ngày, kính định nhật sẽ xoay theo 2 trục hướng về mặt trời và tập trung bức xạ đến một bình chứa ở phần trên ngọn tháp cao 162 m. Sau đó, bình chứa chuyển đổi 92% ánh sáng nhận được thành dòng hơi nước, dẫn xuống một turbine làm chạy máy phát điện ở chân tháp.<br /> <br /> Nhà máy điện mặt trời PS20 được xây dựng từ năm 2006, hoàn thành và đi vào hoạt động trong năm 2009. PS20 có thể sản xuất được 48.000 MWh/năm, cung cấp cho 10.000 hộ gia đình trong khu vực, giúp giảm khoảng 12.000 tấn co2 vào khí quyển (giảm 2 lần so với tòa nhà PS10 được xây dựng trước đó).<br /> <br /> Thuyền Planet Solar</p>\r\n<p><img src=\"http://www.sg.de/images/news/Planet_Solar.jpg\" alt=\"\" width=\"600\" height=\"450\" /></p>\r\n<p>Con thuyền được chế tạo tại xưởng đóng tàu Knierim Yachtbau ( Kiel, Đức), với chi phí 17 triệu USD. Con thuyền này không có cánh buồm, mà di chuyển nhờ vào năng lượng mặt trời.<br /> <br /> Nặng 95 tấn, dài 31 m, rộng gần 16 m. Con thuyền được trang bị các tấm pin năng lượng mặt trời với tổng diện tích 537 m2 để thuyền có thể đạt tốc độ tối đa khoảng 25 km/giờ.<br /> <br /> Đây cũng chính là con thuyền đã xuất phát từ Monte Carlo ( Monaco) vào ngày 27/9/2010, để thực hiện cuộc hành trình vòng quanh thế giới với thông điệp về chống biến đổi khí hậu. Trên hành trình du ngoạn, Planet Solar đã ghé qua thành phố biển Nha Trang (Việt Nam) vào ngày 29/8/2011 và lưu lại đây đến ngày 1/9/2011. <strong></strong></p>\r\n<p><strong>Theo TCĐL chuyên đề Thế giới điện</strong></p>', '2012-12-14 14:43:38', '1', '21', 'http://www.sg.de/images/news/thumbnails/Planet_Solar.jpg', null, '', '', '', '', 'vi');
INSERT INTO `news` VALUES ('8', 'Tây Ban Nha đẩy mạnh sử dụng năng lượng sạch', 'Cùng với Đức và Đan Mạch, Tây Ban Nha là một trong 3 nước ở Châu Âu phát triển năng lượng gió mạnh mẽ.', '<p>Cùng với Đức và Đan Mạch, Tây Ban Nha là một trong 3 nước ở Châu Âu phát triển năng lượng gió mạnh mẽ.</p>\r\n<p> </p>\r\n<p style=\"text-align: center;\"><img src=\"http://www.sg.de/images/news/taybannha.jpg\" alt=\"\" width=\"400\" height=\"293\" /></p>\r\n<p>Nước này đã đặt ra kế hoạch sử dụng giao thông chạy bằng nhiên liệu sạch 20% vào năm 2015, đồng thời khẳng định tập trung phát triển năng lượng tái tạo trong đó có 40% năng lượng gió.</p>\r\n<p>Chính phủ nước này khẳng định sự cần thiết phải phát triển nền kinh tế xanh, năng lượng sạch để giải quyết những vấn đề bức xúc.  Đây là con đường giúp đất nước thoát khỏi cuộc khủng hoảng kinh tế. Sự kết hợp giữa ngành công nghiệp năng lượng bền vững, giao thông vận tải hiệu quả, công nghiệp xây dựng xanh và nền giáo dục sinh thái sẽ làm cho Tây Ban Nha có cuộc sống ngày một tốt hơn, chất lượng sống ngày một cao hơn. Theo các nhà lãnh đạo, ngành công nghiệp sinh thái bền vững và bảo tồn năng lượng có thể giải quyết những khó khăn về năng lượng và tạo công ăn việc làm trong nước trong thập kỷ tiếp theo.<br /> <br /> Chính phủ Tây Ban Nha cho rằng từ trước đến nay, chính phủ đã có những biện pháp đúng đắn thúc đẩy người dân và doanh nghiệp sử dụng năng lượng gió, giảm bớt năng lượng hạt nhân. Giờ đây, với những biện pháp hiệu quả, chắc chắn Tây Ban Nha vẫn và sẽ tiếp tục là một trong những nước tiên phong về năng lượng tái tạo.</p>\r\n<p><strong>Theo EVNNews.vn</strong></p>', '2012-12-14 14:44:44', '1', '12', 'http://www.sg.de/images/news/thumbnails/taybannha.jpg', null, '', '', '', '', 'vi');
INSERT INTO `news` VALUES ('9', 'Thủy điện xanh đầu tiên của Việt Nam sắp phát điện', 'Ngày 9/4, ông Nguyễn Hữu Hát - Phó Giám đốc Ban Quản lý dự án thủy điện Chiêm Hóa cho biết sau gần 3 năm thi công, công trình thủy điện xanh đầu tiên của Việt Nam sẽ phát điện tổ máy số 1 vào cuối tháng Tư.', '<p>Ngày 9/4, ông Nguyễn Hữu Hát - Phó Giám đốc Ban Quản lý dự án thủy điện Chiêm Hóa cho biết sau gần 3 năm thi công, công trình thủy điện xanh đầu tiên của Việt Nam sẽ phát điện tổ máy số 1 vào cuối tháng Tư.</p>\r\n<table style=\"width: 100px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" align=\"left\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\"><img src=\"http://www.sg.de/images/news/TDChiemhoa.jpg\" alt=\"\" width=\"300\" height=\"225\" /></td>\r\n</tr>\r\n<tr>\r\n<td align=\"center\"><span style=\"font-size: 8pt; color: #6b6b6b;\">Thi công xây dựng Nhà máy thủy điện Chiêm Hóa. (Nguồn: Báo Tuyên Quang)</span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Công trình Nhà máy thủy điện Chiêm Hóa có tổng vốn đầu tư trên 1.700 tỷ đồng do Công ty cổ phần đầu tư xây dựng và thương mại Quốc tế làm chủ đầu tư. Khi hoàn thành, nhà máy sẽ có 3 tổ máy với tổng công suất 48MW.<br /> Đây là công trình thủy điện cột nước thấp đầu tiên của Việt Nam với nhiều ưu điểm vượt trội so với các công trình thủy điện cột nước cao. Sử dụng công nghệ Tuabin bóng đèn chạy thẳng, nên chỉ cần mực nước chênh lệch trên 2,5m là nhà máy có thể phát điện.<br /> Ngoài ưu điểm diện tích mặt nước phần lòng hồ không lớn, hạn chế tối đa di dân, giải phóng mặt bằng, đặc trưng của công nghệ cột nước thấp là dòng chảy gần như vẫn giữ nguyên theo tự nhiên vốn có, nên ít gây tác động đến môi trường.   Ông Trần Thế Sơn - Trưởng phòng Quản lý giám sát thi công, Ban Quản lý dự án thủy điện Chiêm Hóa cho biết hiện công trình đã hoàn thành trên 90% công tác xây dựng các hạng mục như: nhà máy, trạm phân phối điện 110KV, đập trọng lực bờ trái, đường dây 110KV đấu nối với hệ thống điện quốc gia.<br /> <br /> Các thiết bị của tổ máy số 1 như rôto, bánh xe công tác, hệ thống cửa van, cơ cấu hướng nước cũng đang được lắp ráp. Dự kiến đến tháng 10/2012, nhà máy sẽ phát điện tổ máy cuối cùng./. <strong>(TTXVN)</strong></p>', '2012-12-15 14:46:17', '1', '3', 'http://www.sg.de/images/news/thumbnails/TDChiemhoa.jpg', null, '', '', '', '', 'vi');
INSERT INTO `news` VALUES ('14', 'Ladywood Furniture Project', 'Ladywood Furniture Project (Lfp) aim to help anyone in Birmingham who has a genuine need of furniture.', '<p class=\"style13\"><span style=\"text-decoration: underline;\">OUR AIMS</span></p>\r\n<p class=\"style9\">Ladywood Furniture Project (Lfp) aim to help anyone in Birmingham who has a genuine need of furniture.</p>\r\n<p class=\"style9\">The charity has two core aims and objectives:</p>\r\n<ul>\r\n<li class=\"style9\"> Firstly to help individuals and families on benefits or low income find good, clean affordable furniture; </li>\r\n<li class=\"style9\"> Secondly to help local people develop employment skills through volunteering in their community. </li>\r\n</ul>\r\n<p class=\"style9\">Lfp charge for furniture but items are priced at affordable levels and the charges makes a small contribution to meeting volunteer expenses.</p>\r\n<p class=\"style13\"><span style=\"text-decoration: underline;\">PRINCIPLES</span></p>\r\n<ul>\r\n<li><span class=\"style9\">Lfp Was set up to help people in need by supplying them with good quality furniture at minimum cost;</span></li>\r\n<li class=\"style11\"> <span class=\"style9\">Lfp is a registered charity;</span></li>\r\n<li class=\"style9\">Lfp is a voluntary project recognised by Birmingham City Council;</li>\r\n<li class=\"style9\">Lfp only deals with people who have been referred by a recognised referral agency;</li>\r\n<li class=\"style9\">Lfp encourages customers to choose their own items of furniture;</li>\r\n<li class=\"style9\">Lfp operates on a first come first served basis;</li>\r\n<li class=\"style9\">Lfp is dependant upon a workforce of volunteers to carry out the collection and delivery of furniture.</li>\r\n<li class=\"style9\">Lfp relies on donations of furniture from the public;</li>\r\n<li class=\"style9\">Lfp aims to provide structured work experience for volunteers and a package of training to help them gain employment;</li>\r\n<li class=\"style9\">Lfp has a voluntary Board of Directors;</li>\r\n<li class=\"style9\">Lfp help Birmingham to re-cycle.</li>\r\n</ul>', '2012-12-15 11:13:00', '5', '7', 'http://www.dpi.dep/images/news/thumbnails/thap2.jpg', null, '', '', '', '', 'en');
INSERT INTO `news` VALUES ('15', 'Birmingham Economic Development Department and City Housing Department', 'Ladywood Furniture Project came into being in 1989 following the decision of the Department of Social Security to no longer offer grants to assist families furnishing new homes. In the beginning Ladywood Furniture Project, relied heavily on the good will of Community Services to collect and distribute furniture donated by the general public.', '<p class=\"style9\">Ladywood Furniture Project came into being in 1989 following the decision of the Department of Social Security to no longer offer grants to assist families furnishing new homes. In the beginning Ladywood Furniture Project, relied heavily on the good will of Community Services to collect and distribute furniture donated by the general public.</p>\r\n<p class=\"style9\">This severely restricted Lfp’s ability to provide assistance to those who needed help and there were severe problems making collections and deliveries with a vehicle only available one day each week.</p>\r\n<p class=\"style9\">Lfp was operated by a group of local people, working as volunteers, who formed the original management group, meeting from time to time, to discuss and form ideas of developing the project to its full potential,</p>\r\n<p class=\"style9\">In its infancy Lfp was located in an unused block of maisonettes, Cavell House, having the use of two of the ground floor properties, one of which was shared with The Babywood Project (a day nursery) and the other used as a store and showroom for furniture.</p>\r\n<p class=\"style9\">In 1992 a decision was made to apply to the “Ladywood Anti Poverty Initiative” for funding to employ two full time workers, at the same time Birmingham Economic Development Department was approached for funds to buy a vehicle. This application was successful and a Ford Cargo Van was purchased. In addition sufficient funds were made available to employ two full time staff for twelve months.</p>\r\n<p class=\"style9\">In 1994 with the support of the Birmingham Economic Development Department and City Housing Department, Lfp applied to the Inner City Partnership programme for funding and the application was successful, assuring a further four years.</p>\r\n<p class=\"style9\">Ladywood Furniture Project was encouraged to use this time to become self-reliant and various initiatives were tried, including offering a furniture removal service to fund its core activity. It proved impossible to make the supply of furniture self-financing without raising our charges to a level that would exclude the very people that needed help and defeated our objectives. For a long period it looked like Lfp was doomed but Birmingham City Council recognised the community need and kept the project afloat.</p>\r\n<p class=\"style9\">In the last three years, Lfp have been fortunate to secure commercial contracts that have generated sufficient revenue to meet most of its furniture service operating costs and along with a small amount of funding through the Neighbourhood Renewal Fund the service has been able to help families across Birmingham.</p>\r\n<p class=\"style9\">Currently the commercial work enables Lfp to employ thirteen paid staff and support an enthusiastic group of volunteers.</p>', '2012-12-15 11:14:47', '5', '3', 'http://www.dpi.dep/images/news/thumbnails/anhso12-doghoto.jpg', null, '', '', '', '', 'en');

-- ----------------------------
-- Table structure for `news_categories`
-- ----------------------------
DROP TABLE IF EXISTS `news_categories`;
CREATE TABLE `news_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(256) NOT NULL,
  `parent_id` tinyint(4) DEFAULT NULL,
  `position` tinyint(4) DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `tags` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `lang` varchar(20) DEFAULT 'vi',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of news_categories
-- ----------------------------
INSERT INTO `news_categories` VALUES ('1', 'Tin tức', '0', '1', '', '', null, null, 'vi');
INSERT INTO `news_categories` VALUES ('2', 'Dịch vụ', '0', '2', '', '', null, null, 'vi');
INSERT INTO `news_categories` VALUES ('3', 'Tư vấn kỹ thuật', '0', '3', '', '', '', null, 'vi');
INSERT INTO `news_categories` VALUES ('5', 'News', '0', '4', '', '', '', null, 'en');
INSERT INTO `news_categories` VALUES ('6', 'Services', '0', '5', '', '', '', null, 'en');
INSERT INTO `news_categories` VALUES ('7', 'Projects', '0', '6', '', '', '', null, 'en');

-- ----------------------------
-- Table structure for `pages`
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `uri` varchar(255) NOT NULL,
  `content` text,
  `created_date` datetime DEFAULT NULL,
  `viewed` int(11) DEFAULT NULL,
  `summary` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `tags` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('1', 'Giới thiệu', '/gioi-thieu.htm', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '2012-12-12 17:48:04', null, '<h2 class=\"title\">Giới thiệu</h2>\r\n<div class=\"content_detail justify\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.      Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.      Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.      Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>', '', '', '', '', '1');
INSERT INTO `pages` VALUES ('16', 'Introduction', '/en/introduction.htm', '<div class=\"introduction\"><img class=\"image_intro\" src=\"/images/introduction.jpg\" alt=\"\" />\r\n<h3 class=\"title\">Introduction</h3>\r\n<p>Ladywood Furniture Project came into being in 1989 following the decision of the Department of Social Security to no longer offer grants to assist families furnishing new homes. In the beginning Ladywood Furniture Project, relied heavily on the good will of Community Services to collect and distribute furniture donated by the general public.</p>\r\n<p>Ladywood Furniture Project came into being in 1989 following the decision of the Department of Social Security to no longer offer grants to assist families furnishing new homes. In the beginning Ladywood Furniture Project, relied heavily on the good will of Community Services to collect and distribute furniture donated by the general public.</p>\r\n</div>', '2012-12-15 16:26:26', null, '<h2 class=\"title\">Giới thiệu</h2>\r\n<div class=\"justify content_detail\">Lorem ipsum dolor sit amet,  consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore  et dolore magna aliqua.      Ut enim ad minim veniam, quis nostrud  exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.       Duis aute irure dolor in reprehenderit in voluptate velit esse cillum  dolore eu fugiat nulla pariatur.      Excepteur sint occaecat cupidatat  non proident, sunt in culpa qui officia deserunt mollit anim id est  laborum.</div>\r\n<p>ribute furniture donated by the general public.</p>', '', '', '', '', '1');
INSERT INTO `pages` VALUES ('13', 'Chân trang', '/chan-trang', '<table style=\"width: 100%;\">\r\n<tbody>\r\n<tr>\r\n<td><strong>GIỚI THIỆU</strong> \r\n<ul>\r\n<li><a href=\"#\">Tổng quan</a></li>\r\n<li><a href=\"#\">Triết lý kinh doanh</a></li>\r\n<li><a href=\"#\">Đối tác chiến lược</a></li>\r\n</ul>\r\n</td>\r\n<td><strong>CHÍNH SÁCH</strong> \r\n<ul>\r\n<li><a href=\"#\">Chính sách bảo hành</a></li>\r\n<li><a href=\"#\">Chính sách vận chuyển</a></li>\r\n<li><a href=\"#\">Chính sách hỗ trợ</a></li>\r\n<li><a href=\"#\">Dịch vụ sửa chữa</a></li>\r\n</ul>\r\n</td>\r\n<td><strong>TRỢ GIÚP MUA HÀNG</strong> \r\n<ul>\r\n<li><a href=\"#\">Hướng dẫn mua hàng</a></li>\r\n<li><a href=\"#\">Trợ giúp thông tin</a></li>\r\n<li><a href=\"#\">Phương thức thanh toán</a></li>\r\n<li><a href=\"#\">Hình thức mua hàng</a></li>\r\n</ul>\r\n</td>\r\n<td><strong>TƯ VẤN</strong> \r\n<ul>\r\n<li><a href=\"#\">Hướng dẫn sử dụng</a></li>\r\n<li><a href=\"#\">Tư vấn thiết kế</a></li>\r\n<li><a href=\"#\">Tư vấn lắp đặt</a></li>\r\n</ul>\r\n</td>\r\n<td style=\"width: 265px;\"><strong>LIÊN HỆ</strong>\r\n<p><strong>Công ty Cổ phần Lưới điện Thông minh<br /></strong></p>\r\n<strong>Địa chỉ :</strong> 59 Vạn Kiếp - Chương Dương - Hoàn Kiếm - Hà Nội<br />\r\n<p><strong>ĐT :</strong> 043 9843829</p>\r\n<p><strong>Website :</strong> <a href=\"#\">indongho.vn</a></p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '2012-12-05 17:31:19', null, '<p>...</p>', '', '', '', '', '1');
INSERT INTO `pages` VALUES ('18', '[EN] Chân trang', '/en/footer', '<table style=\"width: 100%;\">\r\n<tbody>\r\n<tr>\r\n<td><strong>GIỚI THIỆU</strong> \r\n<ul>\r\n<li><a href=\"#\">Overwiew</a></li>\r\n<li><a href=\"#\">Triết lý kinh doanh</a></li>\r\n<li><a href=\"#\">Đối tác chiến lược</a></li>\r\n</ul>\r\n</td>\r\n<td><strong>CHÍNH SÁCH</strong> \r\n<ul>\r\n<li><a href=\"#\">Chính sách bảo hành</a></li>\r\n<li><a href=\"#\">Chính sách vận chuyển</a></li>\r\n<li><a href=\"#\">Chính sách hỗ trợ</a></li>\r\n<li><a href=\"#\">Dịch vụ sửa chữa</a></li>\r\n</ul>\r\n</td>\r\n<td><strong>TRỢ GIÚP MUA HÀNG</strong> \r\n<ul>\r\n<li><a href=\"#\">Hướng dẫn mua hàng</a></li>\r\n<li><a href=\"#\">Trợ giúp thông tin</a></li>\r\n<li><a href=\"#\">Phương thức thanh toán</a></li>\r\n<li><a href=\"#\">Hình thức mua hàng</a></li>\r\n</ul>\r\n</td>\r\n<td><strong>TƯ VẤN</strong> \r\n<ul>\r\n<li><a href=\"#\">Hướng dẫn sử dụng</a></li>\r\n<li><a href=\"#\">Tư vấn thiết kế</a></li>\r\n<li><a href=\"#\">Tư vấn lắp đặt</a></li>\r\n</ul>\r\n</td>\r\n<td style=\"width: 265px;\"><strong>LIÊN HỆ</strong>\r\n<p><strong>Công ty Cổ phần Lưới điện Thông minh<br /></strong></p>\r\n<strong>Địa chỉ :</strong> 59 Vạn Kiếp - Chương Dương - Hoàn Kiếm - Hà Nội<br />\r\n<p><strong>ĐT :</strong> 043 9843829</p>\r\n<p><strong>Website :</strong> <a href=\"#\">indongho.vn</a></p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '2012-12-20 14:49:56', null, '<p>...</p>', '', '', '', '', '1');
INSERT INTO `pages` VALUES ('8', 'Liên hệ', '/thong-tin-lien-he', '<p><strong>Nội thật gỗ online</strong></p>\r\n<p>Điện thoại : 0198888888</p>\r\n<p>Địa chỉ : 631, Kim Ngưu, Hai Bà Trưng</p>', '2012-10-04 11:20:28', null, '<p>...</p>', '', '', '', '', '-1');

-- ----------------------------
-- Table structure for `products`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(150) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `price` double DEFAULT NULL,
  `summary` text,
  `description` text,
  `users_id` int(11) DEFAULT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `viewed` int(11) DEFAULT '0',
  `status` tinyint(4) DEFAULT NULL,
  `top_seller` tinyint(4) DEFAULT NULL,
  `tags` text,
  `unit_id` tinyint(4) DEFAULT NULL,
  `lang` varchar(20) DEFAULT 'vi',
  `meta_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `meta_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_products_users` (`users_id`),
  KEY `fk_products_categories` (`categories_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('7', 'Dây chì trung thế', '2012-12-12 10:09:09', '2012-12-12 10:09:09', '0', '0', '<p>Tiêu chuẩn áp dụng: ANSI C37.42</p>\r\n<p>Điện áp định mức: 24-35kV</p>\r\n<p>Dòng điện định mức: 1, 2, 3, 6, 8, 10, 12, 15, 20, 25, 30, 40, 50, 65, 80, 100, 140, 200A</p>\r\n<p>Loại : K</p>\r\n<p>Chiều dài toàn bộ 23 inch (584mm)</p>', null, '6', '1', '1', '0', '', '-1', 'vi', '', '', '');
INSERT INTO `products` VALUES ('8', 'Cầu chì cắt có tải (Polymer)', '2012-12-12 10:10:43', '2012-12-12 10:10:43', '0', '0', '<p>Tiêu chuẩn áp dụng: ANSI C37.41, C37.42, IEC 282-2, IEC 61109</p>\r\n<p>Điện áp định mức: 24kV</p>\r\n<p>Dòng điện định mức: 100 &amp; 200A</p>\r\n<p>Tần số định mức: 50Hz</p>\r\n<p>Khả năng cắt ngắn mạch: 12kA</p>\r\n<p>Điện áp chịu đựng xung (BIL): 150kV</p>\r\n<p>Chiều dài dòng rò: 635mm</p>\r\n<p>Vật liệu cách điện: Silicone Rubber</p>', null, '6', '1', '1', '0', '', '-1', 'vi', '', '', '');
INSERT INTO `products` VALUES ('9', 'Chì Ống Trung Thế', '2012-12-12 10:12:11', '2012-12-12 10:12:11', '0', '0', '<p>Tiêu chuẩn áp dụng: IEC 282-1</p>\r\n<p>Điện áp định mức: 24-35kV</p>\r\n<p>Dòng điện định mức: 6.3, 10, 16, 20, 25, 32, 40, 50, 63, 80, 100A</p>', null, '6', '4', '1', '0', '', '-1', 'vi', '', '', '');
INSERT INTO `products` VALUES ('10', 'Cầu chì cắt có tải (sứ)', '2012-12-12 10:13:11', '2012-12-12 10:13:11', '0', '0', '<p>Tiêu chuẩn áp dụng: ANSI C37.41, C37.42, IEC 282-2</p>\r\n<p>Điện áp định mức: 24kV</p>\r\n<p>Dòng điện định mức: 100 &amp; 200A</p>\r\n<p>Tần số định mức: 50Hz</p>\r\n<p>Khả năng cắt ngắn mạch: 12kA</p>\r\n<p>Điện áp chịu đựng xung (BIL): 125-150kV</p>\r\n<p>Chiều dài dòng rò: 340-440-720mm</p>\r\n<p>Vật liệu cách điện: Sứ</p>', null, '6', '1', '1', '0', '', '-1', 'vi', '', '', '');
INSERT INTO `products` VALUES ('11', 'Cầu chì tự rơi (sứ)', '2012-12-12 10:14:36', '2012-12-12 10:14:36', '0', '0', '<p>Tiêu chuẩn áp dụng: ANSI C37.41, C37.42, IEC 282-2</p>\r\n<p>Điện áp định mức: 24-35kV</p>\r\n<p>Dòng điện định mức: 100 &amp; 200A</p>\r\n<p>Tần số định mức: 50Hz</p>\r\n<p>Khả năng cắt ngắn mạch: 12kA</p>\r\n<p>Điện áp chịu đựng xung (BIL): 125-150-170kV</p>\r\n<p>Chiều dài dòng rò: 340-440-720mm</p>\r\n<p>Vật liệu cách điện: Sứ</p>\r\n<p>Ống cầu chì bằng fiberglass chịu lực cao và được bọc chống tia cực tím<br /> (High-strength fiberglass fusetube coated with Ultra-Violet inhibitor)</p>', null, '6', '7', '1', '0', '', '-1', 'vi', '', '', '');
INSERT INTO `products` VALUES ('12', 'Cầu chì tự rơi (Polymer)', '2012-12-12 10:19:13', '2012-12-12 10:19:13', '0', '0', '<p>Tiêu chuẩn áp dụng: ANSI C37.41, C37.42, IEC 282-2, IEC 61109</p>\r\n<p>Điện áp định mức: 24-35kV</p>\r\n<p>Dòng điện định mức: 100 &amp; 200A</p>\r\n<p>Tần số định mức: 50Hz</p>\r\n<p>Khả năng cắt ngắn mạch: 12kA</p>\r\n<p>Điện áp chịu đựng xung (BIL): 150-200kV</p>\r\n<p>Chiều dài dòng rò: 635- 965mm</p>\r\n<p>Vật liệu cách điện: Silicone Rubber</p>', null, '6', '48', '1', '0', '', '-1', 'vi', '', '', '');

-- ----------------------------
-- Table structure for `product_images`
-- ----------------------------
DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(256) NOT NULL,
  `position` tinyint(1) DEFAULT '0',
  `products_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_images_products` (`products_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of product_images
-- ----------------------------
INSERT INTO `product_images` VALUES ('19', 'day-chi-trung-the-1b5b7.jpg', '1', '7');
INSERT INTO `product_images` VALUES ('18', 'cau-chi-cat-co-tai-polymer-1b53b.jpg', '1', '8');
INSERT INTO `product_images` VALUES ('17', 'chi-ong-trung-the-1b417.JPG', '1', '9');
INSERT INTO `product_images` VALUES ('16', 'cau-chi-cat-co-tai-su-1b3b7.jpg', '1', '10');
INSERT INTO `product_images` VALUES ('15', 'cau-chi-tu-roi-su-1b212.JPG', '1', '11');
INSERT INTO `product_images` VALUES ('14', 'cau-chi-tu-roi-polymer-1b022.jpg', '1', '12');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('-1', 'Khách');
INSERT INTO `roles` VALUES ('0', 'Quản trị hệ thống');
INSERT INTO `roles` VALUES ('2', 'Quản lý');

-- ----------------------------
-- Table structure for `roles_menus`
-- ----------------------------
DROP TABLE IF EXISTS `roles_menus`;
CREATE TABLE `roles_menus` (
  `menus_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of roles_menus
-- ----------------------------
INSERT INTO `roles_menus` VALUES ('38', '2');
INSERT INTO `roles_menus` VALUES ('39', '2');
INSERT INTO `roles_menus` VALUES ('40', '2');
INSERT INTO `roles_menus` VALUES ('55', '0');
INSERT INTO `roles_menus` VALUES ('55', '2');
INSERT INTO `roles_menus` VALUES ('3', '0');
INSERT INTO `roles_menus` VALUES ('3', '2');
INSERT INTO `roles_menus` VALUES ('11', '0');
INSERT INTO `roles_menus` VALUES ('11', '2');
INSERT INTO `roles_menus` VALUES ('4', '0');
INSERT INTO `roles_menus` VALUES ('4', '2');
INSERT INTO `roles_menus` VALUES ('93', '-1');
INSERT INTO `roles_menus` VALUES ('14', '0');
INSERT INTO `roles_menus` VALUES ('14', '2');
INSERT INTO `roles_menus` VALUES ('93', '0');
INSERT INTO `roles_menus` VALUES ('46', '2');
INSERT INTO `roles_menus` VALUES ('46', '0');
INSERT INTO `roles_menus` VALUES ('47', '2');
INSERT INTO `roles_menus` VALUES ('47', '0');
INSERT INTO `roles_menus` VALUES ('49', '0');
INSERT INTO `roles_menus` VALUES ('49', '2');
INSERT INTO `roles_menus` VALUES ('41', '2');
INSERT INTO `roles_menus` VALUES ('41', '0');
INSERT INTO `roles_menus` VALUES ('43', '2');
INSERT INTO `roles_menus` VALUES ('43', '0');
INSERT INTO `roles_menus` VALUES ('50', '2');
INSERT INTO `roles_menus` VALUES ('50', '0');
INSERT INTO `roles_menus` VALUES ('93', '2');
INSERT INTO `roles_menus` VALUES ('1', '2');
INSERT INTO `roles_menus` VALUES ('1', '0');
INSERT INTO `roles_menus` VALUES ('62', '0');
INSERT INTO `roles_menus` VALUES ('62', '2');
INSERT INTO `roles_menus` VALUES ('45', '0');
INSERT INTO `roles_menus` VALUES ('45', '2');
INSERT INTO `roles_menus` VALUES ('92', '-1');
INSERT INTO `roles_menus` VALUES ('16', '-1');
INSERT INTO `roles_menus` VALUES ('16', '0');
INSERT INTO `roles_menus` VALUES ('16', '2');
INSERT INTO `roles_menus` VALUES ('92', '0');
INSERT INTO `roles_menus` VALUES ('19', '-1');
INSERT INTO `roles_menus` VALUES ('19', '0');
INSERT INTO `roles_menus` VALUES ('19', '2');
INSERT INTO `roles_menus` VALUES ('92', '2');
INSERT INTO `roles_menus` VALUES ('91', '-1');
INSERT INTO `roles_menus` VALUES ('75', '-1');
INSERT INTO `roles_menus` VALUES ('75', '0');
INSERT INTO `roles_menus` VALUES ('75', '2');
INSERT INTO `roles_menus` VALUES ('91', '0');
INSERT INTO `roles_menus` VALUES ('88', '-1');
INSERT INTO `roles_menus` VALUES ('76', '-1');
INSERT INTO `roles_menus` VALUES ('76', '0');
INSERT INTO `roles_menus` VALUES ('76', '2');
INSERT INTO `roles_menus` VALUES ('91', '2');
INSERT INTO `roles_menus` VALUES ('88', '0');
INSERT INTO `roles_menus` VALUES ('88', '2');
INSERT INTO `roles_menus` VALUES ('90', '-1');
INSERT INTO `roles_menus` VALUES ('81', '-1');
INSERT INTO `roles_menus` VALUES ('81', '0');
INSERT INTO `roles_menus` VALUES ('81', '2');
INSERT INTO `roles_menus` VALUES ('83', '-1');
INSERT INTO `roles_menus` VALUES ('83', '0');
INSERT INTO `roles_menus` VALUES ('83', '2');
INSERT INTO `roles_menus` VALUES ('90', '0');
INSERT INTO `roles_menus` VALUES ('87', '0');
INSERT INTO `roles_menus` VALUES ('87', '2');
INSERT INTO `roles_menus` VALUES ('90', '2');
INSERT INTO `roles_menus` VALUES ('84', '2');
INSERT INTO `roles_menus` VALUES ('84', '0');
INSERT INTO `roles_menus` VALUES ('84', '-1');
INSERT INTO `roles_menus` VALUES ('85', '-1');
INSERT INTO `roles_menus` VALUES ('85', '0');
INSERT INTO `roles_menus` VALUES ('85', '2');
INSERT INTO `roles_menus` VALUES ('89', '-1');
INSERT INTO `roles_menus` VALUES ('86', '0');
INSERT INTO `roles_menus` VALUES ('17', '-1');
INSERT INTO `roles_menus` VALUES ('17', '0');
INSERT INTO `roles_menus` VALUES ('17', '2');
INSERT INTO `roles_menus` VALUES ('89', '0');
INSERT INTO `roles_menus` VALUES ('86', '2');
INSERT INTO `roles_menus` VALUES ('94', '2');
INSERT INTO `roles_menus` VALUES ('94', '0');
INSERT INTO `roles_menus` VALUES ('94', '-1');
INSERT INTO `roles_menus` VALUES ('97', '2');
INSERT INTO `roles_menus` VALUES ('97', '0');
INSERT INTO `roles_menus` VALUES ('98', '-1');
INSERT INTO `roles_menus` VALUES ('98', '0');
INSERT INTO `roles_menus` VALUES ('98', '2');
INSERT INTO `roles_menus` VALUES ('123', '0');
INSERT INTO `roles_menus` VALUES ('123', '2');

-- ----------------------------
-- Table structure for `supports`
-- ----------------------------
DROP TABLE IF EXISTS `supports`;
CREATE TABLE `supports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` tinyint(4) DEFAULT NULL,
  `content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(4) DEFAULT NULL,
  `lang` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'vi',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Editable Pages';

-- ----------------------------
-- Records of supports
-- ----------------------------
INSERT INTO `supports` VALUES ('9', 'Kỹ thuật', '1', 'naughtyboy_finds_pleasantgirl', '1', 'en');
INSERT INTO `supports` VALUES ('10', 'Hỗ trợ yahoo', '1', 'naughtyboy_finds_pleasantgirl', '1', 'vi');
INSERT INTO `supports` VALUES ('11', 'Hỗ trợ skype', '2', 'cuongdt90', '2', 'vi');

-- ----------------------------
-- Table structure for `units`
-- ----------------------------
DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `lang` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of units
-- ----------------------------
INSERT INTO `units` VALUES ('1', 'kg', null, null);
INSERT INTO `units` VALUES ('2', 'chai', null, null);
INSERT INTO `units` VALUES ('3', 'quả', null, null);

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(30) NOT NULL,
  `DOB` datetime DEFAULT NULL COMMENT 'Date Of Birth',
  `address` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `phone1` varchar(15) DEFAULT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL COMMENT '	',
  `company` varchar(256) DEFAULT NULL,
  `roles_id` int(11) DEFAULT NULL,
  `active` smallint(1) DEFAULT '1',
  `alias_name` varchar(15) DEFAULT NULL,
  `cities_id` int(11) NOT NULL,
  `joined_date` datetime DEFAULT NULL,
  `avatar` varchar(256) DEFAULT NULL,
  `is_openid` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', null, null, 'anh.nt@infopowers.net', null, null, 'admin', '0cc175b9c0f1b6a831c399e269772661', null, '2', '1', 'Tuấn Anh', '1', null, null, null);
