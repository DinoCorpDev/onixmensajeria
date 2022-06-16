-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 15-06-2022 a las 23:44:25
-- Versión del servidor: 5.7.36
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `laravel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competences`
--

DROP TABLE IF EXISTS `competences`;
CREATE TABLE IF NOT EXISTS `competences` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `competences`
--

INSERT INTO `competences` (`id`, `label`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Protocolo', 'protocol', NULL, NULL),
(2, 'Pasarela ropa interior', 'underwear_catwalk', NULL, NULL),
(3, 'Pasarela ropa exterior', 'outerwear_catwalk', NULL, NULL),
(4, 'Baile', 'dance', NULL, NULL),
(5, 'Canto', 'song', NULL, NULL),
(6, 'Actuación protagónica', 'leading_performance', NULL, NULL),
(7, 'Actuación figurante', 'figurant_performance', NULL, NULL),
(8, 'Actuación extra', 'extra_performance', NULL, NULL),
(9, 'Impulsador(a)', 'impeller', NULL, NULL),
(10, 'Promotor(a)', 'promoter', NULL, NULL),
(11, 'Modelo body painting', 'painting_body_model', NULL, NULL),
(12, 'Modelo de fotografía', 'photography_model', NULL, NULL),
(13, 'Presentación de eventos', 'presentation_of_events', NULL, NULL),
(14, 'Presentación de TV', 'presentation_of_tv', NULL, NULL),
(15, 'Musico', 'musician', NULL, NULL),
(16, 'Cantante', 'singer', NULL, NULL),
(17, 'Comediante', 'comedian', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idItalentt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `typePersonal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initialDate` date NOT NULL,
  `endDate` date NOT NULL,
  `hourly` json NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `totalBudget` bigint(20) NOT NULL,
  `dailyBudget` bigint(20) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `idItalentt`, `name`, `banner`, `typePersonal`, `initialDate`, `endDate`, `hourly`, `city`, `location`, `address`, `totalBudget`, `dailyBudget`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 'Prueba 1', 'https://firebasestorage.googleapis.com/v0/b/italent-6fbfc.appspot.com/o/adminDashboard%2Fpostulations%2Flogo.png?alt=media&token=de6db659-186d-46be-b86b-a1ac32680260', '{\"type\":\"Normal\",\"quantity\":\"8\",\"description\":\"Prueba de web\"}', '2022-06-23', '2022-06-29', '[{\"day\": \"Lunes\", \"hourly\": \"14:00\"}]', 'Mexio', 'Teatro de la ciudad', '\"Conocida\"', 5000, 600, 'open', '2022-06-16 00:51:21', '2022-06-16 00:51:21'),
(2, '2', 'Prueba 2', 'https://firebasestorage.googleapis.com/v0/b/italent-6fbfc.appspot.com/o/adminDashboard%2Fpostulations%2Ffavicon.png?alt=media&token=1e4f8083-adac-4b43-bc4c-fd9acaad8d8b', '{\"type\":\"Solteros\",\"quantity\":\"250\",\"description\":\"Demo 2\"}', '2022-06-21', '2022-06-22', '[{\"day\": \"Sabado\", \"hourly\": \"12:00\"}]', 'Mexico', 'Parke', '\"Conocida 2\"', 6000, 800, 'open', '2022-06-16 01:04:48', '2022-06-16 01:04:48'),
(3, '3', 'Demo 3', 'https://firebasestorage.googleapis.com/v0/b/italent-6fbfc.appspot.com/o/adminDashboard%2Fpostulations%2Ffavicon.png?alt=media&token=e9995b12-ec2a-4c24-8bae-22aa1f4d5508', '{\"type\":\"normal\",\"quantity\":\"150\",\"description\":\"Demo 3\"}', '2022-06-15', '2022-07-01', '[{\"day\": \"lunes\", \"hourly\": \"12:00\"}]', 'Mexico', 'Centro', '\"Conocida 3\"', 20000, 499, 'open', '2022-06-16 02:36:14', '2022-06-16 02:36:14'),
(4, '4', 'Demo 4', 'https://firebasestorage.googleapis.com/v0/b/italent-6fbfc.appspot.com/o/adminDashboard%2Fpostulations%2Flogo.png?alt=media&token=95df6124-5e43-4fe0-8747-acb509bfaab3', '{\"type\":\"normal\",\"quantity\":\"100\",\"description\":\"demo 4\"}', '2022-06-22', '2022-06-28', '[{\"day\": \"luines\", \"hourly\": \"12:00\"}]', 'Mexico', 'Centro', '\"conocida\"', 120000, 1000, 'open', '2022-06-16 02:40:47', '2022-06-16 02:40:47'),
(5, '5', 'Demo 5', 'https://firebasestorage.googleapis.com/v0/b/italent-6fbfc.appspot.com/o/adminDashboard%2Fpostulations%2Flogo.png?alt=media&token=d6340b4f-c9a4-4580-bd45-bf8c127af5ff', '{\"type\":\"normal\",\"quantity\":\"100\",\"description\":\"demo 5\"}', '2022-06-22', '2022-06-28', '[{\"day\": \"luines\", \"hourly\": \"12:00\"}]', 'Mexico', 'Centro', '\"conocida\"', 120000, 1000, 'open', '2022-06-16 02:42:59', '2022-06-16 02:42:59'),
(6, '6', 'Demo 6', 'https://firebasestorage.googleapis.com/v0/b/italent-6fbfc.appspot.com/o/adminDashboard%2Fpostulations%2Flogo.png?alt=media&token=41f34e5a-8992-4d33-ad39-f0cf4c77e27e', '{\"type\":\"normal\",\"quantity\":\"100\",\"description\":\"demo 6\"}', '2022-06-22', '2022-06-28', '[{\"day\": \"luines\", \"hourly\": \"12:00\"}]', 'Mexico', 'Centro', '\"conocida\"', 120000, 1000, 'open', '2022-06-16 02:53:26', '2022-06-16 02:53:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_users`
--

DROP TABLE IF EXISTS `events_users`;
CREATE TABLE IF NOT EXISTS `events_users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idTalent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_event` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `events_users_id_event_foreign` (`id_event`),
  KEY `events_users_id_user_foreign` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genders`
--

DROP TABLE IF EXISTS `genders`;
CREATE TABLE IF NOT EXISTS `genders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_11_162715_roles', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_03_08_185050_create_users_roles_table', 1),
(7, '2022_03_08_210422_create_events_table', 1),
(8, '2022_03_08_212848_create_events_users_table', 1),
(9, '2022_03_24_221805_create_personal_types_table', 1),
(10, '2022_03_24_222159_create_genders_table', 1),
(11, '2022_03_24_222218_create_competences_table', 1),
(12, '2022_03_24_222233_create_sectors_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE IF NOT EXISTS `notificaciones` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `idevento` bigint(20) DEFAULT NULL,
  `titulo` varchar(250) DEFAULT NULL,
  `detalle` text,
  `banner` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `idevento`, `titulo`, `detalle`, `banner`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Demo 6', 'demo 6', NULL, 1, '2022-06-16 02:53:26', '2022-06-16 02:53:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_types`
--

DROP TABLE IF EXISTS `personal_types`;
CREATE TABLE IF NOT EXISTS `personal_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal_types`
--

INSERT INTO `personal_types` (`id`, `label`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Hombre', 'man', NULL, NULL),
(2, 'Mujer', 'woman', NULL, NULL),
(3, 'Mixto', 'both', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `label`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Cantante', 'singer', NULL, NULL),
(2, 'Modelo', 'model', NULL, NULL),
(3, 'Presentador', 'host', NULL, NULL),
(4, 'Actor', 'actor', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectors`
--

DROP TABLE IF EXISTS `sectors`;
CREATE TABLE IF NOT EXISTS `sectors` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sectors`
--

INSERT INTO `sectors` (`id`, `label`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Televisión', 'TV', NULL, NULL),
(2, 'Presentación', 'host', NULL, NULL),
(3, 'Modelaje', 'model', NULL, NULL),
(4, 'Teatro', 'theater', NULL, NULL),
(5, 'Cine', 'cinema', NULL, NULL),
(6, 'Música', 'music', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `nombre`) VALUES
(1, 'Activo'),
(2, 'Pendiente'),
(3, 'Inactivo'),
(4, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sectors` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pyshical` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `competences` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` longtext COLLATE utf8mb4_unicode_ci,
  `identification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autorization` tinyint(1) DEFAULT NULL,
  `terms_conditions` tinyint(1) DEFAULT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provisionalPassword` tinyint(1) NOT NULL DEFAULT '0',
  `firstLogin` tinyint(1) NOT NULL DEFAULT '1',
  `verified` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '2',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `contact`, `email`, `password`, `nickname`, `birthday`, `gender`, `sectors`, `pyshical`, `competences`, `education`, `experience`, `identification`, `address`, `city`, `country`, `profile`, `photos`, `video`, `autorization`, `terms_conditions`, `roles`, `provisionalPassword`, `firstLogin`, `verified`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '1', '{\'phone\':\'3144459146\'}', 'administrador@gmail.com', '$2y$10$vyThDCbL3jS1Ys5n9xDCuOvKISpgityXIVd3S7EjZs.612ySMnaX.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 1, 1, 1, NULL, NULL, NULL),
(2, 'Javier', 'Hernandez', '9988774455', 'fjmg2485@gmail.com', '$2y$10$X1GsVNKkQIk9DDdGNN7dUuNdtSTg62p1tQr7e1aOtNHy.dt4xmHQC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 1, 1, 2, NULL, '2022-06-14 22:33:56', '2022-06-14 22:33:56'),
(3, 'Javier2', 'eee', '9988774455', 'fjmg2485@gmail.com', '$2y$10$HczUZMjnprTbpU1.890pP.fnn0RfZqc4BqOf9CKwKsLkKUoAs46eK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"label\":null,\"string\":null}', NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 1, 1, 3, NULL, '2022-06-14 22:35:07', '2022-06-15 22:15:46'),
(4, 'Francisco', 'demo', '9988774455', 'demo@demo.com', '$2y$10$soP4DIH.sbca7c.vQERJeu3BRGEZ8AjPTuIHcx8GT/7imUurkrRaG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 0, 1, 1, 2, NULL, '2022-06-14 22:36:25', '2022-06-15 22:13:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE IF NOT EXISTS `users_roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_rol` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_roles_id_rol_foreign` (`id_rol`),
  KEY `users_roles_id_user_foreign` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
