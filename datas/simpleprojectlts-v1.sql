-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : jeu. 16 juin 2022 à 12:43
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.0.13

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `simpleprojectlts`
--
DROP DATABASE IF EXISTS `simpleprojectlts`;
CREATE DATABASE IF NOT EXISTS `simpleprojectlts` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `simpleprojectlts`;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220614141804', '2022-06-14 14:21:07', 779),
('DoctrineMigrations\\Version20220616115429', '2022-06-16 11:55:11', 686),
('DoctrineMigrations\\Version20220616120429', '2022-06-16 12:05:47', 328);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `the_articles`
--

DROP TABLE IF EXISTS `the_articles`;
CREATE TABLE IF NOT EXISTS `the_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `the_title` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `the_text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `the_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `the_users`
--

DROP TABLE IF EXISTS `the_users`;
CREATE TABLE IF NOT EXISTS `the_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `themail` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `therealname` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BEBFB6EDF85E0677` (`username`),
  UNIQUE KEY `UNIQ_BEBFB6ED405C2D18` (`themail`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `the_users`
--

INSERT INTO `the_users` (`id`, `username`, `roles`, `password`, `themail`, `therealname`) VALUES
(1, 'util1', '[\"ROLE_USER\"]', '$2y$13$/mEEUBKTq6LUC41TxGzM5.D8S8amMLXfk5JGI7nyLe2yA8qqhusSK', 'michael.pitz@cf2m.be', 'Util the One');
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
