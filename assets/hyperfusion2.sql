-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2024 at 09:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hyperfusion`
--

-- --------------------------------------------------------

--
-- Table structure for table `gamedetails`
--

CREATE TABLE `gamedetails` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `rating` decimal(3,1) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `age_rating` varchar(10) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `image_left` varchar(255) DEFAULT NULL,
  `image_one` varchar(255) DEFAULT NULL,
  `image_two` varchar(255) DEFAULT NULL,
  `image_three` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gamedetails`
--

INSERT INTO `gamedetails` (`id`, `name`, `description`, `rating`, `price`, `age_rating`, `size`, `genre`, `youtube_link`, `image_left`, `image_one`, `image_two`, `image_three`) VALUES
(1, 'EA FC 25', 'Step into the beautiful game with EA FC 25, the latest installment in the globally acclaimed EA Sports football franchise. Building on the legacy of its predecessors, EA FC 25 offers a revolutionary gameplay experience, delivering unparalleled realism and excitement on the pitch.\n\nWith the most advanced football simulation engine, EA FC 25 features updated player rosters, enhanced graphics, and innovative gameplay mechanics that allow players to experience football like never before.\n\nFEATURES:\n\nTeam up with 5v5 Rush: A new way to play with friends in Football Ultimate Team, Clubs, and Kick-Off with small-sided gameplay. In Football Ultimate Team Rush, build your dream 5-a-side squad with up to three friends, each controlling your favourite Player Item, or take on the world with the teammates you trust the most in Clubs Rush.\n\nGet your team playing like the world’s best with FC IQ: An overhaul of tactical foundations across the game delivers greater strategic control and more realistic collective movement at the team level, while a new AI model, powered by real-world data, influences player tactics through all-new Player Roles. FC IQ introduces systems used by football’s top tacticians and modernises the football IQ of every player on the pitch, resulting in your whole team thinking and behaving more like real-world pros.\n\nFor the first time, play an authentic Women’s Career experience: Take control of a club or player from the top five women’s leagues. Plus, rewrite the stories of ICONs from the past, including Thierry Henry and Andrea Pirlo, with the clubs of today in Player Career; or play with the stars of tomorrow in 5v5 Rush tournaments as part of a completely revamped Youth Academy.\n\nPlay, win, and progress with friends in more ways than ever before with Clubs: Connect with club mates in your all-new personalised Clubhouse and see your friends’ avatars when they enter the mode. Take your club to new heights and unlock game-changing opportunities with Facilities. Showcase your skills in Clubs Rush, the fast-paced small-sided football experience that gives you and your club the chance to prove your talent and take home exciting seasonal rewards.\n\nEnjoy more ways to build your dream squad: Play Football Ultimate Team with the best past and present players from across The World’s Game. Select your favourite Player Item and team up with friends to hit the pitch together in new small-sided 5v5 Rush matches, switch up your style of play with the click of a button by employing Manager Items and implementing their real-world tactical preferences, and unlock the full potential of your squad by finding the perfect Player Item with the Player Role that matches best how you want to play.\n\nADDITIONAL INFORMATION:\n\nGame Title: EA FC 25\nGenre: Sports, Soccer (Football)\nPlatform: PlayStation 5, PlayStation 4, Xbox Series X|S, Xbox One, PC, Nintendo Switch\nRelease Date: September 29, 2023\nDeveloped by: EA Sports\nPublisher: EA Sports\nRating: E for Everyone (ESRB)\n', 4.8, 4999.00, 'E', '40GB', 'Sport', 'https://www.youtube.com/embed/TXSFuUXPtP4', 'assets/images/fifaleft.jpg', 'assets/images/fifaimgone.avif', 'assets/images/fifaimgtwo.avif', 'assets/images/fifaimgthree.avif'),
(2, 'Elden Ring', 'Embark on an epic journey of discovery and conquest with Elden Ring on PlayStation 5, a groundbreaking action RPG crafted by FromSoftware and George R.R. Martin. Built for the immersive power of the PS5, Elden Ring brings breathtaking visuals, expansive gameplay, and intricate storytelling to your screen, offering a gaming experience that’s as demanding as it is rewarding.\r\n\r\nGame Features:\r\n\r\nRichly Crafted Open World\r\nExplore the Lands Between, a vast and meticulously designed world filled with sprawling landscapes, towering castles, and unique biomes. Traverse mountains, forests, and desolate ruins while uncovering secrets, lore, and challenges that redefine open-world exploration.\r\n\r\nNext-Gen Visuals and Performance\r\nHarnessing the power of the PS5, Elden Ring runs at 60 FPS with 4K resolution, delivering stunning graphics and seamless gameplay transitions. Real-time ray tracing, HDR support, and faster load times enhance immersion in every battle and every breathtaking vista.\r\n\r\nDeep and Strategic Combat System\r\nEquip a variety of weapons, spells, and combat styles, and master each with precision. Engage in strategic combat with options for stealth, magic, and brutal melee. From weapon-wielding warriors to spellcasting mages, every build has a path to dominance.\r\n\r\nDynamic Day-Night Cycle and Weather\r\nEncounter a world that reacts to your journey, with real-time weather effects and day-night cycles that impact enemy behavior and exploration opportunities. Experience atmospheric changes that add depth and unpredictability to your adventure.\r\n\r\nMultiplayer and Cooperative Play\r\nJoin forces with other players online in Elden Ring’s multiplayer mode. Summon friends or other players for cooperative gameplay to conquer challenging bosses and discover hidden areas, or face off against others in thrilling PvP battles.\r\n\r\nAdditional Details:\r\n\r\nDeveloper: FromSoftware Inc.\r\nPublisher: Bandai Namco Entertainment\r\nPlatform: PlayStation 5\r\nGenre: Action RPG, Open World\r\nRelease Date: February 25, 2022\r\nESRB Rating: M for Mature (Blood and Gore, Intense Violence, Suggestive Themes, Language)\r\nAge Restriction: 17+ (due to Mature Content)', 4.8, 4999.00, '17+', 'PS5', 'Action', 'https://www.youtube.com/embed/qDNq9f_UpRw', 'assets/images/eldenringleft.jpg', 'assets/images/ELDENRINGone.webp', 'assets/images/ELDENRINGtwo.webp', 'assets/images/ELDENRINGthree.webp'),
(3, 'Spider-Man 2', 'Experience the adventure with Spider-Man as he battles against new villains in NYC.', 4.9, 4999.00, '16+', '80GB', 'Action', 'https://www.youtube.com/embed/nq1M_Wc4FIc', 'assets/images/spidermanleft.webp', 'assets/images/spidermanone.webp', 'assets/images/spidermantwo.webp', 'assets/images/spidermanthree.webp'),
(4, 'Final Fantasy XVI', 'A fantastical journey with magic and monsters in the latest installment of the series.', 4.7, 4999.00, '16+', '90GB', 'RPG', 'https://www.youtube.com/embed/aPT26Dd3OzE', 'assets/images/Final_Fantasy_XVIleft.webp', 'assets/images/Final_Fantasy_XVIone.webp', 'assets/images/Final_Fantasy_XVItwo.webp', 'assets/images/Final_Fantasy_XVIthree.webp'),
(5, 'Ratchet & Clank: Rift Apart', 'Explore multiple dimensions with Ratchet and Clank on an epic intergalactic journey.', 4.8, 4799.00, '12+', '50GB', 'Action', 'https://www.youtube.com/embed/55PRv_e00wc', 'assets/images/RatchetClankRiftApartleft.jpg', 'assets/images/RatchetClankRiftApartone.webp', 'assets/images/RatchetClankRiftAparttwo.webp', 'assets/images/RatchetClankRiftApartthree.webp'),
(6, 'God of War: Ragnarok', 'Kratos returns with Atreus, facing new challenges in the Norse world in this epic sequel.', 4.9, 4999.00, '18+', '90GB', 'Action', 'https://www.youtube.com/embed/hfJ4Km46A-0', 'assets/images/GodofWarRagnarokleft.jpg', 'assets/images/GodofWarRagnarokone.webp', 'assets/images/GodofWarRagnaroktwo.webp', 'assets/images/GodofWarRagnarokthree.webp'),
(7, 'Demon’s Souls', 'A challenging dark fantasy adventure, remade for the PS5 in stunning graphics.', 4.8, 4999.00, '18+', '80GB', 'RPG', 'https://www.youtube.com/embed/qjZIw0VUezU', 'assets/images/Demon’s_Soulsleft.webp', 'assets/images/Demon’s_Soulsone.webp', 'assets/images/Demon’s_Soulstwo.webp', 'assets/images/Demon’s_Soulsthree.webp'),
(8, 'Resident Evil Village', 'Enter a horror-filled European village to uncover dark secrets in this survival horror game.', 4.6, 4999.00, '18+', '40GB', 'Horror', 'https://www.youtube.com/embed/dRpXEc-EJow', 'assets/images/Resident_Evil_Villageleft.webp', 'assets/images/Resident_Evil_Villageone.webp', 'assets/images/Resident_Evil_Villagetwo.webp', 'assets/images/Resident_Evil_Villagethree.webp'),
(9, 'Ghost of Tsushima', 'Join Jin Sakai as he defends Tsushima from Mongol invaders in a beautiful open world.', 4.9, 4999.00, '18+', '60GB', 'Adventure', 'https://www.youtube.com/embed/A5gVt028Hww', 'assets/images/Ghost_of_Tsushimaleft.jpg', 'assets/images/Ghost_of_Tsushimaone.webp', 'assets/images/Ghost_of_Tsushimatwo.webp', 'assets/images/Ghost_of_Tsushimathree.webp'),
(10, 'Horizon Forbidden West', 'Explore a lush post-apocalyptic world full of robotic creatures in this action RPG.', 4.8, 4999.00, '16+', '90GB', 'Action', 'https://www.youtube.com/embed/Lq594XmpPBg', 'assets/images/Horizon_Forbidden_Westleft.jpg', 'assets/images/Horizon_Forbidden_Westone.webp', 'assets/images/Horizon_Forbidden_Westtwo.webp', 'assets/images/Horizon_Forbidden_Westthree.webp'),
(11, 'Gran Turismo 7', 'Experience the ultimate driving simulation with realistic graphics and physics.', 4.7, 4999.00, 'E', '110GB', 'Racing', 'https://www.youtube.com/embed/1tBUsXIkG1A', 'assets/images/Gran_Turismo_7left.jpg', 'assets/images/Gran_Turismo_7one.webp', 'assets/images/Gran_Turismo_7two.webp', 'assets/images/Gran_Turismo_7three.webp'),
(12, 'NBA 2K24', 'Step onto the court in this basketball simulation with realistic gameplay and graphics.', 4.5, 4999.00, 'E', '60GB', 'Sport', 'https://www.youtube.com/embed/7t0IQisJubM', 'assets/images/NBA_2K24left.jpg', 'assets/images/NBA_2K24one.webp', 'assets/images/NBA_2K24two.webp', 'assets/images/NBA_2K24three.webp'),
(13, 'Call of Duty: Modern Warfare II', 'Engage in tactical warfare with high-intensity missions worldwide.', 4.7, 4999.00, '18+', '100GB', 'Shooter', 'https://www.youtube.com/embed/Ryk-xxXiwVU', 'assets/images/Call_of_Duty_Modern_Warfare_IIleft.jpg', 'assets/images/Call_of_Duty_Modern_Warfare_IIone.webp', 'assets/images/Call_of_Duty_Modern_Warfare_IItwo.webp', 'assets/images/Call_of_Duty_Modern_Warfare_IIthree.webp'),
(14, 'Assassins Creed Valhalla', 'Live the saga of a Viking warrior on a quest for glory and adventure.', 4.6, 4999.00, '18+', '100GB', 'Action', 'https://www.youtube.com/embed/6TXx0guC5zE', 'assets/images/Assassin\'s_Creed_Valhallaleft.jpg', 'assets/images/Assassin\'s_Creed_Valhallaone.webp', 'assets/images/Assassin\'s_Creed_Valhallatwo.webp', 'assets/images/Assassin\'s_Creed_Valhallathree.webp'),
(15, 'Returnal', 'Survive a hostile alien world where death resets the cycle in this roguelike shooter.', 4.5, 4999.00, '16+', '80GB', 'Shooter', 'https://www.youtube.com/embed/ov4fJmGCsZM', 'assets/images/Returnalleft.webp', 'assets/images/Returnalone.webp', 'assets/images/Returnaltwo.webp', 'assets/images/Returnalthree.webp'),
(16, 'Deathloop', 'A unique first-person shooter where players are trapped in a time loop, unraveling mysteries.', 4.7, 4999.00, '17+', '60GB', 'Shooter', 'https://www.youtube.com/embed/FxgwIP4Cqpc', 'assets/images/Deathloopleft.jpg', 'assets/images/Deathloopone.webp', 'assets/images/Deathlooptwo.webp', 'assets/images/Deathloopthree.webp'),
(17, 'Bloodborne', 'A brutal, dark fantasy RPG set in the haunting city of Yharnam.', 4.9, 4999.00, '18+', '50GB', 'RPG', 'https://www.youtube.com/embed/G203e1HhixY', 'assets/images/Bloodborneleft.jpg_large', 'assets/images/Bloodborneone.jpg', 'assets/images/Bloodbornetwo.webp', 'assets/images/Bloodbornethree.avif'),
(18, 'Cyberpunk 2077', 'Enter the cyberpunk world of Night City with endless customization and story possibilities.', 4.5, 4999.00, '18+', '120GB', 'RPG', 'https://www.youtube.com/embed/Y4x_FjuwV4M', 'assets/images/Cyberpunk_2077left.png', 'assets/images/Cyberpunk_2077one.webp', 'assets/images/Cyberpunk_2077two.webp', 'assets/images/Cyberpunk_2077three.webp'),
(19, 'The Last of Us Part I', 'Experience an emotional story of survival and humanity in a post-apocalyptic world.', 4.9, 4999.00, '18+', '80GB', 'Adventure', 'https://www.youtube.com/embed/R2Ebc_OFeug', 'assets/images/The_Last_of_Us_Part_Ileft.jpg', 'assets/images/The_Last_of_Us_Part_Ione.webp', 'assets/images/The_Last_of_Us_Part_Itwo.webp', 'assets/images/The_Last_of_Us_Part_Ithree.webp'),
(20, 'Uncharted: Legacy of Thieves Collection', 'Follow Nathan Drake\'s adventures in breathtaking environments.', 4.7, 4999.00, '16+', '80GB', 'Adventure', 'https://www.youtube.com/embed/F3Wl-OiZCO4', 'assets/images/Uncharted_Legacy_of_Thieves_Collectionleft.jpg', 'assets/images/Uncharted_Legacy_of_Thieves_Collectionone.webp', 'assets/images/Uncharted_Legacy_of_Thieves_Collectiontwo.webp', 'assets/images/Uncharted_Legacy_of_Thieves_Collectionthree.webp'),
(21, 'Sackboy: A Big Adventure', 'Join Sackboy in a fun and family-friendly 3D platforming adventure.', 4.5, 3999.00, 'E', '30GB', 'Platformer', 'https://www.youtube.com/embed/ZOk3fj5ujNM', 'assets/images/Sackboy_A_Big_Adventureleft.jpg', 'assets/images/Sackboy_A_Big_Adventureone.webp', 'assets/images/Sackboy_A_Big_Adventuretwo.webp', 'assets/images/Sackboy_A_Big_Adventurethree.webp'),
(22, 'Astro’s Playroom', 'Explore the delightful and creative world of Astro in this pre-installed PS5 adventure.', 4.8, 0.00, 'E', '10GB', 'Platformer', 'https://www.youtube.com/embed/lu5VXrEqgco', 'assets/images/Astro’s_Playroomleft.jpg', 'assets/images/Astro’s_Playroomone.webp', 'assets/images/Astro’s_Playroomtwo.webp', 'assets/images/Astro’s_Playroomthree.webp'),
(23, 'Stray', 'Play as a stray cat in a cybercity full of robots, solving puzzles and discovering secrets.', 4.6, 2999.00, '12+', '20GB', 'Adventure', 'https://www.youtube.com/embed/hrdf44z4VWo', 'assets/images/Strayleft.jpg', 'assets/images/Strayone.webp', 'assets/images/Straytwo.webp', 'assets/images/Straythree.webp'),
(24, 'Kena: Bridge of Spirits', 'Embark on a magical journey to help spirits find peace in this action-adventure game.', 4.7, 3999.00, '12+', '25GB', 'Adventure', 'https://www.youtube.com/embed/pWh5388AEHw', 'assets/images/Kena_Bridge_of_Spiritsleft.jpg', 'assets/images/Kena_Bridge_of_Spiritsone.webp', 'assets/images/Kena_Bridge_of_Spiritstwo.webp', 'assets/images/Kena_Bridge_of_Spiritsthree.webp'),
(25, 'FIFA 24', 'Step onto the field with the latest FIFA game, featuring updated teams and players.', 4.5, 4999.00, 'E', '45GB', 'Sport', 'https://www.youtube.com/embed/krYdcYcRuV4', 'assets/images/FIFA_24left.png', 'assets/images/FIFA_24one.webp', 'assets/images/FIFA_24two.webp', 'assets/images/FIFA_24three.webp'),
(26, 'Hitman 3', 'Become Agent 47 and execute contracts in exotic locations with creative assassination options.', 4.6, 4999.00, '18+', '80GB', 'Stealth', 'https://www.youtube.com/embed/NsJyTTsp-PE', 'assets/images/Hitman_3left.webp', 'assets/images/Hitman_3one.webp', 'assets/images/Hitman_3two.webp', 'assets/images/Hitman_3three.webp'),
(27, 'Little Nightmares II', 'Explore a creepy world filled with disturbing creatures in this horror platformer.', 4.5, 2999.00, '16+', '15GB', 'Horror', 'https://www.youtube.com/embed/y1UtH4KG6Xc', 'assets/images/Little_Nightmares_IIleft.jpg', 'assets/images/Little_Nightmares_IIone.webp', 'assets/images/Little_Nightmares_IItwo.webp', 'assets/images/Little_Nightmares_IIthree.webp'),
(28, 'Nioh 2', 'Fight mythological creatures in this action RPG inspired by Japanese folklore.', 4.6, 4999.00, '18+', '85GB', 'Action', 'https://www.youtube.com/embed/hHt30e-r-G8', 'assets/images/Nioh_2left.jpg', 'assets/images/Nioh_2one.webp', 'assets/images/Nioh_2two.webp', 'assets/images/Nioh_2three.webp'),
(29, 'Marvel’s Avengers', 'Assemble a team of Earth’s mightiest heroes and save the world from peril.', 4.0, 3999.00, '16+', '100GB', 'Action', 'https://www.youtube.com/embed/PVrpbeVnRcQ', 'assets/images/Marvel’s_Avengersleft.webp', 'assets/images/Marvel’s_Avengersone.webp', 'assets/images/Marvel’s_Avengerstwo.webp', 'assets/images/Marvel’s_Avengersthree.webp'),
(30, 'The Pathless', 'Embark on a journey with an archer and an eagle to lift a curse from an island.', 4.4, 2999.00, '12+', '18GB', 'Adventure', 'https://www.youtube.com/embed/p8roBoKS98M', 'assets/images/The_Pathlessleft.webp', 'assets/images/The_Pathlessone.webp', 'assets/images/The_Pathlesstwo.webp', 'assets/images/The_Pathlessthree.webp'),
(31, 'Mortal Kombat 11', 'Fight brutal battles with iconic characters in the latest installment of this series.', 4.7, 4999.00, '18+', '45GB', 'Fighting', 'https://www.youtube.com/embed/D2wkVrkPeu4', 'assets/images/Mortal_Kombat_11left.webp', 'assets/images/Mortal_Kombat_11one.webp', 'assets/images/Mortal_Kombat_11two.webp', 'assets/images/Mortal_Kombat_11three.webp'),
(32, 'Dirt 5', 'Race across a variety of challenging tracks with dynamic weather and diverse terrains.', 4.3, 3999.00, 'E', '60GB', 'Racing', 'https://www.youtube.com/embed/rPIj7Lxi-Q8', 'assets/images/Dirt_5left.webp', 'assets/images/Dirt_5one.webp', 'assets/images/Dirt_5two.webp', 'assets/images/Dirt_5three.webp'),
(33, 'Black Myth Wukong', 'Skate through iconic locations with enhanced graphics and new gameplay modes.', 4.8, 2999.00, '12+', '20GB', 'Adventure', 'https://www.youtube.com/embed/pnSsgRJmsCc', 'assets/images/blackleft.webp', 'assets/images/blackone.webp', 'assets/images/blacktwo.webp', 'assets/images/blackthree.webp'),
(34, 'WRC 10', 'Experience the excitement of rally racing with realistic physics and official cars.', 4.5, 3999.00, 'E', '35GB', 'Racing', 'https://www.youtube.com/embed/RWzzZwNSLzM', 'assets/images/WRC_10left.webp', 'assets/images/WRC_10one.webp', 'assets/images/WRC_10two.webp', 'assets/images/WRC_10three.webp'),
(35, 'Overcooked! All You Can Eat', 'Cooperate with friends to cook and serve in this chaotic kitchen simulator.', 4.6, 2999.00, 'E', '10GB', 'Simulation', 'https://www.youtube.com/embed/H-FR-apUaX0', 'assets/images/Overcooked!_All_You_Can_Eatleft.webp', 'assets/images/Overcooked!_All_You_Can_Eatone.webp', 'assets/images/Overcooked!_All_You_Can_Eattwo.webp', 'assets/images/Overcooked!_All_You_Can_Eatthree.webp'),
(36, 'Maquette', 'Solve mind-bending puzzles in a recursive world where everything is both large and small.', 4.2, 1999.00, 'E', '15GB', 'Puzzle', 'https://www.youtube.com/embed/Qtc42zk8RFc', 'assets/images/Maquetteleft.webp', 'assets/images/Maquetteone.webp', 'assets/images/Maquetttwo.webp', 'assets/images/Maquette_three.webp'),
(37, 'Destruction AllStars', 'Compete in high-octane vehicular combat in this action-packed multiplayer game.', 4.1, 2999.00, '12+', '45GB', 'Action', 'https://www.youtube.com/embed/nNO1k5NCDOk', 'assets/images/Destruction_AllStarsleft.webp', 'assets/images/Destruction_AllStarsone.webp', 'assets/images/Destruction_AllStarstwo.webp', 'assets/images/Destruction_AllStarsthree.webp'),
(38, 'Hades', 'Battle through the Underworld in this rogue-like dungeon crawler with Greek mythology.', 4.9, 2999.00, '16+', '15GB', 'RPG', 'https://www.youtube.com/embed/RXq0yBmfiC8', 'assets/images/Hadesleft.webp', 'assets/images/Hadesone.webp', 'assets/images/Hadestwo.webp', 'assets/images/Hadesthree.webp'),
(39, 'Control: Ultimate Edition', 'Uncover the mysteries of the Federal Bureau of Control in this supernatural thriller.', 4.7, 3999.00, '16+', '50GB', 'Action', 'https://www.youtube.com/embed/UISRDU_mzaw', 'assets/images/Control:_Ultimate_Editionleft.webp', 'assets/images/Control:_Ultimate_Editionone.webp', 'assets/images/Control:_Ultimate_Editiontwo.webp', 'assets/images/Control:_Ultimate_Editionthree.webp'),
(40, 'Disco Elysium: The Final Cut', 'Play as a detective in a role-playing game focused on narrative and choices.', 4.8, 3499.00, '18+', '25GB', 'RPG', 'https://www.youtube.com/embed/P-UY6IyI03Q', 'assets/images/Disco_Elysium:_The_Final_Cutleft.webp', 'assets/images/Disco_Elysium:_The_Final_Cutone.webp', 'assets/images/Disco_Elysium:_The_Final_Cuttwo.webp', 'assets/images/Disco_Elysium:_The_Final_Cutthree.webp');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `rating` float NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `name`, `platform`, `rating`, `price`, `image`) VALUES
(1, 'EA FC25', 'PS5', 4.8, 4999.00, 'assets/images/fifa25.jpg'),
(2, 'Elden Ring', 'PS5', 4.8, 2199.00, 'assets/images/eldenring.jpg'),
(3, 'Spider-Man 2', 'PS5', 4.9, 4999.00, 'assets/images/spiderman.png'),
(4, 'Final Fantasy XVI', 'PS5', 4.7, 4999.00, 'assets/images/Final_Fantasy_XVI.jpg'),
(5, 'Ratchet & Clank', 'PS5', 4.8, 4799.00, 'assets/images/RatchetClankRiftApartleft.jpg'),
(6, 'God of War', 'PS5', 4.9, 4999.00, 'assets/images/GodofWarRagnarokleft.jpg'),
(7, 'Demon’s Souls', 'PS5', 4.8, 4999.00, 'assets/images/Demon’s_Soulsleft.webp'),
(8, 'Resident Evil ', 'PS5', 4.6, 4999.00, 'assets/images/Resident_Evil_Villageleft.webp'),
(9, 'Ghost of Tsushima', 'PS5', 4.9, 4999.00, 'assets/images/Ghost_of_Tsushimaleft.jpg'),
(10, 'Horizon FW', 'PS5', 4.8, 4999.00, 'assets/images/Horizon_Forbidden_Westleft2.jpg'),
(11, 'Gran Turismo 7', 'PS5', 4.7, 4999.00, 'assets/images/Gran_Turismo_7left.jpg'),
(12, 'NBA 2K24', 'PS5', 4.5, 4999.00, 'assets/images/NBA_2K24left.jpg'),
(13, 'Call of Duty', 'PS5', 4.7, 4999.00, 'assets/images/Call_of_Duty_Modern_Warfare_IIleft.jpg'),
(14, 'Assassins Creed ', 'PS5', 4.6, 4999.00, 'assets/images/Assassin\'s_Creed_Valhallaleft.jpg'),
(15, 'Returnal', 'PS5', 4.5, 4999.00, 'assets/images/Returnalleft.webp'),
(16, 'Deathloop', 'PS5', 4.7, 4999.00, 'assets/images/Deathloopleft.jpg'),
(17, 'Bloodborne', 'PS5', 4.9, 4999.00, 'assets/images/Bloodborneleft.jpg_large'),
(18, 'Cyberpunk 2077', 'PS5', 4.5, 4999.00, 'assets/images/Cyberpunk_2077left.png'),
(19, 'The Last of Us ', 'PS5', 4.9, 4999.00, 'assets/images/The_Last_of_Us_Part_Ileft.jpg'),
(20, 'Uncharted', 'PS5', 4.7, 4999.00, 'assets/images/Uncharted_Legacy_of_Thieves_Collectionleft.jpg'),
(21, 'Sackboy', 'PS5', 4.5, 3999.00, 'assets/images/Sackboy_A_Big_Adventureleft.jpg'),
(22, 'Astro’s Playroom', 'PS5', 4.8, 0.00, 'assets/images/Astro’s_Playroomleft.jpg'),
(23, 'Stray', 'PS5', 4.6, 2999.00, 'assets/images/Strayleft.jpg'),
(24, 'Kena: B.O.S', 'PS5', 4.7, 3999.00, 'assets/images/Kena_Bridge_of_Spiritsleft.jpg'),
(25, 'FIFA 24', 'PS5', 4.5, 4999.00, 'assets/images/FIFA_24left.png'),
(26, 'Hitman 3', 'PS5', 4.6, 4999.00, 'assets/images/Hitman_3left.webp'),
(27, 'Little Nightmares ', 'PS5', 4.5, 2999.00, 'assets/images/Little_Nightmares_IIleft.jpg'),
(28, 'Nioh 2', 'PS5', 4.6, 4999.00, 'assets/images/Nioh_2left.jpg'),
(29, 'Marvel’s Avengers', 'PS5', 4, 3999.00, 'assets/images/Marvel’s_Avengersleft.webp'),
(30, 'The Pathless', 'PS5', 4.4, 2999.00, 'assets/images/The_Pathlessleft.webp'),
(31, 'Mortal Kombat 11', 'PS5', 4.7, 4999.00, 'assets/images/Mortal_Kombat_11left.webp'),
(32, 'Dirt 5', 'PS5', 4.3, 3999.00, 'assets/images/Dirt_5left.webp'),
(33, 'Black Myth ', 'PS5', 4.8, 2999.00, 'assets/images/blackleft.webp'),
(34, 'WRC 10', 'PS5', 4.5, 3999.00, 'assets/images/WRC_10left.webp'),
(35, 'Overcooked! ', 'PS5', 4.6, 2999.00, 'assets/images/Overcooked!_All_You_Can_Eatleft.webp'),
(36, 'Maquette', 'PS5', 4.2, 1999.00, 'assets/images/Maquetteleft.webp'),
(37, 'Destruction AllStars', 'PS5', 4.1, 2999.00, 'assets/images/Destruction_AllStarsleft.webp'),
(38, 'Hades', 'PS5', 4.9, 2999.00, 'assets/images/Hadesleft.webp'),
(39, 'Control:UE', 'PS5', 4.7, 3999.00, 'assets/images/Control:_Ultimate_Editionleft.webp'),
(40, 'Disco Elysium', 'PS5', 4.8, 3499.00, 'assets/images/Disco_Elysium:_The_Final_Cutleft.webp');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `delivery_charge` decimal(10,2) NOT NULL,
  `location` enum('inside','outside') NOT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `delivery_charge`, `location`, `order_date`) VALUES
