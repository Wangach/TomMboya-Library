-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2023 at 06:38 PM
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
-- Database: `tommboyalibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `adminname` varchar(100) NOT NULL,
  `nationalid` int(100) NOT NULL,
  `adminemail` varchar(100) NOT NULL,
  `phonenumber` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `adminname`, `nationalid`, `adminemail`, `phonenumber`, `password`) VALUES
(1, 'Fred Wizard', 30303030, 'wizard@gmail.com', '1111111111', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `borrowedbooks`
--

CREATE TABLE `borrowedbooks` (
  `order_id` int(100) NOT NULL,
  `serialnumber` varchar(100) NOT NULL,
  `bookname` varchar(100) NOT NULL,
  `borrower_id` varchar(100) NOT NULL,
  `phone_no` varchar(100) NOT NULL,
  `borrower_name` varchar(100) NOT NULL,
  `borrow_date` date NOT NULL,
  `price` int(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `userlocation` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `additionalDetails` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowedbooks`
--

INSERT INTO `borrowedbooks` (`order_id`, `serialnumber`, `bookname`, `borrower_id`, `phone_no`, `borrower_name`, `borrow_date`, `price`, `status`, `userlocation`, `address`, `additionalDetails`) VALUES
(4, 'lib001', 'War Of The Animals', '1', '254769635821', 'fred', '2023-11-14', 1, 'unpaid', 'none', 'mku', ''),
(5, 'lib011', 'Olivia, Mourning', '1', '10191119911', 'fred', '2023-11-14', 500, 'unpaid', 'none', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `deliverystaff`
--

CREATE TABLE `deliverystaff` (
  `id` int(100) NOT NULL,
  `dname` varchar(100) NOT NULL,
  `demail` varchar(100) NOT NULL,
  `dphonenumber` varchar(100) NOT NULL,
  `dpassword` varchar(100) NOT NULL,
  `dnationalid` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliverystaff`
--

INSERT INTO `deliverystaff` (`id`, `dname`, `demail`, `dphonenumber`, `dpassword`, `dnationalid`) VALUES
(1, 'Fred', 'fred@gmail.com', '111111111', '1234', 0),
(2, 'Derrick Ajwang', 'fredswae59@gmail.com', '070000000', '1234', 300000);

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(100) NOT NULL,
  `phonenumber` varchar(100) NOT NULL,
  `MerchantRequestID` varchar(100) NOT NULL,
  `CheckoutRequestID` varchar(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `MpesaReceiptNumber` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `horrorbooks`
--

CREATE TABLE `horrorbooks` (
  `id` int(100) NOT NULL,
  `serialnumber` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `booklocation` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `horrorbooks`
--

INSERT INTO `horrorbooks` (`id`, `serialnumber`, `name`, `booklocation`, `image`) VALUES
(1, 'hor001', 'dracula', 'pdfs/Dracula.pdf', 'hor1.jpg'),
(2, 'hor002', 'collected works of poe', 'pdfs/Collected-Works-of-Poe.pdf', 'hor2.jpg'),
(3, 'hor003', 'beach town', 'pdfs/Beach-Town-Apocalypse.pdf', 'hor3.jpeg'),
(4, 'hor004', 'mostly dark', 'pdfs/Mostly-Dark.pdf', 'hor4.jpeg'),
(5, 'hor005', 'mental damnatiion', 'pdfs/Reality-Mental-Damnation.pdf', 'hor5.jpg'),
(6, 'hor006', 'ash', 'pdfs/Ash---A-Thriller.pdf', 'hor6.jpg'),
(7, 'hor007', 'resurrection', 'pdfs/Resurrection-A-Zombie-Novel.pdf', 'hor7.jpg'),
(8, 'hor008', 'fosgate\'s game', 'pdfs/Fosgates-Game.pdf', 'hor8.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `kidsbooks`
--

CREATE TABLE `kidsbooks` (
  `id` int(100) NOT NULL,
  `serialnumber` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `booklocation` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kidsbooks`
--

INSERT INTO `kidsbooks` (`id`, `serialnumber`, `name`, `booklocation`, `image`) VALUES
(1, 'kid001', 'the ultimate sacrifice', 'pdfs/The-Ultimate-Sacrifice-.pdf', 'kids1.jpg'),
(2, 'kid002', 'cookbook', 'pdfs/Cozy-Mysteries-Cookbook.pdf', 'kids2.jpg'),
(3, 'kid003', 'dark promise', 'pdfs/Dark-Promise-.pdf', 'kids3.jpg'),
(4, 'kid004', 'secrets and guardians', 'pdfs/Secrets-and-Guardians-Devious-Intentions.pdf', 'kids4.jpg'),
(5, 'kid005', 'children of the knight', 'pdfs/Children-of-the-Knight.pdf', 'kids5.jpg'),
(6, 'kid006', 'skylar robbins', 'pdfs/Skylar-Robbins-The-Mystery-of-the-Hidden-Jewels.pdf', 'kids6.jpg'),
(7, 'kid007', 'first magic', 'pdfs/First-Magic.pdf', 'kids7.jpg'),
(8, 'kid008', 'radialloy', 'pdfs/Firmament-Radialloy.pdf', 'kids8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `librarybooks`
--

CREATE TABLE `librarybooks` (
  `id` int(100) NOT NULL,
  `serialnumber` varchar(100) NOT NULL,
  `bookname` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `availability` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `librarybooks`
--

INSERT INTO `librarybooks` (`id`, `serialnumber`, `bookname`, `price`, `image`, `author`, `description`, `availability`) VALUES
(1, 'lib001', 'War Of The Animals', 1, 'lib21.jpg', 'Jonathan DeCoteau', 'A failed effort to weaponize animals awakens their intellects. The military responds by creating death camps to exterminate infected animals. Moon Shadow, an Arctic white wolf, unites with White Claw, a polar bear king, to form Animus Nor, the first animal republic, to negotiate peace. \r\nWill humanity win, or will nature triumph in the end?', 'unaivalable'),
(2, 'lib002', 'When Totems Fall', 500, 'lib2.jpg', 'Wayne C Stewart', '\"A page-turning thriller with dueling protagonists and a tech quotient high enough to satisfy fans of even the hardest science fiction.\" - Independent Book Review\r\n\r\nHe believed his breakthrough AI might someday change the world. It finally has. And now 50,000 Chinese soldiers stand guard over American soil.', 'available'),
(3, 'lib003', 'Desa Kincaid - Bounty Hunter', 500, 'lib3.jpeg', 'R.S. Penney', '\"Desa Kincaid has spent the last ten years in pursuit of a man whose experiments have killed over a dozen people.Blessed with the power to transform ordinary objects into devastating weapons, she journeys through trading ports, backwater towns, forests, deserts and the haunted remains of a dead city. But can she stop her enemy before he unleashes something terrible on the world?', 'available'),
(4, 'lib004', 'Lady Tanglewood', 500, 'lib4.jpg', 'Toni Cabell', '\"Nari knows the rumors about Arrowood. Forbidden magic. Illegal crossbreeding. Strange howls in the night. Should she go through with the wedding anyway?As Nari rides toward Arrowood and her new home, her head is elsewhere. Soon, she will be marrying the clan chief’s handsome son.', 'available'),
(5, 'lib005', 'Dirt Dealers', 500, 'lib5.jpg', 'A.W. Kaylen', '\"A sex scandal. A string of murders. A top secret no one is allowed to know.A seemingly ordinary murder case is assigned to young FBI Special Agent Heather Chase.Little does she know she is about to walk into a dangerous web of deceptions and lies…Why is the FBI involved? The NYPD has plenty of talent.', 'available'),
(6, 'lib006', 'His Burning Desire', 500, 'lib6.jpg', 'Valerie Twombly', '\"Dragon shifter Connor O’Rourke loves his life as a firefighter, but one thing remains missing. His mate. She left him high and dry with only a note and the memory of her kiss. When several mysterious arsons are committed in Dallas, the shifter is called in to investigate and discovers Jenna working at the local firehouse.', 'available'),
(7, 'lib007', 'Billionaire Boss Protector', 500, 'lib7.jpg', 'Tessa Sloan', '\"I’m secretly in love with the man who’s been protecting me for the past 3 years, But he sees me as nothing more than a liability.Derik Lewis is insufferable. Cold. Despotic.If he were only my boss, life would be agonizing enough.But he’s more than that.He’s my guardian and mentor.My grandfather appointed him to watch over me until I’m ready to take over the family business.I shouldn’t want him, but I can’t stop myself.Neither can he.', 'available'),
(8, 'lib008', 'The Making of a Matchmaker', 500, 'lib8.jpg', 'Tess Thompson', '\"In the fall of 1910, a violent patriarch with many enemies is murdered, freeing his long-suffering wife and four misfit children. Can a secret matchmaking plan find love for the eccentric members of the Tutheridge family?', 'available'),
(9, 'lib009', 'Uncovering Lily', 500, 'lib9.jpg', 'Rene Webb', '\"While studying abroad, I was drugged, kidnapped, and imprisoned . . . in a Hong Kong brothel. After several failed attempts to escape, I know my time is running out. My innocence is about to be sold to the highest bidder.', 'available'),
(10, 'lib010', 'Whiskey Witches', 500, 'lib10.jpg', 'Frankie Blooding', 'A string of occult murders. A witch with no powers. The fun never ends. Detective Paige Whiskey is the only Whiskey Witch without powers. Or is she? When she’s called to St. Francisville, Louisiana to solve a series of occult murders, her world is forever changed. She discovers that demons are real and uncovers a secret about her past that could destroy her family. Together with demon hunter,', 'available'),
(11, 'lib011', 'Olivia, Mourning', 500, 'lib11.jpg', 'Yael Politis', 'Olivia wants the 80 acres in far off Michigan that her father left to whichever of his offspring stakes a claimThe problem: shes seventeen, female, and its 1841.', 'unaivalable'),
(12, 'lib012', 'Loving His Workout', 500, 'lib12.jpg', 'Bree Weeks', 'Van: Evie Evans is the hottest woman I’ve ever seen. With her nonstop curves and flaming red hair, I can’t keep her out of my thoughts. My mortal enemy is lurking nearby, and I have a secret mission that must succeed, but nothing is going to keep me from making her mine.', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(100) NOT NULL,
  `orderid` int(100) NOT NULL,
  `MerchantRequestID` varchar(100) NOT NULL,
  `CheckoutRequestID` varchar(100) NOT NULL,
  `ResultCode` int(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `MpesaReceiptNumber` varchar(100) NOT NULL,
  `phonenumber` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `romancebooks`
--

CREATE TABLE `romancebooks` (
  `id` int(100) NOT NULL,
  `serialnumber` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `booklocation` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `romancebooks`
--

INSERT INTO `romancebooks` (`id`, `serialnumber`, `name`, `booklocation`, `image`) VALUES
(1, 'rom001', 'healing her heart', 'pdfs/Healing-Her-Heart.pdf', 'rom1.jpg'),
(2, 'rom002', 'don quixote', 'pdfs/Don-Quixote.pdf', 'rom2.jpg'),
(3, 'rom003', 'anna karenina', 'pdfs/Anna-Karenina.pdf', 'rom3.jpg'),
(4, 'rom004', 'when we let go', 'pdfs/When-We-Let-Go.pdf', 'rom5.jpg'),
(5, 'rom005', 'dark desire', 'pdfs/Dark-Desire.pdf', 'rom6.jpg'),
(6, 'rom006', 'fly away home', 'pdfs/Fly-Away-Home.pdf', 'rom7.jpg'),
(7, 'rom007', 'lost to you', 'pdfs/Lost-to-You.pdf', 'rom4.jpg'),
(8, 'rom008', 'call it chemistry', 'pdfs/Call-It-Chemistry.pdf', 'rom8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tommboyalibraryusers`
--

CREATE TABLE `tommboyalibraryusers` (
  `id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `Useremail` varchar(100) NOT NULL,
  `phoneno` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tommboyalibraryusers`
--

INSERT INTO `tommboyalibraryusers` (`id`, `username`, `Useremail`, `phoneno`, `password`) VALUES
(1, 'fred', 'fredkush6@gmail.com', '10191119911', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `trendingbooks`
--

CREATE TABLE `trendingbooks` (
  `id` int(100) NOT NULL,
  `serialnumber` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `booklocation` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trendingbooks`
--

INSERT INTO `trendingbooks` (`id`, `serialnumber`, `name`, `booklocation`, `image`) VALUES
(1, 'tre001', 'why is everyone always picking on me', 'pdfs/Why-is-Everyone-Always-Picking-on-Me.pdf', 'mist.jpg'),
(2, 'tre002', 'emma', 'pdfs/Emma.pdf', 'mist2.jpg'),
(3, 'tre003', 'a darker shade of sorcery', 'pdfs/A-Darker-Shade-of-Sorcery.pdf', 'mist3.jpg'),
(4, 'tre004', 'winter trials', 'pdfs/Winter-Trials-Northern-Witch-1.pdf', 'mist5.jpg'),
(5, 'tre005', 'Adamant', 'pdfs/Adamant.pdf', 'mist7.jpg'),
(7, 'tre006', 'sound of sirens', 'pdfs/Sound-of-Sirens.pdf', 'mist6.jpg'),
(8, 'tre007', 'dreamthief', 'pdfs/Dreamthief.pdf', 'mist4.jpg'),
(9, 'tre008', 'the witch\'s tower', 'pdfs/The-Witch\'s-Tower.pdf', 'mist8.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrowedbooks`
--
ALTER TABLE `borrowedbooks`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `deliverystaff`
--
ALTER TABLE `deliverystaff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horrorbooks`
--
ALTER TABLE `horrorbooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kidsbooks`
--
ALTER TABLE `kidsbooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `librarybooks`
--
ALTER TABLE `librarybooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `romancebooks`
--
ALTER TABLE `romancebooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tommboyalibraryusers`
--
ALTER TABLE `tommboyalibraryusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trendingbooks`
--
ALTER TABLE `trendingbooks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `borrowedbooks`
--
ALTER TABLE `borrowedbooks`
  MODIFY `order_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `deliverystaff`
--
ALTER TABLE `deliverystaff`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `horrorbooks`
--
ALTER TABLE `horrorbooks`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `kidsbooks`
--
ALTER TABLE `kidsbooks`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `librarybooks`
--
ALTER TABLE `librarybooks`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `romancebooks`
--
ALTER TABLE `romancebooks`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tommboyalibraryusers`
--
ALTER TABLE `tommboyalibraryusers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trendingbooks`
--
ALTER TABLE `trendingbooks`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
