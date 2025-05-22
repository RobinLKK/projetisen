-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 20 mai 2025 à 14:29
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jeu_labyrinthe`
--

-- --------------------------------------------------------

--
-- Structure de la table `niveaux`
--

CREATE TABLE `niveaux` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `data` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `level_id` int(11) DEFAULT NULL,
  `score` int(11) NOT NULL,
  `played_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `scores`
--

INSERT INTO `scores` (`id`, `user_id`, `level_id`, `score`, `played_at`) VALUES
(1, 1, NULL, 1500, '2025-05-14 11:55:24');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT '/uploads/default_avatar.png',
  `bio` text CHARACTER SET utf8mb4,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  `best_score` int(11) DEFAULT NULL,
  `total_games` int(11) DEFAULT NULL,
  `total_time_played` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `email`, `password`, `avatar`, `bio`, `created_at`, `last_login`, `best_score`, `total_games`, `total_time_played`) VALUES
(1, 'Rob', 'rob@rob.fr', '$2y$10$qrGRcWEEdTfwNsPKacUaReLRGaYglYAfgpnLSybnvZg6r2XY6w0QS', 'uploads/avatar_1_1747148347.jpg', 'C&#039;est moi', '2025-05-13 08:37:57', NULL, 8, 8, 492),
(4, 'admin', 'admin@admin.fr', '$2y$10$3zpqpHu.64qUgzT2XcAmseaviqcuogDQlkxtkSFc6zM2u73oSVrKm', '/uploads/default_avatar.png', NULL, '2025-05-15 08:03:39', NULL, 0, 0, 0),
(5, 'aze', 'aze@aze.fr', '$2y$10$h4FehIzukSqlJNZJCNUqUuxxiQmtjE1uLFLXUmGnSunFOO94MZNNi', '/uploads/default_avatar.png', '', '2025-05-15 08:50:19', NULL, 0, 0, 0),
(6, 'coucou', 'coucou@coucou.fr', '$2y$10$ma/Pn4mk7Jc7e27pfd6q5e9ERSn0sTRzOAmQyOdNUO7FLieyXUcbC', '/uploads/default_avatar.png', NULL, '2025-05-20 14:23:18', NULL, 0, 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `niveaux`
--
ALTER TABLE `niveaux`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_scores_user_id` (`user_id`),
  ADD KEY `idx_scores_level_id` (`level_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `niveaux`
--
ALTER TABLE `niveaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `fk_scores_levels` FOREIGN KEY (`level_id`) REFERENCES `niveaux` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_scores_users` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `scores_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `niveaux` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
