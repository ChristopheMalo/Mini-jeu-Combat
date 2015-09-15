-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Client :  localhost:3306
-- Généré le :  Dim 13 Septembre 2015 à 19:41
-- Version du serveur :  5.5.42
-- Version de PHP :  5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `MiniJeuCombat`
--

-- --------------------------------------------------------

--
-- Structure de la table `Personnages`
--

CREATE TABLE `Personnages` (
  `id` smallint(5) unsigned NOT NULL,
  `nom` varchar(50) NOT NULL,
  `degats` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `personnages`
--
ALTER TABLE `Personnages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `personnages`
--
ALTER TABLE `Personnages`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;