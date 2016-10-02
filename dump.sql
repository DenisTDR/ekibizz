/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : ebt

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2016-08-22 22:32:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birthdate` date NOT NULL DEFAULT '0000-00-00',
  `name` varchar(255) DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `grade` int(11) DEFAULT '0',
  `clientOf` int(11) NOT NULL DEFAULT '-1',
  `idnumber` int(11) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'none',
  `occupation` varchar(255) DEFAULT 'none',
  `skills` text,
  `employement` varchar(255) DEFAULT 'none',
  `gender` char(255) DEFAULT 'S',
  `phone` int(15) DEFAULT '333333333',
  `adress` varchar(255) DEFAULT 'none',
  `country` varchar(128) DEFAULT 'none',
  `city` varchar(128) DEFAULT 'none',
  `deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('1', 'tdr', '*0A4639410B568DB6D2342FFE712351A09413E61D', 'denis_tdr@yahoo.com', '1994-11-22', 'TDR Admin', '1', '0', '567', '123', 'png', 'CEO', 'skills skills skills skills skills skills skills skills.<br>skills skills skills skills skills skills skills skills.<br>abc', 'emplyement empl emplll emplyement empl emplll emplyement empl emplll emplyement empl emplll emplyement empl emplll ', 'M', '1234644445', 'adresa mea lunga<br>pe mai multe randuri de mai multe<br>cuvinte foarte lungi si scurte in acelasi timp', 'Romania', 'Dr. Tr. Severin', '\0');
INSERT INTO `account` VALUES ('2', 'tdr2', '*0A4639410B568DB6D2342FFE712351A09413E61D', 'denis_tdr@yahoo.com', '1992-04-03', 'TDR2', '0', '0', '123', '234', 'png', 'none', null, 'none', 'M', '333333333', 'none', '-', '-', '\0');
INSERT INTO `account` VALUES ('3', 'user1', '*0A4639410B568DB6D2342FFE712351A09413E61D', 'user1@mail.mail', '1993-07-12', 'User1', '0', '0', '123', '345', 'none', 'none', null, 'none', 'M', '333333333', 'none', '-', '-', '\0');
INSERT INTO `account` VALUES ('4', 'user2', '*0A4639410B568DB6D2342FFE712351A09413E61D', 'user2@mail.mail', '1993-03-14', 'User2', '0', '0', '123', '456', 'none', 'none', null, 'none', 'M', '333333333', 'none', '-', '-', '\0');
INSERT INTO `account` VALUES ('5', 'admin', '*0A4639410B568DB6D2342FFE712351A09413E61D', 'admin@admin.admin', '2004-02-03', 'Admin', '1', '0', '-1', '567', 'none', 'none', null, 'none', 'S', '333333333', 'none', '-', '-', '\0');
INSERT INTO `account` VALUES ('6', 'alt user', '*0A4639410B568DB6D2342FFE712351A09413E61D', 'denis_tdr@yahoo.com', '0000-00-00', 'alt cont', '0', '0', '123', '58381', 'none', 'none', null, 'none', 'S', '333333333', 'none', '-', '-', '\0');
INSERT INTO `account` VALUES ('7', 'un_nou', '*0A4639410B568DB6D2342FFE712351A09413E61D', 'email@email.email', '0000-00-00', 'Un nou user', '0', '0', '-1', '4562', 'none', 'none', null, null, 'S', '333333333', 'none', '-', '-', '\0');
INSERT INTO `account` VALUES ('8', 'cont_nou_1', '*0A4639410B568DB6D2342FFE712351A09413E61D', 'cont@cont.cont', '0000-00-00', 'Cont nou1', '0', '0', '4562', '665212', 'none', 'none', null, 'none', 'S', '333333333', 'none', '-', '-', '\0');

-- ----------------------------
-- Table structure for account_event
-- ----------------------------
DROP TABLE IF EXISTS `account_event`;
CREATE TABLE `account_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_idNr` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `statut` varchar(255) DEFAULT '0',
  `supervisor_idNr` int(11) DEFAULT NULL,
  `ticket` varchar(255) DEFAULT '0',
  `type` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_event
