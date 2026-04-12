-- ============================================================
-- SCRIPT UPDATE SERVER ALADELPHI.OR.ID
-- Jalankan di phpMyAdmin -> database: alad_boto_delphi
-- ============================================================

-- LANGKAH 1: Tambah kolom baru jika belum ada
ALTER TABLE `beneficiary_groups`
    ADD COLUMN IF NOT EXISTS `type` VARCHAR(50) DEFAULT 'sekolah',
    ADD COLUMN IF NOT EXISTS `count_siswa` INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS `count_guru` INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS `count_hamil` INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS `count_menyusui` INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS `count_balita` INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS `porsi_besar` INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS `porsi_kecil` INT DEFAULT 0;

-- LANGKAH 2: Hapus data lama yang kosong (yang nilai 0 semua) untuk SPPG Karang Rejo (sppg_id=2)
DELETE FROM `beneficiary_groups` WHERE `sppg_id` = 2;

-- LANGKAH 3: Insert data LENGKAP & BENAR sesuai PDF Karang Rejo
-- (SPPG Karang Rejo = sppg_id 2)
INSERT INTO `beneficiary_groups`
(`name`, `location`, `type`, `count_siswa`, `count_guru`, `count_hamil`, `count_menyusui`, `count_balita`, `porsi_besar`, `porsi_kecil`, `total_beneficiaries`, `sppg_id`, `created_at`, `updated_at`)
VALUES
('SD 095560 Karang Sari',       'Karang Sari, Gunung Maligas', 'sekolah', 154, 10, 0, 0, 0, 154, 10, 164, 2, NOW(), NOW()),
('SD 091262 Karang Sari',       'Karang Sari, Gunung Maligas', 'sekolah', 210, 18, 0, 0, 0, 210, 18, 228, 2, NOW(), NOW()),
('SDN 096780 Kampung Tape',     'Kampung Tape, Gunung Maligas','sekolah', 165, 10, 0, 0, 0, 165, 10, 175, 2, NOW(), NOW()),
('SMP N 1 MALIGAS',             'Gunung Maligas',              'sekolah', 385, 26, 0, 0, 0, 385, 26, 411, 2, NOW(), NOW()),
('MIS AL FIKRI',                'Karang Rejo, Gunung Maligas', 'sekolah', 101, 12, 0, 0, 0, 101, 12, 113, 2, NOW(), NOW()),
('MIN 1 SUMALUNGUN',            'Karang Rejo, Gunung Maligas', 'sekolah', 371, 31, 0, 0, 0, 371, 31, 402, 2, NOW(), NOW()),
('PAUD/TK AL-RIDHO',            'Karang Rejo, Gunung Maligas', 'sekolah',  58,  6, 0, 0, 0,  58,  6,  64, 2, NOW(), NOW()),
('SMP SATRYA BUDI',             'Karang Rejo, Gunung Maligas', 'sekolah', 181, 13, 0, 0, 0, 181, 13, 194, 2, NOW(), NOW()),
('SDN 097806 KARANG SARI',      'Karang Sari, Gunung Maligas', 'sekolah',  94,  9, 0, 0, 0,  94,  9, 103, 2, NOW(), NOW()),
('YAYASAN MAS BINAUL IMAN',     'Karang Rejo, Gunung Maligas', 'sekolah', 180, 24, 0, 0, 0, 180, 24, 204, 2, NOW(), NOW()),
('MTS BINAUL IMAN KARANG REJO', 'Karang Rejo, Gunung Maligas', 'sekolah', 240, 21, 0, 0, 0, 240, 21, 261, 2, NOW(), NOW()),
('B3 KARANG REJO',              'Karang Rejo, Gunung Maligas', 'posyandu',  0,  0,34, 80, 86,114, 86, 200, 2, NOW(), NOW());

-- LANGKAH 4: Update data yang sudah ada lainnya agar punya type='sekolah'
UPDATE `beneficiary_groups` SET `type` = 'sekolah' WHERE `type` IS NULL OR `type` = '';

-- Selesai! Total 12 sekolah/posyandu Karang Rejo sudah masuk dengan data lengkap.
