-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 18 Mar 2023 pada 10.20
-- Versi server: 10.0.38-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mrkw7566_db_sifu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_category`
--

CREATE TABLE `tb_category` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `kode` varchar(25) NOT NULL COMMENT '3 Karakter ',
  `bagian` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_category`
--

INSERT INTO `tb_category` (`id`, `nama`, `kode`, `bagian`) VALUES
(1, 'Customer Tokopedia', 'CTP', '5'),
(2, 'Customer Bukalapak', 'CBL', '5'),
(3, 'Customer Shopee', 'CSP', '5'),
(4, 'Customer Whatsapp', 'CWA', '5'),
(5, 'Customer Website', 'CWB', '6'),
(6, 'Customer Bli-Bli', 'CBI', '5'),
(7, 'Customer WA', 'FOP', '4'),
(8, 'Customer Telepon', 'CFP', '3'),
(9, 'Customer WA', 'CWS', '8'),
(10, 'Customer WA', 'CHK', '3'),
(11, 'Customer Telepon', 'CTR', '4'),
(12, 'Customer E-Mail', 'CTE', '3'),
(13, 'Toko Plastik', 'TKP', '4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_followup`
--

CREATE TABLE `tb_followup` (
  `followup_id` varchar(128) NOT NULL,
  `customer_name` varchar(128) NOT NULL,
  `id_category` varchar(25) NOT NULL,
  `pic` varchar(128) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `add_by` varchar(128) NOT NULL,
  `date` int(11) NOT NULL,
  `description` text NOT NULL,
  `format_customer` varchar(128) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0 = OLD Customer, 1 = New Customer',
  `is_open` enum('0','1') DEFAULT '1' COMMENT '0 close, 1 open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_followup`
--

INSERT INTO `tb_followup` (`followup_id`, `customer_name`, `id_category`, `pic`, `phone`, `add_by`, `date`, `description`, `format_customer`, `status`, `is_open`) VALUES
('230308/CWA-0004', 'PT Sushitei Indonesia', 'CWA', 'Ibu Vina', '81999050093', 'Ridhwan Harris', 1678264680, 'Menanyakan kebutuhan FP8', 'E-Commerce', '0', '0'),
('230311/CWA-0001', 'Lettas Kitchen', 'CWA', 'Ibu esti', '8176553882', 'Ridhwan Harris', 1678523220, 'Menanyakan harga UL-FP4 dan UL-250 ada rencana mau order', 'E-Commerce', '0', '0'),
('230311/CWA-0002', 'Endang JS Shop', 'CWA', 'Ibu Sari', '85861291702', 'Ridhwan Harris', 1678521600, 'Menanyakan stock JW-12RP sebanyak 28pcs', 'E-Commerce', '0', '0'),
('230311/CWA-0003', 'Fore Kopi Bandung', 'CWA', 'Bapak Rony', '81294406550', 'Ridhwan Harris', 1678535460, 'Konfirmasi penawaran barang', 'E-Commerce', '1', '1'),
('230313/CWA-0005', 'My Kitchen Indonesia', 'CWA', 'Ibu Maya / Ibu Nuraini', '87715524071', 'Ridhwan Harris', 1678698720, 'Menanyakan laddle soup stainless ukuran 12cm dan 14cm', 'E-Commerce', '0', '0'),
('230313/CWA-0006', 'PT Bumi Nini Pangan Indonesia', 'CWA', 'Bapak Mumu', '8987411149', 'Ridhwan Harris', 1678705620, 'Konfirmasi untuk meliput resto bumi aki untuk konten ig', 'E-Commerce', '0', '1'),
('230314/CWA-0007', 'Trijaya Abadi', 'CWA', 'Ibu Nichaela', '81280000987', 'Ridhwan Harris', 1679021700, 'konfirmasi pesanan barang indent ada sedikit keterlambatan', 'E-Commerce', '0', '1'),
('230314/CWA-0008', 'Aryaduta Semanggi', 'CWA', 'Bapak Ahmad Farhan', '85697976968', 'Ridhwan Harris', 1678793040, 'konfirmasi pengiriman barang dan menanyakan kebutuhan lainnya', 'E-Commerce', '0', '0'),
('230314/CWA-0009', 'Pasar Cisangkuy', 'CWA', 'Frisca', '89675576304', 'Ridhwan Harris', 1678805220, 'Menanyakan piring dan mangkok keramik motif swirl putih', 'E-Commerce', '0', '0'),
('230315/CFP-0004', 'The papandayan', 'CFP', 'Ibu lia', '081283702099', 'Angga yanyan', 1678867500, 'Sedang ada kebutuhan fp 1200 tc black', 'Telemarketing 75', '0', '0'),
('230315/CHK-0001', 'Ibu winda', 'CHK', 'Ibu winda', '08996919119', 'Angga yanyan', 1678843800, '', 'Telemarketing 75', '', '1'),
('230315/CHK-0005', 'Grand preanger hotel bandung', 'CHK', 'Bapak aji', '089632423025', 'Angga yanyan', 1678844400, 'Untuk saat ini masih belum ada kebutuhan barangnya', 'Telemarketing 75', '0', '1'),
('230315/CHK-0006', 'The sage restaurant', 'CHK', 'Reonaldy gomer', '081809901342', 'Angga yanyan', 1678844280, 'Sedang dalam pengajuan untuk proses po ', 'Telemarketing 75', '1', '1'),
('230315/CHK-0007', 'Santika hotel bandung', 'CHK', 'Bapak chandra', '085161042424', 'Angga yanyan', 1678845900, 'Sudah dibuatkan penawaran untuk kebutuhan gelas old fasion', 'Telemarketing 75', '0', '1'),
('230315/CHK-0008', 'Padma hotel bandung', 'CHK', 'Bapak fajrin', '082297568736', 'Angga yanyan', 1678845420, 'Untuk saat ini belum ada kebutuhannya', 'Telemarketing 75', '0', '1'),
('230315/CHK-0009', 'Westpoint hotel bandung', 'CHK', 'Bapak turki', '081296289701', 'Angga yanyan', 1678846140, 'Tanya barang cetakan kue untuk serabi', 'Telemarketing 75', '0', '1'),
('230315/CHK-0010', 'Pioneerindo gourmet', 'CHK', 'Bapak rinto', '081267803773', 'Angga yanyan', 1678846260, 'Sudah proses po ', 'Telemarketing 75', '1', '0'),
('230315/CHK-0011', 'Khas hotel semarang', 'CHK', 'Bapak budi', '081215054939', 'Angga yanyan', 1678850100, 'Sudah ada penawaran mk-zp-25papg', 'Telemarketing 75', '1', '1'),
('230315/CHK-0012', 'Bogor development', 'CHK', 'Bapak irfan', '085718232975', 'Angga yanyan', 1678850100, 'Follow up penawaran mk-yd-fo17', 'Telemarketing 75', '1', '1'),
('230315/CHK-0013', 'Kristal kupang', 'CHK', 'Bapak olfis', '08113931199', 'Angga yanyan', 1678850220, 'Masih dalam proses pengajuan dengan ownernya', 'Telemarketing 75', '0', '1'),
('230315/CHK-0014', 'Aryaduta tugu tani', 'CHK', 'Bapak drivo', '085888563801', 'Angga yanyan', 1678855920, 'Sudah dibuatkan penawaran oven gas steam deck', 'Telemarketing 75', '1', '1'),
('230315/CHK-0015', 'De paviljoen bandung', 'CHK', 'Ibu dian', '087821866660', 'Angga yanyan', 1678855380, 'Tanya barang sushi grill', 'Telemarketing 75', '0', '1'),
('230315/CHK-0016', 'Ibu gabby', 'CHK', 'Ibu gabby', '081224935277', 'Angga yanyan', 1678855800, 'Minta dibantu pengadaan cealler dan cool box', 'Telemarketing 75', '1', '0'),
('230315/CHK-0017', 'Windchime by cheff felix', 'CHK', 'Ibu eti', '085222986222', 'Angga yanyan', 1678856700, 'Belum ada kebutuhannya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0018', 'Intercontinental bandung', 'CHK', 'Bapak okky', '082146840012', 'Angga yanyan', 1678860120, 'Belum ada kebutuhan nya', 'Telemarketing 75', '0', '1'),
('230315/CHK-0019', 'Amarosa hotel bandung', 'CHK', 'Bapak roni', '085722893686', 'Angga yanyan', 1678817400, 'Untuk saat ini belum ada kebutuhan barangnya', 'Telemarketing 75', '0', '0'),
('230315/CHK-0020', 'Amarosa hotel bandung', 'CHK', 'Bapak roni', '085722893686', 'Angga yanyan', 1678817400, 'Belum ada kebutuhannya', 'Telemarketing 75', '0', '1'),
('230315/CHK-0021', 'Sapu lidi bandung', 'CHK', 'Bapak dani', '081122221414', 'Angga yanyan', 1678817400, 'Belum ada kebutuhan barangnya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0022', 'Kytos hotel bandung', 'CHK', 'Bapak ilham', '088707610900', 'Angga yanyan', 1678816920, 'Tanya barang steamer kotak 40cm (1pcs)', 'Telemarketing 75', '0', '1'),
('230315/CHK-0023', 'V hotel bandung', 'CHK', 'Bapak rexa', '089656416433', 'Angga yanyan', 1678817460, 'Belum ada kebutuhannya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0024', 'Biscoe restaurant', 'CHK', 'Ibu naumi', '089509106406', 'Angga yanyan', 1678819620, 'Belum ada kebutuhan barangnya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0025', 'Shakti hotel bandung', 'CHK', 'Ibu chandra', '083174808931', 'Angga yanyan', 1678819980, 'Belum ada kebutuhan barangnya mas kalau ada kami kabari', 'Telemarketing 75', '1', '1'),
('230315/CHK-0026', 'Gormeteria bandung', 'CHK', 'Bapak reza', '08112291327', 'Angga yanyan', 1678820400, 'Belum ada kebutuhannya mas', 'Telemarketing 75', '1', '1'),
('230315/CHK-0027', 'Reunion house grill', 'CHK', 'Ibu emi', '08112338557', 'Angga yanyan', 1678863720, 'Sampai saat ini belum ada kebutuhan barangnya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0028', 'Grand tjokro bandung', 'CHK', 'Ibu nabila', '0859131089380', 'Angga yanyan', 1678821180, 'Untuk saat ini belum ada krbutuhan barangnya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0029', 'Travello hotel bandung', 'CHK', 'Ibu shavira', '082127640903', 'Angga yanyan', 1678821540, 'Untuk saat ini belum ada kebutuhan barangnya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0030', 'Sonoma cafe n resto', 'CHK', 'Ibu wiwik', '087783321766', 'Angga yanyan', 1678863660, 'Untuk saat ini belum ada kebutuhannya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0031', 'Kitchen up bandung', 'CHK', 'Ibu yuna', '081221836507', 'Angga yanyan', 1678866060, 'Untuk sampai saat ini belum ada kebutuhannya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0032', 'Artotel suites mangkuluhur', 'CHK', 'Bapak ujang', '087836031186', 'Angga yanyan', 1678866420, 'Masih dalam proses pengajuan untuk po barangnya oleh management kami', 'Telemarketing 75', '1', '1'),
('230315/CHK-0033', 'Harris convention jakarta', 'CHK', 'Bapak arif', '082298955185', 'Angga yanyan', 1678866540, 'Untuk saat ini belum ada kebutuhannya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0034', 'Aryaduta group jakarta', 'CHK', 'Bapak anthoni', '0895360743125', 'Angga yanyan', 1678870320, 'Untuk saat ini belum ada kebutuhan nya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0035', 'Aryaduta menteng', 'CHK', 'Ibu iipmustikadewi', '0895410674082', 'Angga yanyan', 1679108760, 'Sedang ada kebutuhan cutleries brand serena', 'Telemarketing 75', '1', '1'),
('230315/CHK-0036', 'Swiss bel hotel sorong', 'CHK', 'Bapak faizal', '08114853888', 'Angga yanyan', 1678868760, 'Belum ada kebutuhan barangnya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0037', 'Swiss bel cibitung', 'CHK', 'Bapak nanda', '082246472721', 'Angga yanyan', 1678869060, 'Belum ada kebutuhannya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0038', 'Swissbel resort belitung', 'CHK', 'Bapak tri ashar', '081929677798', 'Angga yanyan', 1678869300, 'Sampai saat ini belum ada kebutuhan ', 'Telemarketing 75', '1', '1'),
('230315/CHK-0039', 'Swiss bel in tunjungan', 'CHK', 'Bapak tri', '087703332664', 'Angga yanyan', 1678870680, 'Belum ada kebutuhannya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0040', 'Swiss bel hotel semarang', 'CHK', 'Bapak yosafat', '082257745145', 'Angga yanyan', 1678870860, 'Belum ada kebutuhannya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0041', 'Swiss bel airport', 'CHK', 'Bapak raffi', '081224441554', 'Angga yanyan', 1678871340, 'Sedang dalam pengajuan untuk po karpetnya', 'Telemarketing 75', '1', '1'),
('230315/CHK-0042', 'Swiss bel simatupang', 'CHK', 'Ibu ajeng', '087786203900', 'Angga yanyan', 1678871520, 'Belum ada kebutuhan ', 'Telemarketing 75', '', '1'),
('230315/CSP-0014', 'Hernawan kelan', 'CSP', 'hernawan kelan', '', 'Ridhwan Harris', 1678867200, 'menanyakan tatakan cangkir legacy ', 'E-Commerce', '1', '1'),
('230315/CTP-0010', 'Liem', 'CTP', 'Liem', '08000000139', 'Ridhwan Harris', 1678843200, 'Menanyakan stock mangkok keramik BZR-BPRGY dan BZR-BPRTMNT', 'E-Commerce', '1', '0'),
('230315/CTP-0011', 'Horison Bhuvana Ciawi', 'CTP', 'teguh', '081383902360', 'Ridhwan Harris', 1678849500, 'Menanyakan stock JW-12RP sebanyak 12 pcs', 'E-Commerce', '1', '0'),
('230315/CTP-0012', 'KAMPUNG DAUN CAFE', 'CTP', 'JHON F', '08000000602', 'Ridhwan Harris', 1678857000, 'Menanyakan stock jelly mousse cup MK-013 sebanyak 200pcs', 'E-Commerce', '1', '0'),
('230315/CTP-0013', 'Daria', 'CTP', 'Daria', '', 'Ridhwan Harris', 1678851000, 'menanyakan measuring spoon ', 'E-Commerce', '1', '0'),
('230315/CTR-0001', 'Samira Frozen Food', 'CTR', 'Ibu Samira', '085289554577', 'Eko', 1678904400, 'Minta sampel Sl-750FPT', 'Telemarketing 118', '1', '1'),
('230315/CWA-0015', 'PT Selera Pangan Harum', 'CWA', 'Bapak Rujianto', '085729587727', 'Ridhwan Harris', 1679108640, 'Konfirmasi pembayaran ', 'E-Commerce', '1', '0'),
('230315/CWA-0016', 'My Kitchen Indonesia', 'CWA', 'bu Tania', '087715524071', 'Ridhwan Harris', 1678958640, 'menanyakan spatula heat resist 25cm sama oil skimme 30cm dan hamburger spatula 38cm ', 'E-Commerce', '0', '0'),
('230315/CWB-0001', 'PT. KEY SHINE INDONESIA', 'CWB', 'RESSA', '087877587711', 'Mellawati', 1678757940, 'Follow up penawaran tgl 8 maret, belum di cek sama atasannya', 'Website', '0', '1'),
('230315/CWB-0002', 'IKOPIN UNIVERSITY', 'CWB', 'MIMAH MUTMAINAH', '085624545326', 'Mellawati', 1678846860, 'FOLLOW UP PENAWARAN TANGGAL 13 MARET 2023', 'Website', '1', '1'),
('230315/CWB-0003', 'BOYS BURGER', 'CWB', 'DINDIN RISYADI', '085213442778', 'Mellawati', 1679018340, 'TANYA BARANG FRYNG PAN', 'Website', '0', '0'),
('230315/CWB-0004', 'SANDRA EKA PUTR', 'CWB', 'SANDRA EKA PUTR', '085779254571', 'Mellawati', 1678843620, 'TANYA PIRING MELAMIN HOOVER', 'Website', '1', '1'),
('230315/CWB-0005', 'TECHNOLIFE JATINANGOR', 'CWB', 'UCI', '085624522266', 'Mellawati', 1678954920, 'MINTA PENAWARAN', 'Website', '1', '1'),
('230315/CWS-0003', 'waterboom bali', 'CWS', 'waterboom bali', '085172355676', 'Pitri', 1678850100, 'follow up costumer,menawarkan barang dan promo yang berlaku', 'Showroom', '', '1'),
('230315/CWS-0004', 'Noor hotel bandung', 'CWS', 'ibu ina', '0838562240', 'Pitri', 1678873680, 'follow up penawaran bowl kaca luminarc  dan sudah po ', 'Showroom', '0', '0'),
('230315/CWS-0005', 'green forest', 'CWS', 'ibu neni', '08112295300', 'Pitri', 1678873860, 'follow up penawaran panci presto maxim', 'Showroom', '0', '1'),
('230315/CWS-0006', 'hotel gratista', 'CWS', 'bp hery', '081395227005', 'Pitri', 1678874100, 'follow up customer,menawarkan promo baru yang berlaku beserta menawarkan barang', 'Showroom', '0', '1'),
('230315/CWS-0007', 'PT BERKAT CAHAYA NOVENA', 'CWS', 'ibu resya', '085719591727', 'Pitri', 1678874280, 'follow up penawaran dan sudah jadi po', 'Showroom', '0', '0'),
('230315/CWS-0008', 'amaris hotel palembang', 'CWS', 'bp dicky', '085841588091', 'Pitri', 1678874580, 'follow up penawaran  electric cettle subron', 'Showroom', '0', '1'),
('230315/FOP-0002', 'Mutiara plastik', 'FOP', 'Bapa andri', '08561034041', 'Mela Puspitasari', 1678172400, '', 'Telemarketing 118', '', '0'),
('230315/HOR-0001', 'Belamie', 'HOR', 'Bp Kusuma', '085855240003', 'Pitri', 1678850100, 'Follow up kunjungan,dan menawarkan barang', 'Showroom', '0', '1'),
('230315/HOR-0002', 'Ibu septamia', 'HOR', 'Ibu septamia (perorangan)', '085659367157', 'Pitri', 1679034660, 'Penawaran harga ,sudah pemesanan barang ( MK-PL-SP2029SL)', 'Showroom', '0', '0'),
('230316/CBL-0023', 'Enyon', 'CBL', 'Enyon', '', 'Ridhwan Harris', 1678953000, 'menanyakan stock Heightening Guest Room Service Cart (With Doors)', 'E-Commerce', '1', '1'),
('230316/CFP-0060', 'Ibu Irma', 'CFP', 'Ibu Irma', '082218808766', 'Witri Rohimah', 1679043000, 'menanyakan botol kecap acrilic uk 150 ml ', 'Telemarketing 75', '1', '0'),
('230316/CFP-0064', 'PO Hotel Semarang', 'CFP', 'Bpk Dedy', '085740122504', 'Witri Rohimah', 1678952280, 'Ada menanyakan beberapa barang , plate ceramic , grill , dan showcase. minta dibuatkan penawaran harga untuk soup turine ', 'Telemarketing 75', '1', '1'),
('230316/CFP-0065', 'Hotel Moxy', 'CFP', 'Bpk Ilham', '085155050511', 'Witri Rohimah', 1678957080, 'menanyakan carving station type CS-901', 'Telemarketing 75', '0', '1'),
('230316/CHK-0043', 'Pullman central park', 'CHK', 'Bapak dendi', '087879818290', 'Angga yanyan', 1678931940, 'Follow up penawaran kebutuhan perlengkapan kitchen dan menawarkan promo yang berlaku di mr kitchen', 'Telemarketing 75', '1', '1'),
('230316/CHK-0044', 'forest hills bandung', 'CHK', 'Ibu Sindi', '089636437553', 'tiranny', 1678939260, 'tanya barang kohana panci', 'Telemarketing 75', '0', '0'),
('230316/CHK-0045', 'Gets Hotel Semarang', 'CHK', 'Bpk Satria', '08995669070', 'Witri Rohimah', 1678959540, 'customer minta list penawaran utensil', 'Telemarketing 75', '0', '1'),
('230316/CHK-0046', 'kelapa retreat & spa', 'CHK', 'Bapak Sukrisna', '085738723132', 'tiranny', 1679033460, 'baru masuk list tanya barang', 'Telemarketing 75', '0', '1'),
('230316/CHK-0047', 'Surya Kirana Lestari CV', 'CHK', 'Ibu Dian', '085890711808', 'Witri Rohimah', 1678939200, 'Menanyakan gelas libbey kode 2349 untuk kebutuhan 200 pcs ', 'Telemarketing 75', '0', '1'),
('230316/CHK-0048', 'Ibu Viany', 'CHK', 'Ibu Viany', '08562109517', 'tiranny', 1678412580, 'baru masuk list tanya barang', 'Telemarketing 75', '0', '0'),
('230316/CHK-0049', 'Elcavana Hotel Bandung', 'CHK', 'Bpk Sandi', '08989796098', 'Witri Rohimah', 1678258200, 'minta dibuat invoice untuk cereal dispenser dan tray anti slip ', 'Telemarketing 75', '0', '0'),
('230316/CHK-0050', 'Royal Ambarrukmo Yogyakarta', 'CHK', 'Bpk Feby', '082225506854', 'Witri Rohimah', 1678762500, 'mau order untuk blender maddin type 206A', 'Telemarketing 75', '0', '1'),
('230316/CHK-0051', 'Sutan Raja Hotel', 'CHK', 'Bpk Rizky', '081395830353', 'Witri Rohimah', 1678867200, 'Minta penawaran decanter dan coffee urn ', 'Telemarketing 75', '0', '1'),
('230316/CHK-0052', 'Aryaduta Kartika', 'CHK', 'Bapak Satya', '081337401061', 'tiranny', 1678860300, 'tanya barang coffee urn', 'Telemarketing 75', '0', '1'),
('230316/CHK-0053', 'Trans Hotel Resort', 'CHK', 'Ibu Asih', '081237601923', 'tiranny', 1678947960, 'tanya barang tent card A5', 'Telemarketing 75', '0', '1'),
('230316/CHK-0054', 'Berry Amour Villa', 'CHK', 'Bapak Edi', '087861855341', 'tiranny', 1678673700, 'tanya barang elektrik kettle brand jvd', 'Telemarketing 75', '0', '0'),
('230316/CHK-0055', 'Mercure Bandung Nexa', 'CHK', 'Bapak Agung', '081319191450', 'tiranny', 1678948740, 'tanya barang commercial cotton candy', 'Telemarketing 75', '0', '0'),
('230316/CHK-0056', 'Deri Santika', 'CHK', 'Bapak Deri', '081222235363', 'tiranny', 1678948680, 'tanya barang insert dari ceramic', 'Telemarketing 75', '0', '0'),
('230316/CHK-0057', 'Tortens Kitchen Cimahi', 'CHK', 'Ibu Kania', '085722897345', 'tiranny', 1678786080, 'tanya barang chopping board', 'Telemarketing 75', '0', '0'),
('230316/CHK-0058', 'Wyl\'s Kitchen - Veranda Hotel Jakarta', 'CHK', 'Bapak Rayson', '08119980209', 'tiranny', 1679016660, 'tanya barang mug  kopin. mk-kpt02cm', 'Telemarketing 75', '0', '1'),
('230316/CHK-0059', 'Ibu Viany', 'CHK', 'Ibu Viany', '08562109517', 'tiranny', 1678521720, 'minta retur barang karna ukuran tidak sesuai keinginan user', 'Telemarketing 75', '0', '0'),
('230316/CHK-0061', 'Grand Melia', 'CHK', 'Ibu Herlina', '081318674666', 'tiranny', 1679102100, 'tanya barang ul-p125', 'Telemarketing 75', '0', '1'),
('230316/CHK-0062', 'whiterose', 'CHK', 'Ibu Sinta', '083114851313', 'tiranny', 1679016780, 'tanya barang pisau ukuran 25cm', 'Telemarketing 75', '0', '1'),
('230316/CHK-0063', 'Ibu Winda', 'CHK', 'Ibu Winda', '08996915119', 'tiranny', 1679031900, 'tanya barang chopper ukuran besar', 'Telemarketing 75', '1', '1'),
('230316/CHK-0066', 'Clove Garden Hotel Bandung', 'CHK', 'Bpk Andri', '085858751449', 'Witri Rohimah', 1679015880, 'menanyakan steamer ukuran 30 cm ', 'Telemarketing 75', '0', '0'),
('230316/CHK-0067', 'Mad Bagel', 'CHK', 'Ibu Yannie', '087755090222', 'tiranny', 1678958100, 'tanya harga untuk list barang plastik', 'Telemarketing 75', '0', '1'),
('230316/CHK-0068', 'Ibis Styles Cikarang', 'CHK', 'Bapak Agus', '082221207330', 'tiranny', 1678936800, 'tanya barang chocolate fountain', 'Telemarketing 75', '0', '1'),
('230316/CHK-0069', 'PT. Angsa', 'CHK', 'Bapak Deri', '082115779396', 'tiranny', 1678959180, 'belum ada kebutuhan', 'Telemarketing 75', '0', '0'),
('230316/CHK-0070', 'The jonglo New', 'CHK', 'Bapak Gede', '085954074203', 'tiranny', 1678959300, '', 'Telemarketing 75', '0', '0'),
('230316/CHK-0071', 'Bapak Bernard', 'CHK', 'Bapak Bernard', '089655252115', 'tiranny', 1678959420, '', 'Telemarketing 75', '0', '0'),
('230316/CHK-0072', 'Mason Pine Hotel', 'CHK', 'Ibu Diana', '087824836261', 'Witri Rohimah', 1678946100, 'menanyakan kenapa sudah tidak bisa tempo, dan tanya harga chp82 ', 'Telemarketing 75', '0', '1'),
('230316/CSP-0022', 'Muchammad Yusuf', 'CSP', 'Muchammad Yusuf', '', 'Ridhwan Harris', 1678953540, 'menanyakan mk-cst20 conical strainer', 'E-Commerce', '1', '1'),
('230316/CTP-0017', 'Toko Platinum Mega Cellular', 'CTP', 'Alysia Cen', '082347828888', 'Ridhwan Harris', 1678933140, 'Menanyakan barang tutup food ukuran 1/3', 'E-Commerce', '0', '0'),
('230316/CTP-0018', 'Ade Saputra', 'CTP', 'Ade Saputra', '', 'Ridhwan Harris', 1679108520, 'Menanyakan hand blender philips', 'E-Commerce', '1', '0'),
('230316/CTP-0019', 'Otella buranchi Resto', 'CTP', 'Otella buranchi Resto', '081310831966', 'Ridhwan Harris', 1678948260, 'menginfokan untuk pesanan gelas harus di packing kayu', 'E-Commerce', '1', '0'),
('230316/CTP-0020', 'Luvero', 'CTP', 'Luvero', '', 'Ridhwan Harris', 1679024580, 'Menanyakan merk pisau sashimi jepang ', 'E-Commerce', '1', '0'),
('230316/CTP-0021', 'MOONWAKE COFFEE', 'CTP', 'Daniel', '', 'Ridhwan Harris', 1678948620, 'menanyakan barang egg slicer', 'E-Commerce', '1', '0'),
('230316/CTP-0024', 'Retno', 'CTP', 'Retno', '', 'Ridhwan Harris', 1678956300, 'menanyakan setrika philips GC1418', 'E-Commerce', '1', '1'),
('230316/CTR-0003', 'PT.Dhanajaya bogaindo', 'CTR', 'Bapa yoga', '081280148553', 'Mela Puspitasari', 1678953600, 'PO UL-FP350 sebanyak 750 pcs', 'Telemarketing 118', '0', '1'),
('230316/CTR-0004', 'Mega plastik', 'CTR', 'Ibu mega', '085773132285', 'Mela Puspitasari', 1678949400, 'Penawaran botol kale ukuran 250 ml ', 'Telemarketing 118', '0', '1'),
('230316/CWB-0006', 'yusar taupan', 'CWB', 'yusar taupan', '087824125671', 'Mellawati', 1679034780, 'tanya karpet', 'Website', '1', '1'),
('230316/CWB-0007', 'RETHA', 'CWB', 'RETHA', '087824241825', 'Mellawati', 1679040120, 'TANYA SLOW COOKER', 'Website', '1', '0'),
('230316/CWB-0008', 'INDRA', 'CWB', 'INDRA', '081212223121', 'Mellawati', 1679104320, 'TANYA DISKON PRODUK PIRING DAN GELAS UNTUK PEMBELIAN GROSIR', 'Website', '1', '0'),
('230316/CWB-0009', 'PT. CIPTA PUTRA NUSANTARA (LONG JOHN SILVER\'S)', 'CWB', 'NATALIE E', '081212399747', 'Mellawati', 1678940640, 'MINTA PENAWARAN ', 'Website', '1', '1'),
('230316/CWB-0010', 'PT. KIEHARA PUTERA GAMALAMA (SUPPLIER)', 'CWB', 'ELLA SAGITA PUTRI', '082211323408', 'Mellawati', 1678942140, 'MINTA PENAWARAN ', 'Website', '1', '1'),
('230316/CWS-0009', 'Sekolah bintang mulya', 'CWS', 'Sekolah bintang mulya', '085797167673', 'Nina yuliana', 1679043780, 'Menanyakan slow cooker', 'Showroom', '1', '1'),
('230316/CWS-0010', 'Hotel Neo Cirebon', 'CWS', 'Ibu ayu', '085703040763', 'Vira Fitri Zulaikha', 1678935600, 'Kebutuhan gelas uk 150 ml dengan harga terjangkau ', 'Showroom', '0', '0'),
('230316/CWS-0011', 'Ibu Siok ing', 'CWS', 'Ibu siok ing', '081320793146', 'Vira Fitri Zulaikha', 1678903920, 'Kebutuhan jartb 1300 dan jartb 500', 'Showroom', '1', '0'),
('230316/CWS-0012', 'Glamping Lakeside Ciwidey', 'CWS', 'Ibu Dera', '082143735511', 'Vira Fitri Zulaikha', 1678854840, 'Masih dalam proses pembangunan untuk restorannya ', 'Showroom', '1', '1'),
('230316/CWS-0013', 'Roni cahyana', 'CWS', 'Roni cahyana', '081220115647', 'Vira Fitri Zulaikha', 1678950000, 'Kebutuhan sq2000 sebanyak 50 pcs,  kebutuhan ul-2500 sebanyak 50 pcs', 'Showroom', '0', '0'),
('230316/CWS-0014', 'Rumah makan soup ciamis', 'CWS', 'Bp agas', '082125368225', 'Vira Fitri Zulaikha', 1678942800, 'Kebutuhan stock pot, cast iron, dan ladle ', 'Showroom', '1', '1'),
('230316/CWS-0015', 'Ayam Geprek bebas', 'CWS', 'Bp adam', '082130338901', 'Vira Fitri Zulaikha', 1678946400, 'Belum ada kebutuhan ', 'Showroom', '0', '0'),
('230316/CWS-0016', 'Fella dining', 'CWS', 'Ibu regina', '081392646301', 'Vira Fitri Zulaikha', 1678858200, 'Follow up untuk kunjungan ', 'Showroom', '0', '1'),
('230316/FOP-0008', 'Allila Uluwatu', 'FOP', 'Ibu Anita', '08113892997', 'Eko', 1678941000, 'Penawaran EMD 360x70cm & 360x100cm warna hitam motif diamond', 'Telemarketing 118', '0', '1'),
('230316/TKP-0005', 'Toko Pona Poni', 'TKP', 'Ibu anggi', '083824277400', 'Eko', 1678932300, 'Tanya Harga Round 1000ml & 470ml black', 'Telemarketing 118', '0', '1'),
('230316/TKP-0006', 'Toko surya plastik', 'TKP', 'Bapa surya', '081212137972', 'Mela Puspitasari', 1678951260, 'Penawaran botol kale ukuran 100 ml ', 'Telemarketing 118', '0', '1'),
('230316/TKP-0007', 'Mega kemasan', 'TKP', 'Pak Asep', '087831682990', 'Eko', 1678937400, 'Tanya Harga Round 1000ml & 470ml black ', 'Telemarketing 118', '0', '1'),
('230317/CFP-0093', 'Sucre Pattiserie And Chocolatier', 'CFP', 'Bpk Hendri', '081394791176', 'Witri Rohimah', 1679040900, 'menanyakan saringan ', 'Telemarketing 75', '1', '1'),
('230317/CFP-0101', 'Mandala Restaurant', 'CFP', 'Bapak Wahirin', '0217398537', 'tiranny', 1679028420, 'follow up untuk kebutuhan', 'Telemarketing 75', '0', '0'),
('230317/CHK-0073', 'Art Deco Luxury Hotel Bandung', 'CHK', 'Bpk Bismi', '087722722199', 'Tria puspita dewi', 1678239000, 'customer turun lembar PO', 'Telemarketing 75', '0', '0'),
('230317/CHK-0074', 'Art Deco Luxury Hotel Bandung', 'CHK', 'Bpk Bismi', '087722722199', 'Tria puspita dewi', 1678928400, 'customer turun PO', 'Telemarketing 75', '0', '0'),
('230317/CHK-0075', 'The Cipaku Garden Hotel', 'CHK', 'Bpk Ducky', '081321197766', 'Tria puspita dewi', 1678677720, 'sedang ada kebutuhan untuk HS-029 sebanyak 60 pcs', 'Telemarketing 75', '0', '0'),
('230317/CHK-0076', 'Manado Quality Hotel', 'CHK', 'Bapak Dewa', '081322558989', 'tiranny', 1678939260, '', 'Telemarketing 75', '0', '1'),
('230317/CHK-0077', 'Swiss-Belhotel Cirebon', 'CHK', 'Bapak Zazat', '081220607123', 'tiranny', 1679033160, '', 'Telemarketing 75', '0', '0'),
('230317/CHK-0078', 'Alana Reort', 'CHK', 'Bapak Rusdi', '089517924510', 'tiranny', 1679041560, 'tanya barang coffee decanter dan coffee stove', 'Telemarketing 75', '0', '1'),
('230317/CHK-0079', 'El Royale Hotel Bandung', 'CHK', 'Bpk Eko', '08131327714', 'Witri Rohimah', 1679035080, 'menanyakan gelas ukuran T: 9,5 cm , D: 5 cm ', 'Telemarketing 75', '0', '1'),
('230317/CHK-0080', 'Plataran Restaurant Bandung', 'CHK', 'Bpk Robi', '083873437920', 'Witri Rohimah', 1678848960, 'meminta penawaran harga untuk glass libbey kode 15240 untuk kebutuhan 400 pcs', 'Telemarketing 75', '1', '1'),
('230317/CHK-0081', 'PT Rumah Alam Sari', 'CHK', 'Ibu Milan', '085294031291', 'Tria puspita dewi', 1679022300, 'customer menghubungi dan bertanya untuk scoop ice cream ', 'Telemarketing 75', '', '1'),
('230317/CHK-0082', 'Eightynine Catering', 'CHK', 'Bpk Riyad', '087833704951', 'Witri Rohimah', 1679028180, 'menanyakan periode lebaran kapan bisa order terakhir untuk beras', 'Telemarketing 75', '0', '1'),
('230317/CHK-0083', 'Tandjung Sari Hotel', 'CHK', 'Ibu Suwini', '081999605973', 'Tria puspita dewi', 1678946100, 'bertanya loyang bakery untuk ukuran 252mm X129mmX120mm kebutuhan 6 pcs', 'Telemarketing 75', '0', '1'),
('230317/CHK-0084', 'Destiny Catering', 'CHK', 'Bpk Rahmat', '083820689236', 'Witri Rohimah', 1678784400, 'menanyakan mesin gilingan daging merk tasin', 'Telemarketing 75', '0', '0'),
('230317/CHK-0085', 'Mauri Resto', 'CHK', 'bapak Heri', '087861173437', 'tiranny', 1677914880, 'tanya barang box ukuran 50x38cm', 'Telemarketing 75', '0', '0'),
('230317/CHK-0086', 'Infiniro', 'CHK', 'Bapak Gansara', '083829401282', 'tiranny', 1678948920, 'follow up kebutuhan', 'Telemarketing 75', '0', '0'),
('230317/CHK-0087', 'Luwak Ubud Villas', 'CHK', 'Bapak Mayun', '083114112264', 'tiranny', 1678931040, 'follow up kebutuhan', 'Telemarketing 75', '0', '0'),
('230317/CHK-0088', 'Duta Selera Pertiwi', 'CHK', 'Ibu Siti', '089636398195', 'tiranny', 1680511680, 'tanya barang gelas bir ukuran 375ml', 'Telemarketing 75', '0', '0'),
('230317/CHK-0089', 'Mercure Lengkong', 'CHK', 'Bapak Kokoh', '081224049498', 'tiranny', 1679039400, 'follow up kebutuhan. sebelumnya pernah tanya barang', 'Telemarketing 75', '0', '1'),
('230317/CHK-0090', 'jayakarta', 'CHK', 'Bapak Heri', '085217240792', 'tiranny', 1679043660, 'follow up ubtuk kebutuhan', 'Telemarketing 75', '0', '0'),
('230317/CHK-0091', 'Marriott Hotel Ypgyakarta', 'CHK', 'Bpk Cornelius', '085823265496', 'Witri Rohimah', 1679039280, 'Customer mengirim lampiran PO CHO-30 non woven ', 'Telemarketing 75', '0', '1'),
('230317/CHK-0092', 'Hilton Bandung', 'CHK', 'Bpk Indra', '081210803251', 'Tria puspita dewi', 1679023800, 'customer bertanya untuk container box dari brand rabbit', 'Telemarketing 75', '', '1'),
('230317/CHK-0094', 'De Java Hotel Bandung', 'CHK', 'Ibu Aneu', '087823865564', 'Tria puspita dewi', 1679033100, 'mengirimkan beberapa list barang dan bertanya untuk harganya', 'Telemarketing 75', '0', '1'),
('230317/CHK-0095', 'Sensa hotel bandung', 'CHK', 'Ibu karin', '081298559696', 'Angga yanyan', 1679041500, 'Follow up penawaran untuk kebutuhan perlengkapan kitchennya', 'Telemarketing 75', '0', '1'),
('230317/CHK-0096', 'Madawa Bali', 'CHK', 'Ibu Vania', '082114481457', 'Tria puspita dewi', 1677564300, 'tanya barang untuk food cover stainless', 'Telemarketing 75', '0', '1'),
('230317/CHK-0097', 'Artotel suites mangkuluhur', 'CHK', 'Bapak ujang', '087858888899', 'Angga yanyan', 1679041860, 'Minta dibuatkan penawaran untuk pr yang diberikan ', 'Telemarketing 75', '1', '1'),
('230317/CHK-0098', 'Hotel Amaris Simpang Lima', 'CHK', 'Bpk Akhwat', '085842312708', 'Witri Rohimah', 1678438920, 'mau order untuk decanter MK-8896', 'Telemarketing 75', '0', '0'),
('230317/CHK-0099', 'Rai Upasha Seminyak', 'CHK', 'Bapak Upasha', '081237783838', 'tiranny', 1679043960, 'follow up kebutuhan. tanya barang pre-rinse', 'Telemarketing 75', '0', '1'),
('230317/CHK-0100', 'Grand tjokro bandung', 'CHK', 'Bapak sony', '087887769897', 'Angga yanyan', 1679042340, 'Follow up untuk perlengkapan kitchennya', 'Telemarketing 75', '1', '1'),
('230317/CSP-0026', 'Diani Indriani', 'CSP', 'Diani Indriani', '', 'Ridhwan Harris', 1679015700, 'menanyakan gelas kaca libbey', 'E-Commerce', '1', '1'),
('230317/CTP-0027', 'Ecko Ryanto Wicaksono', 'CTP', 'Ecko Ryanto Wicaksono', '', 'Ridhwan Harris', 1679017680, 'menanyakan food cover polycarbonate ', 'E-Commerce', '1', '1'),
('230317/CTP-0028', 'Dedi', 'CTP', 'Dedi', '', 'Ridhwan Harris', 1679022300, 'menanyakan kapasitas kastrol no 7 ', 'E-Commerce', '', '1'),
('230317/CTP-0030', 'Djournal Coffee', 'CTP', 'Donny', '', 'Ridhwan Harris', 1679024820, 'menanyakan stock nampan warna hitam ', 'E-Commerce', '1', '0'),
('230317/CTP-0031', 'Trendyar', 'CTP', 'Trendyar', '', 'Ridhwan Harris', 1679036220, 'Menanyakan card holder kayu mahoni', 'E-Commerce', '1', '1'),
('230317/CTP-0032', 'Rieke', 'CTP', 'Rieke', '', 'Ridhwan Harris', 1679037240, 'Menanyakan mangkok kaca luminarc', 'E-Commerce', '1', '0'),
('230317/CTP-0033', 'Mangkokku Indonesia Kemanggisan', 'CTP', 'Devi', '082228286678', 'Ridhwan Harris', 1679040000, 'Menanyakan cutting board warna putih MK-CB-520W', 'E-Commerce', '1', '0'),
('230317/CTP-0034', 'Tjin Ling', 'CTP', 'Tjin Ling', '', 'Ridhwan Harris', 1679039400, 'menanyakan grill pan subron', 'E-Commerce', '1', '1'),
('230317/CTP-0035', 'Revizka Nuraini', 'CTP', 'Revizka Nuraini', '', 'Ridhwan Harris', 1679046540, 'menanyakan service bell mau order 2 pcs', 'E-Commerce', '1', '1'),
('230317/CWA-0025', 'Lettas Kitchen', 'CWA', 'Ibu Mai', '08176553882', 'Ridhwan Harris', 1679104320, 'konfirmasi pengiriman barang', 'E-Commerce', '0', '1'),
('230317/CWA-0029', 'My Kitchen Indonesia', 'CWA', 'Ibu Tania', '', 'Ridhwan Harris', 1679037660, 'menanyakan teko kinox dan coffee stove double warmer', 'E-Commerce', '0', '1'),
('230317/CWB-0011', 'KAMPUS MUBARAK', 'CWB', 'SYAIFUL AHMAD (ASEP)', '081222639390', 'Mellawati', 1679034660, 'CUSTOMER TANYA BARANG', 'Website', '1', '1'),
('230317/CWB-0012', 'ARIF FRIATNA', 'CWB', 'ARIF FRIATNA', '082116795969', 'Mellawati', 1679104200, 'TANYA CHAFFING DISH ', 'Website', '1', '1'),
('230317/CWS-0017', 'Grand Sunshine Soreang', 'CWS', 'Bp Erwin', '082316762621', 'Vira Fitri Zulaikha', 1679018400, 'Kebutuhan kuali uk 80 cm bahan blacksteel ', 'Showroom', '1', '1'),
('230317/CWS-0018', 'Bpk Indra', 'CWS', 'Bpk Indra', '081212223121', 'SINTA APR', 1679019360, 'customer sedang mencari piring saji, sendok, dan gelas untuk kebutuhan restaurant baru ', 'Showroom', '1', '1'),
('230317/CWS-0019', 'Wahoo', 'CWS', 'Bp.andhy', '082811231080', 'Fredinal juniawan', 1678943280, 'Membutuhkan beberapa barang ,termasuk yg tidak ada di toko\r\nTurner ,ladle ,cook knife ,opener ,pizza cutter ,bar mat ,fabric glove ,cheker ,rak sepatu .', 'Showroom', '1', '0'),
('230317/CWS-0020', 'Ibis Padang', 'CWS', 'Bp adit', '08116627770', 'Vira Fitri Zulaikha', 1679025780, 'Kebutuhan coklat fountain ', 'Showroom', '1', '1'),
('230317/CWS-0021', 'Pak Sandy', 'CWS', 'Pak Sandy', '08118085899', 'SINTA APR', 1679024580, 'Mencari barang untuk kebutuhan Restoran titik point Jakarta ', 'Showroom', '1', '1'),
('230317/CWS-0022', 'Al Jazeerah Signature Middle East Restaurant', 'CWS', 'Pak Ahmad', '0859117340766', 'SINTA APR', 1679025600, '', 'Showroom', '1', '1'),
('230317/CWS-0023', '081510126819', 'CWS', 'Ibu Dita', '082811231080', 'Fredinal juniawan', 1678955160, 'Membutuhkan barang gn pans,insert ', 'Showroom', '0', '1'),
('230317/CWS-0024', 'Sariater Hot Springs', 'CWS', 'Bp Dede', '082218406389', 'Vira Fitri Zulaikha', 1678852800, 'Belum ada kebutuhan ', 'Showroom', '1', '1'),
('230317/CWS-0025', 'Kampung Sampireun', 'CWS', 'Bp Aang', '089608052285', 'Vira Fitri Zulaikha', 1678860000, 'Belum ada respon ', 'Showroom', '1', '1'),
('230317/CWS-0026', 'Strawbery highland', 'CWS', 'Ibu imas', '08179203135', 'Vira Fitri Zulaikha', 1678856400, 'Baru masuk katalog', 'Showroom', '1', '1'),
('230317/CWS-0027', 'Hotel Harmoni Garut', 'CWS', 'Ibu khofifah', '085727233669', 'Vira Fitri Zulaikha', 1679028360, 'Belum ada respon', 'Showroom', '1', '1'),
('230317/CWS-0028', 'Hutan Jati Cafe Purwakarta', 'CWS', 'Bp acon', '082115155451', 'Vira Fitri Zulaikha', 1679027760, 'Kebutuhan grill', 'Showroom', '1', '1'),
('230317/CWS-0029', 'Eiger Coffee Jatinangor', 'CWS', 'Ibu ratna', '08562188200', 'Vira Fitri Zulaikha', 1678863600, 'Masuk katalog', 'Showroom', '1', '1'),
('230317/CWS-0030', 'Blackbird Hotel', 'CWS', 'Ibu Sandra', '088224331080', 'Vira Fitri Zulaikha', 1678942800, 'Kebutuhan sugar pack ', 'Showroom', '1', '1'),
('230317/CWS-0031', 'Hemanggini hotel', 'CWS', 'Bp iqbal', '081390019203', 'Vira Fitri Zulaikha', 1679029320, 'Baru mengontak', 'Showroom', '1', '1'),
('230317/CWS-0032', 'Solaria cihampelas ciwalk', 'CWS', 'Ibu risma', '085973811348', 'Vira Fitri Zulaikha', 1679034300, 'Kebutuhan gelas libbey', 'Showroom', '0', '1'),
('230317/CWS-0033', 'Sensa Hotel Bandung', 'CWS', 'ibu karin', '081298559696', 'Pitri', 1679035020, 'follow up costumer dan buat penawaran', 'Showroom', '1', '1'),
('230317/CWS-0034', 'bp alvin', 'CWS', 'bp alvin', '', 'Pitri', 1679035740, 'follow up customer dan membuat penawaran', 'Showroom', '0', '1'),
('230317/CWS-0035', 'Tirta kencana Garut', 'CWS', 'Bp sendi', '081222741329', 'Vira Fitri Zulaikha', 1678860000, 'Tidak merespon', 'Showroom', '1', '1'),
('230317/CWS-0036', 'Cibiuk Resto', 'CWS', 'Bp iden', '08987924961', 'Vira Fitri Zulaikha', 1678862400, 'Kebutuhan mangkok ', 'Showroom', '0', '1'),
('230317/CWS-0037', 'Miranty Catering', 'CWS', 'Bp imam', '081290830304', 'Vira Fitri Zulaikha', 1679040000, 'Belum ada respon', 'Showroom', '0', '1'),
('230317/CWS-0038', 'Geulis hotel', 'CWS', 'Bp Jamal', '081320635570', 'Vira Fitri Zulaikha', 1678869000, 'Baru dapat no purchasing', 'Showroom', '1', '1'),
('230317/CWS-0039', 'Amaris Hotel Setiabudhi', 'CWS', 'Bp deden', '083894447218', 'Vira Fitri Zulaikha', 1678863600, 'Belum adaa kebutuhan ', 'Showroom', '1', '1'),
('230317/CWS-0040', 'Mana Cafe', 'CWS', 'Bp Sofyan', '085720406360', 'Vira Fitri Zulaikha', 1678863600, 'Belum ada kebutuhan ', 'Showroom', '1', '1'),
('230317/CWS-0041', 'Hotel Depaviljoen', 'CWS', 'Ibu dian', '087821866660', 'Vira Fitri Zulaikha', 1678858200, 'Belum ada respon', 'Showroom', '1', '1'),
('230317/CWS-0042', 'Ayana stawerding', 'CWS', 'Ibu Arvinia', '081337403237', 'Fredinal juniawan', 1679043240, 'Meminta penawaran karpet afd', 'Showroom', '0', '1'),
('230317/CWS-0043', 'Highheels Resort', 'CWS', 'Ibu tince', '0821220080056', 'Vira Fitri Zulaikha', 1678856400, 'Masih belum ada kebutuhan ', 'Showroom', '1', '1'),
('230317/CWS-0044', 'Neo Hotel Cirebon', 'CWS', 'Ibu ayu', '085703040763', 'Vira Fitri Zulaikha', 1678946400, 'Kebutuhan Bnb plate uk 16 cm ', 'Showroom', '0', '1'),
('230317/CWS-0045', 'sangimicnano', 'CWS', 'bp rouf', '', 'Nina yuliana', 1679043720, 'follow up costumer ', 'Showroom', '0', '1'),
('230317/CWS-0046', 'boy and cow resto', 'CWS', 'boy and cow', '082144716526', 'Nina yuliana', 1679043960, 'follow up costumer', 'Showroom', '1', '1'),
('230317/CWS-0047', 'ibis hotel palembang', 'CWS', 'bu ema', '085841057988', 'Pitri', 1679044440, 'follow up dan penawaran', 'Showroom', '0', '1'),
('230318/CFP-0104', 'Bakmi along', 'CFP', 'Bapak surya', '', 'Angga yanyan', 1679108100, 'Menawarkan product perlengkapan kitchen dan menjelaskan promo yang berlaku di mr kitchen', 'Telemarketing 75', '1', '1'),
('230318/CFP-0105', 'Bakmi ratu dahlia', 'CFP', 'Admin bakmi dahlia', '087877120556', 'Angga yanyan', 1679108220, 'Menawarkan perlengkapan kitchen dan promo yang sedang berlaku di mr kitchen bandung', 'Telemarketing 75', '1', '1'),
('230318/CFP-0106', 'Bapak indra', 'CFP', 'Bapak indra', '085789540540', 'Angga yanyan', 1679109480, 'Menawarkan kebutuhan untuk perlengkapan kitchen serta menawarkan promo yang sedang berlaku di mr kitchen', 'Telemarketing 75', '1', '1'),
('230318/CHK-0102', 'PT. Tomafood', 'CHK', 'Ibu Inne', '081285535563', 'tiranny', 1679102400, 'tanya barang cup bowl 200ml', 'Telemarketing 75', '0', '1'),
('230318/CHK-0103', 'Montigo resort seminyak', 'CHK', 'Bapak Putu', '081238118281', 'tiranny', 1679107620, 'tanya barang chiller, salamander. deep fryer, flat griddle, grill stove, show case', 'Telemarketing 75', '0', '1'),
('230318/CTP-0036', 'Nordia', 'CTP', 'Nordia', '', 'Ridhwan Harris', 1679101980, 'Menanyakan panggangan putar  magic roaster pro 34cm', 'E-Commerce', '1', '1'),
('230318/CTP-0037', 'Fia', 'CTP', 'Fia', '', 'Ridhwan Harris', 1679106600, 'Menanyakan teko siul subron', 'E-Commerce', '1', '1'),
('230318/CTP-0038', 'Iman', 'CTP', 'Iman', '', 'Ridhwan Harris', 1679102100, 'Menanyakan wajan enamel ukuran 48cm ', 'E-Commerce', '1', '1'),
('230318/CTP-0040', 'Ajeng Anggraeni', 'CTP', 'Ajeng Anggraeni', '', 'Ridhwan Harris', 1679108100, 'menanyakan juicer kirin', 'E-Commerce', '1', '1'),
('230318/CWA-0039', 'Ibu Wahyu Jatim', 'CWA', 'Ibu Wahyu Jatim', '0811121258', 'Ridhwan Harris', 1679101800, 'Menanyakan harga piring tempura melamin', 'E-Commerce', '0', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_followup_detail`
--

CREATE TABLE `tb_followup_detail` (
  `id` int(11) NOT NULL,
  `followup_id` varchar(128) NOT NULL,
  `followup_date` int(11) NOT NULL,
  `comment` enum('0','1','2','3','4') NOT NULL COMMENT '0 Kontak, 1 Followup, 2 Penawaran, 3 Followup penwaran, 4 PO',
  `notes` text,
  `input_date` int(11) NOT NULL,
  `due_date` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_followup_detail`
--

INSERT INTO `tb_followup_detail` (`id`, `followup_id`, `followup_date`, `comment`, `notes`, `input_date`, `due_date`, `value`) VALUES
(1, '230311/CWA-0001', 1678537980, '0', 'Menunggu Po', 1678537980, 1678710780, 0),
(2, '230311/CWA-0001', 1678714380, '1', 'Jadi order SO230313-16404', 1678714380, 1678887180, 0),
(3, '230311/CWA-0001', 1678792800, '4', 'Konfirmasi pembayaran', 1678792800, 1678792800, 1580000),
(4, '230311/CWA-0002', 1678521600, '0', 'Kontak', 1678521600, 1678521600, 0),
(5, '230311/CWA-0002', 1678538280, '1', 'Jadi Order SO230311-16378', 1678538280, 1678711080, 0),
(6, '230311/CWA-0002', 1678785900, '4', 'konfirmasi pengiriman barang dan menanyakan kebutuhan barang lainnya', 1678785900, 1678785900, 0),
(7, '230311/CWA-0003', 1678535460, '0', 'Kontak', 1678535460, 1678535460, 0),
(8, '230311/CWA-0003', 1678538460, '2', 'Penawaran masih dalam proses', 1678538460, 1678538460, 0),
(9, '230311/CWA-0003', 1678714260, '3', 'penawaran barang (terlampir list barangnya sesuai yang di minta)', 1678714260, 1678714260, 0),
(10, '230308/CWA-0004', 1678264680, '0', 'Kontak', 1678264680, 1678264680, 0),
(11, '230308/CWA-0004', 1678714800, '1', 'Jadi PO FP8 sebanyak 20.000pcs no po SO230310-16353', 1678714800, 1678714800, 0),
(12, '230308/CWA-0004', 1678722960, '4', 'konfirmasi untuk pengiriman barangnya di hari selasa 14 maret 2023', 1678722960, 1678722960, 0),
(13, '230313/CWA-0005', 1678698720, '0', 'Kontak', 1678264680, 1678264680, 0),
(14, '230313/CWA-0005', 1678721880, '1', 'Menanyakan blender madin tipe MD 206 , MD 207 dan 326S', 1678721880, 1678894680, 0),
(15, '230313/CWA-0005', 1678803720, '1', 'Menanyakan kompor portable dan spatula', 1678803720, 1678976520, 0),
(16, '230313/CWA-0006', 1678705620, '0', 'Kontak pertama', 1678705620, 1678705620, 0),
(17, '230313/CWA-0006', 1678790460, '1', 'Konfirmasi keputusan untuk meliput resto bumi aki', 1678790460, 1678963260, 0),
(19, '230314/CWA-0007', 1678791660, '0', 'konfirmasi pesanan barang indent ada sedikit keterlambatan', 1678791660, 1678964460, 0),
(20, '230314/CWA-0008', 1678793040, '4', 'konfirmasi pengiriman barang dan menanyakan kebutuhan lainnya', 1678793040, 1678793040, 0),
(21, '230314/CWA-0009', 1678805220, '0', 'Menanyakan piring dan mangkok keramik motif swirl putih', 1678805220, 1678978020, 0),
(22, '230314/CWA-0009', 1678805580, '4', 'Jadi order di tokopedia no po SO230314-16500', 1678805580, 1678978380, 0),
(23, '230315/CWB-0001', 1678757940, '0', 'Follow up penawaran tgl 8 maret, belum di cek sama atasannya', 1678846725, 1678930740, NULL),
(24, '230315/CWB-0001', 1678846740, '3', 'masih follow up penawaran tgl 8 maret, akhir bulan mungkin akan ada order', 1678846830, 1679019540, NULL),
(25, '230315/Ctr-0001', 1678845600, '0', 'Minta sampel Sl-750FPT', 1678847073, 1679018400, NULL),
(26, '230315/CWB-0002', 1678846860, '0', 'FOLLOW UP PENAWARAN TANGGAL 13 MARET 2023', 1678847074, 1679019660, NULL),
(27, '230315/CTR-0001', 1678847040, '3', 'Kirim Sampel SL-750FPT', 1678847117, 1679019840, NULL),
(28, '230315/CTP-0010', 1678843200, '0', 'Menanyakan stock mangkok keramik BZR-BPRGY dan BZR-BPRTMNT', 1678848174, 1679016000, NULL),
(29, '230315/CTP-0010', 1678848180, '4', 'Customer sudah Po no SO230315-16517', 1678848260, 1679020980, NULL),
(30, '230313/CWA-0005', 1678848300, '2', 'penawaran harga food tong stainless', 1678848344, 1679021100, 0),
(31, '230315/CHK-0001', 1678843800, '0', '', 1678850064, 1679016600, NULL),
(32, '230315/CHK-0001', 1678850100, '1', 'Sedang tanya sink dan gas stove', 1678850144, 1679022900, NULL),
(33, '230315/HOR-0001', 1678850100, '0', 'Follow up kunjungan,dan menawarkan barang', 1678850293, 1679022900, NULL),
(34, '230315/HOR-0001', 1678850280, '1', 'Follow kunjungan, menawarkan barang', 1678850350, 1679023080, NULL),
(37, '230315/CFP-0004', 1678867500, '0', 'Sedang ada kebutuhan fp 1200 tc black', 1678850535, 1679040300, NULL),
(38, '230315/CHK-0005', 1678844400, '0', 'Untuk saat ini masih belum ada kebutuhan barangnya', 1678851016, 1679017200, NULL),
(39, '230315/CHK-0006', 1678844280, '0', 'Sedang dalam pengajuan untuk proses po ', 1678851131, 1679017080, NULL),
(42, '230315/CHK-0006', 1678851420, '2', 'Penawaran kebutuhan perlengkapan kitchen', 1678851462, 1679024220, NULL),
(43, '230315/CHK-0005', 1678851480, '1', 'Belum ada kebutuhan barangnya ', 1678851505, 1679024280, NULL),
(44, '230315/CFP-0004', 1678851540, '1', 'Tanya barang fp 1200 tc', 1678851604, 1679024340, NULL),
(48, '230315/CHK-0007', 1678845900, '0', 'Sudah dibuatkan penawaran untuk kebutuhan gelas old fasion', 1678851895, 1679018700, NULL),
(49, '230315/CHK-0007', 1678851900, '2', 'Sedang ada kebutuhan gelas oldfasion ', 1678851983, 1679024700, NULL),
(50, '230315/CHK-0008', 1678845420, '0', 'Untuk saat ini belum ada kebutuhannya', 1678852248, 1679018220, NULL),
(51, '230315/CTP-0011', 1678849500, '0', 'Menanyakan stock JW-12RP sebanyak 12 pcs', 1678852271, 1679022300, NULL),
(52, '230315/CHK-0008', 1678852260, '1', 'Untuk saat ini masih belum ada kebutuhan barangnya', 1678852342, 1679025060, NULL),
(53, '230315/CHK-0009', 1678846140, '0', 'Tanya barang cetakan kue untuk serabi', 1678852628, 1679018940, NULL),
(54, '230315/CHK-0009', 1678852620, '1', 'Sedang tanya barang cetakan kue serabi', 1678852679, 1679025420, NULL),
(55, '230315/CHK-0010', 1678846260, '0', 'Sudah proses po ', 1678852925, 1679019060, NULL),
(56, '230315/CHK-0010', 1678852920, '4', 'Po mk-kb-2201-160green (10pcs)\r\nMk-kb-2201-160blue(10pcs)\r\nMk-d1217pblack(100pcs)\r\n', 1678853090, 1679025720, NULL),
(57, '230315/CTP-0011', 1678853400, '4', 'Jadi order Po no SO230315-16527', 1678853512, 1679026200, NULL),
(58, '230315/CHK-0011', 1678850100, '0', 'Sudah ada penawaran mk-zp-25papg', 1678853532, 1679022900, NULL),
(59, '230315/CHK-0011', 1678853520, '2', 'Sudah dibuatkan penawaran mk-zp-25papg', 1678853615, 1679026320, NULL),
(60, '230315/CHK-0012', 1678850100, '0', 'Follow up penawaran mk-yd-fo17', 1678853953, 1679022900, NULL),
(61, '230315/CHK-0012', 1678853940, '3', 'Masih dalam proses pengajuan dengan user dan management mengenai penawarannya', 1678854029, 1679026740, NULL),
(62, '230313/CWA-0005', 1678854300, '3', 'penawaran harga ladle sebanyak 3pcs ', 1678854388, 1679027100, 0),
(63, '230315/CHK-0013', 1678850220, '0', 'Masih dalam proses pengajuan dengan ownernya', 1678854785, 1679023020, NULL),
(64, '230315/CHK-0013', 1678854780, '3', 'Masih dalam proses pengajuan untuk pembayaran dengan management dan accounting kami', 1678854857, 1679027580, NULL),
(65, '230314/CWA-0007', 1678854900, '3', 'Penawaran harga panci bima (barang indent)', 1678854995, 1679027700, 0),
(66, '230315/CHK-0014', 1678855920, '0', 'Sudah dibuatkan penawaran oven gas steam deck', 1678855055, 1679028720, NULL),
(67, '230315/CHK-0014', 1678855080, '3', 'Masih dalam proses meeting untuk ovennya dengan user dan managementnya', 1678855144, 1679027880, NULL),
(68, '230315/CHK-0014', 1678855140, '3', 'Masih dalam proses meeting untuk penawaran oven gas steam decknya', 1678855220, 1679027940, NULL),
(69, '230315/HOR-0002', 1678854900, '0', 'Penawaran harga ,sudah pemesanan barang ( MK-PL-SP2029SL)', 1678855220, 1679027700, NULL),
(70, '230315/CHK-0014', 1678855200, '3', '', 1678855258, 1679028000, NULL),
(71, '230315/HOR-0002', 1678855200, '3', 'Menunggu stok barang', 1678855331, 1679028000, NULL),
(72, '230315/CHK-0015', 1678855380, '0', 'Tanya barang sushi grill', 1678855513, 1679028180, NULL),
(73, '230315/CHK-0015', 1678855500, '1', 'Tanya barang sushi grill', 1678855604, 1679028300, NULL),
(74, '230315/CHK-0016', 1678855800, '0', 'Minta dibantu pengadaan cealler dan cool box', 1678855825, 1679028600, NULL),
(77, '230315/CHK-0016', 1678856040, '4', 'Sudah po ', 1678856069, 1679028840, NULL),
(78, '230315/CHK-0017', 1678856700, '0', 'Belum ada kebutuhannya', 1678856704, 1679029500, NULL),
(79, '230315/CHK-0017', 1678856700, '1', 'Belum ada kebutuhannya', 1678856753, 1679029500, NULL),
(80, '230315/CHK-0018', 1678860120, '0', 'Belum ada kebutuhan nya', 1678860226, 1679032920, NULL),
(81, '230315/CHK-0018', 1678860180, '1', 'Untuk saat ini belum ada kebutuhannya', 1678860278, 1679032980, NULL),
(82, '230315/CHK-0017', 1678860240, '1', 'Untuk saat ini belum ada kebutuhan nya', 1678860340, 1679033040, NULL),
(83, '230315/CHK-0014', 1678860360, '3', 'Sedang dalam proses pengajuan untuk oven gas steamnya', 1678860453, 1679033160, NULL),
(84, '230315/CHK-0019', 1678817400, '0', 'Untuk saat ini belum ada kebutuhan barangnya', 1678860595, 1678990200, NULL),
(85, '230315/CHK-0020', 1678817400, '0', 'Belum ada kebutuhannya', 1678860758, 1678990200, NULL),
(86, '230315/CHK-0019', 1678860780, '1', '', 1678860830, 1679033580, NULL),
(87, '230315/CHK-0020', 1678860840, '1', 'Belum ada kebutuhannya', 1678860881, 1679033640, NULL),
(88, '230315/CHK-0021', 1678817400, '0', 'Belum ada kebutuhan barangnya', 1678861025, 1678990200, NULL),
(89, '230315/CHK-0021', 1678861020, '1', 'Untuk saat ini masih belum ada kebutuhan barangnya', 1678861104, 1679033820, NULL),
(90, '230315/CHK-0022', 1678816920, '0', 'Tanya barang steamer kotak 40cm (1pcs)', 1678861255, 1678989720, NULL),
(91, '230315/CHK-0022', 1678861260, '1', 'Tanya barang steamer ', 1678861320, 1679034060, NULL),
(92, '230313/CWA-0005', 1678861260, '4', 'jadi order po no SO230315-16533', 1678861373, 1679034060, 0),
(93, '230315/CHK-0023', 1678817460, '0', 'Belum ada kebutuhannya', 1678861623, 1678990260, NULL),
(94, '230315/CTP-0012', 1678857000, '0', 'Menanyakan stock jelly mousse cup MK-013 sebanyak 200pcs', 1678862148, 1679029800, NULL),
(95, '230315/FOP-0002', 1678172400, '0', '', 1678862500, 1678345200, NULL),
(96, '230315/FOP-0002', 1678862460, '4', 'UL-FP4 6000pcs', 1678862620, 1679035260, NULL),
(97, '230315/CHK-0024', 1678819620, '0', 'Belum ada kebutuhan barangnya', 1678862894, 1678992420, NULL),
(98, '230315/CHK-0023', 1678862880, '1', 'Belum ada kebutuhan barangnya', 1678862943, 1679035680, NULL),
(99, '230315/CHK-0024', 1678862940, '1', 'Belum ada kebutuhan barangnya', 1678862984, 1679035740, NULL),
(100, '230315/CHK-0025', 1678819980, '0', 'Belum ada kebutuhan barangnya mas kalau ada kami kabari', 1678863367, 1678992780, NULL),
(101, '230315/CHK-0025', 1678863360, '1', 'Belum ada kebutuhan kalau sudah ada kami kabari ke mas angga', 1678863415, 1679036160, NULL),
(102, '230315/CHK-0026', 1678820400, '0', 'Belum ada kebutuhannya mas', 1678863540, 1678993200, NULL),
(103, '230315/CHK-0026', 1678863540, '1', 'Belum ada kebutuhan barangnya', 1678863581, 1679036340, NULL),
(104, '230315/CHK-0027', 1678863720, '0', 'Sampai saat ini belum ada kebutuhan barangnya', 1678863762, 1679036520, NULL),
(105, '230315/CHK-0027', 1678863780, '1', 'Sampai saat ini belum ada kebutuhan untuk tambahan barangnya', 1678863832, 1679036580, NULL),
(106, '230315/CTP-0012', 1678864260, '4', 'jadi order po no SO230315-16542', 1678864565, 1679037060, NULL),
(107, '230315/CHK-0028', 1678821180, '0', 'Untuk saat ini belum ada krbutuhan barangnya', 1678864708, 1678993980, NULL),
(108, '230315/CHK-0028', 1678864740, '1', 'Untuk saat ini belum ada kebutuhan barangnya', 1678864775, 1679037540, NULL),
(109, '230315/CHK-0029', 1678821540, '0', 'Untuk saat ini belum ada kebutuhan barangnya', 1678864910, 1678994340, NULL),
(110, '230315/CHK-0029', 1678864920, '1', 'Untuk saat ini belum ada kebutuhan nya', 1678864974, 1679037720, NULL),
(111, '230315/CHK-0030', 1678863660, '0', 'Untuk saat ini belum ada kebutuhannya', 1678865313, 1679036460, NULL),
(112, '230311/CWA-0003', 1678865340, '3', 'Follow up penawaran ', 1678865393, 1679038140, NULL),
(113, '230315/CWB-0001', 1678865340, '2', 'PENAWARAN TAMBAHAN BARANG', 1678865448, 1679038140, NULL),
(114, '230315/CHK-0030', 1678865340, '1', 'Untuk saat ini masih belum ada kebutuhannya', 1678865454, 1679038140, NULL),
(115, '230315/CWB-0003', 1678848300, '0', 'TANYA BARANG FRYNG PAN', 1678865871, 1679021100, NULL),
(116, '230315/CHK-0031', 1678865760, '0', 'Untuk sampai saat ini belum ada kebutuhannya', 1678865965, 1679038560, NULL),
(117, '230315/CWB-0003', 1678865820, '1', 'TANYA BARANG FRYNG PAN HANDLE SATU, TAPI BARANG YG DITAWARKAN BERBEDA DENGAN PERMINTAAN CUSTOMER YAITU FRYNG PAN DENGAN DOUBLE HANDLE', 1678865998, 1679038620, NULL),
(118, '230315/CHK-0031', 1678866000, '1', 'Untuk sampai saat ini belum ada kebutuhannya', 1678866034, 1679038800, NULL),
(119, '230315/CHK-0031', 1678866060, '1', 'Untuk sampai saat ini belum ada kebutuhannya', 1678866097, 1679038860, NULL),
(120, '230315/CHK-0032', 1678866300, '0', 'Masih dalam proses pengajuan untuk po barangnya oleh management kami', 1678866364, 1679039100, NULL),
(121, '230315/CHK-0032', 1678866360, '3', 'Masih dalam pengajuan untuk po dengan managementnya', 1678866420, 1679039160, NULL),
(122, '230315/CHK-0032', 1678866420, '3', 'Masih dalam pengajuan untuk po dengan managementnya', 1678866451, 1679039220, NULL),
(123, '230315/CHK-0033', 1678866600, '0', 'Untuk saat ini belum ada kebutuhannya', 1678866587, 1679039400, NULL),
(124, '230315/CTP-0013', 1678849200, '0', 'menanyakan measuring spoon ', 1678866601, 1679022000, NULL),
(125, '230315/CHK-0033', 1678866540, '1', 'Untuk saat ini masih belum ada kebutuhan untuk perlengkapannya', 1678866624, 1679039340, NULL),
(126, '230315/CTP-0013', 1678851000, '1', 'barang tidak ada', 1678866675, 1679023800, NULL),
(127, '230315/CWB-0004', 1678842900, '0', 'TANYA PIRING MELAMIN HOOVER', 1678866874, 1679015700, NULL),
(128, '230315/CSP-0014', 1678846800, '0', 'menanyakan tatakan cangkir legacy ', 1678867082, 1679019600, NULL),
(129, '230315/CHK-0034', 1678896900, '0', 'Untuk saat ini belum ada kebutuhan nya', 1678867281, 1679069700, NULL),
(130, '230315/CWB-0004', 1678843620, '1', 'PIRING HOOVER MINTA PENGADAAN KE BU LINA, CUSTOMER MINTA DISCOUNT HARGA', 1678867284, 1679016420, NULL),
(131, '230315/CSP-0014', 1678867200, '1', 'menanyakan berapa pcs yang di dapat dari harga barangnya', 1678867293, 1679040000, NULL),
(132, '230315/CHK-0034', 1678867260, '1', 'Untuk saat ini belum ada kebutuhan', 1678867359, 1679040060, NULL),
(133, '230315/CHK-0035', 1678867500, '0', 'Sedang ada kebutuhan cutleries brand serena', 1678867542, 1679040300, NULL),
(134, '230315/CWB-0005', 1678842900, '0', 'MINTA PENAWARAN', 1678867578, 1679015700, NULL),
(135, '230315/CHK-0034', 1678867560, '1', 'Belum ada kebutuhannya', 1678867584, 1679040360, NULL),
(136, '230315/CHK-0035', 1678867560, '2', 'Sudah dibuatkan penawaran cutleries brand serena ', 1678867652, 1679040360, NULL),
(137, '230315/CWA-0015', 1678843200, '0', 'Konfirmasi pembayaran ', 1678868161, 1679016000, NULL),
(138, '230315/CWA-0015', 1678843800, '1', 'menanyakan kebutuhan fp1200ts black', 1678868220, 1679016600, NULL),
(139, '230315/CWA-0016', 1678856100, '0', 'menanyakan spatula heat resist 25cm sama oil skimme 30cm dan hamburger spatula 38cm ', 1678868501, 1679028900, NULL),
(140, '230315/CWA-0016', 1678868460, '1', 'tawari produk pembanding', 1678868632, 1679041260, NULL),
(141, '230315/CHK-0036', 1678868700, '0', 'Belum ada kebutuhan barangnya', 1678868772, 1679041500, NULL),
(142, '230315/CHK-0036', 1678868760, '1', 'Belum ada kebutuhannya', 1678868809, 1679041560, NULL),
(143, '230315/CHK-0037', 1678869000, '0', 'Belum ada kebutuhannya', 1678868968, 1679041800, NULL),
(144, '230315/CHK-0037', 1678868940, '1', 'Belum ada kebutuhan nya', 1678869003, 1679041740, NULL),
(145, '230315/CHK-0037', 1678869060, '1', 'Belum ada kebutuhannya', 1678869088, 1679041860, NULL),
(146, '230315/CHK-0038', 1678869240, '0', 'Sampai saat ini belum ada kebutuhan ', 1678869215, 1679042040, NULL),
(147, '230315/CHK-0038', 1678869180, '1', 'Sampai saat ini belum ada kebutuhan barangnya', 1678869249, 1679041980, NULL),
(148, '230315/CHK-0038', 1678869300, '1', 'Belum ada kebutuhan ', 1678869320, 1679042100, NULL),
(149, '230315/CHK-0034', 1678870320, '1', 'Belum ada kebutuhannya', 1678870387, 1679043120, NULL),
(150, '230315/CHK-0039', 1678870860, '0', 'Belum ada kebutuhannya', 1678870602, 1679043660, NULL),
(151, '230315/CHK-0039', 1678870560, '1', 'Belum ada kebutuhannya', 1678870682, 1679043360, NULL),
(152, '230315/CHK-0039', 1678870680, '1', 'Belum ada kebutuhannya', 1678870724, 1679043480, NULL),
(153, '230315/CHK-0040', 1678868100, '0', 'Belum ada kebutuhannya', 1678870898, 1679040900, NULL),
(154, '230315/CHK-0040', 1678870860, '1', 'Belum ada kebutuhan', 1678870943, 1679043660, NULL),
(155, '230315/CHK-0041', 1678871280, '0', 'Sedang dalam pengajuan untuk po karpetnya', 1678871289, 1679044080, NULL),
(156, '230315/CHK-0041', 1678871280, '3', 'Sedang dalam proses pengajuan untuk po karpetnya', 1678871327, 1679044080, NULL),
(157, '230315/CHK-0041', 1678871280, '3', 'Sedang dalam proses pengajuan po untuk karpetnya', 1678871367, 1679044080, NULL),
(158, '230315/CHK-0041', 1678871340, '3', 'Sedang dalam proses pengajuan po untuk karpetnya', 1678871399, 1679044140, NULL),
(159, '230315/CHK-0042', 1678871580, '0', 'Belum ada kebutuhan ', 1678871514, 1679044380, NULL),
(160, '230315/CHK-0042', 1678871460, '1', 'Belum ada kebutuhan', 1678871540, 1679044260, NULL),
(161, '230315/CHK-0042', 1678871520, '1', 'Belum ada kebutuhan', 1678871564, 1679044320, NULL),
(162, '230315/CWS-0003', 1678850100, '0', 'follow up costumer,menawarkan barang dan promo yang berlaku', 1678873314, 1679022900, NULL),
(163, '230315/CWS-0003', 1678850100, '1', 'follow up customer,menawarkan barang dan promo yang berlaku', 1678873402, 1679022900, NULL),
(164, '230315/CWS-0004', 1678850100, '0', 'follow up penawaran bowl kaca luminarc  dan sudah po ', 1678873596, 1679022900, NULL),
(166, '230315/CWS-0004', 1678873680, '4', 'barang sudah terjual sebanyak 20 pcs', 1678873729, 1679046480, NULL),
(167, '230315/CWS-0005', 1678850400, '0', 'follow up penawaran panci presto maxim', 1678873903, 1679023200, NULL),
(168, '230315/CWS-0005', 1678873860, '3', 'follow up penawaran panci presto maxim', 1678873943, 1679046660, NULL),
(169, '230315/CWS-0006', 1678850400, '0', 'follow up customer,menawarkan promo baru yang berlaku beserta menawarkan barang', 1678874109, 1679023200, NULL),
(170, '230315/CWS-0006', 1678874100, '1', 'follow up customer menawarkan promo dan barang', 1678874154, 1679046900, NULL),
(171, '230315/CWS-0007', 1678850400, '0', 'follow up penawaran dan sudah jadi po', 1678874301, 1679023200, NULL),
(172, '230315/CWS-0007', 1678874280, '4', 'barang sudah di order dan sudah transaksi', 1678874344, 1679047080, NULL),
(173, '230315/CWS-0008', 1678851000, '0', 'follow up penawaran  electric cettle subron', 1678874622, 1679023800, NULL),
(174, '230315/CWS-0008', 1678874580, '3', 'follow up penawaran electric cettle subron', 1678874654, 1679047380, NULL),
(175, '230316/CTP-0017', 1678929900, '0', 'Menanyakan barang tutup food ukuran 1/3', 1678931808, 1679102700, NULL),
(176, '230316/CHK-0043', 1678932000, '0', 'Follow up penawaran kebutuhan perlengkapan kitchen dan menawarkan promo yang berlaku di mr kitchen', 1678931948, 1679104800, NULL),
(177, '230316/CTP-0018', 1678928700, '0', 'Menanyakan hand blender philips', 1678931952, 1679101500, NULL),
(178, '230316/CTP-0017', 1678931940, '1', 'Menginfokan untuk stocknya ready', 1678931997, 1679104740, NULL),
(179, '230316/CHK-0043', 1678931940, '1', 'Follow up penawaran untuk kebutuhan perlengkapan kitchen dan menawarkan promo yang ada di mr kitchen', 1678932028, 1679104740, NULL),
(180, '230316/CTP-0018', 1678932900, '1', 'menginfokan merk philips kosong digantikan dengan merk yang lain ', 1678932976, 1679105700, NULL),
(181, '230316/CWB-0006', 1678879200, '0', 'tanya karpet', 1678933146, 1679052000, NULL),
(182, '230316/CTP-0017', 1678933140, '4', 'Jadi order po no SO230316-16565', 1678933214, 1679105940, NULL),
(183, '230316/CWB-0006', 1678930920, '1', 'tanya karpet AFD premium-straight edge, tapi barang tidak ada, jadi ditawarkan karpet yg sejenis tapi ketebalannya berbeda. ', 1678933376, 1679103720, NULL),
(184, '230316/CTP-0019', 1678932000, '0', 'menginfokan untuk pesanan gelas harus di packing kayu', 1678933424, 1679104800, NULL),
(185, '230316/CWB-0007', 1678876020, '0', 'TANYA SLOW COOKER', 1678935501, 1679048820, NULL),
(186, '230316/CWB-0007', 1678930020, '1', 'TANYA SLOW COOKER, DITAWARKAN MERK IDEALIFE. BELUM RESPON LAGI', 1678935581, 1679102820, NULL),
(187, '230315/CWB-0003', 1678933380, '1', 'TANYA FRYING PAN SINGLE HANDLE NON STICK, DIAMETER DIATAS 36 CM, DITAWARKAN FRYING PAN NONSTICK DENGAN DOUBLE HANDLE, TAPI TIDAK MAU, SEDANG DITAWARKAN LAGI FRYING PAN SINGLE HANDLE YG STAINLESS, SEDANG DITANYAKAN KE ATASANNYA', 1678935863, 1679106180, NULL),
(188, '230316/CWB-0008', 1678933800, '0', 'TANYA DISKON PRODUK PIRING DAN GELAS UNTUK PEMBELIAN GROSIR', 1678936238, 1679106600, NULL),
(189, '230316/CTP-0019', 1678936260, '1', 'Setuju barang untuk pakai packing kayu', 1678936341, 1679109060, NULL),
(190, '230316/CWB-0008', 1678935240, '1', 'UNTUK DISCOUNT KATA BU LINA AKAN DILIHAT DULU DARI JENIS DAN BAHAN PIRING ATAU GELAS DAN JUGA JUMLAH PEMBELIAN. CUSTOMER AKAN LIHAT-LIHAT DULU DI WEBSITE UNTUK BARANGNYA', 1678936362, 1679108040, NULL),
(191, '230316/CTP-0020', 1678937100, '0', 'Menanyakan merk pisau sashimi jepang ', 1678937812, 1679109900, NULL),
(192, '230316/CWS-0009', 1678824900, '0', 'Menanyakan slow cooker', 1678938915, 1678997700, NULL),
(193, '230316/CWS-0010', 1678897860, '0', 'Kebutuhan gelas uk 150 ml dengan harga terjangkau ', 1678938964, 1679110680, NULL),
(194, '230316/CHK-0044', 1678875420, '0', 'tanya barang kohana panci', 1678939260, 1679048220, NULL),
(195, '230316/CHK-0044', 1678939260, '1', 'cancel order dikarnakan barangnya tidak ada', 1678939295, 1679112060, NULL),
(196, '230316/CWS-0010', 1678935600, '1', 'Masih diajukan untuk uk gelas dan harga yang telah diberikan ', 1678939303, 1679108400, NULL),
(197, '230316/CHK-0045', 1678090080, '0', 'customer minta list penawaran utensil', 1678939401, 1678262880, NULL),
(198, '230316/CHK-0046', 1678596300, '0', 'baru masuk list tanya barang', 1678939439, 1678769100, NULL),
(199, '230316/CHK-0045', 1678271340, '2', 'mengirim list penawaran yang sudah diproses ', 1678939470, 1681097340, NULL),
(200, '230316/CHK-0046', 1678849020, '1', 'follow up untuk list penawaran', 1678939551, 1679021820, NULL),
(201, '230316/CHK-0045', 1678959540, '3', 'untuk penawaran yang utensil sedang diajukan dulu dengan chef nya, hari ini mengirimkan penawaran baru list asset kitchen ', 1678939574, 1681785540, NULL),
(202, '230316/CHK-0046', 1678873980, '2', 'minta dibuatkan penawaran untuk list barang', 1678939638, 1679046780, NULL),
(203, '230316/CHK-0047', 1678933920, '0', 'Menanyakan gelas libbey kode 2349 untuk kebutuhan 200 pcs ', 1678939757, 1679106720, NULL),
(204, '230316/CWS-0011', 1678939920, '0', 'Kebutuhan jartb 1300 dan jartb 500', 1678940128, 1679076720, NULL),
(205, '230316/CWS-0011', 1678966020, '4', 'Po jartb 1300 sebanyak 85 bh\r\n      Jartb 500 sebanyak 70 bh\r\nDiambil tanggal 18-03-23', 1678940358, 1678258920, NULL),
(206, '230316/CHK-0048', 1678086120, '0', 'baru masuk list tanya barang', 1678940199, 1678258920, NULL),
(207, '230316/CHK-0047', 1678939200, '1', 'dicek stock ke gudang untuk kebutuhan 200 pcs ', 1678940225, 1679112000, NULL),
(208, '230316/CHK-0048', 1678093020, '2', 'minta dibuatkan penawaran list tanya barang', 1678940244, 1678265820, NULL),
(209, '230316/CHK-0048', 1678171680, '3', 'minta dibuatkan PI untuk list barang', 1678940305, 1678344480, NULL),
(210, '230316/CHK-0048', 1678412580, '4', 'order untuk list barang', 1678940358, 1678585380, NULL),
(211, '230316/CHK-0049', 1677836460, '0', 'minta dibuat invoice untuk cereal dispenser dan tray anti slip ', 1678941345, 1678009260, NULL),
(212, '230316/CHK-0049', 1678007700, '1', 'sedang dibantu dicek stock dulu ke gudang ', 1678941462, 1680833700, NULL),
(213, '230316/CHK-0049', 1678186320, '1', 'menginformasikan bahwa stock nya ready dan mengirimkan invoice nya ', 1678941548, 1681012320, NULL),
(214, '230316/CWS-0012', 1678854840, '0', 'Masih dalam proses pembangunan untuk restorannya ', 1678941599, 1679027640, NULL),
(215, '230316/CHK-0049', 1678258200, '4', 'customer mengirimkan lampiran PO dan sudah transaksi \r\nno PO SO23039-16298', 1678941942, 1678431000, NULL),
(216, '230316/CHK-0050', 1678517520, '0', 'mau order untuk blender maddin type 206A', 1678942219, 1678690320, NULL),
(217, '230316/CHK-0050', 1678672500, '1', 'Customer mengirimkan lampiran PO, dan meminta dibuat performa invoice', 1678942334, 1678845300, NULL),
(218, '230316/CHK-0050', 1678698000, '1', 'Mengirimkan performa invoice kepada customer', 1678942433, 1678870800, NULL),
(219, '230316/CHK-0050', 1678762500, '1', 'customer sedang proses pengajuan untuk pembayaran', 1678942506, 1678935300, NULL),
(220, '230316/CHK-0051', 1678249620, '0', 'Minta penawaran decanter dan coffee urn ', 1678943052, 1678422420, NULL),
(221, '230316/CHK-0051', 1678256880, '2', 'mengirimkan penawaran yang sudah dibuat ke customer', 1678943152, 1678429680, NULL),
(222, '230316/CHK-0051', 1678867200, '3', 'memfollow up penawaran yang sudah dibuat , sedang diajukan dulu oleh customer nya ', 1678943233, 1679040000, NULL),
(223, '230316/CTP-0020', 1678947240, '1', 'menanyakan ukuran bilah pisaunya', 1678947336, 1679120040, NULL),
(224, '230316/CTP-0021', 1678946700, '0', 'menanyakan barang egg slicer', 1678947422, 1679119500, NULL),
(225, '230316/CHK-0052', 1678340700, '0', 'tanya barang coffee urn', 1678947620, 1678513500, NULL),
(226, '230316/CHK-0052', 1678345500, '2', 'minta dibuatkan penawaran untuk coffee urn', 1678947753, 1678518300, NULL),
(227, '230316/CHK-0052', 1678860300, '3', 'masih diajukan ke managementnya', 1678947800, 1679033100, NULL),
(228, '230316/CHK-0053', 1678774560, '0', 'tanya barang tent card A5', 1678947878, 1678947360, NULL),
(229, '230316/CHK-0053', 1678777200, '2', 'dibuatkan penawaran untuk tent card A5', 1678947929, 1678950000, NULL),
(230, '230316/CHK-0053', 1678947960, '3', 'masih pengajuan ke managementnya', 1678947997, 1679120760, NULL),
(231, '230316/CHK-0054', 1678510620, '0', 'tanya barang elektrik kettle brand jvd', 1678948122, 1678683420, NULL),
(232, '230316/CHK-0054', 1678673700, '1', 'cancel karna barang tidak ada', 1678948164, 1678846500, NULL),
(233, '230316/CTP-0019', 1678948260, '4', 'Jadi order po no SO230314-16510', 1678948346, 1679121060, NULL),
(234, '230316/CTP-0021', 1678948320, '1', 'menanyakan ukuran dan bahannya terbuat dari apa', 1678948379, 1679121120, NULL),
(235, '230316/CHK-0055', 1678274580, '0', 'tanya barang commercial cotton candy', 1678948462, 1678447380, NULL),
(236, '230316/CHK-0055', 1678512000, '1', 'follow up barang commercial cotton candy', 1678948516, 1678684800, NULL),
(237, '230316/CHK-0055', 1678948320, '1', 'masih follow up untuk barang commercial cotton candy', 1678948545, 1679121120, NULL),
(238, '230315/CWA-0016', 1678948500, '1', 'menanyakan gelas kaca ukuran panjang 18cm dan diameter 7.5cm', 1678948555, 1679121300, NULL),
(239, '230316/CTP-0021', 1678948620, '4', 'Jadi order po no SO230316-16573', 1678948703, 1679121420, NULL),
(240, '230316/CHK-0056', 1678428420, '0', 'tanya barang insert dari ceramic', 1678948707, 1678601220, NULL),
(241, '230316/CHK-0056', 1678948680, '1', 'cancel untuk insert dari ceramic karna baranya tidak ada', 1678948753, 1679121480, NULL),
(242, '230316/CHK-0055', 1678948740, '1', 'cancel untuk commercial cotton candy karna harga tidak masuk/kemahalan', 1678948806, 1679121540, NULL),
(243, '230316/CHK-0057', 1678780080, '0', 'tanya barang chopping board', 1678948932, 1678952880, NULL),
(244, '230315/CWA-0016', 1678948920, '1', 'menanyakan botol kaca 1 liter', 1678948986, 1679121720, NULL),
(245, '230316/CHK-0057', 1678786080, '4', 'sudah order mk-lion-ch-1. barang diambil pakai gojek', 1678949004, 1678958880, NULL),
(246, '230316/CWS-0013', 1678942800, '0', 'Kebutuhan sq2000 sebanyak 50 pcs,  kebutuhan ul-2500 sebanyak 50 pcs', 1678949053, 1679115600, NULL),
(247, '230316/CSP-0022', 1678949700, '0', 'menanyakan mk-cst20 conical strainer', 1678949895, 1679122500, NULL),
(248, '230316/CSP-0022', 1678950060, '1', 'menginfokan untuk ukuran 20cm sedang kosong, jadi di tawari yang ukuran 16cm ', 1678950163, 1679122860, NULL),
(249, '230316/CHK-0058', 1678949400, '0', 'tanya barang mug  kopin. mk-kpt02cm', 1678950545, 1679122200, NULL),
(250, '230316/CWB-0009', 1678939500, '0', 'MINTA PENAWARAN ', 1678950567, 1679112300, NULL),
(251, '230316/CWB-0009', 1678940640, '1', 'AKAN DIKIRIM PENAWARAN', 1678950630, 1679113440, NULL),
(252, '230316/CWS-0013', 1678950000, '4', 'Sudah order sq2000 sebanyak 50 pcs dan ul-2500 sebanyak 50 pcs transaksi di showroom', 1678951828, 1679122800, NULL),
(253, '230316/CWS-0014', 1678942800, '0', 'Kebutuhan stock pot, cast iron, dan ladle ', 1678952101, 1679115600, NULL),
(254, '230316/CHK-0059', 1678425600, '0', 'minta retur barang karna ukuran tidak sesuai keinginan user', 1678952257, 1678598400, NULL),
(255, '230316/CHK-0059', 1678433820, '2', 'minta dibuatkan penawaran untuk baking tray', 1678952298, 1678606620, NULL),
(256, '230316/CHK-0059', 1678518600, '3', ' maurestur barang yang tidak sesuai dan karna akan buka cafe baru sekalian belanja beberapa barang langsung ke toko', 1678952437, 1678691400, NULL),
(257, '230316/CHK-0059', 1678521720, '4', 'retur barang dan sekaligus belanja beberapa kebutuhan langsung ke toko', 1678952494, 1678694520, NULL),
(258, '230316/CWB-0010', 1678942140, '0', 'MINTA PENAWARAN ', 1678952798, 1679114940, NULL),
(259, '230316/CBL-0023', 1678953000, '0', 'menanyakan stock Heightening Guest Room Service Cart (With Doors)', 1678953449, 1679125800, NULL),
(260, '230316/CSP-0022', 1678953540, '1', 'menanyakan harga MK-CST16', 1678953630, 1679126340, NULL),
(261, '230316/CFP-0060', 1678949580, '0', 'menanyakan botol kecap acrilic uk 150 ml ', 1678954395, 1679122380, NULL),
(262, '230316/CFP-0060', 1678954140, '1', 'menginformasikan bahwa untuk ukuran 150 ml kosong barangnya, ada nya ukuran 100 , 200 ml ', 1678954476, 1679126940, NULL),
(263, '230316/CHK-0061', 1678163160, '0', 'tanya barang ul-p125', 1678954586, 1678335960, NULL),
(264, '230316/CHK-0061', 1678252560, '2', 'dibuatkan penawaran untuk ul-p125', 1678954644, 1678425360, NULL),
(265, '230316/CHK-0061', 1678411020, '3', 'masih pengajuan ke pihak management', 1678954699, 1678583820, NULL),
(266, '230316/CHK-0061', 1678954680, '3', 'masih pengajuan PO ke pihak managementnya', 1678954734, 1679127480, NULL),
(267, '230316/CHK-0062', 1678243920, '0', 'tanya barang pisau ukuran 25cm', 1678954835, 1678416720, NULL),
(268, '230316/CHK-0062', 1678849500, '1', 'follow up untuk pisau ukuran 25cm', 1678954899, 1679022300, NULL),
(269, '230316/CHK-0062', 1678954860, '1', 'follow up untuk pisau 25cm. masih pengajuan ke management', 1678954944, 1679127660, NULL),
(270, '230315/CWB-0005', 1678954920, '1', 'SUDAH KIRIM PENAWARAN SEBAGIAN. SEBAGIAN BARANG PENGADAAN AKAN DIKASI KE BU LINA', 1678954975, 1679127720, NULL),
(271, '230316/CHK-0063', 1678945440, '0', 'tanya barang chopper ukuran besar', 1678955343, 1679118240, NULL),
(272, '230316/CTP-0024', 1678955400, '0', 'menanyakan setrika philips GC1418', 1678955502, 1679128200, NULL),
(273, '230316/CHK-0058', 1678956240, '2', 'minta dibuatkan penawaran untuk mk-kpt02cm', 1678956318, 1679129040, NULL),
(274, '230316/CTP-0024', 1678956300, '1', 'menginfokan stock dan garansi barang', 1678956328, 1679129100, NULL),
(275, '230316/CFP-0064', 1678949160, '0', 'Ada menanyakan beberapa barang , plate ceramic , grill , dan showcase. minta dibuatkan penawaran harga untuk soup turine ', 1678956685, 1679121960, NULL),
(276, '230316/CFP-0064', 1678952280, '2', 'penawaran harga mk-sb-6000', 1678956756, 1679125080, NULL),
(277, '230316/CFP-0065', 1678955340, '0', 'menanyakan carving station type CS-901', 1678957101, 1679128140, NULL),
(278, '230316/CWS-0015', 1678852800, '0', 'Belum ada kebutuhan ', 1678957389, 1679025600, NULL),
(279, '230316/CWS-0015', 1678946400, '1', 'Belum ada kebutuhan untuk bulan ini ', 1678957452, 1679119200, NULL),
(280, '230316/CWS-0016', 1678858200, '0', 'Follow up untuk kunjungan ', 1678957607, 1679031000, NULL),
(281, '230316/CFP-0065', 1678957080, '1', 'Customer meminta dibuat performa invoice, tetapi barangnya tidak ready. sedang diajukan dulu ke purchasing untuk dicarikan dari brand lain', 1678957615, 1679129880, NULL),
(282, '230316/CHK-0066', 1678673880, '0', 'menanyakan steamer ukuran 30 cm ', 1678957850, 1678846680, NULL),
(283, '230316/CHK-0066', 1678680900, '1', 'sudah ditawarkan steamer dari golden ukuran 30 cm , sedang diajukan dulu oleh customer nya ', 1678958042, 1678853700, NULL),
(284, '230316/CHK-0067', 1678162620, '0', 'tanya harga untuk list barang plastik', 1678958121, 1678335420, NULL),
(285, '230316/CHK-0067', 1678958100, '1', 'minta list harga plastik ziplock dll', 1678958160, 1679130900, NULL),
(286, '230316/CHK-0066', 1678950660, '1', 'menanyakan mesin popcorn ', 1678958287, 1679123460, NULL),
(287, '230315/CTR-0001', 1678904400, '2', 'Sudah kirim sampel', 1678958660, 1679077200, NULL),
(288, '230316/CTR-0003', 1678953600, '0', 'PO UL-FP350 sebanyak 750 pcs', 1678958696, 1679126400, NULL),
(289, '230316/CHK-0068', 1678074060, '0', 'tanya barang chocolate fountain', 1678958696, 1678246860, NULL),
(290, '230315/CWA-0016', 1678958640, '4', 'Jadi order di tokopedia po no SO230316-16585', 1678958738, 1679131440, NULL),
(291, '230316/CHK-0068', 1678253460, '2', 'minta dibuatkan penawaran chocolate fountain', 1678958751, 1678426260, NULL),
(292, '230316/CHK-0068', 1678422000, '3', 'masih pengajuan untuk chocolate fountain ke management', 1678958803, 1678594800, NULL),
(293, '230316/CHK-0068', 1678936800, '3', 'masih diajukan ke managementnya dulu', 1678958846, 1679109600, NULL),
(294, '230316/CTR-0004', 1678949400, '0', 'Penawaran botol kale ukuran 250 ml ', 1678958876, 1679122200, NULL),
(295, '230316/TKP-0005', 1678932300, '0', 'Tanya Harga Round 1000ml & 470ml black', 1678958950, 1679105100, NULL),
(296, '230316/TKP-0006', 1678951260, '0', 'Penawaran botol kale ukuran 100 ml ', 1678959045, 1679124060, NULL),
(297, '230316/TKP-0007', 1678937400, '0', 'Tanya Harga Round 1000ml & 470ml black ', 1678959058, 1679110200, NULL),
(298, '230316/FOP-0008', 1678941000, '0', 'Penawaran EMD 360x70cm & 360x100cm warna hitam motif diamond', 1678959152, 1679113800, NULL),
(299, '230316/CHK-0069', 1678958400, '0', 'belum ada kebutuhan', 1678959201, 1679131200, NULL),
(300, '230316/CHK-0069', 1678959180, '1', 'belum ada kebutuhan', 1678959217, 1679131980, NULL),
(301, '230316/CHK-0070', 1678949040, '0', '', 1678959319, 1679121840, NULL),
(302, '230316/CHK-0070', 1678959300, '1', 'purchasing sudah resign', 1678959349, 1679132100, NULL),
(303, '230316/CHK-0071', 1678938960, '0', '', 1678959410, 1679111760, NULL),
(304, '230316/CHK-0071', 1678959420, '1', 'belum ada kebutuhan lagi', 1678959434, 1679132220, NULL),
(305, '230316/CHK-0072', 1678946100, '0', 'menanyakan kenapa sudah tidak bisa tempo, dan tanya harga chp82 ', 1678961219, 1679118900, NULL),
(306, '230316/CHK-0058', 1679016660, '3', 'follow up untuk mug yg sudah dibuatkan penawarannya', 1679016695, 1679189460, NULL),
(307, '230316/CHK-0062', 1679016780, '1', 'follow up mengenai pisau 25cm. masih di ajukan ke pihak management dan akunting', 1679016816, 1679189580, NULL),
(308, '230317/CWA-0025', 1679015400, '0', 'konfirmasi pengiriman barang', 1679017183, 1679188200, NULL),
(309, '230317/CSP-0026', 1679015700, '0', 'menanyakan gelas kaca libbey', 1679017285, 1679188500, NULL),
(310, '230317/CTP-0027', 1679016540, '0', 'menanyakan food cover polycarbonate ', 1679017391, 1679189340, NULL),
(311, '230317/CTP-0027', 1679017680, '1', 'menanyakan alamat offline store', 1679017743, 1679190480, NULL),
(312, '230315/CWB-0003', 1679018340, '1', 'FRYING PAN TIDAK SESUAI DENGAN YANG DIINGINKAN, TIDAK JADI MEMBELI', 1679018439, 1679191140, NULL),
(313, '230317/CHK-0073', 1678096680, '0', 'customer turun lembar PO', 1679019590, 1678269480, NULL),
(314, '230317/CWS-0017', 1679018400, '0', 'Kebutuhan kuali uk 80 cm bahan blacksteel ', 1679019908, 1679191200, NULL),
(315, '230317/CHK-0073', 1678239000, '4', 'PO di proses dan payment Cash On Delivery ', 1679019986, 1678411800, NULL),
(316, '230317/CHK-0074', 1678872300, '0', 'customer turun PO', 1679020092, 1679045100, NULL),
(317, '230317/CHK-0074', 1678928400, '4', 'PO di proses dan barang dikirim', 1679020133, 1679101200, NULL),
(318, '230317/CWS-0018', 1678935120, '0', 'customer sedang mencari piring saji, sendok, dan gelas untuk kebutuhan restaurant baru ', 1679020182, 1679107920, NULL),
(319, '230317/CWS-0018', 1679019360, '1', 'menginformasikan dan memfotokan jenis barang yang customer cari ', 1679020279, 1679192160, NULL),
(320, '230317/CHK-0075', 1677726000, '0', 'sedang ada kebutuhan untuk HS-029 sebanyak 60 pcs', 1679020487, 1677898800, NULL),
(321, '230317/CHK-0075', 1678256100, '1', 'customer minta dibuatkan proforma invoice untuk proses payment ', 1679020571, 1678428900, NULL),
(322, '230317/CHK-0075', 1678677720, '4', 'customer turun PO, barang dikirim dan customer payment Cash On Delivery di hari selasa, 14 Maret 2023', 1679020729, 1678850520, NULL),
(323, '230317/CHK-0076', 1678939260, '0', '', 1679021617, 1679112060, NULL),
(324, '230317/CHK-0077', 1678941000, '0', '', 1679021714, 1679113800, NULL),
(325, '230314/CWA-0007', 1679021700, '3', 'menanyakan barang indent ', 1679021755, 1679194500, NULL),
(326, '230317/CWA-0025', 1679021760, '1', 'meminta no resi pengiriman barang', 1679021798, 1679194560, NULL),
(327, '230316/CTP-0020', 1679022060, '1', 'menginfokan customer akan order hari ini dan ingin di kirim hari ini juga barangnya', 1679022136, 1679194860, NULL),
(328, '230317/CTP-0028', 1679022300, '0', 'menanyakan kapasitas kastrol no 7 ', 1679022768, 1679195100, NULL),
(329, '230317/CWA-0029', 1679022900, '0', 'menanyakan teko kinox dan coffee stove double warmer', 1679023635, 1679195700, NULL),
(330, '230317/CHK-0078', 1679022780, '0', 'tanya barang coffee decanter dan coffee stove', 1679023688, 1679195580, NULL),
(331, '230317/CWS-0019', 1678860480, '0', 'Membutuhkan beberapa barang ,termasuk yg tidak ada di toko\r\nTurner ,ladle ,cook knife ,opener ,pizza cutter ,bar mat ,fabric glove ,cheker ,rak sepatu .', 1679023867, 1679033280, NULL),
(332, '230317/CWS-0019', 1678937460, '1', 'Konfirmasi harga dan stock barang', 1679023926, 1679110260, NULL),
(333, '230317/CTP-0030', 1679023500, '0', 'menanyakan stock nampan warna hitam ', 1679023934, 1679196300, NULL),
(334, '230317/CWS-0019', 1678943280, '4', 'Sudah order melalui showroom ,kebutuhan sudah terpenuhi dan pak Andi sangat puas ', 1679024000, 1679116080, NULL),
(335, '230317/CTP-0030', 1679024100, '1', 'menanyakan pengiriman bisa dikirim pakai instant', 1679024142, 1679196900, NULL),
(336, '230317/CWS-0020', 1679024100, '0', 'Kebutuhan coklat fountain ', 1679024158, 1679196900, NULL),
(337, '230317/CHK-0079', 1678951740, '0', 'menanyakan gelas ukuran T: 9,5 cm , D: 5 cm ', 1679024442, 1679124540, NULL),
(338, '230317/CWS-0021', 1679024580, '0', 'Mencari barang untuk kebutuhan Restoran titik point Jakarta ', 1679024656, 1679197380, NULL),
(339, '230317/CHK-0079', 1678954800, '1', 'menawarkan ke customer untuk gelas dari KIM-T606 ', 1679024659, 1679127600, NULL),
(340, '230316/CTP-0020', 1679024580, '4', 'Jadi order no po SO230317-16614', 1679024667, 1679197380, NULL),
(341, '230317/CHK-0079', 1679018220, '2', 'Customer meminta dibuatkan untuk penawaran dulu kode MK-KIM-T606 untuk kebutuhan 1000 pcs', 1679024740, 1679191020, NULL),
(342, '230317/CTP-0030', 1679024820, '4', 'Jadi order no po SO230317-16615', 1679024898, 1679197620, NULL),
(343, '230317/CHK-0078', 1679024400, '1', 'follow up coffee decanter dan coffee stove', 1679025535, 1679197200, NULL),
(344, '230317/CWS-0022', 1679025600, '0', '', 1679025698, 1679198400, NULL),
(345, '230317/CWS-0020', 1679025780, '2', 'Mengajukan penawaran ', 1679025751, 1679198580, NULL),
(346, '230316/CHK-0066', 1679015880, '4', 'sudah turun PO untuk mesin pop corn dan sudah transaksi juga. No PO : SO230317-16607 ', 1679026141, 1679188680, NULL),
(347, '230317/CWS-0023', 1678932360, '0', 'Membutuhkan barang gn pans,insert ', 1679026796, 1679105160, NULL),
(348, '230317/CWS-0024', 1678852800, '0', 'Belum ada kebutuhan ', 1679026833, 1679025600, NULL),
(349, '230317/CWS-0023', 1678955160, '2', 'Kirim penawaran harga ', 1679026852, 1679127960, NULL),
(350, '230317/CWS-0025', 1678860000, '0', 'Belum ada respon ', 1679027093, 1679032800, NULL),
(351, '230317/CWS-0026', 1678856400, '0', 'Baru masuk katalog', 1679027256, 1679029200, NULL),
(352, '230317/CWS-0027', 1678863600, '0', 'Belum ada respon', 1679027435, 1679036400, NULL),
(353, '230317/CWS-0028', 1679027760, '0', 'Kebutuhan grill', 1679027832, 1679200560, NULL),
(354, '230317/CWS-0027', 1679028360, '0', 'Baru masuk katalog ', 1679028420, 1679201160, NULL),
(355, '230317/CWS-0029', 1678863600, '0', 'Masuk katalog', 1679028516, 1679036400, NULL),
(356, '230317/CWS-0030', 1678942800, '0', 'Kebutuhan sugar pack ', 1679028779, 1679115600, NULL),
(357, '230317/CWS-0031', 1679029320, '0', 'Baru mengontak', 1679029407, 1679202120, NULL),
(358, '230317/CWS-0032', 1679030880, '0', 'Kebutuhan gelas libbey', 1679030925, 1679203680, NULL),
(359, '230317/CHK-0078', 1679032920, '2', 'minta dibuatkan penawaran untuk coffee stove dan coffee decanter', 1679032970, 1679205720, NULL),
(360, '230316/CHK-0063', 1679031900, '1', 'follow up barang food proseccor ukuran besar', 1679033047, 1679204700, NULL),
(361, '230317/CHK-0077', 1679033160, '1', 'follow up kebutuhan. masih belum ada kebutuhan, barangnya masih lengkap', 1679033280, 1679205960, NULL),
(362, '230316/CHK-0046', 1679033460, '3', 'masih diajukan ke pihak management dan n usernya', 1679033496, 1679206260, NULL),
(363, '230317/CWS-0032', 1679034300, '2', 'Gelas libbey kode 15244 sebanyak 15 lusin diambil kamis tanggal 21-03-23', 1679034434, 1679207100, NULL),
(364, '230315/HOR-0002', 1679034660, '4', 'sudah order ', 1679034725, 1679207460, NULL),
(365, '230317/CWS-0033', 1679034900, '0', 'follow up costumer dan buat penawaran', 1679035003, 1679207700, NULL),
(366, '230317/CWS-0033', 1679034960, '2', 'membuat penawaran', 1679035032, 1679207760, NULL),
(367, '230317/CWS-0033', 1679035020, '3', 'follow up penawaran customer', 1679035064, 1679207820, NULL),
(368, '230317/CWB-0011', 1678755600, '0', 'CUSTOMER TANYA BARANG', 1679035219, 1678928400, NULL),
(369, '230317/CWB-0011', 1678758840, '1', 'MINTA PENAWARAN', 1679035282, 1678931640, NULL),
(370, '230317/CWB-0011', 1679034660, '2', 'KIRIM PENAWARAN BARU SEBAGIAN BARANG, MASIH ADA YG BELUM ADA, MINTA KE BU LINA', 1679035357, 1679207460, NULL),
(371, '230317/CHK-0079', 1679035080, '3', 'penawaran sudah diberikan ke customer, dan customer meminta dikirim sampel nya dulu ke hotel untuk diajukan ', 1679035424, 1679207880, NULL),
(372, '230317/CWS-0034', 1679035500, '0', 'follow up customer dan membuat penawaran', 1679035744, 1679208300, NULL),
(373, '230317/CHK-0080', 1678074360, '0', 'meminta penawaran harga untuk glass libbey kode 15240 untuk kebutuhan 400 pcs', 1679035811, 1678247160, NULL),
(374, '230317/CWS-0034', 1679035740, '2', 'penawaran barang ', 1679035834, 1679208540, NULL),
(375, '230317/CHK-0080', 1678076640, '2', 'sudah dibuatkan penawaran harga mk-15240 (400 pcs), sedang diajukan oleh customer ', 1679035929, 1678249440, NULL),
(376, '230317/CTP-0031', 1679032500, '0', 'Menanyakan card holder kayu mahoni', 1679035969, 1679205300, NULL),
(377, '230316/CWB-0006', 1679034780, '1', 'SEDANG DIAJUKAN DULU KE ATASANNYA', 1679036015, 1679207580, NULL),
(378, '230317/CTP-0032', 1679029020, '0', 'Menanyakan mangkok kaca luminarc', 1679036022, 1679201820, NULL),
(379, '230317/CHK-0080', 1678848960, '3', 'untuk penawaran yang sebelumnya sedang diajukan dulu, daan meminta penawaran baru untuk rack glass', 1679036078, 1679021760, NULL),
(380, '230317/CHK-0081', 1678670100, '0', 'customer menghubungi dan bertanya untuk scoop ice cream ', 1679036201, 1678842900, NULL),
(381, '230317/CTP-0031', 1679036220, '1', 'menanyakan pengiriman bisa pakai gojek', 1679036250, 1679209020, NULL),
(382, '230317/CHK-0081', 1678671000, '1', 'diberi foto gambar dan diinfokan untuk harganya', 1679036257, 1678843800, NULL),
(383, '230317/CTP-0032', 1679036220, '1', 'konfrimasi pengiriman pakai instant', 1679036288, 1679209020, NULL),
(384, '230317/CHK-0082', 1679028180, '0', 'menanyakan periode lebaran kapan bisa order terakhir untuk beras', 1679036329, 1679200980, NULL),
(385, '230317/CHK-0081', 1678672800, '2', 'dibuatkan lembar penawaran resmi', 1679036329, 1678845600, NULL),
(386, '230317/CHK-0081', 1679022300, '3', 'payment sedang di proses, customer akan menghubungi dan memberikan bukti transfer ketika sudah melakukan payment ', 1679036398, 1679195100, NULL),
(387, '230317/CHK-0083', 1678248000, '0', 'bertanya loyang bakery untuk ukuran 252mm X129mmX120mm kebutuhan 6 pcs', 1679036564, 1678420800, NULL),
(388, '230317/CHK-0083', 1678251300, '1', 'diberikan foto product dan diinfokan untuk harga barangnya', 1679036677, 1678424100, NULL),
(389, '230317/CHK-0084', 1678782660, '0', 'menanyakan mesin gilingan daging merk tasin', 1679036702, 1678955460, NULL),
(390, '230317/CHK-0083', 1678262400, '2', 'dibuatkan lembar penawaran resmi untuk diajukan ke user', 1679036775, 1678435200, NULL),
(391, '230317/CHK-0084', 1678784400, '1', 'menginformasikan untuk barangnya tidak jual ', 1679036788, 1678957200, NULL),
(392, '230317/CHK-0085', 1677914760, '0', 'tanya barang box ukuran 50x38cm', 1679036974, 1678087560, NULL),
(393, '230317/CHK-0085', 1677907500, '1', 'follow up untuk barang yang ditanyakan', 1679037191, 1678080300, NULL),
(394, '230317/CTP-0032', 1679037240, '4', 'Jadi order po no SO230317-16628', 1679037267, 1679210040, NULL),
(395, '230317/CHK-0085', 1677914880, '1', 'cancel barang yg ditanyakan dikarenakan barang tidak ada dan tidak mau pengadaan', 1679037287, 1678087680, NULL),
(396, '230317/CWA-0029', 1679037360, '1', 'meminta foto real produknya dan menanyakan stocknya ', 1679037451, 1679210160, NULL),
(397, '230317/CWA-0029', 1679037660, '1', 'produk kosong ditawarkan dengan type yang lain ', 1679037722, 1679210460, NULL),
(398, '230317/CHK-0086', 1678852860, '0', 'follow up kebutuhan', 1679037752, 1679025660, NULL),
(399, '230317/CHK-0086', 1678948920, '1', 'masih belum ada kebutuhan lagi. semua masih lengkap', 1679037810, 1679121720, NULL),
(400, '230317/CTP-0033', 1679035800, '0', 'Menanyakan cutting board warna putih MK-CB-520W', 1679037982, 1679208600, NULL),
(401, '230317/CHK-0087', 1678595460, '0', 'follow up kebutuhan', 1679038069, 1678768260, NULL),
(402, '230317/CHK-0087', 1678931040, '1', 'sekarang masih lengkap dan belum ada kebutuhan', 1679038189, 1679103840, NULL),
(403, '230317/CHK-0088', 1677807420, '0', 'tanya barang gelas bir ukuran 375ml', 1679039099, 1677980220, NULL),
(404, '230317/CHK-0088', 1677809220, '1', 'follow up untuk barang yg ditanyakan', 1679039150, 1677982020, NULL),
(405, '230317/CHK-0088', 1677809640, '2', 'penawaran harga langsung ke customer untuk gelas bir 375ml', 1679039304, 1677982440, NULL),
(406, '230317/CHK-0088', 1680511680, '3', 'cancel untuk barang yang ditanyakan karena barang tidak ada dan customer tidak mau pengadaan (kebutuhan barang urgent)', 1679039396, 1680684480, NULL),
(407, '230317/CHK-0089', 1679039400, '0', 'follow up kebutuhan. sebelumnya pernah tanya barang', 1679039570, 1679212200, NULL),
(408, '230317/CHK-0090', 1679039520, '0', 'follow up ubtuk kebutuhan', 1679039632, 1679212320, NULL),
(409, '230317/CTP-0034', 1679039400, '0', 'menanyakan grill pan subron', 1679039922, 1679212200, NULL),
(410, '230317/CTP-0033', 1679040000, '4', 'Jadi order po no SO230317-16627', 1679040037, 1679212800, NULL),
(411, '230317/CHK-0083', 1678946100, '3', 'sudah turun PO dan payment sedang di proses, payment aga terhambat karena sedang fokus persiapan perayaan nyepi', 1679040300, 1679118900, NULL),
(412, '230317/CHK-0091', 1678940640, '0', 'Customer mengirim lampiran PO CHO-30 non woven ', 1679040362, 1679113440, NULL),
(413, '230317/CHK-0091', 1678947360, '1', 'menginformasikan ke customer untuk barang cho-30 tidak ada stocknya, dan ditawarkan untuk chc-30 non woven ', 1679040484, 1679120160, NULL),
(414, '230316/CWB-0007', 1679040120, '1', 'SUDAH DI WA TIDAK DIRESPON SAMA SEKALI', 1679040670, 1679212920, NULL),
(415, '230317/CHK-0091', 1679039280, '2', 'Customer meminta untuk dibuat performa invoice CHC-30 non woven sebnyak 50 pcs', 1679040714, 1679212080, NULL),
(416, '230317/CWS-0035', 1678860000, '0', 'Tidak merespon', 1679040851, 1679032800, NULL),
(417, '230317/CWS-0036', 1678862400, '0', 'Kebutuhan mangkok ', 1679040919, 1679035200, NULL),
(418, '230317/CHK-0092', 1678756440, '0', 'customer bertanya untuk container box dari brand rabbit', 1679040934, 1678929240, NULL),
(419, '230317/CHK-0092', 1678757400, '1', 'diberikan foto product dan menginformasikan harganya', 1679040984, 1678930200, NULL),
(420, '230317/CFP-0093', 1679040780, '0', 'menanyakan saringan ', 1679041000, 1679213580, NULL),
(421, '230317/CHK-0092', 1679023800, '2', 'minta dibuatkan penawaran untuk container box rabbit kebutuhan sebanyak 30 pcs, 8 merah, 8 biru, 14 hijau', 1679041087, 1679196600, NULL),
(422, '230317/CFP-0093', 1679040900, '1', 'menanyakan ke customer , kebutuhan untuk ukuran diameter berapa dan kebutuhan brp pcs. sudah ditawarkan dari brand cypruz', 1679041137, 1679213700, NULL),
(423, '230317/CHK-0094', 1679019840, '0', 'mengirimkan beberapa list barang dan bertanya untuk harganya', 1679041212, 1679192640, NULL),
(424, '230317/CWS-0037', 1679040000, '0', 'Belum ada respon', 1679041241, 1679212800, NULL),
(425, '230317/CHK-0094', 1679021760, '1', 'menginfokan harga dan ukuran barangnya', 1679041270, 1679194560, NULL),
(426, '230317/CWS-0038', 1678869000, '0', 'Baru dapat no purchasing', 1679041337, 1679041800, NULL),
(427, '230317/CHK-0094', 1679033100, '2', 'minta dibuatkan penawaran resmi dan mengkonfirmasikan untuk detail payment', 1679041343, 1679205900, NULL),
(428, '230317/CHK-0095', 1678998180, '0', 'Follow up penawaran untuk kebutuhan perlengkapan kitchennya', 1679041478, 1679170980, NULL),
(429, '230317/CHK-0095', 1679041500, '1', 'Sedang ada kebutuhan perlengkapannya nanti kita list dulu untuk kebutuhannya', 1679041605, 1679214300, NULL),
(430, '230317/CWS-0039', 1678863600, '0', 'Belum adaa kebutuhan ', 1679041709, 1679036400, NULL),
(431, '230317/CHK-0096', 1677564300, '0', 'tanya barang untuk food cover stainless', 1679041724, 1677737100, NULL),
(432, '230317/CWS-0040', 1678863600, '0', 'Belum ada kebutuhan ', 1679041799, 1679036400, NULL),
(433, '230317/CHK-0097', 1679041680, '0', 'Minta dibuatkan penawaran untuk pr yang diberikan ', 1679041824, 1679214480, NULL);
INSERT INTO `tb_followup_detail` (`id`, `followup_id`, `followup_date`, `comment`, `notes`, `input_date`, `due_date`, `value`) VALUES
(434, '230317/CHK-0097', 1679041860, '2', 'Sudah dibuatkan penawaran pr untuk kebutuhan kitchen nya', 1679041927, 1679214660, NULL),
(435, '230317/CHK-0098', 1678078800, '0', 'mau order untuk decanter MK-8896', 1679042016, 1678251600, NULL),
(436, '230317/CHK-0099', 1679039580, '0', 'follow up kebutuhan. tanya barang pre-rinse', 1679042020, 1679212380, NULL),
(437, '230317/CHK-0099', 1679042040, '1', 'follow up untuk barang yg ditanyakan', 1679042089, 1679214840, NULL),
(438, '230317/CWS-0041', 1678858200, '0', 'Belum ada respon', 1679042167, 1679031000, NULL),
(439, '230317/CHK-0078', 1679041560, '2', 'minta dibuatkan penawaran untuk coffee dispense/coffee urn subron', 1679042167, 1679214360, NULL),
(440, '230317/CHK-0098', 1678082340, '1', 'dicek dulu untuk stock nya ke gudang ', 1679042272, 1678255140, NULL),
(441, '230317/CHK-0100', 1679042220, '0', 'Follow up untuk perlengkapan kitchennya', 1679042311, 1679215020, NULL),
(442, '230317/CHK-0100', 1679042340, '1', 'Sedang ada kebutuhan ice crush machine dengan dibantu pengadaan barangnya ', 1679042451, 1679215140, NULL),
(443, '230317/CHK-0098', 1678160880, '2', 'Customer minta dibuatkan untuk performa invoice ', 1679043081, 1678333680, NULL),
(444, '230317/CWS-0042', 1678940040, '0', 'Meminta penawaran karpet afd', 1679043219, 1679112840, NULL),
(445, '230317/CWS-0042', 1678956780, '2', 'Kirim penawaran afd', 1679043280, 1679129580, NULL),
(446, '230317/CWS-0042', 1679043240, '3', 'Menunggu approve dari purchasing manager .', 1679043324, 1679216040, NULL),
(447, '230316/CFP-0060', 1679043000, '3', 'Cancel, karena barang yang dicari nya tidak ada ukuran yang sesuai ', 1679043329, 1679215800, NULL),
(448, '230317/CWB-0012', 1679041860, '0', 'TANYA CHAFFING DISH ', 1679043377, 1679214660, NULL),
(449, '230317/CWS-0043', 1678856400, '0', 'Masih belum ada kebutuhan ', 1679043433, 1679029200, NULL),
(450, '230317/CWB-0012', 1679041860, '1', 'DITAWARKAN CHAFFING DISH SUBRON MK-SUBRON-RT-10KG DAN MK-SUBRON-RT-02', 1679043481, 1679214660, NULL),
(451, '230317/CWS-0044', 1678946400, '0', 'Kebutuhan Bnb plate uk 16 cm ', 1679043597, 1679119200, NULL),
(452, '230317/CWS-0045', 1679043600, '0', 'follow up costumer ', 1679043702, 1679216400, NULL),
(453, '230317/CHK-0090', 1679043660, '1', 'follow up untuk kebutuhan. belum ada kebutuhan dan belum ada permintaan dari n usernya', 1679043748, 1679216460, NULL),
(454, '230317/CWS-0045', 1679043720, '1', 'follow up costumer', 1679043749, 1679216520, NULL),
(455, '230316/CWS-0009', 1679043720, '2', 'membuat penawaran', 1679043806, 1679216520, NULL),
(456, '230316/CWS-0009', 1679043780, '3', 'follow up penawaran customer', 1679043836, 1679216580, NULL),
(457, '230317/CWS-0046', 1679043900, '0', 'follow up costumer', 1679044004, 1679216700, NULL),
(458, '230317/CWS-0046', 1679043960, '1', 'masuk catalog', 1679044024, 1679216760, NULL),
(459, '230317/CHK-0099', 1679043960, '2', 'dikirm penawaran untuk barang mk-5pr-8w08-h', 1679044060, 1679216760, NULL),
(460, '230317/CWS-0047', 1679044200, '0', 'follow up dan penawaran', 1679044305, 1679217000, NULL),
(461, '230317/CWS-0047', 1679044260, '1', 'follow up costumer', 1679044331, 1679217060, NULL),
(462, '230317/CWS-0047', 1679044320, '2', 'membuat penawaran', 1679044350, 1679217120, NULL),
(463, '230317/CHK-0098', 1678438920, '4', 'customer sudah proses untuk payment dan PO diproses, no PO : SO230313-16403', 1679044380, 1678611720, NULL),
(464, '230317/CWS-0047', 1679044320, '3', 'follow up penawaran sedang diajukan payment', 1679044416, 1679217120, NULL),
(465, '230317/CWS-0047', 1679044440, '3', 'sedang pengajuan payment', 1679044478, 1679217240, NULL),
(466, '230317/CFP-0101', 1679026500, '0', 'follow up untuk kebutuhan', 1679045237, 1679199300, NULL),
(467, '230317/CFP-0101', 1679028420, '1', 'sudah tutup permanen dan sudah tidak butuh alat kitchen', 1679045291, 1679201220, NULL),
(468, '230317/CTP-0035', 1679046540, '0', 'menanyakan service bell mau order 2 pcs', 1679047307, 1679219340, NULL),
(469, '230316/CHK-0061', 1679102100, '3', 'minta dibuatkan pro forma invoice', 1679102173, 1679274900, NULL),
(470, '230318/CHK-0102', 1679100300, '0', 'tanya barang cup bowl 200ml', 1679102391, 1679273100, NULL),
(471, '230318/CHK-0102', 1679102400, '1', 'follow up untuk barang yg ditanyakan', 1679102423, 1679275200, NULL),
(472, '230318/CTP-0036', 1679101980, '0', 'Menanyakan panggangan putar  magic roaster pro 34cm', 1679104019, 1679274780, NULL),
(473, '230318/CTP-0037', 1679102880, '0', 'Menanyakan teko siul subron', 1679104135, 1679275680, NULL),
(474, '230318/CTP-0038', 1679102100, '0', 'Menanyakan wajan enamel ukuran 48cm ', 1679104202, 1679274900, NULL),
(475, '230318/CHK-0103', 1679100300, '0', 'tanya barang chiller, salamander. deep fryer, flat griddle, grill stove, show case', 1679104240, 1679273100, NULL),
(476, '230318/CWA-0039', 1679101800, '0', 'Menanyakan harga piring tempura melamin', 1679104296, 1679274600, NULL),
(477, '230317/CWB-0012', 1679104200, '1', 'MENCARI CHAFING DISH, SEDANG DIPERTIMBANGKAN DULU', 1679104344, 1679277000, NULL),
(478, '230317/CWA-0025', 1679104320, '1', 'komplain ada kekurangan barang UL-250 sebanyak 300pcs', 1679104416, 1679277120, NULL),
(479, '230316/CWB-0008', 1679104320, '1', 'TANYA HARGA GROSIR, TIDAK JADI BELI KARENA HARGA DI MR KITCHEN BUKAN HARGA GROSIR', 1679104496, 1679277120, NULL),
(480, '230318/CTP-0037', 1679106600, '1', 'menanyakan teko untuk masak air tapi yang tidak ada bunyinya ', 1679106681, 1679279400, NULL),
(481, '230318/CHK-0103', 1679107620, '1', 'follow up untuk barang yg ditanyakan', 1679107689, 1679280420, NULL),
(482, '230318/CFP-0104', 1679108100, '0', 'Menawarkan product perlengkapan kitchen dan menjelaskan promo yang berlaku di mr kitchen', 1679108065, 1679280900, NULL),
(483, '230318/CFP-0105', 1679108220, '0', 'Menawarkan perlengkapan kitchen dan promo yang sedang berlaku di mr kitchen bandung', 1679108219, 1679281020, NULL),
(484, '230318/CTP-0040', 1679108100, '0', 'menanyakan juicer kirin', 1679108494, 1679280900, NULL),
(485, '230316/CTP-0018', 1679108520, '4', 'jadi order po no SO230318-16659', 1679108594, 1679281320, NULL),
(486, '230315/CWA-0015', 1679108640, '1', 'belum ada kebutuhan kembali ', 1679108678, 1679281440, NULL),
(487, '230315/CHK-0035', 1679108760, '3', 'Follow up penawaran sebelumnya mengenai cutleries dari brand serena,dan masih dalam proses pengajuan management nya untuk price productnya', 1679108907, 1679281560, NULL),
(488, '230318/CFP-0106', 1679109480, '0', 'Menawarkan kebutuhan untuk perlengkapan kitchen serta menawarkan promo yang sedang berlaku di mr kitchen', 1679109575, 1679282280, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(150) NOT NULL,
  `user_nama` varchar(128) NOT NULL,
  `create_date` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `loc` varchar(10) NOT NULL,
  `photo` varchar(128) NOT NULL DEFAULT 'default.svg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `email`, `password`, `user_nama`, `create_date`, `role_id`, `is_active`, `loc`, `photo`) VALUES
('MK-001', 'alif@mwk.com', '$2y$10$aY2a3lHpFBaFN3f63Z3CDuxNoOoz1VM0LpDFbJRVxMCZb1NPHvwgi', 'Alif', 1678341855, 1, '1', '', 'default.svg'),
('MK-002', 'ridhwan@mwk.com', '$2y$10$aY2a3lHpFBaFN3f63Z3CDuxNoOoz1VM0LpDFbJRVxMCZb1NPHvwgi', 'Ridhwan Harris', 1678341917, 5, '1', '', 'default.svg'),
('MK-003', 'mela@website.com', '$2y$10$aY2a3lHpFBaFN3f63Z3CDuxNoOoz1VM0LpDFbJRVxMCZb1NPHvwgi', 'Mellawati', 1678447932, 6, '1', '', 'default.svg'),
('MK-004', 'paulus@mwk.com', '$2y$10$Jb2TOF69LBc3HuYUmrMco.MSQZwxmZaXTVikW2JvOb0AhtdEgpfi2', 'Paulus Christofel S', 1663832770, 1, '1', 'Riau118', 'default.svg'),
('MK-005', 'Telemkt02@gmail.com', '$2y$10$ksilDlRShEX48K3HGFUzXeEdWRVWfxYtwg.n6m0OhoH2xgnQt9nEy', 'Eko', 1678846867, 4, '1', '', 'default.svg'),
('MK-006', 'Anggayanyan12@gmail.com', '$2y$10$KzoLmz/6ZLUItunkE9KsV.5E14/ILP4/0YbIhV.C4gb8oYktXfcGG', 'Angga yanyan', 1678849532, 3, '1', '', 'default.svg'),
('MK-007', 'pitriananda911@gmail.com', '$2y$10$uTh2ied4Q.xJHxIe9f6xJehW6RhXeqVVJD6BXA58dz3ZlY.O.CGkC', 'Pitri', 1678849745, 8, '1', '', 'default.svg'),
('MK-008', 'melapuspita229@gmail.com', '$2y$10$gHPmgGt6xG5TJQpWrNXATOPozdEiWsw.qDaFRGU4oyXkgqF/MLXyS', 'Mela Puspitasari', 1678861024, 4, '1', '', 'default.svg'),
('MK-009', 'tiranny@mwk.com', '$2y$10$4/8dvzKAVzNOxv1YOqKWMObEutnFueVDZC9AY6wQD42Ar17XwOsFC', 'tiranny', 1678938230, 3, '1', '', 'default.svg'),
('MK-010', 'Virafitrizulaikha@gmail.com', '$2y$10$mEgqhk6OvCCs3jaj4FYsMOE9apSK8bW8ZJRd04vRiK33dA.awcFyG', 'Vira Fitri Zulaikha', 1678938438, 8, '1', '', 'default.svg'),
('MK-011', 'witrirohimah1018@gmail.com', '$2y$10$U8WceN1.Yz3yD5aCEqZjc.u9W/PiODoHnmgsDCKfd4X1lqt/wo7Ei', 'Witri Rohimah', 1678938475, 3, '1', '', 'default.svg'),
('MK-012', 'ninay9085@gmail.com', '$2y$10$GFnhZsjfftj8gJaCXmDloeT7d1rw6m5bzYIs8pzdgFZcybng/YaES', 'Nina yuliana', 1678938479, 8, '1', '', 'default.svg'),
('MK-013', 'Showroom7577@gmail.com', '$2y$10$kGL3vNgtKmQkkVyxyScsoO4F06oiq4RD1OrdNEKCZp9Vu2VbVz81m', 'Fredinal juniawan', 1678938551, 8, '1', '', 'default.svg'),
('MK-014', 'Triapuspita24@gmail.com', '$2y$10$eLdAlmzUKvWEYi0dGfHb3e.jFB2cjR6SrrOQb0sxPNI7CTWkqEZai', 'Tria puspita dewi', 1678941761, 3, '1', '', 'default.svg'),
('MK-015', 'SINTAAPR@mwk.com', '$2y$10$uPskaFtWBw8wJpLE4xIbDOIU9Hp4ePCWIzt9QwfS17Mhsaz1wxDJi', 'SINTA APR', 1679019485, 8, '1', '', 'default.svg'),
('MK-016', 'anton@sifu.com', '$2y$10$y65WC1KZWunngu659bVRa.7yw1cisJafPKOrIxWXmg96etz2YrWJS', 'Antonius', 1679040272, 9, '1', '', 'default.svg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(2, 1, 2),
(4, 1, 1),
(5, 1, 3),
(6, 5, 1),
(7, 5, 3),
(8, 6, 1),
(9, 7, 1),
(10, 4, 1),
(11, 3, 1),
(12, 2, 1),
(13, 1, 4),
(14, 6, 3),
(15, 8, 1),
(16, 8, 3),
(17, 4, 3),
(18, 3, 3),
(19, 2, 4),
(20, 1, 5),
(21, 9, 1),
(22, 9, 5),
(23, 7, 5),
(24, 2, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL,
  `nourut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`, `nourut`) VALUES
(1, 'Dashboard', 1),
(2, 'Administrator', 2),
(3, 'Followup', 4),
(4, 'User', 5),
(5, 'Master', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL COMMENT 'Devisi',
  `keterangan` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`role_id`, `role`, `keterangan`) VALUES
(1, 'IT ADMINISTRATOR', 'Team IT Developpers'),
(2, 'Human Resource Team', 'HRD'),
(3, 'Telemarketing 75', 'Tim telemarketing garuda 75'),
(4, 'Telemarketing 118', 'Tim telemarketing Riau 118'),
(5, 'E-Commerce', 'Tim Penjualan E-commerce'),
(6, 'Website', 'Tim penjualan via Website'),
(7, 'MIS', 'Tim MIS'),
(8, 'Showroom', 'Showroom jln garuda 75 & Riau 118'),
(9, 'Monitoring', 'Kepala bagian');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` enum('0','1') NOT NULL COMMENT '0 = Nonaktif, 1 = aktif',
  `created_date` int(11) DEFAULT NULL,
  `created_by` varchar(128) DEFAULT NULL,
  `nourutan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`, `created_date`, `created_by`, `nourutan`) VALUES
(1, 1, 'Dashboard', 'dashboard', 'fa fa-th-large', '1', NULL, NULL, 1),
(2, 2, 'Menu Setting', 'administrator', 'fa fa-cog', '1', NULL, NULL, 1),
(3, 2, 'User Role', 'administrator/userRole', 'fa fa-cogs', '1', NULL, NULL, 2),
(4, 3, 'List Follow Up', 'followup/liste', 'fa fa-address-book', '1', 1678339457, 'Paulus Christofel S', 2),
(5, 4, 'Daftar Pengguna', 'user', 'fa fa-users', '1', 1678340864, 'Paulus Christofel S', 1),
(6, 3, 'Detail Followup', 'followup/detailFu', 'fa fa-stack-exchange', '1', 1678343568, 'Paulus Christofel S', 3),
(7, 3, 'Kategori Customer', 'followup/cstCategory', 'fa fa-dropbox', '1', 1678440394, 'Paulus Christofel S', 1),
(8, 5, 'Summary Followup	', 'master/summaryFollowup', 'fa fa-cubes', '1', 1678959946, 'Paulus Christofel S', 1),
(10, 5, 'Data Followup', 'master/zvoseFollowup', 'fa fa-address-book', '1', 1679103339, 'Paulus Christofel S', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_followup`
--
ALTER TABLE `tb_followup`
  ADD PRIMARY KEY (`followup_id`),
  ADD KEY `id_category` (`id_category`);

--
-- Indeks untuk tabel `tb_followup_detail`
--
ALTER TABLE `tb_followup_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `followup_id` (`followup_id`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tb_followup_detail`
--
ALTER TABLE `tb_followup_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=489;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_followup_detail`
--
ALTER TABLE `tb_followup_detail`
  ADD CONSTRAINT `tb_followup_detail_ibfk_1` FOREIGN KEY (`followup_id`) REFERENCES `tb_followup` (`followup_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