-- ----------------------------
INSERT INTO `account_event` VALUES ('1', '123', '7', 'active', '345', '6444', 'second');
INSERT INTO `account_event` VALUES ('2', '567', '7', 'passive', '123', '4533', 'second');
INSERT INTO `account_event` VALUES ('3', '345', '7', 'active', '567', '5588', 'second');
INSERT INTO `account_event` VALUES ('5', '345', '8', 'passive', '456', 'sdsd', 'second');
INSERT INTO `account_event` VALUES ('6', '4562', '8', 'passive', '58381', 'dfdf', 'first');
INSERT INTO `account_event` VALUES ('7', '567', '8', 'active', '345', 'sdfsdf', 'first');
INSERT INTO `account_event` VALUES ('8', '234', '7', 'active', '456', '2322', 'first');
INSERT INTO `account_event` VALUES ('10', '234', '9', 'active', '123', '344', 'second');
INSERT INTO `account_event` VALUES ('11', '345', '9', 'active', '123', '133', 'second');
INSERT INTO `account_event` VALUES ('12', '567', '9', 'active', '123', '5533', 'second');
INSERT INTO `account_event` VALUES ('13', '4562', '9', 'passive', '123', '4312', 'second');
INSERT INTO `account_event` VALUES ('14', '123', '8', 'active', '345', '6454', 'second');
INSERT INTO `account_event` VALUES ('15', '123', '9', 'active', '567', '455', 'first');
INSERT INTO `account_event` VALUES ('16', '123', '10', 'passive', '234', 'dff', 'second');

-- ----------------------------
-- Table structure for akl
-- ----------------------------
DROP TABLE IF EXISTS `akl`;
CREATE TABLE `akl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` longtext,
  `post` longtext,
  `get` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of akl
-- ----------------------------

-- ----------------------------
-- Table structure for bizz_idea
-- ----------------------------
DROP TABLE IF EXISTS `bizz_idea`;
CREATE TABLE `bizz_idea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text,
  `status` enum('just_sent','read','reply','finished') DEFAULT 'just_sent',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bizz_idea
-- ----------------------------
INSERT INTO `bizz_idea` VALUES ('1', '1', 'testttt', 'sds ds dsds', 'just_sent');

-- ----------------------------
-- Table structure for event
-- ----------------------------
DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `price` varchar(32) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `info` text,
  `photo` varchar(255) DEFAULT 'none',
  `deleted` bit(1) DEFAULT b'0',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of event
-- ----------------------------
INSERT INTO `event` VALUES ('7', 'Un eveniment', 'Bucuresti, Romania', '23 RON', '2017-06-16 00:00:00', 'Informatii despre eveniment. Informatii despre eveniment. Informatii despre eveniment. Informatii despre eveniment. Informatii despre eveniment. ', 'jpg', '\0', '0', '0');
INSERT INTO `event` VALUES ('8', 'Eveniment modificat', 'Severin, Romania', '14 Ron', '2017-06-15 00:00:00', 'Alt eveniment. Descriere... Alt eveniment. Descriere... Alt eveniment. Descriere... Alt eveniment. Descriere... ', 'jpg', '\0', '44.632595', '22.656223');
INSERT INTO `event` VALUES ('9', 'The New Event', 'tot acolo', '30 euro', '2017-09-09 00:00:00', 'alte informatii', 'jpg', '\0', '44.632524', '22.655783');
INSERT INTO `event` VALUES ('10', 'My event', 'altundeva', '10 Ron', '2017-06-17 00:00:00', 'das asd adasdsd', 'jpg', '\0', '-', '-');

-- ----------------------------
-- Table structure for help_request
-- ----------------------------
DROP TABLE IF EXISTS `help_request`;
CREATE TABLE `help_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `how_can_help` varchar(255) DEFAULT NULL,
  `status` enum('just_sent','read','reply','finished') DEFAULT 'just_sent',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of help_request
-- ----------------------------
INSERT INTO `help_request` VALUES ('1', 'TDR Admin2', 'email@email.email', 'asdsdsd', 'sdasdas as das', 'dasdas das asd', 'just_sent');

