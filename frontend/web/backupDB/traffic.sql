-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 15 2021 г., 16:58
-- Версия сервера: 5.6.47
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `traffic`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1613395637);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Администратор', NULL, NULL, 1613395637, 1613395637),
('driver', 1, 'Водитель', NULL, NULL, 1613395637, 1613395637),
('manager', 1, 'Менеджер', NULL, NULL, 1613395637, 1613395637),
('market', 1, 'Сотрудник рынка', NULL, NULL, 1613395637, 1613395637),
('permissionAdmin', 2, 'Полный доступ ко всмем параметрам и вкладкам', NULL, NULL, 1613395637, 1613395637),
('permissionDriver', 2, 'Просмотр списка оформленных клиентов', NULL, NULL, 1613395637, 1613395637),
('permissionManager', 2, 'Выгрузка упаковочного листа по клиентам и позициям', NULL, NULL, 1613395637, 1613395637),
('permissionMarket', 2, 'Создание, редактирование клиентов. Оформление заявки клиента', NULL, NULL, 1613395637, 1613395637),
('permissionStock', 2, 'Создание, редактирование заказов. ', NULL, NULL, 1613395637, 1613395637),
('permissionStockDPR', 2, 'Отмечать проверенные и отгруженные заказы', NULL, NULL, 1613395637, 1613395637),
('stockman', 1, 'Сотрудник склада', NULL, NULL, 1613395637, 1613395637),
('stockmanDPR', 1, 'Сотрудник склада в ДНР', NULL, NULL, 1613395637, 1613395637);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'driver'),
('admin', 'manager'),
('admin', 'market'),
('admin', 'permissionAdmin'),
('driver', 'permissionDriver'),
('manager', 'permissionManager'),
('market', 'permissionMarket'),
('stockman', 'permissionStock'),
('stockmanDPR', 'permissionStockDPR'),
('admin', 'stockman'),
('admin', 'stockmanDPR');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `carrier`
--

CREATE TABLE `carrier` (
  `id` int(11) NOT NULL,
  `article` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `carrier`
--

INSERT INTO `carrier` (`id`, `article`, `name`, `phone`) VALUES
(1, 'СВ', 'Самовывоз', '+38(071)000-00-00');

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `article` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1613395547),
('m130524_201442_init', 1613395634),
('m140506_102106_rbac_init', 1613395613),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1613395613),
('m180523_151638_rbac_updates_indexes_without_prefix', 1613395614),
('m190124_110200_add_verification_token_column_to_user_table', 1613395635),
('m200409_110543_rbac_update_mssql_trigger', 1613395614),
('m201002_141014_create_client_table', 1613395636),
('m201002_144548_create_type_of_package_table', 1613395636),
('m201002_144620_create_unit_table', 1613395636),
('m201013_171415_create_carrier_table', 1613395636),
('m210111_105945_alter_table_user_drop_index_unique_on_username', 1613395637),
('m210111_114241_create_rbac_date', 1613395637),
('m210115_222008_create_registr_client_table', 1613395638),
('m210202_125610_create_order_table', 1613395641),
('m210202_132552_create_pack_table', 1613395642),
('m210211_120348_create_default_parameter', 1613395642);

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `carrier_id` int(11) DEFAULT NULL,
  `type_of_package_id` varchar(255) DEFAULT NULL,
  `width` varchar(255) DEFAULT NULL,
  `height` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `length` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `cost` varchar(255) DEFAULT NULL,
  `notes` text,
  `status` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pack`
--

CREATE TABLE `pack` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `count` varchar(255) DEFAULT NULL,
  `unit_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `registr_client`
--

CREATE TABLE `registr_client` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `client_article` varchar(255) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `client_phone` varchar(255) DEFAULT NULL,
  `client_city` varchar(255) DEFAULT NULL,
  `client_area` varchar(255) DEFAULT NULL,
  `client_carrier_id` varchar(255) DEFAULT NULL,
  `client_carrier_article` varchar(255) DEFAULT NULL,
  `client_carrier_name` varchar(255) DEFAULT NULL,
  `client_carrier_phone` varchar(255) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `type_of_package`
--

CREATE TABLE `type_of_package` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `type_of_package`
--

INSERT INTO `type_of_package` (`id`, `name`) VALUES
(1, 'сумка');

-- --------------------------------------------------------

--
-- Структура таблицы `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `unit`
--

INSERT INTO `unit` (`id`, `name`) VALUES
(1, 'шт');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'Админ', 'kGwXiuaumUMcwK1LETpBBn4CIS6ftCmN', '$2y$13$P9.d7KUb8C6BHCvkdzMsrOi5U.vIAw01UmriB.34PiN50e8nTGFge', NULL, 'admin@admin.ru', 10, 1613395637, 1613395637, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `carrier`
--
ALTER TABLE `carrier`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-order-user_id` (`user_id`);

--
-- Индексы таблицы `pack`
--
ALTER TABLE `pack`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-pack-order_id` (`order_id`);

--
-- Индексы таблицы `registr_client`
--
ALTER TABLE `registr_client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-registr_client-client_id` (`client_id`);

--
-- Индексы таблицы `type_of_package`
--
ALTER TABLE `type_of_package`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `carrier`
--
ALTER TABLE `carrier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `pack`
--
ALTER TABLE `pack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `registr_client`
--
ALTER TABLE `registr_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `type_of_package`
--
ALTER TABLE `type_of_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk-order-user_id` FOREIGN KEY (`user_id`) REFERENCES `registr_client` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pack`
--
ALTER TABLE `pack`
  ADD CONSTRAINT `fk-pack-order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `registr_client`
--
ALTER TABLE `registr_client`
  ADD CONSTRAINT `fk-registr_client-client_id` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
