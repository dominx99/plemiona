-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 25 Wrz 2018, 22:43
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
-- Struktura tabeli dla tabeli `plemiona_armies`
--

CREATE TABLE `plemiona_armies` (
  `id` int(11) NOT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `power` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plemiona_army_expedition`
--

CREATE TABLE `plemiona_army_expedition` (
  `id` int(11) NOT NULL,
  `army_id` int(11) NOT NULL,
  `expedition_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `plemiona_army_expedition`
--

INSERT INTO `plemiona_army_expedition` (`id`, `army_id`, `expedition_id`, `amount`, `created_at`, `updated_at`) VALUES
(47, 1, 1, 25, '2018-09-23 17:07:09', '0000-00-00 00:00:00'),
(48, 1, 2, 50, '2018-09-23 17:09:08', '0000-00-00 00:00:00'),
(49, 1, 3, 85, '2018-09-23 17:10:49', '0000-00-00 00:00:00'),
(50, 2, 4, 10, '2018-09-23 17:31:46', '0000-00-00 00:00:00'),
(51, 2, 5, 10, '2018-09-23 17:31:47', '0000-00-00 00:00:00'),
(52, 2, 6, 10, '2018-09-23 17:31:47', '0000-00-00 00:00:00'),
(53, 2, 7, 10, '2018-09-23 17:31:47', '0000-00-00 00:00:00'),
(54, 2, 8, 10, '2018-09-23 17:31:48', '0000-00-00 00:00:00'),
(55, 1, 9, 145, '2018-09-23 17:31:54', '0000-00-00 00:00:00'),
(56, 2, 9, 21, '2018-09-23 17:31:54', '0000-00-00 00:00:00'),
(57, 2, 10, 39, '2018-09-23 17:32:11', '0000-00-00 00:00:00'),
(58, 2, 11, 50, '2018-09-23 17:32:16', '0000-00-00 00:00:00'),
(59, 1, 12, 145, '2018-09-23 17:32:20', '0000-00-00 00:00:00'),
(60, 2, 12, 21, '2018-09-23 17:32:20', '0000-00-00 00:00:00'),
(61, 1, 13, 145, '2018-09-23 17:56:43', '0000-00-00 00:00:00'),
(62, 2, 13, 270, '2018-09-23 17:56:43', '0000-00-00 00:00:00'),
(63, 3, 13, 20, '2018-09-23 17:56:43', '0000-00-00 00:00:00'),
(64, 2, 14, 40, '2018-09-23 17:58:28', '0000-00-00 00:00:00'),
(65, 3, 14, 40, '2018-09-23 17:58:28', '0000-00-00 00:00:00'),
(66, 2, 15, 300, '2018-09-23 18:00:05', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plemiona_army_village`
--

CREATE TABLE `plemiona_army_village` (
  `id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `army_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Struktura tabeli dla tabeli `plemiona_expeditions`
--

CREATE TABLE `plemiona_expeditions` (
  `id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `destination` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `food` int(11) DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `reach_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plemiona_reports`
--

CREATE TABLE `plemiona_reports` (
  `id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `expedition_id` int(11) NOT NULL,
  `is_sender` tinyint(1) NOT NULL,
  `win` tinyint(1) NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_polish_ci,
  `power` int(11) DEFAULT NULL,
  `defense` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
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
  `requirementable_type` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
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
-- Indeksy dla tabeli `plemiona_armies`
--
ALTER TABLE `plemiona_armies`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `plemiona_army_expedition`
--
ALTER TABLE `plemiona_army_expedition`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `plemiona_army_village`
--
ALTER TABLE `plemiona_army_village`
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
-- Indeksy dla tabeli `plemiona_expeditions`
--
ALTER TABLE `plemiona_expeditions`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `plemiona_reports`
--
ALTER TABLE `plemiona_reports`
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
-- AUTO_INCREMENT dla tabeli `plemiona_armies`
--
ALTER TABLE `plemiona_armies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `plemiona_army_expedition`
--
ALTER TABLE `plemiona_army_expedition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT dla tabeli `plemiona_army_village`
--
ALTER TABLE `plemiona_army_village`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT dla tabeli `plemiona_buildings`
--
ALTER TABLE `plemiona_buildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT dla tabeli `plemiona_building_costs`
--
ALTER TABLE `plemiona_building_costs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `plemiona_building_village`
--
ALTER TABLE `plemiona_building_village`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT dla tabeli `plemiona_expeditions`
--
ALTER TABLE `plemiona_expeditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `plemiona_reports`
--
ALTER TABLE `plemiona_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `plemiona_requirements`
--
ALTER TABLE `plemiona_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `plemiona_timings`
--
ALTER TABLE `plemiona_timings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `plemiona_users`
--
ALTER TABLE `plemiona_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `plemiona_villages`
--
ALTER TABLE `plemiona_villages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
