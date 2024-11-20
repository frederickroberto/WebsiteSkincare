-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 02:59 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skincare`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'frederick', '123'),
(2, 'melvina', '123'),
(3, 'admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id_cart`, `id_user`, `id_produk`, `jumlah`, `total_harga`) VALUES
(43, 2, 16, 2, 0),
(44, 2, 12, 1, 0),
(45, 2, 17, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id_fav` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`id_fav`, `id_user`, `id_produk`) VALUES
(1, 1, 45);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','done','','') DEFAULT 'pending',
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_user`, `id_produk`, `jumlah`, `total_harga`, `status`, `tanggal`) VALUES
(9, 2, NULL, 1, 220000.00, 'pending', '2024-11-15 03:17:31'),
(10, 2, 12, 1, NULL, 'pending', '2024-11-15 03:27:44'),
(11, 2, 13, 2, NULL, 'pending', '2024-11-15 03:27:44'),
(13, 2, 13, 1, 174000.00, 'pending', '2024-11-15 03:29:42'),
(14, 2, 13, 2, 348000.00, 'pending', '2024-11-15 03:31:33'),
(15, 2, 12, 1, 220000.00, 'pending', '2024-11-15 03:32:41'),
(16, 2, 13, 1, 174000.00, 'pending', '2024-11-15 03:33:33'),
(17, 2, 13, 1, 174000.00, 'pending', '2024-11-15 03:34:41'),
(18, 2, 12, 1, 220000.00, 'pending', '2024-11-15 03:38:54'),
(19, 2, 13, 1, 174000.00, 'pending', '2024-11-15 03:39:52'),
(20, 2, 12, 1, 220000.00, 'pending', '2024-11-15 03:40:47'),
(21, 2, 12, 1, 220000.00, 'pending', '2024-11-15 03:41:49'),
(22, 1, 12, 1, 220000.00, 'pending', '2024-11-15 05:17:50'),
(23, 1, 12, 1, 220000.00, 'done', '2024-11-15 05:19:51'),
(24, 1, 12, 1, 220000.00, 'done', '2024-11-15 05:25:30'),
(25, 1, 12, 2, 440000.00, 'done', '2024-11-15 05:27:01'),
(26, 2, 16, 1, 115000.00, 'done', '2024-11-16 07:01:26'),
(27, 2, 16, 3, 345000.00, 'pending', '2024-11-16 09:09:17'),
(28, 2, 17, 1, 89000.00, 'pending', '2024-11-16 09:09:17'),
(29, 2, 12, 1, 220000.00, 'pending', '2024-11-16 09:09:17'),
(30, 1, 43, 1, 60000.00, 'done', '2024-11-20 00:53:56'),
(31, 1, 41, 3, 528000.00, 'done', '2024-11-20 00:53:56');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` enum('Moisturizer','Cleanser','Serum','Sunscreen','Toner') NOT NULL,
  `deskripsi` text NOT NULL,
  `stok` int(10) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama`, `kategori`, `deskripsi`, `stok`, `foto`, `merk`, `harga`) VALUES
