-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 06 Lut 2017, 11:05
-- Wersja serwera: 10.1.19-MariaDB
-- Wersja PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `owasptop10`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `a1_uzytkownicy`
--

CREATE TABLE `a1_uzytkownicy` (
  `Id` int(11) NOT NULL,
  `Nazwa` text NOT NULL,
  `Haslo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `a1_uzytkownicy`
--

INSERT INTO `a1_uzytkownicy` (`Id`, `Nazwa`, `Haslo`) VALUES
(1, 'login1', 'haslo1'),
(2, 'login2', 'haslo2'),
(3, 'login3', 'haslo3');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `a1_wiadomosci`
--

CREATE TABLE `a1_wiadomosci` (
  `Id` int(11) NOT NULL,
  `Tytul` text NOT NULL,
  `Tekst` text NOT NULL,
  `Kategoria` int(11) NOT NULL,
  `Aktywna` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `a1_wiadomosci`
--

INSERT INTO `a1_wiadomosci` (`Id`, `Tytul`, `Tekst`, `Kategoria`, `Aktywna`) VALUES
(1, 'Pierwszy przykladowy tytul', '', 1, b'1'),
(2, 'Drugi przykladowy tytul', '', 2, b'0'),
(3, 'Trzeci przykladowy tytul', '', 2, b'1'),
(4, 'Czwarty przykldowy tytul', '', 1, b'1'),
(5, 'Piaty przykladowy tytul', '', 1, b'0'),
(6, 'Szosty przykladowy tytul', '', 2, b'1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `a3_ksiega_gosci`
--

CREATE TABLE `a3_ksiega_gosci` (
  `id` int(10) UNSIGNED NOT NULL,
  `autor` varchar(45) NOT NULL,
  `tresc` text NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `a3_ksiega_gosci`
--

INSERT INTO `a3_ksiega_gosci` (`id`, `autor`, `tresc`, `data`) VALUES
(1, 'Admin', 'Testowy wpis do ksiegi gosci', '2016-12-20 17:21:06'),
(45, 'test2', 'Testuje <b> GruboÅ›Ä‡ </b> , <em> pochylenie </em> i <strong> Grubosc 2 </strong>', '2017-01-10 16:58:24'),
(46, 'Autor', '<script>alert(''xss'');</script>', '2017-01-10 17:44:43'),
(47, 'Autor', 'Usuwa skrypty <script> alert(''aha'') </script> <b> ale nie pogrubienie </b>', '2017-01-10 19:55:22'),
(48, 'asfasda', '<script> alert(''xxx'')</script>', '2017-01-13 14:58:04'),
(49, 'dasfa', '<script> alert(''xxx'')</script>', '2017-01-13 15:00:29'),
(50, 'abc', '<SCRIPT>document.write(document.cookie);</SCRIPT>', '2017-01-16 16:26:31');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `a5_pliki`
--

CREATE TABLE `a5_pliki` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL,
  `opis` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `a5_pliki`
--

INSERT INTO `a5_pliki` (`id`, `nazwa`, `opis`) VALUES
(7, 'Logo3.jpg', 'Owasp logo'),
(8, 'MySQL.png', 'Logo MySQL'),
(9, 'logo-php-adbac78231.png', 'SÅ‚oÅ„ PHP');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `a5_pliki_fix`
--

CREATE TABLE `a5_pliki_fix` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL,
  `opis` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `a5_pliki_fix`
--

INSERT INTO `a5_pliki_fix` (`id`, `nazwa`, `opis`) VALUES
(1, '2fe3597a688703339c447a00041693c5.png', 'MySQL logo'),
(2, 'f1e96c00a4f8384fe0699c126afd5cc5.png', 'PHP'),
(3, 'e0783cd84d3ef405bd2fcd89039441e4.PNG', 'logo');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `a6_uzytkownicy`
--

CREATE TABLE `a6_uzytkownicy` (
  `Id` int(11) NOT NULL,
  `Nazwa` varchar(20) NOT NULL,
  `Haslo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `a6_uzytkownicy`
--

INSERT INTO `a6_uzytkownicy` (`Id`, `Nazwa`, `Haslo`) VALUES
(1, 'login1', 'haslo1'),
(2, 'login2', 'haslo2'),
(3, 'login3', 'haslo3');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `a6_uzytkownicy_fix`
--

CREATE TABLE `a6_uzytkownicy_fix` (
  `Id` int(11) NOT NULL,
  `Nazwa` varchar(20) NOT NULL,
  `Haslo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `a6_uzytkownicy_fix`
--

INSERT INTO `a6_uzytkownicy_fix` (`Id`, `Nazwa`, `Haslo`) VALUES
(1, 'login1', '$5$OJh1uCykRoYifvEa$sy7TPX1UpvSt9uLij36qxw2kS0mIFPovyJutDqHHhz1'),
(2, 'login2', '$5$vVcDY7FVu4GMoekn$2ndQ7hsoI.0rFQM4e.qHSZG2PQ4MQK6QWd5.hSCw4E8'),
(3, 'Nowy201', '$5$GVzdTG6R3pRPBc4Y$uoQi/vXOHUz5ZDU7PL18VmjiQ8wF0P5eA9leWB5qTQ/');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `a7_uzytkownicy`
--

CREATE TABLE `a7_uzytkownicy` (
  `Id` int(11) NOT NULL,
  `Nazwa` text NOT NULL,
  `Haslo` text NOT NULL,
  `Punkty` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `a7_uzytkownicy`
--

INSERT INTO `a7_uzytkownicy` (`Id`, `Nazwa`, `Haslo`, `Punkty`) VALUES
(1, 'login1', 'haslo1', 80),
(2, 'login2', 'haslo2', 20),
(3, 'login3', 'haslo3', 60);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `a9_licznik`
--

CREATE TABLE `a9_licznik` (
  `data` date NOT NULL DEFAULT '0000-00-00',
  `licznik` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `a9_licznik`
--

INSERT INTO `a9_licznik` (`data`, `licznik`) VALUES
('2017-01-25', 23),
('2017-01-26', 36),
('2017-01-27', 16),
('2017-01-28', 15),
('2017-01-29', 28);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `a1_uzytkownicy`
--
ALTER TABLE `a1_uzytkownicy`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `a1_wiadomosci`
--
ALTER TABLE `a1_wiadomosci`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `a3_ksiega_gosci`
--
ALTER TABLE `a3_ksiega_gosci`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a5_pliki`
--
ALTER TABLE `a5_pliki`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a5_pliki_fix`
--
ALTER TABLE `a5_pliki_fix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a6_uzytkownicy`
--
ALTER TABLE `a6_uzytkownicy`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nazwa` (`Nazwa`);

--
-- Indexes for table `a6_uzytkownicy_fix`
--
ALTER TABLE `a6_uzytkownicy_fix`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nazwa` (`Nazwa`);

--
-- Indexes for table `a7_uzytkownicy`
--
ALTER TABLE `a7_uzytkownicy`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `a9_licznik`
--
ALTER TABLE `a9_licznik`
  ADD PRIMARY KEY (`data`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `a1_uzytkownicy`
--
ALTER TABLE `a1_uzytkownicy`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `a3_ksiega_gosci`
--
ALTER TABLE `a3_ksiega_gosci`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT dla tabeli `a5_pliki`
--
ALTER TABLE `a5_pliki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT dla tabeli `a5_pliki_fix`
--
ALTER TABLE `a5_pliki_fix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `a6_uzytkownicy`
--
ALTER TABLE `a6_uzytkownicy`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `a6_uzytkownicy_fix`
--
ALTER TABLE `a6_uzytkownicy_fix`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