-- ----------------------------
-- Table structure for location_request
-- ----------------------------
DROP TABLE IF EXISTS `location_request`;
CREATE TABLE `location_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` enum('just_sent','read','reply','finished') NOT NULL DEFAULT 'just_sent',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of location_request
-- ----------------------------
INSERT INTO `location_request` VALUES ('1', 'sdsd', '32', 'sdsd', 'sdsd', 'sdsdsd', 'just_sent');

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `state` enum('new','read','arh','del') DEFAULT 'new',
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES ('59', '123', '567', null, 'dfdfd', 'new', '2014-06-06 02:41:39');
INSERT INTO `message` VALUES ('60', '123', '234', null, 'sdsd', 'new', '2014-06-06 14:01:58');
INSERT INTO `message` VALUES ('61', '123', '234', null, 'alt mesaj interesant<br>', 'new', '2014-06-06 14:02:04');
INSERT INTO `message` VALUES ('62', '123', '234', null, '&lt;a&gt;Test&lt;/a&gt;', 'new', '2014-06-06 14:10:06');
INSERT INTO `message` VALUES ('63', '234', '123', null, 'mesaj trimis de la tdr2', 'new', '2014-06-06 14:55:49');
INSERT INTO `message` VALUES ('64', '123', '234', null, 'dfdfd', 'new', '2014-06-06 17:16:51');
INSERT INTO `message` VALUES ('65', '123', '234', null, 'nu te creeeed', 'new', '2014-06-06 17:16:58');
INSERT INTO `message` VALUES ('66', '234', '123', 'test', 'sdsdsds sdsd', 'new', '2014-06-06 17:24:01');
INSERT INTO `message` VALUES ('67', '123', '234', 'altceva?', 'si tu?', 'new', '2014-06-06 17:26:34');
INSERT INTO `message` VALUES ('68', '234', '123', 'no shit?', 'no shiiiiit?<br>de doua ori', 'new', '2014-06-06 17:26:50');
INSERT INTO `message` VALUES ('69', '567', '123', '', 'mesaj ... mesaj ... mesaj ... ', 'new', '2014-06-06 18:09:49');
INSERT INTO `message` VALUES ('70', '123', '567', 'Alt mesaj', 'alt test', 'del', '2014-06-09 19:23:14');
INSERT INTO `message` VALUES ('71', '123', '567', 'test', 'test st sfs f', 'del', '2014-06-09 19:28:33');
INSERT INTO `message` VALUES ('72', '123', '567', 'dfdf', 'dfdffdfdf dfd d df sd sd<br> sdf<br>sdf<br>sd ffsd fsdf sf', 'del', '2014-06-09 19:30:21');
INSERT INTO `message` VALUES ('73', '123', '567', '', 'sdfsfd', 'new', '2014-06-14 02:27:26');
INSERT INTO `message` VALUES ('77', '123', '567', '', 'dfdf', 'new', '2014-06-15 22:57:01');
INSERT INTO `message` VALUES ('78', '123', '567', '', 'da da da', 'new', '2014-06-15 22:57:10');
INSERT INTO `message` VALUES ('79', '123', '567', '', 'test 123', 'new', '2014-06-15 23:05:26');
INSERT INTO `message` VALUES ('80', '123', '4562', '', 'test ', 'new', '2014-06-19 20:44:02');
INSERT INTO `message` VALUES ('81', '123', '4562', '', 'trimit mesaj', 'new', '2014-06-19 20:44:11');
INSERT INTO `message` VALUES ('82', '123', '234', '', 'weefdsf', 'new', '2014-06-20 15:48:49');
INSERT INTO `message` VALUES ('83', '567', '123', '', 'fff', 'new', '2014-07-09 22:42:20');

-- ----------------------------
-- Table structure for setting
-- ----------------------------
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of setting
-- ----------------------------
INSERT INTO `setting` VALUES ('1', 'langs', ' en tr ro ');

