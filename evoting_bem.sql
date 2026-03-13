-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 11 Mar 2026 pada 06.33
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `evoting_bem`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_profiles`
--

CREATE TABLE `admin_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin_profiles`
--

INSERT INTO `admin_profiles` (`id`, `user_id`, `phone`, `department`, `avatar`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, '08123456789', 'BEM Kesejahteraan', NULL, 'active', '2026-03-09 06:15:48', '2026-03-09 06:15:48'),
(2, 8, '085883277167', 'ahna', NULL, 'active', '2026-03-09 06:27:34', '2026-03-09 06:27:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendance_approvals`
--

CREATE TABLE `attendance_approvals` (
  `id` bigint UNSIGNED NOT NULL,
  `kampus_id` bigint UNSIGNED DEFAULT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `petugas_id` bigint UNSIGNED DEFAULT NULL,
  `voting_booth_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','voted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'offline',
  `approved_at` timestamp NULL DEFAULT NULL,
  `voted_at` timestamp NULL DEFAULT NULL,
  `session_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kampus`
--

CREATE TABLE `kampus` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#667eea',
  `secondary_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#764ba2',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kampus`
--

INSERT INTO `kampus` (`id`, `nama`, `kode`, `slug`, `alamat`, `kota`, `logo`, `primary_color`, `secondary_color`, `deskripsi`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Universitas Indonesia', 'UI', 'ui', NULL, 'Depok', NULL, '#fff700', '#000000', NULL, 1, '2026-03-09 06:15:47', '2026-03-10 03:39:30'),
(2, 'Universitas Gunadarma', 'GUNDAR', 'gundar', 'depok', 'depok', NULL, '#667eea', '#764ba2', 'wljw', 1, '2026-03-09 06:26:50', '2026-03-10 03:39:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kandidats`
--

CREATE TABLE `kandidats` (
  `id` bigint UNSIGNED NOT NULL,
  `kampus_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `misi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_votes` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kandidats`
--

INSERT INTO `kandidats` (`id`, `kampus_id`, `nama`, `visi`, `misi`, `foto`, `total_votes`, `created_at`, `updated_at`) VALUES
(1, 2, 'asdadas', 'asdadad', 'asdada', 'kandidat/S6c0QV60Gkpv7pmWZfK7bsRNvRoFtdUexJFVfN2s.png', 0, '2026-03-09 06:29:08', '2026-03-09 06:29:08'),
(2, 2, '12312313', 'qwe23123123', '123123123', 'kandidat/nMomAeCUMIzxmwe5nWfz3Rcfd4PxrMsjsjurfxwV.jpg', 0, '2026-03-09 06:29:30', '2026-03-09 06:29:30'),
(3, 1, 'calon 1', 'abcd', 'aabbccdd', 'kandidat/ZkII0srcLiZH85QRRRpFNgCa7oVvJKgyuJBby7Pc.png', 0, '2026-03-10 05:24:51', '2026-03-10 05:24:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa_profiles`
--

CREATE TABLE `mahasiswa_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_studi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` int NOT NULL DEFAULT '1',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','graduated','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `has_voted` tinyint(1) NOT NULL DEFAULT '0',
  `vote_receipt` longtext COLLATE utf8mb4_unicode_ci,
  `voted_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mahasiswa_profiles`
--

INSERT INTO `mahasiswa_profiles` (`id`, `user_id`, `nim`, `program_studi`, `angkatan`, `semester`, `phone`, `avatar`, `status`, `has_voted`, `vote_receipt`, `voted_at`, `created_at`, `updated_at`) VALUES
(1, 3, '19081234001', 'Teknik Informatika', '2019', 5, '08306822408', NULL, 'active', 0, NULL, NULL, '2026-03-09 06:15:48', '2026-03-09 06:15:48'),
(2, 4, '19081234002', 'Teknik Informatika', '2019', 5, '08181590637', NULL, 'active', 0, NULL, NULL, '2026-03-09 06:15:48', '2026-03-09 06:15:48'),
(3, 5, '20081234001', 'Teknik Elektro', '2020', 5, '08515003436', NULL, 'active', 0, NULL, NULL, '2026-03-09 06:15:48', '2026-03-09 06:15:48'),
(4, 6, '20081234002', 'Sistem Informasi', '2020', 5, '08617589831', NULL, 'active', 0, NULL, NULL, '2026-03-09 06:15:48', '2026-03-09 06:15:48'),
(5, 7, '21081234001', 'Teknik Informatika', '2021', 5, '08207231007', NULL, 'active', 0, NULL, NULL, '2026-03-09 06:15:49', '2026-03-09 06:15:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
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
(7, '2026_02_10_061137_add_encrypted_vote_to_votes_table', 1),
(8, '2026_02_10_061727_modify_votes_table_for_encryption', 1),
(9, '2026_02_10_075310_add_election_info_to_settings_table', 1),
(10, '2026_02_12_032900_add_petugas_role_to_users_table', 1),
(11, '2026_02_12_032901_create_tahapan_table', 1),
(12, '2026_02_12_032902_create_voting_booths_table', 1),
(13, '2026_02_12_032903_create_attendance_approvals_table', 1),
(14, '2026_02_12_062824_add_total_votes_to_kandidats_table', 1),
(15, '2026_02_12_063540_make_user_id_nullable_in_votes_table', 1),
(16, '2026_02_13_103302_add_vote_receipt_to_mahasiswa_profiles_table', 1),
(17, '2026_02_13_135801_drop_location_fields_from_mahasiswa_profiles', 1),
(18, '2026_02_13_140621_drop_unused_fields_from_admin_profiles', 1),
(19, '2026_02_13_140637_drop_address_from_mahasiswa_profiles', 1),
(20, '2026_02_19_151934_change_voted_at_to_date_on_mahasiswa_profiles', 1),
(21, '2026_02_23_091255_add_mode_to_attendance_approvals_table', 1),
(22, '2026_02_23_094640_make_petugas_id_nullable_in_attendance_approvals_table', 1),
(23, '2026_03_09_095254_add_super_admin_role_and_campus_to_users_table', 1),
(24, '2026_03_09_095300_create_kampus_table', 1),
(25, '2026_03_09_150546_add_kampus_id_to_votes_and_attendance_approvals', 2),
(26, '2026_03_10_030000_add_slug_to_kampus_table', 3),
(27, '2026_03_10_123009_add_is_abstain_to_votes_table', 99);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `kampus_id` bigint UNSIGNED DEFAULT NULL,
  `election_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `election_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voting_start` timestamp NULL DEFAULT NULL,
  `voting_end` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `kampus_id`, `election_name`, `election_logo`, `voting_start`, `voting_end`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, '2026-03-09 06:15:49', '2026-03-10 06:15:49', '2026-03-09 06:15:49', '2026-03-09 06:15:49'),
(2, NULL, NULL, NULL, '2026-03-09 06:22:12', '2026-03-10 06:22:12', '2026-03-09 06:22:12', '2026-03-09 06:22:12'),
(3, 2, 'E-Voting BEM Universitas Gunadarma', NULL, '2026-03-09 06:26:50', '2026-03-10 06:26:50', '2026-03-09 06:26:50', '2026-03-09 06:26:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahapan`
--

CREATE TABLE `tahapan` (
  `id` bigint UNSIGNED NOT NULL,
  `kampus_id` bigint UNSIGNED DEFAULT NULL,
  `nama_tahapan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `waktu_mulai` datetime NOT NULL,
  `waktu_selesai` datetime NOT NULL,
  `status` enum('draft','active','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `is_current` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tahapan`
--

INSERT INTO `tahapan` (`id`, `kampus_id`, `nama_tahapan`, `deskripsi`, `waktu_mulai`, `waktu_selesai`, `status`, `is_current`, `created_at`, `updated_at`) VALUES
(1, 2, 'pemilihan A', 'adhkahsdah', '2026-03-09 13:28:00', '2026-03-10 13:28:00', 'draft', 0, '2026-03-09 06:28:30', '2026-03-09 06:28:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin','mahasiswa','petugas_daftar_hadir') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `kampus_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `kampus_id`, `is_active`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'SUPER ADMIN', 'superadmin@bem.ac.id', '2026-03-09 06:15:47', '$2y$12$t72jpQSUlkloWVELf5aAduq8EJPRm49KYjDN9oXMI23zqe7eJr6ju', 'super_admin', NULL, 1, NULL, NULL, '2026-03-09 06:15:47', '2026-03-09 06:15:47'),
(2, 'Admin Kampus UI', 'admin@ui.ac.id', '2026-03-09 06:15:48', '$2y$12$Azx1VVQ.tlg/aPj5WyqfaeaRASfqICLwQIdtcGncuQmvBYkUHsa7u', 'admin', 1, 1, NULL, NULL, '2026-03-09 06:15:48', '2026-03-09 06:15:48'),
(3, 'Budi Santoso', 'budi@student.ac.id', '2026-03-09 06:15:48', '$2y$12$dEbnMDLCh4QYbu.qY9HVXujihRKTZ7UbdT/KKtsv7xwM7Y3GrRX7O', 'mahasiswa', 1, 1, NULL, NULL, '2026-03-09 06:15:48', '2026-03-09 06:15:48'),
(4, 'Siti Nurhaliza', 'siti@student.ac.id', '2026-03-09 06:15:48', '$2y$12$vdFxWe6KghvQQo/HSy6ie.L2EzRXCCWQvSVL0VKHIIZ/9BqJuWECi', 'mahasiswa', 1, 1, NULL, NULL, '2026-03-09 06:15:48', '2026-03-09 06:15:48'),
(5, 'Ahmad Ridho', 'ahmad@student.ac.id', '2026-03-09 06:15:48', '$2y$12$DLZ4NKw3hdhOxVv2h4UmKuH2Sd57ldEHcH2LT6TlXheYP.0fkz4xW', 'mahasiswa', 1, 1, NULL, NULL, '2026-03-09 06:15:48', '2026-03-09 06:15:48'),
(6, 'Diana Kusuma', 'diana@student.ac.id', '2026-03-09 06:15:48', '$2y$12$rb.gBrqTR3Z1v2Qrsm.HyeY4IE4/QdWVf47kR12OWF5oBG4VjlJnS', 'mahasiswa', 1, 1, NULL, NULL, '2026-03-09 06:15:48', '2026-03-09 06:15:48'),
(7, 'Rahmat Wijaya', 'rahmat@student.ac.id', '2026-03-09 06:15:49', '$2y$12$G6mAoMdNNQTUvNefMTVCu.rcB4LubwG14tLLVM9ixBoTaBegcfftO', 'mahasiswa', 1, 1, NULL, NULL, '2026-03-09 06:15:49', '2026-03-09 06:15:49'),
(8, 'NAHRUL HAYAT', 'hayat.nahrul46@gmail.com', NULL, '$2y$12$ux6VnY/te/D/LS0f/i1GvOiXAe8QUjiQJAV4bRNUGcdkBrwfjznD2', 'admin', 2, 1, NULL, NULL, '2026-03-09 06:27:34', '2026-03-09 06:27:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `votes`
--

CREATE TABLE `votes` (
  `id` bigint UNSIGNED NOT NULL,
  `kampus_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `kandidat_id` bigint UNSIGNED NOT NULL,
  `encrypted_kandidat_id` text COLLATE utf8mb4_unicode_ci,
  `vote_hash` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_abstain` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kandidat_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `voting_booths`
--

CREATE TABLE `voting_booths` (
  `id` bigint UNSIGNED NOT NULL,
  `kampus_id` bigint UNSIGNED DEFAULT NULL,
  `nama_booth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `voting_booths`
--

INSERT INTO `voting_booths` (`id`, `kampus_id`, `nama_booth`, `lokasi`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'bilik 1', 'adads', 1, '2026-03-09 06:28:44', '2026-03-09 06:28:44'),
(2, 2, 'bilik 2', 'abdad', 1, '2026-03-09 06:28:52', '2026-03-09 06:28:52');

--
-- Indeks untuk tabel yang dibuang
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
-- Indeks untuk tabel `attendance_approvals`
--
ALTER TABLE `attendance_approvals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_approvals_session_token_unique` (`session_token`),
  ADD KEY `attendance_approvals_voting_booth_id_foreign` (`voting_booth_id`),
  ADD KEY `attendance_approvals_status_index` (`status`),
  ADD KEY `attendance_approvals_mahasiswa_id_index` (`mahasiswa_id`),
  ADD KEY `attendance_approvals_petugas_id_index` (`petugas_id`),
  ADD KEY `attendance_approvals_session_token_index` (`session_token`),
  ADD KEY `attendance_approvals_created_at_index` (`created_at`),
  ADD KEY `attendance_approvals_kampus_id_index` (`kampus_id`);

--
-- Indeks untuk tabel `kampus`
--
ALTER TABLE `kampus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kampus_kode_unique` (`kode`),
  ADD UNIQUE KEY `kampus_slug_unique` (`slug`),
  ADD KEY `kampus_is_active_index` (`is_active`),
  ADD KEY `kampus_slug_index` (`slug`);

--
-- Indeks untuk tabel `kandidats`
--
ALTER TABLE `kandidats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kandidats_kampus_id_index` (`kampus_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_kampus_id_index` (`kampus_id`);

--
-- Indeks untuk tabel `tahapan`
--
ALTER TABLE `tahapan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahapan_status_index` (`status`),
  ADD KEY `tahapan_is_current_index` (`is_current`),
  ADD KEY `tahapan_waktu_mulai_waktu_selesai_index` (`waktu_mulai`,`waktu_selesai`),
  ADD KEY `tahapan_kampus_id_index` (`kampus_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`),
  ADD KEY `users_is_active_index` (`is_active`),
  ADD KEY `users_kampus_id_index` (`kampus_id`);

--
-- Indeks untuk tabel `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votes_vote_hash_index` (`vote_hash`),
  ADD KEY `votes_kampus_id_index` (`kampus_id`);

--
-- Indeks untuk tabel `voting_booths`
--
ALTER TABLE `voting_booths`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voting_booths_is_active_index` (`is_active`),
  ADD KEY `voting_booths_kampus_id_index` (`kampus_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin_profiles`
--
ALTER TABLE `admin_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `attendance_approvals`
--
ALTER TABLE `attendance_approvals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kampus`
--
ALTER TABLE `kampus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kandidats`
--
ALTER TABLE `kandidats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa_profiles`
--
ALTER TABLE `mahasiswa_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tahapan`
--
ALTER TABLE `tahapan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `voting_booths`
--
ALTER TABLE `voting_booths`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD CONSTRAINT `admin_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `attendance_approvals`
--
ALTER TABLE `attendance_approvals`
  ADD CONSTRAINT `attendance_approvals_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_approvals_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_approvals_voting_booth_id_foreign` FOREIGN KEY (`voting_booth_id`) REFERENCES `voting_booths` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `mahasiswa_profiles`
--
ALTER TABLE `mahasiswa_profiles`
  ADD CONSTRAINT `mahasiswa_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
