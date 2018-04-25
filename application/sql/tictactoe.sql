-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 25 2018 г., 23:48
-- Версия сервера: 5.5.53
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tictactoe`
--

-- --------------------------------------------------------

--
-- Структура таблицы `moves`
--

CREATE TABLE `moves` (
  `id` int(11) NOT NULL,
  `cell` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `moves`
--

INSERT INTO `moves` (`id`, `cell`, `user_id`, `room_id`) VALUES
(13, 0, 1, 20),
(14, 1, 2, 20),
(15, 3, 2, 20),
(17, 4, 2, 20),
(18, 6, 2, 20),
(19, 2, 2, 20),
(20, 5, 2, 20),
(21, 7, 2, 20),
(22, 8, 2, 20),
(23, 5, 2, 0),
(24, 3, 2, 20),
(25, 3, 2, 20),
(26, 3, 2, 20),
(27, 0, 2, 20),
(28, 2, 2, 20),
(29, 1, 2, 20),
(30, 4, 2, 20),
(31, 7, 2, 20),
(32, 6, 2, 20),
(33, 3, 2, 20),
(34, 0, 2, 20),
(35, 8, 2, 20),
(36, 7, 2, 20),
(37, 6, 2, 20),
(38, 3, 2, 20),
(39, 4, 2, 20),
(40, 5, 2, 20),
(41, 2, 2, 20),
(42, 1, 2, 20),
(43, 0, 2, 20),
(44, 5, 2, 20),
(45, 4, 2, 20),
(46, 7, 2, 37),
(47, 4, 2, 37),
(48, 5, 3, 37),
(49, 8, 2, 37),
(50, 3, 3, 37),
(51, 6, 2, 37),
(52, 4, 2, 0),
(53, 4, 2, 0),
(54, 0, 2, 0),
(55, 0, 2, 0),
(56, 0, 2, 0),
(57, 3, 2, 0),
(58, 0, 3, 40),
(59, 1, 2, 40),
(60, 4, 2, 40),
(61, 3, 2, 40),
(62, 2, 2, 40),
(63, 5, 2, 40),
(64, 7, 2, 40),
(65, 6, 2, 40),
(66, 4, 3, 41),
(67, 3, 2, 42),
(68, 4, 2, 43),
(69, 1, 3, 44),
(70, 4, 2, 45),
(71, 4, 3, 46),
(72, 0, 2, 46),
(73, 0, 3, 46),
(74, 1, 3, 46),
(75, 2, 2, 46),
(76, 3, 3, 46),
(77, 5, 2, 46),
(78, 7, 3, 46),
(79, 6, 2, 46),
(80, 8, 3, 46),
(81, 0, 2, 46),
(82, 1, 2, 47),
(83, 4, 3, 47),
(84, 0, 2, 47),
(85, 0, 3, 47),
(86, 2, 2, 47),
(87, 0, 3, 48),
(88, 1, 2, 48),
(89, 2, 3, 48),
(90, 3, 2, 48),
(91, 4, 3, 48),
(92, 3, 3, 49),
(93, 0, 2, 49),
(94, 4, 3, 49),
(95, 1, 2, 49),
(96, 5, 3, 49);

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `current_player` int(11) NOT NULL,
  `start_move` int(11) NOT NULL,
  `date` int(11) NOT NULL COMMENT 'Дата создания',
  `owner` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `moves` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `current_player`, `start_move`, `date`, `owner`, `status`, `moves`) VALUES
(49, 'It\'s my life', 2, 1524688834, 1524688716, 3, 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `room_members`
--

CREATE TABLE `room_members` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sign` int(11) NOT NULL,
  `last_move` int(11) NOT NULL COMMENT 'Время последнего хода'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `room_members`
--

INSERT INTO `room_members` (`id`, `room_id`, `user_id`, `sign`, `last_move`) VALUES
(45, 49, 3, 1, 1524688834),
(46, 49, 2, 0, 1524688826);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `sex` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `wins` int(11) NOT NULL,
  `defeats` int(11) NOT NULL,
  `matches` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `sex`, `room`, `wins`, `defeats`, `matches`) VALUES
(2, 'Admin', '827ccb0eea8a706c4c34a16891f84e7b', 'dfdsf', 0, 49, 1, 1, 2),
(3, 'User', '827ccb0eea8a706c4c34a16891f84e7b', 'sddfgfd', 0, 49, 1, 1, 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `moves`
--
ALTER TABLE `moves`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `room_members`
--
ALTER TABLE `room_members`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `moves`
--
ALTER TABLE `moves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT для таблицы `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT для таблицы `room_members`
--
ALTER TABLE `room_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
