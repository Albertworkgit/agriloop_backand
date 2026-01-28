-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 28 jan. 2026 à 08:25
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `agriloop_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_17_154058_create_products_table', 1),
(6, '2026_01_19_135710_create_t_produits_table', 2),
(7, '2026_01_19_154234_add_image_to_t_produits_table', 3);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `t_admin`
--

CREATE TABLE `t_admin` (
  `mail_admin` varchar(100) NOT NULL,
  `password_admin` varchar(1000) DEFAULT NULL,
  `user_name` varchar(1000) DEFAULT NULL,
  `contact_admin` varchar(1000) DEFAULT NULL,
  `profil` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_admin`
--

INSERT INTO `t_admin` (`mail_admin`, `password_admin`, `user_name`, `contact_admin`, `profil`) VALUES
('al@gmail.com', '$2y$10$Jd0l34ZOFjx45n82/7cRNuCNJc7PgXOMHtYQLYLzvK9bY5TybWuGS', 'Albert work', '0987654', '697329de95992.jpg'),
('albert@gmail.com', '$2y$10$1NMY5e9.lCDjsay2t/TTNeyXNIwTPuzjsqLmVHK8O5xAl52E9oehy', 'Albert', '0987654433', '697329591edc1.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `t_categorie`
--

CREATE TABLE `t_categorie` (
  `id_categorie` int(11) NOT NULL,
  `categorie` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `t_commande`
--

CREATE TABLE `t_commande` (
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `mail_user` varchar(100) DEFAULT NULL,
  `quantite` decimal(10,2) DEFAULT NULL,
  `date_jour` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_commande`
--

INSERT INTO `t_commande` (`id_commande`, `id_produit`, `mail_user`, `quantite`, `date_jour`) VALUES
(2, 10, 'a@gmail.com', 100.00, '2023-01-26'),
(3, 13, 'albert@gmail.com', 100.00, '2026-01-26');

-- --------------------------------------------------------

--
-- Structure de la table `t_produits`
--

CREATE TABLE `t_produits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(255) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `mail_user` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `quantite` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `t_produits`
--

INSERT INTO `t_produits` (`id`, `designation`, `categorie`, `mail_user`, `description`, `prix`, `quantite`, `image`, `created_at`, `updated_at`) VALUES
(10, 'tomate', 'tomate', 'lflflf@gmail.com', 'nzzzzzzzzzzzz', 233.00, 44.00, '69729176a40e0.jpeg', NULL, NULL),
(11, 'kdkdk', 'kkxkx', 'ssi@gmail.com', 'kkksksks', 10.00, 33.00, '696f6fcf2b327.jpg', NULL, NULL),
(12, 'kdkdk', 'kkxkx', 'ssjjji@gmail.com', 'kkksksks', 10.00, 33.00, '696f6fe3e4f4b.jpg', NULL, NULL),
(13, 'kkkk', 'kkkkkk', 'a@gmail.com', 'jjjjjjjjjj', 567.00, 56.00, '6971dc5ee9f7e.jpeg', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_utilisateur`
--

CREATE TABLE `t_utilisateur` (
  `mail_user` varchar(100) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `type_compte` varchar(100) DEFAULT NULL,
  `password_user` varchar(1000) DEFAULT NULL,
  `profil_user` varchar(1000) DEFAULT NULL,
  `etat_compte` varchar(100) DEFAULT NULL,
  `adress_user` varchar(100) DEFAULT NULL,
  `contact_user` varchar(26) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_utilisateur`
--

INSERT INTO `t_utilisateur` (`mail_user`, `user_name`, `type_compte`, `password_user`, `profil_user`, `etat_compte`, `adress_user`, `contact_user`) VALUES
('a@gmail.com', 'james', 'particulier', '$2y$10$rc27ll8557Eey.1550Y46Oc9tX8BN23EzbO1CT2Da.0E1AIhG/yZu', '69726f6127639.jpeg', 'desactive', 'beni', '09876543'),
('alberson@gmail.com', 'hhj', 'Entreprise', '$2y$10$tvWz4Nh.niNtT9IUFDtA9eqjPoJtSl13hjZw1xqZTcAsVgGVAUaOy', '6977284ae86c2.jpg', 'desactive', 'jjjjj', 'àç_è-('),
('albert@gmail.com', 'kambale', 'client', '$2y$10$ADk3k0iZ6EC7iy63tBXaduTN4tc24xkx/cf5khYWP6fUAVkU8F13C', '6977330558a6c.jpg', 'desactive', 'beni', '098765432');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `t_admin`
--
ALTER TABLE `t_admin`
  ADD PRIMARY KEY (`mail_admin`);

--
-- Index pour la table `t_categorie`
--
ALTER TABLE `t_categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `t_commande`
--
ALTER TABLE `t_commande`
  ADD PRIMARY KEY (`id_commande`);

--
-- Index pour la table `t_produits`
--
ALTER TABLE `t_produits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_utilisateur`
--
ALTER TABLE `t_utilisateur`
  ADD PRIMARY KEY (`mail_user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_categorie`
--
ALTER TABLE `t_categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_commande`
--
ALTER TABLE `t_commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `t_produits`
--
ALTER TABLE `t_produits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
