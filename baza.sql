-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2017 at 09:12 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `partneri`
--

-- --------------------------------------------------------

--
-- Table structure for table `adrese`
--

CREATE TABLE `adrese` (
  `idAdrese` int(11) NOT NULL,
  `naziv` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `adrese`
--

INSERT INTO `adrese` (`idAdrese`, `naziv`) VALUES
(1, 'Beograd'),
(2, 'Novi Sad'),
(3, 'Pristina'),
(4, 'Nis'),
(5, 'Kragujevac'),
(6, 'Subotica'),
(7, 'Pancevo'),
(8, 'Zrenjanin'),
(9, 'Cacak'),
(10, 'Kraljevo'),
(11, 'Novi Pazar'),
(12, 'Leskovac');

-- --------------------------------------------------------

--
-- Table structure for table `materijali`
--

CREATE TABLE `materijali` (
  `idMaterijala` int(11) NOT NULL,
  `naziv` varchar(45) DEFAULT NULL,
  `sifra` varchar(15) NOT NULL,
  `preduzece` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materijali`
--

INSERT INTO `materijali` (`idMaterijala`, `naziv`, `sifra`, `preduzece`) VALUES
(1, 'NDS kartica', '90011', 1),
(2, 'HD satelitski prijemnik', '19624', 1),
(3, 'LNB Twin monoblok', '17511', 1),
(4, 'LNB Triple monoblok', '19881', 1),
(5, 'LNB Quad monoblok', '17512', 1),
(6, 'Satelitska antena', '17321', 1),
(7, 'RCA kabl', '30582', 1),
(8, 'SCART/RCA adapter', '16126', 1),
(9, 'Kabl SCART 6xRCA', '30584', 1),
(10, 'TP Link', '19797', 1);

-- --------------------------------------------------------

--
-- Table structure for table `partneri`
--

CREATE TABLE `partneri` (
  `idPartnera` int(10) UNSIGNED NOT NULL,
  `naziv` varchar(45) NOT NULL,
  `brojLicence` int(10) UNSIGNED DEFAULT NULL,
  `idPreduzeca` int(10) UNSIGNED NOT NULL,
  `adresa` int(11) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `partneri`
--

INSERT INTO `partneri` (`idPartnera`, `naziv`, `brojLicence`, `idPreduzeca`, `adresa`, `username`, `password`, `email`) VALUES
(1, 'MP-SAT', 122524, 1, 4, 'p1', '$2y$10$WTYMWQANhmKNV8IIE6di..nSQfLt9hf1V7WNNfPdSyGgXSNL.sgv2', 'testp1@gmail.com'),
(2, 'ASTRA', 245221, 1, 4, 'p2', '$2y$10$1ZFULsf34lP9mNWX3GJohebc2h/zh0e3SwfiSK1ebrAs9wwm/t8x.', 'testp2@gmail.com'),
(3, 'Tehno mont', 782334, 1, 4, 'p3', '$2y$10$IvyOzol2M.CMWd8ido7J.uBe5fv89G5TJF4rAg5fIMAEF4AudIqRS', 'testp3@gmail.com'),
(4, 'Antena mont', 876543, 1, 4, 'p4', '$2y$10$NvhZP8D0dfoyc3j2Hdz6ZuQN/Wy/YS/sJQL51UbZuAfEl/stxc6EW', 'testp4@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `preduzeca`
--

CREATE TABLE `preduzeca` (
  `idPreduzeca` int(10) UNSIGNED NOT NULL,
  `naziv` varchar(45) NOT NULL,
  `maticniBroj` varchar(8) DEFAULT NULL,
  `PIB` varchar(11) DEFAULT NULL,
  `sifraDelatnosti` varchar(5) DEFAULT NULL,
  `racun` varchar(20) DEFAULT NULL,
  `adresa` int(11) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `preduzeca`
--

INSERT INTO `preduzeca` (`idPreduzeca`, `naziv`, `maticniBroj`, `PIB`, `sifraDelatnosti`, `racun`, `adresa`, `username`, `password`, `email`) VALUES
(1, 'SBB', '12312345', '23234', '1312', '180-1232532-23', 1, 'test', '$2y$10$URpNAR.DFFI4Y25l/IiW7uw5uAvJOiDLQuH/Acr8oJI6lcVhzH6U2', 'test@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `razduzenje`
--

CREATE TABLE `razduzenje` (
  `idRazduzenje` int(11) NOT NULL,
  `partner` int(10) UNSIGNED NOT NULL,
  `materijal` int(11) NOT NULL,
  `kolicina` int(11) DEFAULT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `razduzenje`
--

INSERT INTO `razduzenje` (`idRazduzenje`, `partner`, `materijal`, `kolicina`, `datum`) VALUES
(1, 1, 1, 5, '2017-02-15'),
(2, 1, 6, 5, '2017-02-14'),
(4, 1, 9, 1, '2017-02-13'),
(5, 1, 3, 1, '2017-02-04'),
(6, 2, 2, 2, '2017-02-15'),
(7, 2, 10, 5, '2017-02-12'),
(8, 2, 1, 7, '2017-02-08'),
(9, 3, 1, 2, '2017-02-15'),
(10, 3, 2, 3, '2017-02-14'),
(11, 3, 6, 2, '2017-02-15');

-- --------------------------------------------------------

--
-- Table structure for table `zaduzenja`
--

CREATE TABLE `zaduzenja` (
  `idZaduzenja` int(11) NOT NULL,
  `partner` int(10) UNSIGNED NOT NULL,
  `materijal` int(11) NOT NULL,
  `kolicina` int(11) DEFAULT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zaduzenja`
--

INSERT INTO `zaduzenja` (`idZaduzenja`, `partner`, `materijal`, `kolicina`, `datum`) VALUES
(1, 1, 1, 20, '2017-02-14'),
(2, 1, 1, 27, '2017-02-05'),
(3, 1, 2, 4, '2017-02-01'),
(4, 1, 3, 8, '2017-02-15'),
(5, 1, 6, 43, '2017-02-05'),
(7, 1, 2, 12, '2017-02-03'),
(8, 1, 7, 100, '2017-02-02'),
(9, 1, 8, 2, '2017-02-08'),
(10, 1, 9, 22, '2017-02-06'),
(11, 1, 10, 1, '2017-01-31'),
(12, 2, 1, 32, '2017-02-08'),
(13, 2, 1, 12, '2017-02-14'),
(14, 2, 3, 54, '2017-02-06'),
(15, 2, 5, 23, '2017-02-08'),
(16, 2, 2, 62, '2017-02-03'),
(17, 2, 6, 23, '2017-02-07'),
(18, 2, 8, 2, '2017-02-09'),
(19, 2, 10, 12, '2017-02-15'),
(20, 2, 4, 1, '2017-02-14'),
(21, 3, 1, 22, '2017-02-07'),
(22, 3, 4, 2, '2017-02-10'),
(23, 3, 6, 14, '2017-02-13'),
(24, 3, 10, 5, '2017-02-11'),
(25, 3, 5, 9, '2017-02-07'),
(26, 3, 7, 11, '2017-02-14'),
(27, 3, 2, 18, '2017-02-06'),
(28, 3, 8, 2, '2017-02-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adrese`
--
ALTER TABLE `adrese`
  ADD PRIMARY KEY (`idAdrese`),
  ADD UNIQUE KEY `idAdrese_UNIQUE` (`idAdrese`);

--
-- Indexes for table `materijali`
--
ALTER TABLE `materijali`
  ADD PRIMARY KEY (`idMaterijala`),
  ADD UNIQUE KEY `idMaterijala_UNIQUE` (`idMaterijala`),
  ADD KEY `fk_materijali_preduzeca1_idx` (`preduzece`);

--
-- Indexes for table `partneri`
--
ALTER TABLE `partneri`
  ADD PRIMARY KEY (`idPartnera`),
  ADD UNIQUE KEY `id_UNIQUE` (`idPartnera`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `brojLicence_UNIQUE` (`brojLicence`),
  ADD KEY `fk_partneri_preduzeca_idx` (`idPreduzeca`),
  ADD KEY `fk_partneri_adrese1_idx` (`adresa`);

--
-- Indexes for table `preduzeca`
--
ALTER TABLE `preduzeca`
  ADD PRIMARY KEY (`idPreduzeca`),
  ADD UNIQUE KEY `idfirme_UNIQUE` (`idPreduzeca`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `maticniBroj_UNIQUE` (`maticniBroj`),
  ADD UNIQUE KEY `PIB_UNIQUE` (`PIB`),
  ADD UNIQUE KEY `racun_UNIQUE` (`racun`),
  ADD KEY `fk_preduzeca_adrese1_idx` (`adresa`);

--
-- Indexes for table `razduzenje`
--
ALTER TABLE `razduzenje`
  ADD PRIMARY KEY (`idRazduzenje`),
  ADD UNIQUE KEY `idRazduzenje_UNIQUE` (`idRazduzenje`),
  ADD KEY `fk_razduzenje_partneri1_idx` (`partner`),
  ADD KEY `fk_razduzenje_materijali1_idx` (`materijal`);

--
-- Indexes for table `zaduzenja`
--
ALTER TABLE `zaduzenja`
  ADD PRIMARY KEY (`idZaduzenja`),
  ADD UNIQUE KEY `idZaduzenja_UNIQUE` (`idZaduzenja`),
  ADD KEY `fk_zaduzenja_partneri1_idx` (`partner`),
  ADD KEY `fk_zaduzenja_materijali1_idx` (`materijal`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adrese`
--
ALTER TABLE `adrese`
  MODIFY `idAdrese` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `materijali`
--
ALTER TABLE `materijali`
  MODIFY `idMaterijala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `partneri`
--
ALTER TABLE `partneri`
  MODIFY `idPartnera` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `preduzeca`
--
ALTER TABLE `preduzeca`
  MODIFY `idPreduzeca` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `razduzenje`
--
ALTER TABLE `razduzenje`
  MODIFY `idRazduzenje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `zaduzenja`
--
ALTER TABLE `zaduzenja`
  MODIFY `idZaduzenja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `materijali`
--
ALTER TABLE `materijali`
  ADD CONSTRAINT `fk_materijali_preduzeca1` FOREIGN KEY (`preduzece`) REFERENCES `preduzeca` (`idPreduzeca`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `partneri`
--
ALTER TABLE `partneri`
  ADD CONSTRAINT `fk_partneri_adrese1` FOREIGN KEY (`adresa`) REFERENCES `adrese` (`idAdrese`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_partneri_preduzeca` FOREIGN KEY (`idPreduzeca`) REFERENCES `preduzeca` (`idPreduzeca`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `preduzeca`
--
ALTER TABLE `preduzeca`
  ADD CONSTRAINT `fk_preduzeca_adrese1` FOREIGN KEY (`adresa`) REFERENCES `adrese` (`idAdrese`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `razduzenje`
--
ALTER TABLE `razduzenje`
  ADD CONSTRAINT `fk_razduzenje_materijali1` FOREIGN KEY (`materijal`) REFERENCES `materijali` (`idMaterijala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_razduzenje_partneri1` FOREIGN KEY (`partner`) REFERENCES `partneri` (`idPartnera`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `zaduzenja`
--
ALTER TABLE `zaduzenja`
  ADD CONSTRAINT `fk_zaduzenja_materijali1` FOREIGN KEY (`materijal`) REFERENCES `materijali` (`idMaterijala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_zaduzenja_partneri1` FOREIGN KEY (`partner`) REFERENCES `partneri` (`idPartnera`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
