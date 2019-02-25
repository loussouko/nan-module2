-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 25 fév. 2019 à 18:54
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `nanphp`
--

-- --------------------------------------------------------

--
-- Structure de la table `avatar`
--

CREATE TABLE `avatar` (
  `id` smallint(6) NOT NULL,
  `image` varchar(255) NOT NULL,
  `id_users` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `avatar`
--

INSERT INTO `avatar` (`id`, `image`, `id_users`) VALUES
(25, '../public/upload/1550846969anasse3.jpg', 3),
(26, 'public/upload/1550847063junior2.jpg', 2),
(27, 'public/upload/1550941298kouadio25.jpg', 25),
(28, 'public/upload/1550945273kouadio36.jpg', 36),
(29, 'public/upload/1550948080kouadio35.jpg', 35),
(30, 'public/upload/1551115174kouadio34.jpg', 34);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `id` smallint(6) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `solde` int(255) NOT NULL,
  `code` int(9) NOT NULL,
  `compte_user` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id`, `mail`, `solde`, `code`, `compte_user`) VALUES
(26, 'kouadiokoffi@gmail.com', 298500, 753951456, 34),
(27, 'leontine@gmail.com', 568000, 753369987, 35),
(28, 'kouadio@gmail.com', 628500, 357684426, 36);

-- --------------------------------------------------------

--
-- Structure de la table `frais`
--

CREATE TABLE `frais` (
  `id` int(6) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `frais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `frais`
--

INSERT INTO `frais` (`id`, `min`, `max`, `frais`) VALUES
(1, 200, 5000, 100),
(2, 5005, 25000, 250),
(3, 25000, 50000, 500),
(4, 50000, 100000, 1000),
(5, 100005, 499999, 1500),
(6, 500000, 500000, 10000);

-- --------------------------------------------------------

--
-- Structure de la table `transfert`
--

CREATE TABLE `transfert` (
  `id` int(4) NOT NULL,
  `mail_expediteur` varchar(255) NOT NULL,
  `code_expediteur` int(255) NOT NULL,
  `mail_destinataire` varchar(255) NOT NULL,
  `montant` int(30) NOT NULL,
  `date_transfert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `frais` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `transfert`
--

INSERT INTO `transfert` (`id`, `mail_expediteur`, `code_expediteur`, `mail_destinataire`, `montant`, `date_transfert`, `frais`) VALUES
(29, 'kouadio@gmail.com', 357684426, 'leontine@gmail.com', 400000, '2019-02-25 16:55:25', 1500),
(30, 'kouadiokoffi@gmail.com', 753951456, 'kouadio@gmail.com', 200000, '2019-02-25 17:15:24', 1500),
(31, 'leontine@gmail.com', 753369987, 'kouadio@gmail.com', 30000, '2019-02-25 17:22:19', 500),
(32, 'leontine@gmail.com', 753369987, 'kouadio@gmail.com', 300000, '2019-02-25 17:28:56', 1500);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` smallint(6) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `numero` varchar(30) NOT NULL,
  `nationalite` varchar(255) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `statut` varchar(20) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `mdpR` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `age`, `numero`, `nationalite`, `sexe`, `statut`, `mdp`, `mdpR`, `mail`) VALUES
(3, 'anasse', 'joel', 20, '55297961', 'ivoirienne', 'masculin', 'admin', '2dd07c9ce0189aaacacff6a86a5fc61a8d38d851', '2dd07c9ce0189aaacacff6a86a5fc61a8d38d851', 'anassejean@gmail.com'),
(34, 'kouadio', 'franck', 25, '78945614', 'ivoirienne', 'masculin', 'client', '956f7172d574af630d202995c2e9a8c464a19c60', '956f7172d574af630d202995c2e9a8c464a19c60', 'kouadiokoffi@gmail.com'),
(35, 'kouame', 'leontine', 20, '02325614', 'ivoirienne', 'feminin', 'client', '009e058c883c683e1330228851ecafe3265c8f51', '009e058c883c683e1330228851ecafe3265c8f51', 'leontine@gmail.com'),
(36, 'kouadio', 'koffi yao', 45, '22545678912', 'ivoirienne', 'masculin', 'client', 'a1ea5461c70014e5c7cb6ddff30988ca62142804', 'a1ea5461c70014e5c7cb6ddff30988ca62142804', 'kouadio@gmail.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `frais`
--
ALTER TABLE `frais`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transfert`
--
ALTER TABLE `transfert`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avatar`
--
ALTER TABLE `avatar`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `frais`
--
ALTER TABLE `frais`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `transfert`
--
ALTER TABLE `transfert`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
