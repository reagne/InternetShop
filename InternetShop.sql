-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 21 Lut 2016, 18:42
-- Wersja serwera: 5.5.47-0ubuntu0.14.04.1
-- Wersja PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `InternetShop`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Admins`
--

CREATE TABLE IF NOT EXISTS `Admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(70) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Zrzut danych tabeli `Admins`
--

INSERT INTO `Admins` (`id`, `email`, `password`) VALUES
(1, 'agata@admin.pl', '$2y$11$JpWqU8Vwox/WmvImtlb59eNwUsO4hpkqBRDiT9kvFqOIUBAek2jm6'),
(43, 'regina@wp.pl', '$2y$11$NPRWvhdPA4tA0Oj354/DseTKXWRC3ef7GBkP7FEgEqTZqh2N0d4qK');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Categories`
--

CREATE TABLE IF NOT EXISTS `Categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `Categories`
--

INSERT INTO `Categories` (`id`, `name`) VALUES
(1, 'meble'),
(3, 'plecaki'),
(4, 'torby'),
(2, 'ubrania');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Clients`
--

CREATE TABLE IF NOT EXISTS `Clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(70) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `address` varchar(150) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Zrzut danych tabeli `Clients`
--

INSERT INTO `Clients` (`id`, `first_name`, `last_name`, `email`, `password`, `address`) VALUES
(1, 'Ewelina', 'Kozio³', 'ew@wp.pl', '$2y$11$qOz.XBZ6UODRtRegnpwzsOjnhL/NZNSeTSXcFkWVFCK05fbdLOoFy', 'ul. Jagienki 6\r\n67-100 Nowa Sól'),
(3, 'Andrzej', 'Koala', 'andrzej@wp.pl', '$2y$11$BTDLr2J8MOzz7RApSPZ4D.BIgwwZ6YDGTH1iq0P/hLGt0fyf6D0XS', 'ul. Opolska 2\r\n34-100 O³awa'),
(5, 'Robert', 'Man', 'robert@wp.pl', '$2y$11$EZULwjgNPQgCH/T67M4PMupmeDqwVJ7exnr.hM6Jyehp8WOonk05G', 'ul. Kileonajkn 4');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Images`
--

CREATE TABLE IF NOT EXISTS `Images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `path_to_file` varchar(280) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Orders`
--

CREATE TABLE IF NOT EXISTS `Orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `price_sum` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Zrzut danych tabeli `Orders`
--

INSERT INTO `Orders` (`id`, `client_id`, `status`, `price_sum`) VALUES
(1, 1, 2, 4034.98),
(14, 1, 3, 0),
(15, 3, 3, NULL),
(17, 1, 2, 5827.92);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Products`
--

CREATE TABLE IF NOT EXISTS `Products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `price` double NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `active` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Products_ibfk_1` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `Products`
--

INSERT INTO `Products` (`id`, `name`, `price`, `description`, `category`, `active`) VALUES
(1, 'łóżko', 1289, 'drewniane, mocne', 1, 1),
(2, 'sofa', 1456.98, 'rozkładana sofa', 1, 0),
(3, 'test', 123, 'jgjgj', 1, 0),
(4, 'test1', 12, 'testtt', 2, 1),
(5, 'bia?a', 2, 'kredka', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Products_Orders`
--

CREATE TABLE IF NOT EXISTS `Products_Orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_price` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Zrzut danych tabeli `Products_Orders`
--

INSERT INTO `Products_Orders` (`id`, `product_id`, `order_id`, `product_quantity`, `product_price`) VALUES
(1, 1, 1, 3, 0),
(2, 2, 1, 2, 0),
(4, 2, 17, 4, 0);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Images`
--
ALTER TABLE `Images`
  ADD CONSTRAINT `Images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `Clients` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `Products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `Categories` (`id`);

--
-- Ograniczenia dla tabeli `Products_Orders`
--
ALTER TABLE `Products_Orders`
  ADD CONSTRAINT `Products_Orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`),
  ADD CONSTRAINT `Products_Orders_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
