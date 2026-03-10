-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Feb 2026 pada 04.04
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evoting_bem`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_profiles`
--

CREATE TABLE `admin_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `appointed_at` timestamp NULL DEFAULT NULL,
  `terminated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin_profiles`
--

INSERT INTO `admin_profiles` (`id`, `user_id`, `phone`, `department`, `address`, `city`, `province`, `postal_code`, `avatar`, `bio`, `status`, `appointed_at`, `terminated_at`, `created_at`, `updated_at`) VALUES
(1, 1, '085883277167', 'BEM Kesejahteraan', 'Kantor BEM Kampus', 'Jakarta', 'DK Jakarta', '13850', 'avatars/avgQKzIs6Xugo76VH7z5jlo35Lz6KkUMupvzAGAZ.png', 'Administrator Sistem E-Voting BEM', 'active', '2026-02-08 23:38:25', NULL, '2026-02-08 23:38:25', '2026-02-10 00:20:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kandidats`
--

CREATE TABLE `kandidats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kandidats`
--

INSERT INTO `kandidats` (`id`, `nama`, `visi`, `misi`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'Nahrul Hayat', 'perubahan', 'sistem e-voting', 'kandidat/g3uoN3JbIX2sE9nrOeGBUPYDzQjT65XacbQ1VzgO.jpg', '2026-02-08 23:42:30', '2026-02-08 23:42:30'),
(2, 'Tedi Kurnia', 'pemilihan', 'PEMIRA', 'kandidat/gxI8lngjigXgVq2CyRyeco0C3uH0g8clw2KNWJdW.jpg', '2026-02-08 23:42:58', '2026-02-08 23:42:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa_profiles`
--

CREATE TABLE `mahasiswa_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) NOT NULL,
  `program_studi` varchar(255) NOT NULL,
  `angkatan` varchar(255) NOT NULL,
  `semester` int(11) NOT NULL DEFAULT 1,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','graduated','suspended') NOT NULL DEFAULT 'active',
  `has_voted` tinyint(1) NOT NULL DEFAULT 0,
  `voted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mahasiswa_profiles`
--

INSERT INTO `mahasiswa_profiles` (`id`, `user_id`, `nim`, `program_studi`, `angkatan`, `semester`, `phone`, `address`, `city`, `province`, `postal_code`, `avatar`, `status`, `has_voted`, `voted_at`, `created_at`, `updated_at`) VALUES
(1, 2, '19081234001', 'Teknik Informatika', '2019', 5, '08312484988', NULL, 'Surabaya', 'Jawa Timur', NULL, NULL, 'active', 1, '2026-02-10 00:38:41', '2026-02-08 23:38:25', '2026-02-10 00:38:41'),
(2, 3, '19081234002', 'Teknik Informatika', '2019', 5, '08456686294', NULL, 'Surabaya', 'Jawa Timur', NULL, NULL, 'active', 0, NULL, '2026-02-08 23:38:25', '2026-02-10 00:38:21'),
(3, 4, '20081234001', 'Teknik Elektro', '2020', 5, '08977971346', NULL, 'Surabaya', 'Jawa Timur', NULL, NULL, 'active', 1, '2026-02-10 00:21:17', '2026-02-08 23:38:26', '2026-02-10 00:21:17'),
(4, 5, '20081234002', 'Sistem Informasi', '2020', 5, '08433777266', NULL, 'Surabaya', 'Jawa Timur', NULL, NULL, 'active', 0, NULL, '2026-02-08 23:38:26', '2026-02-08 23:38:26'),
(5, 6, '21081234001', 'Teknik Informatika', '2021', 5, '08174580335', NULL, 'Surabaya', 'Jawa Timur', NULL, NULL, 'active', 0, NULL, '2026-02-08 23:38:26', '2026-02-08 23:38:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_02_09_021404_create_kandidats_table', 1),
(2, '2026_02_09_021404_create_votes_table', 1),
(3, '2026_02_09_021405_create_settings_table', 1),
(4, '2026_02_09_100000_create_users_table', 1),
(5, '2026_02_09_100001_create_admin_profiles_table', 1),
(6, '2026_02_09_100002_create_mahasiswa_profiles_table', 1),
(7, '2026_02_10_061137_add_encrypted_vote_to_votes_table', 2),
(8, '2026_02_10_061727_modify_votes_table_for_encryption', 2),
(9, '2026_02_10_075310_add_election_info_to_settings_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `election_name` varchar(255) DEFAULT NULL,
  `election_logo` varchar(255) DEFAULT NULL,
  `voting_start` timestamp NULL DEFAULT NULL,
  `voting_end` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `election_name`, `election_logo`, `voting_start`, `voting_end`, `created_at`, `updated_at`) VALUES
(1, 'E-Voting BEM Jakarta', 'election-logos/9V8iMxaOz4rKQkHsyV2TI6ZdS3SyzlZRycAgftfd.png', '2026-02-09 23:38:00', '2026-02-10 08:30:00', '2026-02-08 23:38:26', '2026-02-10 01:04:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','mahasiswa') NOT NULL DEFAULT 'mahasiswa',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin BEM', 'admin@bem.ac.id', '2026-02-08 23:38:25', '$2y$12$IQVA6rniFHozNiw1raWf9uF373zUDfBA2BzyZNjQGT1sMUcnPa.tm', 'admin', 1, NULL, NULL, '2026-02-08 23:38:25', '2026-02-08 23:38:25'),
(2, 'Budi Santoso', 'budi@student.ac.id', '2026-02-08 23:38:25', '$2y$12$H2zaFYmQfj4OrcYxo7tzT.pl2Vy/R80WamrutR8dUJqjFAFDkHbC.', 'mahasiswa', 1, NULL, NULL, '2026-02-08 23:38:25', '2026-02-08 23:38:25'),
(3, 'Siti Nurhaliza', 'siti@student.ac.id', '2026-02-08 23:38:25', '$2y$12$9fa9avLuX1oZHhQ67kS8QOlNQpYijp98YwwgukNP8f9yJnxkWJADi', 'mahasiswa', 1, NULL, NULL, '2026-02-08 23:38:25', '2026-02-08 23:38:25'),
(4, 'Ahmad Ridho', 'ahmad@student.ac.id', '2026-02-08 23:38:26', '$2y$12$saRtYs0efJfRGDel86PES.FuRChN/mdH0UyT7HIcPBIM/ayJp4FL6', 'mahasiswa', 1, NULL, NULL, '2026-02-08 23:38:26', '2026-02-08 23:38:26'),
(5, 'Diana Kusuma', 'diana@student.ac.id', '2026-02-08 23:38:26', '$2y$12$SLT0nVSJDLUF.E/YJYeep.rcac6ykTZIKyxH0As608d78qPXowEFq', 'mahasiswa', 1, NULL, NULL, '2026-02-08 23:38:26', '2026-02-08 23:38:26'),
(6, 'Rahmat Wijaya', 'rahmat@student.ac.id', '2026-02-08 23:38:26', '$2y$12$43EkWzw2DMJjB0zDE/4n/OZSTuGUtv6r.oMANYFTndHTGorRP.v1q', 'mahasiswa', 1, NULL, NULL, '2026-02-08 23:38:26', '2026-02-08 23:38:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `votes`
--

CREATE TABLE `votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kandidat_id` bigint(20) UNSIGNED NOT NULL,
  `encrypted_kandidat_id` text DEFAULT NULL,
  `vote_hash` varchar(64) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `kandidat_id`, `encrypted_kandidat_id`, `vote_hash`, `created_at`, `updated_at`) VALUES
(3, 4, 2, 'eyJpdiI6Ikw4Sit2VVBxZ1owWTlIekIrb3hUWFE9PSIsInZhbHVlIjoiNGVNOTlwbzlWZ3hnMnVOMXFZZ0dOUT09IiwibWFjIjoiZGNiNjRkMjJmNmYyNzNjOTdiZGVjNjc4MDY4MjRhNTliMWU4MDBlYzQwMGM4MWQ3YmY4OWRmYzQ4NzZjMzk1NiIsInRhZyI6IiJ9', 'a1720967af93c4eec52980d1c3262fcbfb4f190f7b596d021dea10cc9961eef5', '2026-02-10 00:21:17', '2026-02-10 00:21:17'),
(4, 2, 2, 'eyJpdiI6IlRtYW5UQkxrWE1IZzMxRTBGOW9PaWc9PSIsInZhbHVlIjoiUTdxcHBSRmtYOVEyZjhwbXEybmV3dz09IiwibWFjIjoiNTgzNjI1NWZhZjMxNTcwY2Q4ZThiNjU0MjQ3NDdhNTlmNzk0NDkyYzg5YjQ5NDg4Y2M0ZjU3YjY3MzExNjZhOSIsInRhZyI6IiJ9', '264220af497ec93f638103e0a57505f8c0efd1a758441a3579fb14ad5d365b7d', '2026-02-10 00:38:41', '2026-02-10 00:38:41');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_profiles_user_id_index` (`user_id`),
  ADD KEY `admin_profiles_status_index` (`status`),
  ADD KEY `admin_profiles_department_index` (`department`);

--
-- Indeks untuk tabel `kandidats`
--
ALTER TABLE `kandidats`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mahasiswa_profiles`
--
ALTER TABLE `mahasiswa_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mahasiswa_profiles_nim_unique` (`nim`),
  ADD KEY `mahasiswa_profiles_user_id_index` (`user_id`),
  ADD KEY `mahasiswa_profiles_nim_index` (`nim`),
  ADD KEY `mahasiswa_profiles_program_studi_index` (`program_studi`),
  ADD KEY `mahasiswa_profiles_angkatan_index` (`angkatan`),
  ADD KEY `mahasiswa_profiles_status_index` (`status`),
  ADD KEY `mahasiswa_profiles_has_voted_index` (`has_voted`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`),
  ADD KEY `users_is_active_index` (`is_active`);

--
-- Indeks untuk tabel `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `votes_user_id_unique` (`user_id`),
  ADD KEY `votes_vote_hash_index` (`vote_hash`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin_profiles`
--
ALTER TABLE `admin_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kandidats`
--
ALTER TABLE `kandidats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa_profiles`
--
ALTER TABLE `mahasiswa_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD CONSTRAINT `admin_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mahasiswa_profiles`
--
ALTER TABLE `mahasiswa_profiles`
  ADD CONSTRAINT `mahasiswa_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
