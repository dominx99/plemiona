-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 16 Wrz 2018, 19:18
-- Wersja serwera: 10.1.30-MariaDB
-- Wersja PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `plemiona`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plemiona_army`
--

CREATE TABLE `plemiona_army` (
  `id` int(11) NOT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `power` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `plemiona_army`
--

INSERT INTO `plemiona_army` (`id`, `type`, `name`, `power`, `defense`, `capacity`, `created_at`, `updated_at`) VALUES
(1, 'pikeman', 'Pikinier', 3, 7, 30, '2018-09-15 20:26:10', '2018-09-15 20:38:15'),
(2, 'swordman', 'Miecznik', 5, 5, 50, '2018-09-15 20:27:02', '2018-09-15 20:38:17');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plemiona_buildings`
--

CREATE TABLE `plemiona_buildings` (
  `id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `color` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plemiona_building_costs`
--

CREATE TABLE `plemiona_building_costs` (
  `id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plemiona_building_village`
--

CREATE TABLE `plemiona_building_village` (
  `id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `building_level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plemiona_requirements`
--

CREATE TABLE `plemiona_requirements` (
  `id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `requirementable_level` int(11) NOT NULL,
  `requirementable_id` int(11) NOT NULL,
  `requirementable_type` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plemiona_timings`
--

CREATE TABLE `plemiona_timings` (
  `id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `done_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plemiona_users`
--

CREATE TABLE `plemiona_users` (
  `id` int(11) NOT NULL,
  `nick` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plemiona_villages`
--

CREATE TABLE `plemiona_villages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `food` int(11) NOT NULL DEFAULT '50',
  `gold` int(11) NOT NULL DEFAULT '300',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `plemiona_army`
--
ALTER TABLE `plemiona_army`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `plemiona_buildings`
--
ALTER TABLE `plemiona_buildings`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `plemiona_building_costs`
--
ALTER TABLE `plemiona_building_costs`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `plemiona_building_village`
--
ALTER TABLE `plemiona_building_village`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `plemiona_requirements`
--
ALTER TABLE `plemiona_requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `plemiona_timings`
--
ALTER TABLE `plemiona_timings`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `plemiona_users`
--
ALTER TABLE `plemiona_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `plemiona_villages`
--
ALTER TABLE `plemiona_villages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `plemiona_army`
--
ALTER TABLE `plemiona_army`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `plemiona_buildings`
--
ALTER TABLE `plemiona_buildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT dla tabeli `plemiona_building_costs`
--
ALTER TABLE `plemiona_building_costs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT dla tabeli `plemiona_building_village`
--
ALTER TABLE `plemiona_building_village`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT dla tabeli `plemiona_requirements`
--
ALTER TABLE `plemiona_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `plemiona_timings`
--
ALTER TABLE `plemiona_timings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT dla tabeli `plemiona_users`
--
ALTER TABLE `plemiona_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT dla tabeli `plemiona_villages`
--
ALTER TABLE `plemiona_villages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;