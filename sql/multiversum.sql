-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 07 apr 2020 om 01:28
-- Serverversie: 10.4.11-MariaDB
-- PHP-versie: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `multiversum`
--
CREATE DATABASE IF NOT EXISTS `multiversum` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `multiversum`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `contact`
--

CREATE TABLE `contact` (
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `contact`
--

INSERT INTO `contact` (`street`, `city`, `state`, `postcode`) VALUES
('1861 jan pieterszoon coenstraat', 'maasdriel', 'zeeland', '69217');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `content`
--

CREATE TABLE `content` (
  `content_id` int(11) NOT NULL,
  `content_page` varchar(255) NOT NULL,
  `content_name` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `content`
--

INSERT INTO `content` (`content_id`, `content_page`, `content_name`, `content`) VALUES
(1, 'home', 'call_to_action', 'De beste vr winkel in nederland voor elke vr bril die je maar wilt!');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `insertion` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `house` varchar(255) NOT NULL,
  `zipcode` varchar(6) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ean` varchar(255) NOT NULL DEFAULT '-',
  `sku` varchar(255) NOT NULL DEFAULT '-',
  `price` int(11) NOT NULL DEFAULT 0,
  `img_path` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `brand` varchar(255) NOT NULL DEFAULT '-',
  `platform` varchar(255) NOT NULL DEFAULT '-',
  `own_display` tinyint(1) NOT NULL,
  `resolution` varchar(255) NOT NULL DEFAULT '-',
  `pov` int(11) NOT NULL DEFAULT 0,
  `refresh` int(11) NOT NULL DEFAULT 0,
  `min_phone_size` int(11) NOT NULL DEFAULT 0,
  `max_phone_size` int(11) NOT NULL DEFAULT 0,
  `accelerometer` tinyint(1) NOT NULL,
  `camera` tinyint(1) NOT NULL,
  `gyroscoop` tinyint(1) NOT NULL,
  `headphone` tinyint(1) NOT NULL,
  `microphone` tinyint(1) NOT NULL,
  `adjustable_lenses` tinyint(1) NOT NULL,
  `eyetracking` tinyint(1) NOT NULL,
  `handtracking` tinyint(1) NOT NULL,
  `magnetometer` tinyint(1) NOT NULL,
  `speakers` tinyint(1) NOT NULL,
  `connection_c` varchar(255) NOT NULL DEFAULT '-',
  `connection_w` varchar(255) NOT NULL DEFAULT '-',
  `connection_b` tinyint(1) NOT NULL,
  `remote_controll` tinyint(1) NOT NULL,
  `controllers` int(11) NOT NULL DEFAULT 0,
  `cables` varchar(255) NOT NULL DEFAULT '-',
  `tracking_stations` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `dept` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `color` varchar(255) NOT NULL DEFAULT '-',
  `released` date NOT NULL,
  `series` varchar(255) NOT NULL DEFAULT '-',
  `archieved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `product`
--

INSERT INTO `product` (`id`, `title`, `ean`, `sku`, `price`, `img_path`, `description`, `brand`, `platform`, `own_display`, `resolution`, `pov`, `refresh`, `min_phone_size`, `max_phone_size`, `accelerometer`, `camera`, `gyroscoop`, `headphone`, `microphone`, `adjustable_lenses`, `eyetracking`, `handtracking`, `magnetometer`, `speakers`, `connection_c`, `connection_w`, `connection_b`, `remote_controll`, `controllers`, `cables`, `tracking_stations`, `height`, `width`, `dept`, `weight`, `color`, `released`, `series`, `archieved`) VALUES
(12, 'Oculus Rift S', '0815820020387', '301-00178-01', 604, './view/assets/img/2002572294.jpeg', 'Test', 'Oculus', 'PC', 1, '2560x1440 (Quad HD)', 30, 80, 10, 30, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, '3.5mm', 'PC Ethernet', 0, 1, 2, 'Ja', 4, 20, 25, 15, 30, 'zwart', '2020-03-04', 'Oculus', 0),
(13, 'Oculus Quest 64GB', '0815820020318', '301-00174-01', 499, './view/assets/img/2002572254.jpeg', '', 'Oculus', 'Standalone', 1, '2880x1600', 100, 72, 20, 20, 1, 1, 1, 0, 1, 1, 0, 0, 0, 0, 'USB 3.2 (Gen1, 5Gb/s) type-c', '802.11a, 802.11ac (Wi-Fi 5), 802.11b, 802.11g, 802.11n (Wi-Fi 4)', 1, 0, 2, 'Ja', 0, 20, 25, 20, 470, 'zwart', '2020-03-01', 'Quest', 0),
(14, 'HP Reverb - Professional Edition', '0193905282654', '6KP43EA#ABB', 736, './view/assets/img/2002570918.jpeg', '', 'HP', 'PC', 1, '4320x2160', 114, 90, 20, 20, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 'Geen', 'PC Ethernet', 1, 0, 2, 'Ja', 4, 55, 84, 177, 433, 'zwart', '2019-11-06', 'Professional Edition', 0),
(15, 'HTC Vive Cosmos', '4718487715022', '99HARL002-00', 744, './view/assets/img/2003398638.jpeg', '', 'HTC', 'PC', 1, '2880x1700', 110, 90, 20, 20, 0, 1, 1, 1, 0, 0, 0, 1, 0, 0, 'Kabel', 'PC Ethernet', 0, 0, 2, 'Ja', 4, 55, 84, 177, 450, 'Blauw', '2019-11-14', 'Cosmos', 0),
(16, 'Oculus Go 64GB', '0815820020219', '301-00105-01', 232, './view/assets/img/2001963381.png', '', 'Oculus', 'Standalone', 1, '2560x1440 (Quad HD)', 100, 72, 20, 20, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 'Geen', 'Geen', 0, 0, 2, 'Nee', 0, 60, 84, 177, 490, 'Grijs', '2019-05-07', '', 0),
(17, 'HTC Vive Pro (Full Kit)', '4718487708055', '99HANW003-00', 1199, './view/assets/img/2002474892.jpeg', '', 'HTC', 'PC', 1, '2880x1600', 110, 90, 20, 20, 0, 1, 1, 1, 1, 1, 0, 0, 1, 0, '3.5mm, USB 3.2 (Gen1, 5Gb/s) type-c', 'PC Ethernet', 0, 0, 2, 'Ja', 2, 90, 80, 190, 500, 'Blauw, Zwart', '2019-09-11', 'Pro (Full Kit)', 0),
(18, 'Acer Mixed Reality Headset', '4713883398558', 'VD.R05EE.003', 349, './view/assets/img/2001712799.png', '', 'Acer', 'PC', 1, '2880x1440', 100, 90, 20, 20, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, '3.5mm, HDMI, USB 3.2 (Gen1, 5Gb/s)', 'PC Ethernet', 0, 0, 2, 'Ja', 0, 143, 196, 384, 440, 'Blauw', '2019-11-05', '', 0),
(19, 'Sony PlayStation VR Megapack 2', '0711719998105', '7362177401', 228, './view/assets/img/2003201456.jpeg', '', 'Sony', 'PS4', 1, '1920x1080 (Full HD)', 100, 90, 20, 20, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 'HDMI, USB 2.0', 'PS4 Ethernet', 0, 0, 2, 'Ja', 0, 80, 99, 179, 500, 'Zwart, Wit', '2019-11-08', '', 0),
(20, 'Sony PlayStation VR', '2750057115988', '9843757', 297, './view/assets/img/2000774356.png', '', 'Sony', 'PS4', 1, '1920x1080 (Full HD)', 100, 90, 0, 0, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 'HDMI, USB 2.0', 'PS4 Ethernet', 0, 0, 2, 'Ja', 0, 80, 90, 190, 500, 'Zwart', '2019-02-12', '', 0),
(21, 'Dell Visor + Dell Visor controllers', '5397184004470', '545-BBBF', 467, './view/assets/img/2001740465.jpeg', '', 'Dell', 'PC', 1, '2880x1440', 110, 90, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, '3.5mm, HDMI, USB 3.2 (Gen1, 5Gb/s)', 'PC Ethernet', 0, 0, 2, 'Ja', 0, 150, 210, 270, 590, 'Wit', '0000-00-00', '', 0),
(22, 'HTC Vive Cosmos Elite', '4718487716814', '99HART002-00', 999, './view/assets/img/2003398732.png', '', 'HTC', 'PC', 1, '2880x1700', 110, 90, 0, 0, 0, 1, 1, 1, 0, 0, 0, 1, 0, 0, 'PC Ethernet', 'Geen', 0, 0, 2, 'Ja', 2, 200, 260, 279, 500, 'Zwart', '2019-09-17', 'Cosmos Elite', 0),
(23, 'Oculus Go 32GB', '0815820020202', '301-00103-01', 249, './view/assets/img/2001963385.jpeg', '', 'Oculus', 'Standalone', 1, '2560x1440 (Quad HD)', 100, 72, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'WiFi', 'WiFi', 0, 0, 2, 'Nee', 0, 300, 342, 322, 564, 'Wit', '2019-10-08', 'Go 32GB', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'jack', '$2y$10$3Vp.zRpYhH/BiAW3tMtsh.l/hGq.a2wAdYE8fDz6jSkgG8h7svu/S'),
(2, 'haneke', '$2y$10$3Vp.zRpYhH/BiAW3tMtsh.l/hGq.a2wAdYE8fDz6jSkgG8h7svu/S');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexen voor tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `content`
--
ALTER TABLE `content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