(1, 1, 5099.00, 100.00, 'inside', '2024-11-09 07:33:59'),
(2, 1, 30294.00, 300.00, 'outside', '2024-11-09 07:38:47'),
(3, 1, 3599.00, 100.00, 'inside', '2024-11-09 07:46:29'),
(4, 1, 5299.00, 300.00, 'outside', '2024-11-09 07:50:21'),
(5, 1, 15297.00, 300.00, 'outside', '2024-11-09 07:51:12'),
(6, 1, 5299.00, 300.00, 'outside', '2024-11-09 07:53:06'),
(7, 3, 5099.00, 100.00, 'inside', '2024-11-09 10:28:11'),
(8, 4, 14097.00, 100.00, 'inside', '2024-11-10 08:21:49');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 7, 1, 4999.00),
(2, 2, 8, 1, 4999.00),
(3, 2, 18, 2, 4999.00),
(4, 2, 2, 3, 4999.00),
(5, 3, 40, 1, 3499.00),
(6, 4, 8, 1, 4999.00),
(7, 5, 7, 3, 4999.00),
(8, 6, 1, 1, 4999.00),
(9, 7, 11, 1, 4999.00),
(10, 8, 21, 1, 3999.00),
(11, 8, 3, 1, 4999.00),
(12, 8, 8, 1, 4999.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `number` varchar(10) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `google_id`, `created_at`, `updated_at`, `number`, `profile_pic`) VALUES
(1, 'Nikil Maharjan', 'nikilmrz2060@gmail.com', '$2y$10$cQdXUBA8ZSpMPVTRulnHE.LEy3VEG0OdqrCNSy3w4b29e6pTcA9bW', NULL, '2024-11-08 13:53:59', '2024-11-08 13:53:59', '9808325864', NULL),
(3, 'David Maharjan', 'Davidmaharjan012@gmail.com', '$2y$10$6LvmMZomHtZQ4Jq0m01E6OtLHKZcNyrzv8yFnoXoJVTGpUX7pbnG2', NULL, '2024-11-09 10:26:19', '2024-11-09 10:26:19', '9828559530', NULL),
(4, 'Deeya Maharjan', 'Deeyamaharjan@gmail.com', '$2y$10$dneR/OUcityI0e6P38AqI.THQyhK1Mix81DlD/n6sJI9lVsiVf18u', NULL, '2024-11-10 08:20:46', '2024-11-10 08:20:46', '9808325865', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gamedetails`
--
ALTER TABLE `gamedetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `number` (`number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gamedetails`
--
ALTER TABLE `gamedetails`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `gamedetails` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