(12, 'Uyu Toner', 'Toner', 'Toner yang diformulasikan dengan Jeju Milk Ekstrak Complex 15% dan  Ceramide 5 Complex yang dapat mengisi serta mengunci kelembaban pada kulit. Dengan kandungan Niacinamide 2%, Allantoin dan Peptide Complex, toner ini mampu mencerahkan menenangkan, serta memberikan nutrisi untuk peremajaan kulit. Kulit lembab hingga 100 jam', 15, 'toner1.jpg', 'NACIFIC', 220000),
(13, 'Mist Toner', 'Toner', 'Pyunkang Yul Mist Toner merupakan toner yang terbuat dari 91,9% ekstrak Coptis Japonica Root, bahan antioksidan yang dikenal akan sifatnya yang membantu meredakan inflamasi. Pyunkang Yul Mist Toner dapat melembabkan dan menyegarkan kulit dengan baik. Berfungsi sebagai toner dalam rutinitas perawatan kulit.', 20, 'toner2.jpg', 'PYUNKANG YUL', 174000),
(14, 'Hydrium Watery Toner', 'Toner', 'COSRX Hydrium Watery Toner cocok digunakan untuk kulit yang kering/ dehidrasi. Diformulaikan dengan Vitamin B5 (D-panthenol), 6 tipe hyaluronic acid & Allantoin yang dapat membantu menghidrasi kulit secara mendalam dan tahan lama.', 47, 'toner3.jpg', 'COSRX', 89000),
(15, 'Aloe BHA Skin Toner', 'Toner', 'Benton mempunyai campuran khusus yaitu Aloe Vera, bahan-bahan alami, dan 0.5% Salicyclic Acid untuk mengatasi masalah kulit. Sodium Hyaluronate dan Vegetable Glycerin tidak hanya menambah kelembapan ke dalam kulit tetapi juga menjaga kelembapan kulit.', 36, 'toner4.jpg', 'BENTON', 54000),
(16, 'Acid Anti-Acne Gel Moisturizer', 'Moisturizer', 'Diformulasikan secara Pro-Potent Ingredients dengan penggabungan 3 Acid yang fokus untuk meredakan masalah jerawat tanpa mengiritasi. Menggunakan Molecular Coupling Technology, membentuk struktur 3D yang membuat penetrasi lebih terproses secara baik ke kulit, tidak mengiritasi serta aman di kulit dengan fungsi yang sangat efektif.', 20, 'mois9.jpg', 'SKINTIFIC', 115000),
(17, 'Probiotics Comfort Moisturizer', 'Moisturizer', 'Pelembab tekstur ringan yang cocok dipakai sehari-hari. Kandungan utama 48% Natural Noni dan Probiotics 9 Complex dapat menjaga skin microbiome agar kulit tampak sehat. Diperkaya dengan Ekstrak Chamomile, Bisabolol, Betaine, Allantoin, dan Ceramide NP yang melembabkan dan memberikan efek soothing, sangat ideal untuk kulit sensitif. Dengan Natural Moisturizing Factor sebagai pelindung untuk menjaga lapisan luar kulit agar tetap terlindungi dan terhidrasi dengan baik, serta meningkatkan skin barrier dari waktu ke waktu. Kulit Tampak Sehat Alami.', 30, 'mois11.jpg', 'NPURE', 89000),
(18, 'Hyalucera Moisturizer', 'Moisturizer', 'A serum formulated to maintain the skin barrier using a combination of chemical laboratory active ingredients that are natural ingredients from nature. Formulated with Hyaluronic Acid and Ceramide which can repair and maintain skin barriers, lock hydration in the skin, and maintain skin elasticity. Contains Chlorelina, a combination of chlorella and spirulina which functions to maintain elasticity, as an antioxidant for the skin, as oil control and its gel texture makes this moisturizer suitable for all skin types.', 18, 'mois2.jpg', 'THE ORIGINOTE', 46500),
(19, 'Acid Acne Moisturizer', 'Moisturizer', 'Moisturizer untuk permasalahan kulit berjerawat yang di formulasikan secara Pro-potent ingredients dengan melakukan penggabungan 3 Acid ( Salicylic Acid, Succinic Acid, Mandelic Acid) dalam satu produk yang fokus untuk meredakan, mematangkan dan mengeringkan jerawat tanpa mengiritasi dan tidak membuat kulit menjadi kering. Dengan menjaga ketahanan kelembapan dan hidrasi pada kulit.', 23, 'mois7.jpg', 'GLAD2GLOW', 52000),
(20, 'B5 Acne Serum', 'Serum', 'Acne serum yang diformulasikan dengan gabungan bahan aktif laboratorium kimia yang teruji secara klinis aman dan bahan natural dari alam. Diformulasikan dengan salicylic acid khusus untuk mengatasi jerawat dan mengecilkan pori-pori penyebab minyak berlebih, Panthenol untuk tetap menjaga kelembaban kulit, dan Tamanu Oil mempercepat proses penyembuhan jerawat, mengurangi bekas jerawat dan anti inflammatory. Acne B5 Serum ini dapat dikombinasikan dengan serum Ceratides untuk wajah yang bebas jerawat serta skin barrier yang lebih kuat.', 9, 'serum1.jpg', 'THE ORIGINOTE', 42000),
(21, 'Acne Toner', 'Toner', 'Whitelab Acne toner merupakan produk yang di formulasikan khusus sebagai pendukung untuk acne treatment anda.', 24, 'toner5.jpg', 'WHITE LAB', 52000),
(22, 'Acne Refresh Toner', 'Toner', 'Toner yang berfungsi untuk membersihkan kulit wajah yang berjerawat dari kotoran dan sisa makeup. Juga menyegarkan kulit wajah serta membantu kulit wajah yang berjerawat. Memiliki kandungan Salicylic Acid bermanfaat untuk mengembalikan pH dan kelembaban alami kulit setelah proses pembersihan, sekaligus mengurangi komedo dan bakteri penyebab jerawat.', 13, 'toner6.jpg', 'ELSHESKIN', 45500),
(23, 'Mild Purifying Toner', 'Toner', 'Azarine mild purifying toner merupakan produk yang berfungsi untuk menetralkan pH kulit serta mengatasi masalah jerawat, minyak berlebih, komedo, dan pori besar. Toner ini diformulasi tanpa alcohol, oil, dan fragrance. Toner ini menggunakan succinic acid sebagai alternatif salicylic acid sehingga lebih ringan untuk kulit sensitive dan juga dapat digunakan oleh ibu hamil.', 6, 'toner7.jpg', 'AZARINE', 58500),
(24, 'Lightening Face Toner', 'Toner', 'Toner dengan alcohol free dan pH balance formula yang nyaman serta terasa sejuk di kulit. Mengoptimalkan proses pembersihan pada wajah dan menjaga kelembabannya. Diformulasikan dengan Skin Lightening System, kandungan ekstrak Licorice, Seaweed plis Vitamin B3 nya membuat kulit tampak lebih cerah sekaligus terasa halus, segar dan tetap lembab.', 42, 'toner8.jpg', 'WARDAH', 27500),
(25, 'Bija Trouble Skin Toner', 'Toner', 'Toner untuk kulit berjerawat yang membantu membersihkan dan mengangkat kotoran penyebab jerawat dengan kandungan salicylic acid dan alkohol alami dari Bija. Perkenalan Produk : Toner yang terbuat dari minyak Bija untuk perawatan kulit bermasalah.', 32, 'toner9.jpg', 'INNISFREE', 180000),
(26, 'Hyathenol Hydra Toner', 'Toner', 'Hydrating Toner dengan kandungan Niacinamide, Panthenol, Sodium Hyaluronate, Squalane, Adenosine, dan berbagai botanical extracts, yang memberikan kesegaran pada kulit seusai membersihkan wajah dengan Foam Cleanser, menjaga kulit agar tetap terasa lembap.', 27, 'toner10.jpg', 'NATURE REPUBLIC', 295000),
(27, 'Pink Bliss Moisturizer', 'Moisturizer', 'Pink Bliss Moisturizer adalah moisturizer kedua dari Dorskin yang berfungsi untuk membantu melembapkan dan mencerahkan, terutama untuk oily dan acne-prone skin. Moisturizer ini juga lebih cocok digunakan di pagi hari, kerena memiliki tekstur ringan dan mudah meresap. Memiliki kandungan Centella Asiatica dan Aloe Vera untuk membantu menenangkan inflamasi. Ditambah dengan Niacinamide dan ekstrak delima sebagai pewarna natural.', 34, 'mois1.jpg', 'DORSKIN', 123000),
(28, 'Acne Care Moisturizer Gel', 'Moisturizer', 'Diformulasikan dengan kekuatan 3 kandungan utama BHA, Mugwort, dan Tea Tree yang dapat membantu merawat kulit berjerawat, menenangkan kulit yang iritasi dan kemerahan akibat jerawat, mengurangi produksi minyak berlebih, serta membantu meningkatkan level hidrasi kulit wajah. Kulit tampak lebih lembap, halus, dan sehat.', 23, 'mois3.jpg', 'WHITE LAB', 88500),
(29, 'Kind Cream Moisturizer', 'Moisturizer', 'Kind Cream Moisturizer merupakan pelembab dengan tekstur cream yang nyaman digunakan untuk kulit cenderung kering. Kind Cream Moisturizer hadir dalam 2 varian ukuran yaitu 100 ml dan 30 ml.', 25, 'mois4.jpg', 'SKIN GAME', 117000),
(30, 'Rhodiola Moisturizer Gel', 'Moisturizer', 'Rhodiola Moisturizer Gel adalah pelembap ringan yang cepat menyerap dengan kandungan bahan aktif Rhodiola serta 15 Key Ingredients. Diformulasikan untuk semua jenis kulit, terutama kulit berminyak karena kemampuan mengontrol produksi minyak berlebih. Berfungsi untuk melembapkan dan menghidrasi, menenangkan kemerahan dan radang, serta melembutkan tekstur kulit.', 63, 'mois5.jpg', 'KLEVERU', 102000),
(31, 'Cica Care Gel Moisturizer', 'Moisturizer', 'Toner yang diformulasikan dapat bekerja 2x lebih baik dalam melembabkan dan menghidrasi kulit serta lebih efektif untuk mengurangi kemerahan dan menenangkan kulit.', 12, 'mois6.jpg', 'JARTE BEAUTY', 101000),
(32, '24-Hour Hydro Moisturizer', 'Moisturizer', 'Pelembab dengan tekstur Fast Hydrogel yang sangat ringan, cepat menyerap, dan tidak lengket. Diformulasikan dengan 10X HYDROBOOST, 2% Niacinamide, dan 3% Calendula Extract yang efektif untuk menenangkan kulit kemerahan, mengurangi produksi minyak berlebih, dan menyamarkan tampilan pori-pori pada kulit. Teruji klinis mengunci hidrasi di dalam lapisan kulit selama 24 jam.', 54, 'mois8.jpg', 'ROSE ALL DAY', 120000),
(33, 'Hydra Bost Oil Free Moisturizer', 'Moisturizer', 'Hydra Boost Oil Free Moisturizer memiliki manfaat untuk menyeimbangkan sebum production pada kulit berminyak, mengurangi kemerahan pada kulit berjerawat, melindungi, memperbaiki dan memperkuat skin’s barrier.', 23, 'mois10.jpg', 'ELSHESKIN', 85000),
(35, 'Bright Up Serum', 'Serum', 'Safi Serum Essentials Bright Up Serum adalah serum lembut dengan formula yang ringan cepat meresap dan tidak berminyak. Serum ini diformulasikan dengan 50X Vitamin C dan Hyaluronic Acid untuk kulit wajah tampak lebih cerah merata. Dengan tekstur yang ringan, produk ini mudah meresap ke dalam kulit dan sangat cocok untuk menjadi pilihan perawatan kulit Anda sehari-hari.', 24, 'serum2.jpg', 'SAFI', 150000),
(36, 'Sebium Serum', 'Serum', 'Serum yang menargetkan tanda-tanda penuaan dini dan melawan jerawat. Dengan kandungan aktif Hyaluronic Acid & Salicylic Acid efektif mengatasi jerawat, pori-pori besar serta bekas jerawat, serta melawan tanda-tanda penuaan dini seperti garis halus, kerutan, kulit kendur. Memiliki tekstur ringan, mudah menyerap, dan terlihat hasilnya dalam 7 hari pemakaian.', 25, 'serum3.jpg', 'BIODERMA', 235000),
(37, 'Acen Spot Serum', 'Serum', 'Serum dengan duo action yaitu memudarkan jerawat serta kulit kusam. Di formulasikan dengan Succinic Acid sebagai alternatif Asam Salisilat, CICA dan ekstrak lain untuk merawat kulit berjerawat. Kandungan Arbutin dan Papaya untuk menyamarkan bekas jerawat sekaligus mencerahkan agar kulit tampak lebih bersih.', 16, 'serum4.jpg', 'AZARINE', 29000),
(38, 'Moisture Serum', 'Serum', 'Formulated to help the skin find its optimal proportion of moisture and oil for a balanced healthy complexion. The secret is in the right combination of the star ingredients, including the coptis japonica root extract and olive oil. The Pyunkang Yul Moisture Serum calms and cools while providing deep hydration for irritated, sensitive, oily, yet dehydrated skin. The light lotion-like texture spreads easily and absorbs quickly.', 3, 'serum5.jpg', 'PYUNKANG YUL', 78000),
(39, 'Smoothing Serum', 'Serum', 'Elsheskin Smoothing Serum di formulasikan dengan Centella Asiatica yang dapat menenangkan kulit, merawat wajah akibat bekas jerawat kemerahan, memberikan kelembapan dan membuat wajah menjadi kenyal hanya dalam 7 hari. Dilengkapi dengan Salicylic Acid yang dapat mengangkat sel kulit mati sehingga wajah menjadi halus dan lembut.', 7, 'serum6.jpg', 'ELSHESKIN', 94000),
(40, 'Pink AHABHA Serum', 'Serum', 'Perawatan untuk kulit sensitive & kering. Mampu mencerahkan, menghaluskan & mengurangi kerutan pada kulit. Mengandung AHA 900ppm dan BHA 1.000 ppm berfungsi mengeksfoliasi sel-sel kulit mati dan membuat kulit lebih halus dan cerah serta mengurangi tampilan kerutan di kulit, ekstrak semangka yang membantu melembapkan kulit, dan Glutathione yang membantu mencerahkan kulit', 21, 'serum7.jpg', 'NACIFIC', 105000),
(41, 'Pure Fit Cica Serum', 'Serum', 'COSRX Pure Fit Cica Serum merupakan serum untuk semua jenis kulit termasuk kulit sensitif. Dengan 76% Cica-7 Complex (Centella Asiatica) untuk membantu memperkuat skin barrier, mengurangi kemerahan, serta membantu menenangkan kulit sensitif.', 23, 'serum8.jpg', 'COSRX', 176000),
(42, 'Acne Calming Serum', 'Serum', 'Bertekstur ringan dan mudah menyerap di kulit dan dapat digunakan untuk semua jenis kulit', 13, 'serum9.jpg', 'WHITELAB', 81000),
(43, 'Eyelash Care Serum', 'Serum', 'Breylee Eyelash Care Serum adalah serum untuk merawat bulu mata, menambah panjang bulu mata, meningkatkan kegelapan serta ketebalan bulu mata sehingga bulu mata terlihat lebih lentik dan indah.', 21, 'serum10.jpg', 'BREYLEE', 60000),
(44, 'Oily Skin Cleanser', 'Cleanser', 'Oily Skin Cleanser merupakan sabun cuci muka untuk wajah yang cenderung berjerawat dan untuk kulit berminyak. Dengan formula yang mild dan non irritant cocok untuk yang punya kulit sensitif Membersihkan dan menjaga kelembaban kulit Tidak mengandung pewangi, tidak mengiritasi kulit dan menjaga PH balance kulit. Bisa dipakai juga untuk seluruh tubuh. cleanser ini juga mampu membersihkan wajah tanpa mengganggu kelembapan alami kulit. Bahkan, katanya produk ini juga sudah terbukti secara klinis mampu mengurangi sebum dalam waktu dua minggu. ', 31, 'cleanser1.jpg', 'CETAPHIL', 196000),
(45, 'Perfect Whip Berry Bright', 'Cleanser', 'Senka Perfect Whip Berry Bright merupakan pembersih wajah yang mengandung campuran red berries dari raspberry dan cranberry yang dapat menyehatkan kulit yang kusam, bahkan dilengkapi dengan ekstrak  yoshino cherry jepang yang terkenal dapat digunakan untuk deep cleansing, membantu menyamarkan noda hitam dan mengangkat sel kulit mati.', 7, 'cleanser2.jpg', 'SENKA', 77000),
(46, 'Triple Care Facial Gel Cleanser', 'Cleanser', 'Facial Gel Cleanser yang diformulasikan mampu membersihkan, menghilangkan kotoran dan minyak hingga ke dalam pori yang menyumbat serta aman untuk semua jenis kulit dengan memberikan hidrasi yang cukup, lembut, dan menenangkan di wajah, tanpa membuat kulit menjadi terasa. kering, ketarik maupun iritasi serta mampu menjaga kulit dari radikal bebas. Cleanser ini memiliki pH yang rendah (5,0 - 5,5) sehingga mampu mengembalikan kadar pH kulit', 18, 'cleanser3.jpg', 'FACETOLOGY', 70000),
(47, 'Triple Care Facial Gel Cleanser', 'Cleanser', 'Facial Gel Cleanser yang diformulasikan mampu membersihkan, menghilangkan kotoran dan minyak hingga ke dalam pori yang menyumbat serta aman untuk semua jenis kulit dengan memberikan hidrasi yang cukup, lembut, dan menenangkan di wajah, tanpa membuat kulit menjadi terasa. kering, ketarik maupun iritasi serta mampu menjaga kulit dari radikal bebas. Cleanser ini memiliki pH yang rendah (5,0 - 5,5) sehingga mampu mengembalikan kadar pH kulit', 18, 'cleanser3.jpg', 'FACETOLOGY', 70000),
(48, 'Daily Gentle Low pH Cleanser', 'Cleanser', 'Elformula Daily Gentle Low pH Facial Cleanser adalah pembersih wajah yang memiliki pH rendah (5-6) dan dapat digunakan secara harian. Berikut ini adalah beberapa deskripsi produknya:', 19, 'cleanser4.jpg', 'ELFORMULA', 101000),
(49, '5x Ceramide Low pH Cleanser', 'Cleanser', 'Niacinamide Brightening Cleanser dengan tekstur yang padat namun lembut, dapat membuat busa dengan mudah dan kaya. Diformulasikan dengan Niacinamide, Alpha Arbutin, dan Enzyme, menjadikan kulit tampak lebih cerah dan halus, serta membersihkan secara menyeluruh sekaligus mengontrol produksi minyak berlebih', 23, 'cleanser5.jpg', 'SKINTIFIC', 96000),
(50, 'Aloe Soothing Sun Cream SPF 50+ PA+++', 'Sunscreen', 'COSRX Aloe Soothing Sun Cream SPF 50+ PA+++, merupakan sunscreen/ sun cream pertama yang memberikan double proteksi. Texture ringan dan tidak menimbulkan whitecast. melembabkan dengan 5,500ppm dari Aloe Barbadensis Leaf Water memberikan kelembaban dan nutrisi pada kulit sekaligus melindungi kulit dari paparan sinar UVA dan UVB. Aloe Soothing Sun Cream merupakan campuran dari bahan-bahan alami dan bahan pelindung terhadap sinar UV yang telah teruji secara klinis (Vivo Test)', 23, 'ss5.jpg', 'COSRX', 154000),
(51, 'Hydrashoothe Sunscreen Gel Spf45+++', 'Sunscreen', 'A water-based gel sunscreen that is extremely lightweight, cooling, and quickly absorbed, suitable for all skin types including oily and acne-prone skin. Formulated with natural ingredients like Propolis, Aloe Vera, Green Tea, and Pomegranate to protect the skin from UV A & UV B rays while nourishing it.', 24, 'ss4.jpg', 'AZARINE', 57000),
(52, 'Matte Fit Serum Sunscreen SPF50+ PA++++', 'Sunscreen', 'Memperkenalkan tabir surya kami yang inovatif, ringan, dan bebas kilap, dirancang sebagai perlindungan terbaik Anda sepanjang hari. Diperkaya dengan Zinc PCA dan Fomes Officinalis Extract untuk membantu mengontrol minyak berlebih, serta Ectoin dan Oat Extract untuk membantu menenangkan dan menutrisi kulit Anda, formula canggih ini memberikan perlindungan kuat terhadap sinar UVA dan UVB sekaligus memastikan hasil akhir matte yang sehat.', 10, 'ss3.jpg', 'SKINTIFIC', 93000),
(53, 'Cica Beat The Sun Spray', 'Sunscreen', 'Sunscreen Spray yang praktis untuk melindungi kulit dari sinar UVA dan UVB. Dengan SPF 50+ dan PA++++ diformulasikan lengkap dengan 5X UV Protection, Organic Centella Extract dan Ceramide dapat melembapkan, menjaga skin barrier serta merawat kulit berjerawat. Dapat digunakan setiap saat baik sebelum maupun sesudah makeup.', 9, 'ss2.jpg', 'NPURE', 78500),
(54, 'Triple Care Lip Protector Sunscreen', 'Sunscreen', 'Menggunakan Triple Lip Sunscreen Protector Sunscreen SPF 50 PA++++ adalah solusi untuk merawat dan sekaligus melindungi bibirmu. Lip serum kami hadir dengan manfaat triple yaitu, diperkaya Vitamin C dan Squalene untuk melembabkan, mencerahkan dan menjaga agar bibir tetap sehat dan cantik', 12, 'ss1.jpg', 'FACETOLOGY', 69000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`) VALUES
(1, 'frederick', '123'),
(2, 'melvina', '123'),
(3, 'zahra', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id_fav`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