-- ----------------------------
-- Table structure for translate
-- ----------------------------
DROP TABLE IF EXISTS `translate`;
CREATE TABLE `translate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `en` mediumtext NOT NULL,
  `tr` mediumtext NOT NULL,
  `ro` mediumtext NOT NULL,
  `note` varchar(255) NOT NULL DEFAULT '[note]',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=156 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of translate
-- ----------------------------
INSERT INTO `translate` VALUES ('1', 'site_title', 'Eki Business Organization', 'Eskşehir İş Eğitimi', 'Eki Business Organization', 'test');
INSERT INTO `translate` VALUES ('155', 'about_trainings', 'About trainings', 'Eğitim hakkında', 'Despre training', '[note]');
INSERT INTO `translate` VALUES ('3', 'how_it_works', 'How it works', 'Nasıl işlediği hakkında bilgi  ', 'Cum funcționează', '[note]');
INSERT INTO `translate` VALUES ('4', 'future_plans', 'Future plans', 'Gelecek planı', 'Planuri de viitor', '[note]');
INSERT INTO `translate` VALUES ('5', 'your_bizz', 'Your business', 'Senin işin ', 'Afacerile tale', '[note]');
INSERT INTO `translate` VALUES ('6', 'training_location', 'Training location', 'Eğitim Yeri', 'Locație trainig', '[note]');
INSERT INTO `translate` VALUES ('7', 'login', 'Login', 'Giriş', 'Autentificare', '[note]');
INSERT INTO `translate` VALUES ('8', 'welcome_to_1', 'Welcome to var1!', 'var1 Hoşgeldiniz!', 'Bine ați venit la var1!', '[note]');
INSERT INTO `translate` VALUES ('9', 'home', 'Home', 'Ev', 'Acasă', '[note]');
INSERT INTO `translate` VALUES ('10', 'you_dont_have_to_pay', 'YOU DON’T HAVE TO PAY FOR SEMINARS', 'SEMİNERLER İ&Ccedil;İN PARA &Ouml;DEMEK ZORUNDA DEĞİLSİNİZ', 'NU TREBUIE SĂ PLĂTEȘTI PENTRU SEMINARII', '[note]');
INSERT INTO `translate` VALUES ('11', 'you_dont_have_to_pay_content', 'abc1', '[text]', '[text]', '[note]');
INSERT INTO `translate` VALUES ('12', 'develop_your_personal_skills', 'DEVELOP YOUR PERSONAL SKILLS', 'YETENEĞİNİZİ GELİŞTİRİN', 'DEZVOLTĂ-ȚI ABILITĂȚILE PERSONALE', '[note]');
INSERT INTO `translate` VALUES ('13', 'develop_your_personal_skills_content', '[text]', '[text]', '[text]', '[note]');
INSERT INTO `translate` VALUES ('14', 'learn_more_1', 'LEARN MORE ABOUT THE BUSINESS ENVIRONMENT', 'iŞ &Ccedil;EVRESİ HAKKINDA DAHA FAZLASINI &Ouml;ĞRENİN', 'ÎNVAȚĂ MAI MULTE DESPRE AFACERI', '[note]');
INSERT INTO `translate` VALUES ('15', 'learn_more_1_content', '[text]', '[text]', '[text]', '[note]');
INSERT INTO `translate` VALUES ('16', 'have_fun_1', 'HAVE FUN AND MAKE MONEY', 'EĞLENEREK PARA KAZANIN', 'DISTREAZĂ-TE FĂCÂND BANI', '[note]');
INSERT INTO `translate` VALUES ('17', 'have_fun_1_content', '[text En]', '[text Tr]', '[text Ro]', '[note]');
INSERT INTO `translate` VALUES ('18', 'password', 'Password', 'Șifre', 'Parola', '[note]');
INSERT INTO `translate` VALUES ('19', 'user', 'User', 'Kullanıcı', 'Utilizator', '[note]');
INSERT INTO `translate` VALUES ('20', 'invalid_user_pass', 'Invalid username or password!', 'Geçersiz kullanıcı adı veya şifre!', 'Utilizator sau parolă invalidă!', '[note]');
INSERT INTO `translate` VALUES ('21', 'login_success', 'You where logged in!<br>Welcome var1!<br>You will be redirected to your account.', 'Sizin girdiğiniz yer burası!<br>Hoşgeldiniz var1!<br>Hesabınıza yeniden y&ouml;nlendirilecekinz.', 'Ai fost logat cu succes!<br>Bine ai venit, var1!<br>Vei fi redirecționat către contul tău.', '[note]');
INSERT INTO `translate` VALUES ('22', 'there_are_3_steps_1', 'There are 3 steps that you need to follow', 'İzlemeniz gereken 3 adım var.', 'Trebuie să urmezi 3 pași', '[note]');
INSERT INTO `translate` VALUES ('23', 'join_free_seminars', 'Join the free seminars', 'Bedava seminerlere katıl.', 'Înscrie-te gratuit la seminarii', '[note]');
INSERT INTO `translate` VALUES ('24', 'get_your_account', 'Get your account', 'Hesabını al.', 'Primește contul', '[note]');
INSERT INTO `translate` VALUES ('25', 'began_bizz_activity', 'Began your business activity', 'İş aktivitene katıl.', 'Începe afacerea ta', '[note]');
INSERT INTO `translate` VALUES ('26', 'join_free_seminars_content', '[text]', '[text]', '[text]', '[note]');
INSERT INTO `translate` VALUES ('27', 'get_your_account_content', '[text]', '[text]', '[text]', '[note]');
INSERT INTO `translate` VALUES ('28', 'began_bizz_activity_content', '[text]', '[text]', '[text]', '[note]');
INSERT INTO `translate` VALUES ('29', 'future_plans_1', '[text En]', '[text Tr]', '[text Ro]', '[note]');
INSERT INTO `translate` VALUES ('30', 'your_bizz_1', 'We can offer you some help for your business.', 'İşin i&ccedil;in sana birka&ccedil; yardım &ouml;nerebiliriz.', 'Putem să te ajutăm cu afacerea ta.', '[note]');
INSERT INTO `translate` VALUES ('31', 'write_us_and_describe_1', 'Write to us and describe your business problem:', 'Bize yazın ve iş probleminizi tanımla.', 'Scrie-ne și descrie problema din afacerea ta:', '[note]');
INSERT INTO `translate` VALUES ('32', 'name', 'Name', 'Isim', 'Nume', '[note]');
INSERT INTO `translate` VALUES ('33', 'your_position_in_firm', 'Your position in firm', 'Firmadaki pozisyonun.', 'Poziția ta în firmă', '[note]');
INSERT INTO `translate` VALUES ('34', 'bizz_desc', 'Business description', 'İş tanımı', 'Descriere afacere', '[note]');
INSERT INTO `translate` VALUES ('35', 'how_can_we_help_you', 'How can we help you?', 'Sana nasıl yardımcı olabilirim?', 'Cum putem să te ajutăm?', '[note]');
INSERT INTO `translate` VALUES ('36', 'email_adress', 'Email adress', 'Email adresi', 'Adresă email', '[note]');
INSERT INTO `translate` VALUES ('37', 'send', 'Send', 'G&ouml;nder', 'Trimite', '[note]');
INSERT INTO `translate` VALUES ('38', 'sending_request', 'Sending your request...', 'Talebini g&ouml;nderiyor.', 'Procesez cererea...', '[note]');
INSERT INTO `translate` VALUES ('39', 'fields_incomplete', 'Please recheck the fields!', 'L&uuml;tfen alanları tekrar kontrol et!', 'Te rog verifică câmpurile!', '[note]');
INSERT INTO `translate` VALUES ('40', 'error_ocurred_retry', 'An error ocurred!<br>Please try again...', 'Hata oluştu!<br>L&uuml;tfen tekrar deneyin.', 'A apărut o eroare!<br>Te rugăm încearcă din nou...', '[note]');
INSERT INTO `translate` VALUES ('41', 'request_registered', 'Your request was registered!', 'Talebiniz kaydedildi!', 'Cererea a fost înregistrată', '[note]');
INSERT INTO `translate` VALUES ('42', 'we_will_contact_you', 'We will contact you as soon as we can!', 'Sizle en kısa zamanda iletişim kuracağız!', 'Te vom contacta cât mai curand posibil!', '[note]');
INSERT INTO `translate` VALUES ('43', 'training_location_1', 'There is a limited number of places for the people interested of our seminars.<br>\r\nAlso you have to fit to the profile for our candidates.<br>\r\nYou will get the information as soon as possible.', 'Seminerlerimiz ile ilgilenen bireyler i&ccedil;in limitli sayıda yerimiz vardır.<br>Aynı zamanda adaylarımız i&ccedil;in profile uygun olmak zorundasınız<br><br>M&uuml;mk&uuml;n olduğunca kısa s&uuml;rede bilgi alacaksınız.<br>', 'Avem un număr limitat de locații pentru cei interesați de seminarii.<br>\r\nDe asemenea, trebuie să te potrivesti unui profil pentru candidații noștri.<br>\r\nVei primi informațiile cât mai curând posibil.', '[note]');
INSERT INTO `translate` VALUES ('44', 'age', 'Age', 'Yaş', 'Vârstă', '[note]');
INSERT INTO `translate` VALUES ('45', 'profession', 'Profession', 'Meslek', 'Profesie', '[note]');
INSERT INTO `translate` VALUES ('46', 'phone', 'Phone number', 'Telefon', 'Nr. Telefon', '[note]');
INSERT INTO `translate` VALUES ('47', 'my_account', 'My Account', 'Hesabm', 'Contul meu', '[note]');
INSERT INTO `translate` VALUES ('48', 'log_out', 'Logout', '&Ccedil;ıkış Yap', 'Deconectare', '[note]');
INSERT INTO `translate` VALUES ('49', 'settings', 'Settings', 'Ayarlar', 'Setări', '[note]');
INSERT INTO `translate` VALUES ('50', 'messages', 'Messages', 'Mesajlar', 'Mesaje', '[note]');
INSERT INTO `translate` VALUES ('51', 'log_out_message', 'You where disconnected. <br>You will be redirected to the Home page.', 'Bağlantınız kesildi.<br>Anasayfaya y&ouml;nlendirileceksiniz.', 'Ai fost deconectat.<br> Vei fi redirecționat către pagina principală.', '[note]');
INSERT INTO `translate` VALUES ('52', 'events', 'Events', 'Etkinlikler', 'Evenimente', '[note]');
INSERT INTO `translate` VALUES ('53', 'share_your_bizz_idea', 'Share your bizz idea', 'İş fikirlerinizi paylaşın', 'Ideea ta de afacere', '[note]');
INSERT INTO `translate` VALUES ('54', 'jobs_for_u', 'Jobs for you', 'Sizin i&ccedil;in işler', 'Job-uri pentru tine', '[note]');
INSERT INTO `translate` VALUES ('55', 'your_clients', 'Your clients', 'M&uuml;şterileriniz', 'Clienții tăi', '[note]');
INSERT INTO `translate` VALUES ('56', 'id_number', 'ID Number', 'Kimlik Numarası', 'ID Number', '[note]');
INSERT INTO `translate` VALUES ('57', 'no_clients', 'You don\'t have clients', 'M&uuml;şteriniz yok.', 'Nu ai clienți', '[note]');
INSERT INTO `translate` VALUES ('58', 'actions', 'Actions', 'Hareketler.', 'Acțiuni', '[note]');
INSERT INTO `translate` VALUES ('59', 'error_403', 'Permission denied!', 'İzin reddeldi.', 'Acces interzis', '[note]');
INSERT INTO `translate` VALUES ('60', 'error_404', 'Page not found!', 'Sayfa bulunamadı!', 'Pagina nu a fost găsită!', '[note]');
INSERT INTO `translate` VALUES ('61', 'title', 'Title', 'Başlık', 'Titlu', '[note]');
INSERT INTO `translate` VALUES ('62', 'desc', 'Description', 'Tanım', 'Descriere', '[note]');
INSERT INTO `translate` VALUES ('63', 'st_went_wrong', 'Something went wrong!', 'Bir şey yanlış oldu!', 'Cererea nu a fost înregistrată!', '[note]');
INSERT INTO `translate` VALUES ('64', 'change_password', 'Change Password', 'Şifreyi Değiştir', 'Schimbare parola', '[note]');
INSERT INTO `translate` VALUES ('65', 'old_pass', 'Old Password', 'Eski şifre', 'Parola veche', '[note]');
INSERT INTO `translate` VALUES ('66', 'new_pass', 'New Password', 'Yeni şifre', 'Parola noua', '[note]');
INSERT INTO `translate` VALUES ('67', 'new_pass_again', 'New Password again', 'Yeni Şifreyi tekrarlayın', 'Parola din nou', '[note]');
INSERT INTO `translate` VALUES ('68', 'save', 'Save', 'Y&uuml;kle', 'Salvează', '[note]');
INSERT INTO `translate` VALUES ('69', 'invalid_old_password', 'Invalid old password', 'Ge&ccedil;ersiz eski şifre', 'Parola veche nu este corecta', '[note]');
INSERT INTO `translate` VALUES ('70', 'pass_not_safe', 'Password must have at least 5 characters.', 'Şifre en az beş karakter olmalıdır.', 'Parola trebuie să aibă cel puțin 5 caractere.', '[note]');
INSERT INTO `translate` VALUES ('71', 'pass_not_match', 'The passwords does not match.', 'Şifreler uyuşmuyor.', 'Parolele nu e potrivesc.', '[note]');
INSERT INTO `translate` VALUES ('72', 'pass_changed', 'Password changed', 'Şifre değiştirildi.', 'Parola a fost schimbată', '[note]');
INSERT INTO `translate` VALUES ('73', 'change_avatar', 'Profile picture', 'Profil Resmi', 'Poza de profil', '[note]');
INSERT INTO `translate` VALUES ('74', 'max_allowed_size', 'Maximum allowed size is var1', 'İzin verilen maksimum boyut var1 ', 'Dimensiunea maximă permisă este var1', '[note]');
INSERT INTO `translate` VALUES ('75', 'invalid_ext', 'Invalid extension. var1 allowed.', 'Ge&ccedil;ersiz uzantı. var1 İzin verildi.', 'Extensie nepermisă. Cele permise sunt var1.', '[note]');
INSERT INTO `translate` VALUES ('76', 'image_saved', 'Image saved!', 'Fotoğraf y&uuml;klendi!', 'Imaginea a fost salvată!', '[note]');
INSERT INTO `translate` VALUES ('77', 'create_account', 'Create account', 'Hesap a&ccedil;', 'Cont nou', '[note]');
INSERT INTO `translate` VALUES ('78', 'password_again', 'Password again', 'Şifreyi tekrarla', 'Parola din nou', '[note]');
INSERT INTO `translate` VALUES ('79', 'loading_page', 'Loading page', 'Sayfa doluyor.', 'Se încarcă pagina', '[note]');
INSERT INTO `translate` VALUES ('80', 'please_wait', 'Please wait...', 'L&uuml;tfen bekleyin... ', 'Așteptați...', '[note]');
INSERT INTO `translate` VALUES ('81', 'page_loaded', 'Page loaded', 'Sayfa doldu', 'Pagina a fost încărcată', '[note]');
INSERT INTO `translate` VALUES ('82', 'updating_st', 'Updating your var1', ' var1 ını g&uuml;ncelliyor.', 'Se actualizeaza var1', '[note]');
INSERT INTO `translate` VALUES ('83', 'field_length', 'Your var1 contain between var2 and var3 characters.', 'var1 ın   var2 and var3 karakterleri arasını i&ccedil;erir. ', 'Câmpul var1 trebuie să conțină între var2 și var3 caractere.', '[note]');
INSERT INTO `translate` VALUES ('84', 'field_already_taken', 'This var1 is already used by someone else.', 'Bu var1zaten başka kullanıcı tarafından kullanılıyor.', 'var1 este deja folosit de altcineva.', '[note]');
INSERT INTO `translate` VALUES ('85', 'field_changed', 'var1 updated!', 'var1 değiştirildi!', 'var1 a fost schimbat!', '[note]');
INSERT INTO `translate` VALUES ('86', 'birthdate', 'Birth date', 'Doğum Tarihi', 'Data nașterii', '[note]');
INSERT INTO `translate` VALUES ('87', 'profession', 'Profession', 'Meslek', 'Ocupație', '[note]');
INSERT INTO `translate` VALUES ('88', 'prof_exp', 'Professional experience', 'Profesyonel deneyim', 'Experiență profesională', '[note]');
INSERT INTO `translate` VALUES ('89', 'cancel', 'Cancel', 'İptal et ', 'Anulează', '[note]');
INSERT INTO `translate` VALUES ('90', 'send_message', 'Send message', 'Mesaj g&ouml;nder', 'Trimite mesaj', '[note]');
INSERT INTO `translate` VALUES ('91', 'recipient', 'Recipient', 'Alıcı', 'Destinatar', '[note]');
INSERT INTO `translate` VALUES ('92', 'subject', 'Subject', 'Konu', 'Subiect', '[note]');
INSERT INTO `translate` VALUES ('93', 'message', 'Message', 'Mesaj', 'Mesaj', '[note]');
INSERT INTO `translate` VALUES ('94', 'to', 'To', 'Kime', 'Către', '[note]');
INSERT INTO `translate` VALUES ('95', 'message_sent', 'Message sent!', 'Message g&ouml;nderildi!', 'Mesajul a fost trimis!', '[note]');
INSERT INTO `translate` VALUES ('96', 'last_messages', 'Last messages', 'Son mesajlar', 'Ultimele mesaje', '[note]');
INSERT INTO `translate` VALUES ('97', 'logout', 'Log out', '&Ccedil;ıkış yap', 'Ieșire', '[note]');
INSERT INTO `translate` VALUES ('98', 'gender', 'Gender', 'Cinsiyet', 'Gen', '[note]');
INSERT INTO `translate` VALUES ('99', 'male', 'Male', 'Bay', 'Masculin', '[note]');
INSERT INTO `translate` VALUES ('100', 'female', 'Female', 'Bayan', 'Feminim', '[note]');
INSERT INTO `translate` VALUES ('101', 'unspecified', 'Unspecified', 'Belirtilmemiş', 'Nespecificat', '[note]');
INSERT INTO `translate` VALUES ('102', 'basic_info', 'Basic information', 'Temel Bilgi', 'Date personale', '[note]');
INSERT INTO `translate` VALUES ('103', 'contact_info', 'Contact information', 'Bilgi kur ', 'Date de contact', '[note]');
INSERT INTO `translate` VALUES ('104', 'adress', 'Adress', 'Adres', 'Adresă', '[note]');
INSERT INTO `translate` VALUES ('105', 'work', 'Work', 'İş', 'Muncă', '[note]');
INSERT INTO `translate` VALUES ('106', 'occupation', 'Occupation', 'İş', 'Ocupație', '[note]');
INSERT INTO `translate` VALUES ('107', 'skills', 'Skills', 'Yetenekler', 'Abilități', '[note]');
INSERT INTO `translate` VALUES ('108', 'employement', 'Employement', 'G&ouml;rev', 'Angajări', '[note]');
INSERT INTO `translate` VALUES ('109', 'account_sett', 'Account settings', 'Hesap ayarları', 'Setări cont', '[note]');
INSERT INTO `translate` VALUES ('110', 'change', 'Change', 'Değiştir', 'Schimbă', '[note]');
INSERT INTO `translate` VALUES ('111', 'ebo_id', 'Ebo id', 'Ebo kimliği', 'Id Ebo', '[note]');
INSERT INTO `translate` VALUES ('112', 'updating_pw', 'Updating,<br>Please wait...', 'G&uuml;ncelleme yapılıyor, l&uuml;tfen bekleyin...', 'Se actualizează<br>Așteaptă...', '[note]');
INSERT INTO `translate` VALUES ('113', 'update_done', 'Update done!', 'G&uuml;ncelleme yapıldı', 'Actualizare finalizată!', '[note]');
INSERT INTO `translate` VALUES ('114', 'image_upped', 'Image uploaded!', 'Resim y&uuml;klendi!', 'Imaginea a fost încărcată!', '[note]');
INSERT INTO `translate` VALUES ('115', 'crt_event', 'Curent event', 'Curent event[Tr]', 'Eveniment curent', '[note]');
INSERT INTO `translate` VALUES ('116', 'next_event', 'Next event', 'Next event[Tr]', 'Următorul eveniment', '[note]');
INSERT INTO `translate` VALUES ('117', 'price', 'Price', 'Price[Tr]', 'Pret', '[note]');
INSERT INTO `translate` VALUES ('118', 'location', 'Location', 'Location[Tr]', 'Locație', '[note]');
INSERT INTO `translate` VALUES ('119', 'date', 'Date', 'Date[Tr]', 'Data', '[note]');
INSERT INTO `translate` VALUES ('120', 'statut', 'Statut', 'Statut[Tr]', 'Statut', '[note]');
INSERT INTO `translate` VALUES ('121', 'type', 'Type', 'Type[Tr]', 'Tip', '[note]');
INSERT INTO `translate` VALUES ('122', 'ticket_nr', 'Ticket number', 'Ticket number[Tr]', 'Număr bilet', '[note]');
INSERT INTO `translate` VALUES ('123', 'event_info', 'Event details', 'Event details[Tr]', 'Detalii eveniment', '[note]');
INSERT INTO `translate` VALUES ('124', 'personal_info', 'Personal informations', 'Personal informations[Tr]', 'Informatii personale', '[note]');
INSERT INTO `translate` VALUES ('125', 'not_registered_event_member', 'You are not registered for this event.', 'You are not registered for this event.[Tr]', 'Nu ești înscris la acest eveniment.', '[note]');
INSERT INTO `translate` VALUES ('126', 'supervisor', 'Supervisor', 'Supervisor[Tr]', 'Supraveghetor', '[note]');
INSERT INTO `translate` VALUES ('127', 'more_info_event', 'More information about this event', 'More information about this event[Tr]', 'Alte informații despre acest eveniment', '[note]');
INSERT INTO `translate` VALUES ('128', 'brought_clients_event', 'List of client that you bring', 'List of client that you bring[Tr]', 'Clienții aduși de tine', '[note]');
INSERT INTO `translate` VALUES ('129', 'event_member_info_change', 'Change informations of a member about an event', 'Change informations of a member about an event[Tr]', 'Schimbă informațiile unui membru despre un eveniment', '[note]');
INSERT INTO `translate` VALUES ('131', 'clientof', 'Client of', 'Client of[Tr]', 'Client al lui', '[note]');
INSERT INTO `translate` VALUES ('132', 'time', 'Time', 'Time[Tr]', 'Timp', '[note]');
INSERT INTO `translate` VALUES ('133', 'all', 'All', 'All', 'Toate', '[note]');
INSERT INTO `translate` VALUES ('134', 'delete', 'Delete', 'Delete', 'Șterge', '[note]');
INSERT INTO `translate` VALUES ('135', 'this_is_admin', 'This user is admin', 'This user is admin[Tr]', 'Acest utilizator este admin', '[note]');
INSERT INTO `translate` VALUES ('136', 'last_message', 'Last message', 'Last message[Tr]', 'Ultimul mesaj', '[note]');
INSERT INTO `translate` VALUES ('137', 'edit', 'Edit', 'Edit[Tr]', 'Modifică', '[note]');
INSERT INTO `translate` VALUES ('138', 'view', 'View', 'View[Tr]', 'Arată', '[note]');
INSERT INTO `translate` VALUES ('139', 'sure_delet_conv', 'Are you sure you want to delete selected conversations?', 'Are you sure you want to delete selected conversations?[Tr]', 'Ești sigur că vrei să ștergi conversațiile selectate?', '[note]');
INSERT INTO `translate` VALUES ('140', 'yes', 'Yes', 'Yes[Tr]', 'Da', '[note]');
INSERT INTO `translate` VALUES ('141', 'no', 'No', 'No[Tr]', 'Nu', '[note]');
INSERT INTO `translate` VALUES ('142', 'done', 'Done!', 'Done!', 'Efectuat!', '[note]');
INSERT INTO `translate` VALUES ('143', 'sure_delete_events', 'Are you sure you want do telete selected events?', 'Are you sure you want do telete selected events?[Tr]', 'Ești sigur că vrei să ștergi evenimentele selctate?', '[note]');
INSERT INTO `translate` VALUES ('144', 'country', 'Country', 'Country[Tr]', 'Țara', '[note]');
INSERT INTO `translate` VALUES ('145', 'city', 'City', 'City[Tr]', 'Oraș', '[note]');
INSERT INTO `translate` VALUES ('146', 'open_google_maps', 'Open in Google Maps', 'Open in Google Maps[Tr]', 'Deschide în Google Maps', '[note]');
INSERT INTO `translate` VALUES ('148', 'days', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', 'Luni,Marți,Miercuri,Joi,Vineri,Sâmbăta,Duminică', '[note]');
INSERT INTO `translate` VALUES ('149', 'sure_delete_msg', 'Are you sure you want to delete this message?', ' Are you sure you want to delete this message?', 'Ești sigur că vrei să ștergi acest mesaj?', '[note]');
INSERT INTO `translate` VALUES ('150', 'allm', 'All', 'All', 'Toți', '[note]');
INSERT INTO `translate` VALUES ('151', 'admin_messages', 'Admins Messages', 'Admins Messages', 'Mesaje Admini', '[note]');
INSERT INTO `translate` VALUES ('152', 'admins', 'Administrators', 'Administrators', 'Administratori', '[note]');
INSERT INTO `translate` VALUES ('153', 'loading', 'Loading', 'Loading', 'Se încarcă', '[note]');
