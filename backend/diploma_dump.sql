-- MySQL dump 10.13  Distrib 8.1.0, for Win64 (x86_64)
--
-- Host: localhost    Database: diploma
-- ------------------------------------------------------
-- Server version	8.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `black_lists`
--

DROP TABLE IF EXISTS `black_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `black_lists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `violation_count` smallint unsigned NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `black_lists_user_id_index` (`user_id`),
  CONSTRAINT `black_lists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `black_lists`
--

LOCK TABLES `black_lists` WRITE;
/*!40000 ALTER TABLE `black_lists` DISABLE KEYS */;
INSERT INTO `black_lists` VALUES (4,3,1,NULL,NULL,'2025-05-14 04:51:10','2025-05-14 04:51:10');
INSERT INTO `black_lists` VALUES (11,7,1,NULL,NULL,'2025-05-22 10:43:38','2025-05-22 10:43:38');
/*!40000 ALTER TABLE `black_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_genres`
--

DROP TABLE IF EXISTS `book_genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book_genres` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `book_id` bigint unsigned NOT NULL,
  `genre_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_genres_book_id_foreign` (`book_id`),
  KEY `book_genres_genre_id_foreign` (`genre_id`),
  CONSTRAINT `book_genres_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_genres_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_genres`
--

LOCK TABLES `book_genres` WRITE;
/*!40000 ALTER TABLE `book_genres` DISABLE KEYS */;
INSERT INTO `book_genres` VALUES (1,33,51,NULL,NULL);
INSERT INTO `book_genres` VALUES (2,33,52,NULL,NULL);
INSERT INTO `book_genres` VALUES (3,34,56,NULL,NULL);
INSERT INTO `book_genres` VALUES (4,34,47,NULL,NULL);
INSERT INTO `book_genres` VALUES (5,35,50,NULL,NULL);
INSERT INTO `book_genres` VALUES (6,36,61,NULL,NULL);
INSERT INTO `book_genres` VALUES (7,36,43,NULL,NULL);
INSERT INTO `book_genres` VALUES (8,37,61,NULL,NULL);
INSERT INTO `book_genres` VALUES (9,38,50,NULL,NULL);
INSERT INTO `book_genres` VALUES (10,39,45,NULL,NULL);
INSERT INTO `book_genres` VALUES (11,39,53,NULL,NULL);
INSERT INTO `book_genres` VALUES (12,39,49,NULL,NULL);
INSERT INTO `book_genres` VALUES (13,40,55,NULL,NULL);
INSERT INTO `book_genres` VALUES (14,40,57,NULL,NULL);
INSERT INTO `book_genres` VALUES (15,40,58,NULL,NULL);
INSERT INTO `book_genres` VALUES (16,41,52,NULL,NULL);
INSERT INTO `book_genres` VALUES (17,41,51,NULL,NULL);
INSERT INTO `book_genres` VALUES (18,42,59,NULL,NULL);
INSERT INTO `book_genres` VALUES (19,42,54,NULL,NULL);
INSERT INTO `book_genres` VALUES (20,43,56,NULL,NULL);
INSERT INTO `book_genres` VALUES (21,44,50,NULL,NULL);
INSERT INTO `book_genres` VALUES (22,45,50,NULL,NULL);
INSERT INTO `book_genres` VALUES (23,46,54,NULL,NULL);
INSERT INTO `book_genres` VALUES (24,46,59,NULL,NULL);
INSERT INTO `book_genres` VALUES (25,47,50,NULL,NULL);
INSERT INTO `book_genres` VALUES (26,48,60,NULL,NULL);
INSERT INTO `book_genres` VALUES (27,48,48,NULL,NULL);
INSERT INTO `book_genres` VALUES (28,48,56,NULL,NULL);
INSERT INTO `book_genres` VALUES (29,49,49,NULL,NULL);
INSERT INTO `book_genres` VALUES (30,49,53,NULL,NULL);
INSERT INTO `book_genres` VALUES (31,49,45,NULL,NULL);
INSERT INTO `book_genres` VALUES (32,50,50,NULL,NULL);
INSERT INTO `book_genres` VALUES (33,51,52,NULL,NULL);
INSERT INTO `book_genres` VALUES (34,52,50,NULL,NULL);
INSERT INTO `book_genres` VALUES (35,12,2,NULL,NULL);
/*!40000 ALTER TABLE `book_genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_tags`
--

DROP TABLE IF EXISTS `book_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book_tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `book_id` bigint unsigned DEFAULT NULL,
  `tag_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_tags_book_id_index` (`book_id`),
  KEY `book_tags_tag_id_index` (`tag_id`),
  CONSTRAINT `book_tags_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_tags`
--

LOCK TABLES `book_tags` WRITE;
/*!40000 ALTER TABLE `book_tags` DISABLE KEYS */;
INSERT INTO `book_tags` VALUES (1,10,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (3,11,1,NULL,NULL);
INSERT INTO `book_tags` VALUES (4,12,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (5,33,8,NULL,NULL);
INSERT INTO `book_tags` VALUES (6,33,5,NULL,NULL);
INSERT INTO `book_tags` VALUES (7,33,6,NULL,NULL);
INSERT INTO `book_tags` VALUES (8,33,4,NULL,NULL);
INSERT INTO `book_tags` VALUES (9,34,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (10,34,1,NULL,NULL);
INSERT INTO `book_tags` VALUES (11,34,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (12,35,6,NULL,NULL);
INSERT INTO `book_tags` VALUES (13,35,4,NULL,NULL);
INSERT INTO `book_tags` VALUES (14,36,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (15,36,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (16,36,5,NULL,NULL);
INSERT INTO `book_tags` VALUES (17,36,4,NULL,NULL);
INSERT INTO `book_tags` VALUES (18,36,6,NULL,NULL);
INSERT INTO `book_tags` VALUES (19,37,4,NULL,NULL);
INSERT INTO `book_tags` VALUES (20,37,6,NULL,NULL);
INSERT INTO `book_tags` VALUES (21,37,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (22,37,5,NULL,NULL);
INSERT INTO `book_tags` VALUES (23,37,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (24,38,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (25,38,6,NULL,NULL);
INSERT INTO `book_tags` VALUES (26,38,5,NULL,NULL);
INSERT INTO `book_tags` VALUES (27,38,8,NULL,NULL);
INSERT INTO `book_tags` VALUES (28,39,1,NULL,NULL);
INSERT INTO `book_tags` VALUES (29,39,5,NULL,NULL);
INSERT INTO `book_tags` VALUES (30,40,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (31,40,5,NULL,NULL);
INSERT INTO `book_tags` VALUES (32,41,6,NULL,NULL);
INSERT INTO `book_tags` VALUES (33,41,1,NULL,NULL);
INSERT INTO `book_tags` VALUES (34,41,8,NULL,NULL);
INSERT INTO `book_tags` VALUES (35,42,8,NULL,NULL);
INSERT INTO `book_tags` VALUES (36,42,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (37,43,4,NULL,NULL);
INSERT INTO `book_tags` VALUES (38,43,1,NULL,NULL);
INSERT INTO `book_tags` VALUES (39,44,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (40,44,6,NULL,NULL);
INSERT INTO `book_tags` VALUES (41,44,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (42,44,8,NULL,NULL);
INSERT INTO `book_tags` VALUES (43,45,5,NULL,NULL);
INSERT INTO `book_tags` VALUES (44,45,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (45,45,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (46,46,5,NULL,NULL);
INSERT INTO `book_tags` VALUES (47,46,1,NULL,NULL);
INSERT INTO `book_tags` VALUES (48,46,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (49,46,6,NULL,NULL);
INSERT INTO `book_tags` VALUES (50,47,8,NULL,NULL);
INSERT INTO `book_tags` VALUES (51,47,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (52,47,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (53,47,4,NULL,NULL);
INSERT INTO `book_tags` VALUES (54,47,1,NULL,NULL);
INSERT INTO `book_tags` VALUES (55,48,8,NULL,NULL);
INSERT INTO `book_tags` VALUES (56,48,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (57,48,6,NULL,NULL);
INSERT INTO `book_tags` VALUES (58,48,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (59,48,5,NULL,NULL);
INSERT INTO `book_tags` VALUES (60,49,6,NULL,NULL);
INSERT INTO `book_tags` VALUES (61,49,1,NULL,NULL);
INSERT INTO `book_tags` VALUES (62,49,5,NULL,NULL);
INSERT INTO `book_tags` VALUES (63,49,4,NULL,NULL);
INSERT INTO `book_tags` VALUES (64,49,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (65,50,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (66,50,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (67,50,4,NULL,NULL);
INSERT INTO `book_tags` VALUES (68,50,1,NULL,NULL);
INSERT INTO `book_tags` VALUES (69,51,6,NULL,NULL);
INSERT INTO `book_tags` VALUES (70,51,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (71,51,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (72,52,5,NULL,NULL);
INSERT INTO `book_tags` VALUES (73,52,2,NULL,NULL);
INSERT INTO `book_tags` VALUES (74,52,8,NULL,NULL);
INSERT INTO `book_tags` VALUES (75,52,3,NULL,NULL);
INSERT INTO `book_tags` VALUES (76,52,6,NULL,NULL);
/*!40000 ALTER TABLE `book_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `books_category_id_index` (`category_id`),
  CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'Lord of Rings','TestAuthor','TestDesc',NULL,1,'2025-02-23 03:36:48','2025-02-23 03:36:48');
INSERT INTO `books` VALUES (2,'NewBook','NewAuthor','NewDesc',NULL,NULL,'2025-02-23 03:41:10','2025-02-23 03:41:10');
INSERT INTO `books` VALUES (10,'TestBook1','TestAuth1','TestDesc1','books/kUK7ObHtySHbYMIhaJKMwWDp14z0KJ1fiLD0l90Y.webp',2,'2025-02-23 04:07:09','2025-02-23 05:02:17');
INSERT INTO `books` VALUES (11,'aesdasd','asdas','asdasd','covers/Qn7N6PX0d10LIfYM5ZK2JsdUVC2n9a6WnZXyFBNP.png',1,'2025-02-23 05:09:47','2025-02-23 05:09:47');
INSERT INTO `books` VALUES (12,'Harry Potter','J. K. Rowling','test','covers/E78LGG8NBUWzN9nd5QOACWCYku45Op90OFNPaT4E.jpg',3,'2025-05-18 05:38:52','2025-05-20 03:34:54');
INSERT INTO `books` VALUES (33,'Quis veniam qui distinctio.','Hermina Brakus','Adipisci veniam aut animi ea facilis. Odio qui perferendis veritatis eos.',NULL,9,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (34,'Rerum numquam voluptas corrupti.','Newton Kuhic','Dolorem suscipit distinctio quasi eos minima deleniti. Aut neque repellat ea nam quis ab quis ipsa. Perspiciatis ipsam consectetur commodi.',NULL,2,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (35,'Rerum adipisci excepturi aut.','Deangelo Ferry','Assumenda dolore explicabo ut est aliquam. Voluptatum sed consectetur inventore magnam est ut. Libero molestiae quasi amet eius. Nihil libero perferendis molestias sed ratione. Sint veritatis voluptas rerum ipsum.',NULL,1,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (36,'Debitis iure.','Prof. Madyson Schiller Sr.','Ea omnis consectetur quo voluptate modi. Cumque magni cupiditate aliquam inventore dolor magni autem. Minima tempora ut nostrum ab consequatur natus repudiandae.',NULL,4,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (37,'Quia dolorem hic quidem.','Mohamed Fritsch','Sit quae ab quia sunt dolor provident quasi laboriosam. Aut beatae consequatur porro quisquam voluptas velit illo. Odit et minima amet ut.',NULL,4,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (38,'Consequatur laudantium cumque corporis.','Johnathon Grant','Eaque ad ipsa sit. Officiis accusantium atque maiores voluptatem reiciendis recusandae.',NULL,1,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (39,'Voluptas illum.','Brenna Leffler','Aperiam ut perspiciatis ut quis dolorem. Aut accusantium asperiores possimus rerum officiis. Qui qui eius nisi incidunt.',NULL,8,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (40,'Delectus et iure.','Serenity Ernser DDS','Fugiat dolores provident iusto ducimus nisi deleniti. Dicta dolorem voluptatum doloremque consequatur quia molestiae ea. Necessitatibus architecto architecto voluptas ipsa ut nulla. Magnam corrupti ut est quia.',NULL,7,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (41,'Omnis consequatur et explicabo nulla.','Neal Little','Asperiores quas est dolores. Possimus voluptates ducimus tenetur.',NULL,9,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (42,'Ea iure.','Icie Pollich','Eveniet assumenda eum unde ut quasi. Dolorem inventore enim voluptate molestiae cumque voluptatem qui officia. Pariatur adipisci qui ut rerum est.',NULL,5,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (43,'Expedita ullam earum.','Dr. Ara Bergnaum PhD','Architecto ipsum officia ut veritatis accusamus amet in. Sit sit molestias magnam corporis ratione in aut et. Dolores odit non ipsum enim dolorem rerum. Fuga vel unde quasi.',NULL,2,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (44,'Expedita facilis cumque quidem fugit.','Candida Armstrong Sr.','Recusandae in quasi vel. Vero aperiam autem eligendi eum autem repellat. Nostrum similique delectus sequi sed ut quasi. Quasi facere dolorem natus molestiae. Dolor enim et nisi non non nam.',NULL,1,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (45,'Occaecati hic quia quisquam.','Mohammed Johns Sr.','Minima officiis odit repudiandae. Praesentium et possimus rerum quas provident ducimus ad voluptate. Quia velit quae incidunt nostrum.',NULL,1,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (46,'Praesentium eos voluptatem.','Ardith Sipes','Et nisi expedita est harum tempora molestiae rerum laboriosam. Sit minus a corrupti ratione doloremque. Maiores sunt omnis repudiandae et harum facere provident. Ex doloribus odio aut repudiandae.',NULL,5,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (47,'Magni sit cupiditate dolorum.','Prof. Guillermo Rau V','Dolor deserunt ad distinctio assumenda itaque nulla molestias. Sed qui suscipit aut soluta aut voluptas necessitatibus corporis. Omnis est quia omnis doloribus velit ut.',NULL,1,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (48,'Reiciendis magni ut maiores.','John Runolfsson','Eos alias dolore autem autem possimus. Distinctio quia molestiae placeat quia. Nobis sapiente laborum impedit fuga laborum. Eum exercitationem molestiae dolor porro ipsa molestiae sit nesciunt.',NULL,2,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (49,'Quia et inventore hic.','Frederique Prohaska','Sunt est porro dolore distinctio deserunt doloremque. Adipisci laborum quod sunt a et consequuntur dolorem. Labore repudiandae laboriosam ut nemo et porro veniam. Ut consequatur est minima et quae molestiae.',NULL,8,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (50,'Dolore eveniet expedita.','Angie Gleichner PhD','Alias molestiae perspiciatis corporis similique quis. Aspernatur voluptas omnis nihil iste dolore rerum. Aspernatur repellat ut dolore quibusdam error ea hic.',NULL,1,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (51,'Sunt fugit quia.','Harvey Emmerich MD','Illum enim maxime est excepturi. Et ad aut alias aut reiciendis voluptatum ducimus. Nisi debitis aperiam qui quo quas quas. Aut laudantium ut fugiat. Voluptate unde deleniti iure sunt assumenda aliquam sint.',NULL,9,'2025-05-20 04:59:20','2025-05-20 04:59:20');
INSERT INTO `books` VALUES (52,'Quis qui nihil velit.','Wava Graham','Rerum voluptatem ut fugit error et. Aut aspernatur commodi repellendus. Quia autem provident inventore sapiente rerum. Aut recusandae fugiat non nostrum.',NULL,1,'2025-05-20 04:59:20','2025-05-20 04:59:20');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrowed_books`
--

DROP TABLE IF EXISTS `borrowed_books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `borrowed_books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `book_id` bigint unsigned DEFAULT NULL,
  `location_id` bigint unsigned DEFAULT NULL,
  `borrow_check` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `borrowed_at` date NOT NULL,
  `due_date` date NOT NULL,
  `received_at` date DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('borrowed','returned','received') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'borrowed',
  PRIMARY KEY (`id`),
  KEY `borrowed_books_user_id_index` (`user_id`),
  KEY `borrowed_books_book_id_index` (`book_id`),
  KEY `borrowed_books_location_id_index` (`location_id`),
  KEY `borrowed_books_borrow_check_index` (`borrow_check`),
  CONSTRAINT `borrowed_books_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `borrowed_books_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `borrowed_books_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowed_books`
--

LOCK TABLES `borrowed_books` WRITE;
/*!40000 ALTER TABLE `borrowed_books` DISABLE KEYS */;
INSERT INTO `borrowed_books` VALUES (5,3,10,1,'BI9T00OVQM','2025-02-23','2025-03-09','2025-05-14',12,'2025-02-23 16:15:09','2025-05-14 03:25:15','returned');
INSERT INTO `borrowed_books` VALUES (6,3,2,6,'WFQK5O0VEM','2025-02-24','2025-03-10','2025-05-14',6,'2025-02-24 01:17:32','2025-05-14 04:51:10','returned');
INSERT INTO `borrowed_books` VALUES (9,7,12,6,'WHRGLEU9QE','2025-05-21','2025-06-04','2025-05-21',1,'2025-05-21 07:52:34','2025-05-21 07:55:12','returned');
INSERT INTO `borrowed_books` VALUES (10,7,10,5,'7FABODKDET','2025-05-21','2025-05-21','2025-05-22',1,'2025-05-21 08:05:06','2025-05-22 10:26:30','returned');
INSERT INTO `borrowed_books` VALUES (11,7,10,1,'1U8GSAGDDQ','2025-04-22','2025-05-05','2025-05-22',1,'2025-05-22 10:27:19','2025-05-22 10:43:38','returned');
/*!40000 ALTER TABLE `borrowed_books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'TestCat1','2025-02-22 05:25:49','2025-02-23 02:35:09');
INSERT INTO `categories` VALUES (2,'NewCat','2025-02-23 00:04:57','2025-02-23 00:04:57');
INSERT INTO `categories` VALUES (3,'Fiction','2025-05-20 01:34:47','2025-05-20 01:34:47');
INSERT INTO `categories` VALUES (4,'Non-Fiction','2025-05-20 04:52:20','2025-05-20 04:52:20');
INSERT INTO `categories` VALUES (5,'Education','2025-05-20 04:52:20','2025-05-20 23:18:52');
INSERT INTO `categories` VALUES (6,'Biography','2025-05-20 04:52:20','2025-05-20 04:52:20');
INSERT INTO `categories` VALUES (7,'History','2025-05-20 04:52:20','2025-05-20 04:52:20');
INSERT INTO `categories` VALUES (8,'Fantasy','2025-05-20 04:52:20','2025-05-20 04:52:20');
INSERT INTO `categories` VALUES (9,'Mystery','2025-05-20 04:52:20','2025-05-20 04:52:20');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint unsigned NOT NULL,
  `receiver_id` bigint unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_sender_id_foreign` (`sender_id`),
  KEY `chat_messages_receiver_id_foreign` (`receiver_id`),
  CONSTRAINT `chat_messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_messages`
--

LOCK TABLES `chat_messages` WRITE;
/*!40000 ALTER TABLE `chat_messages` DISABLE KEYS */;
INSERT INTO `chat_messages` VALUES (1,7,3,'Hi',1,'2025-05-22 16:16:05','2025-05-22 17:44:18');
INSERT INTO `chat_messages` VALUES (4,7,3,'asdasd',1,'2025-05-22 17:37:19','2025-05-22 17:44:18');
INSERT INTO `chat_messages` VALUES (5,7,3,'asdasd',1,'2025-05-22 17:38:09','2025-05-22 17:44:18');
INSERT INTO `chat_messages` VALUES (6,7,3,'asdasd',1,'2025-05-22 17:38:25','2025-05-22 17:44:18');
INSERT INTO `chat_messages` VALUES (7,7,3,'adasdad',1,'2025-05-22 17:38:49','2025-05-22 17:44:18');
INSERT INTO `chat_messages` VALUES (8,7,3,'adsasda',1,'2025-05-22 17:39:28','2025-05-22 17:44:18');
INSERT INTO `chat_messages` VALUES (9,7,3,'adasda',1,'2025-05-22 17:41:32','2025-05-22 17:44:18');
INSERT INTO `chat_messages` VALUES (10,7,3,'asdasd',1,'2025-05-22 17:42:39','2025-05-22 17:44:18');
INSERT INTO `chat_messages` VALUES (11,7,3,'asdasdasd',1,'2025-05-22 17:43:18','2025-05-22 17:44:18');
INSERT INTO `chat_messages` VALUES (12,3,7,'Hi',1,'2025-05-22 17:44:24','2025-05-23 04:52:05');
/*!40000 ALTER TABLE `chat_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Ms. Rylee Heathcote','rhoda89@example.org','Earth Driller',33656.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (2,'Ellen Kling','predovic.general@example.com','Shipping and Receiving Clerk',97471.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (3,'Else Koelpin II','wolf.logan@example.org','Assessor',87102.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (4,'Miss Aryanna Yost PhD','jlockman@example.net','Actuary',71629.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (5,'Dudley Cummings','abel19@example.net','Hunter and Trapper',54030.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (6,'Eldon Stamm','rex.macejkovic@example.com','Marketing Manager',65977.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (7,'Brown Haley','lela.morissette@example.com','Insurance Investigator',55592.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (8,'Lucas VonRueden Sr.','fkilback@example.com','Vocational Education Teacher',31846.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (9,'Bernadine Sanford','roberts.ricardo@example.org','Engineering Manager',48755.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (10,'Prof. Buster Reichel','jgreenfelder@example.org','Foundry Mold and Coremaker',33667.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (11,'Christopher Shields Sr.','raven.weimann@example.net','Product Specialist',32236.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (12,'Elwyn Toy','fbins@example.net','Garment',54610.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (13,'Monica Dicki','maximo76@example.com','Licensed Practical Nurse',88161.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (14,'Veronica Kassulke','jcartwright@example.com','Rock Splitter',33416.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (15,'Laverne Ernser','drutherford@example.net','Sketch Artist',52747.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (16,'Janiya Lowe','gbernhard@example.net','Product Promoter',78809.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (17,'Adriel Sporer','rtromp@example.net','Head Nurse',39635.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (18,'Miss Bert Funk','brent.mohr@example.org','Pressure Vessel Inspector',85684.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (19,'Patricia Borer','wmarks@example.com','Air Crew Member',35526.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (20,'Dr. Abel Dibbert','owilliamson@example.org','Numerical Control Machine Tool Operator',43509.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (21,'Alene Jacobson','samara84@example.com','Philosophy and Religion Teacher',63236.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (22,'Ms. Eileen Anderson','lysanne.okon@example.net','File Clerk',61541.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (23,'Bailey Kuphal I','alivia.jenkins@example.com','Tool Sharpener',63468.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (24,'Kenyatta Johns','west.rose@example.com','Eligibility Interviewer',69079.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (25,'Elisabeth Ruecker','pcollier@example.net','Interviewer',31097.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (26,'Alysha Stokes','uschiller@example.net','Marine Cargo Inspector',64304.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (27,'Ted Torp','anya.lesch@example.com','Educational Counselor OR Vocationall Counselor',78132.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (28,'Hudson Gorczany Sr.','adrianna28@example.com','Textile Worker',99039.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (29,'Heaven Glover','mose44@example.org','Paralegal',68037.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (30,'Derrick Hermann','karmstrong@example.com','Chemical Equipment Controller',43965.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (31,'Brooklyn Powlowski DVM','lucie41@example.com','Team Assembler',98953.00,'2025-02-10 07:39:20','2025-02-10 07:39:20');
INSERT INTO `employees` VALUES (32,'Frida Becker PhD','jeromy.buckridge@example.net','Gas Pumping Station Operator',44123.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (33,'Madie Runolfsson','mcglynn.sabina@example.net','Aircraft Cargo Handling Supervisor',34683.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (34,'Ian Hermann','destin.watsica@example.com','Manufacturing Sales Representative',58870.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (35,'Prof. Keith O\'Connell MD','thompson.carole@example.com','Driver-Sales Worker',32970.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (36,'Joyce Schmitt','hegmann.philip@example.com','Clergy',37143.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (37,'Forest Smith','dora79@example.com','Human Resource Director',99168.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (38,'Prof. Milan King PhD','wkuhic@example.net','Welding Machine Tender',30529.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (39,'Christ Waelchi','conner34@example.net','Cashier',69884.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (40,'Prof. Breanne Goodwin','bechtelar.ari@example.net','Bartender Helper',94695.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (41,'Billie Wisoky','nikolas.hintz@example.net','Battery Repairer',89722.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (42,'Santos Emmerich','smith.marlin@example.org','Shuttle Car Operator',34264.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (43,'Prof. Broderick Christiansen','greyson.spencer@example.net','Law Enforcement Teacher',50440.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (44,'Randi Wuckert','mireya.hauck@example.net','Aircraft Cargo Handling Supervisor',37757.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (45,'Lila Stracke','uriah79@example.net','Armored Assault Vehicle Crew Member',49358.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (46,'Leda Bednar IV','nlockman@example.org','Sound Engineering Technician',79061.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (47,'Reyes Gislason','aaron.abbott@example.com','Carver',95822.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (48,'Darian Casper','pfannerstill.lonzo@example.org','Tractor-Trailer Truck Driver',32053.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (49,'Adam Yundt PhD','nelda69@example.net','Dispatcher',65400.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
INSERT INTO `employees` VALUES (50,'Trenton Abbott','dalton22@example.net','Food Science Technician',69978.00,'2025-02-10 07:39:21','2025-02-10 07:39:21');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favourites`
--

DROP TABLE IF EXISTS `favourites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favourites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `book_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `favourites_user_id_index` (`user_id`),
  KEY `favourites_book_id_index` (`book_id`),
  CONSTRAINT `favourites_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favourites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favourites`
--

LOCK TABLES `favourites` WRITE;
/*!40000 ALTER TABLE `favourites` DISABLE KEYS */;
INSERT INTO `favourites` VALUES (1,3,10,NULL,NULL);
INSERT INTO `favourites` VALUES (3,3,11,'2025-05-14 21:57:21','2025-05-14 21:57:21');
INSERT INTO `favourites` VALUES (5,3,2,'2025-05-14 23:25:56','2025-05-14 23:25:56');
INSERT INTO `favourites` VALUES (7,7,11,'2025-05-20 00:56:38','2025-05-20 00:56:38');
INSERT INTO `favourites` VALUES (8,7,38,'2025-05-23 12:13:02','2025-05-23 12:13:02');
/*!40000 ALTER TABLE `favourites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendships`
--

DROP TABLE IF EXISTS `friendships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friendships` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint unsigned NOT NULL,
  `recipient_id` bigint unsigned NOT NULL,
  `status` enum('pending','accepted','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `friendships_sender_id_foreign` (`sender_id`),
  KEY `friendships_recipient_id_foreign` (`recipient_id`),
  CONSTRAINT `friendships_recipient_id_foreign` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `friendships_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendships`
--

LOCK TABLES `friendships` WRITE;
/*!40000 ALTER TABLE `friendships` DISABLE KEYS */;
INSERT INTO `friendships` VALUES (1,7,3,'accepted',NULL,NULL);
INSERT INTO `friendships` VALUES (2,3,7,'accepted',NULL,NULL);
INSERT INTO `friendships` VALUES (3,7,2,'accepted','2025-05-22 18:28:25','2025-05-22 18:55:27');
INSERT INTO `friendships` VALUES (4,2,7,'accepted','2025-05-22 18:28:25','2025-05-22 18:55:27');
/*!40000 ALTER TABLE `friendships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genres` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `genres_category_id_name_unique` (`category_id`,`name`),
  CONSTRAINT `genres_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` VALUES (1,3,'Science Fiction','2025-05-20 01:36:52','2025-05-20 01:36:52');
INSERT INTO `genres` VALUES (2,3,'Fantasy','2025-05-20 03:45:20','2025-05-20 03:45:20');
INSERT INTO `genres` VALUES (3,3,'Horror','2025-05-20 03:45:26','2025-05-20 03:45:26');
INSERT INTO `genres` VALUES (4,3,'Romance','2025-05-20 03:45:33','2025-05-20 03:45:33');
INSERT INTO `genres` VALUES (5,3,'Thriller','2025-05-20 03:45:39','2025-05-20 03:45:39');
INSERT INTO `genres` VALUES (42,9,'atque','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (43,4,'Self-Help','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (44,6,'Political Biography','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (45,8,'a','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (46,6,'Literary Biography','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (47,2,'rem','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (48,2,'laboriosam','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (49,8,'mollitia','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (50,1,'ratione','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (51,9,'explicabo','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (52,9,'eos','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (53,8,'et','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (54,5,'Physics','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (55,7,'Military History','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (56,2,'nostrum','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (57,7,'Ancient History','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (58,7,'Cultural History','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (59,5,'Mathematics','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (60,2,'magnam','2025-05-20 04:56:45','2025-05-20 04:56:45');
INSERT INTO `genres` VALUES (61,4,'History','2025-05-20 04:56:45','2025-05-20 04:56:45');
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location_books`
--

DROP TABLE IF EXISTS `location_books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `location_books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `location_id` bigint unsigned DEFAULT NULL,
  `book_id` bigint unsigned DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `location_books_location_id_index` (`location_id`),
  KEY `location_books_book_id_index` (`book_id`),
  CONSTRAINT `location_books_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `location_books_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location_books`
--

LOCK TABLES `location_books` WRITE;
/*!40000 ALTER TABLE `location_books` DISABLE KEYS */;
INSERT INTO `location_books` VALUES (1,1,10,80,NULL,'2025-05-22 10:27:19');
INSERT INTO `location_books` VALUES (2,1,2,205,NULL,'2025-02-23 10:34:26');
INSERT INTO `location_books` VALUES (5,6,2,93,NULL,'2025-05-17 05:27:50');
INSERT INTO `location_books` VALUES (9,4,1,50,NULL,NULL);
INSERT INTO `location_books` VALUES (10,7,1,19,NULL,'2025-05-17 03:11:13');
INSERT INTO `location_books` VALUES (12,5,11,5,NULL,NULL);
INSERT INTO `location_books` VALUES (13,5,10,3,NULL,'2025-05-21 08:05:06');
INSERT INTO `location_books` VALUES (22,1,11,1,NULL,NULL);
INSERT INTO `location_books` VALUES (23,6,12,0,NULL,'2025-05-21 07:52:34');
INSERT INTO `location_books` VALUES (24,4,11,1,NULL,NULL);
INSERT INTO `location_books` VALUES (25,6,11,1,NULL,NULL);
INSERT INTO `location_books` VALUES (26,7,12,20,NULL,NULL);
INSERT INTO `location_books` VALUES (27,6,38,1,NULL,NULL);
INSERT INTO `location_books` VALUES (28,9,12,30,NULL,NULL);
/*!40000 ALTER TABLE `location_books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'NewLoc',50.84757295,71.53417915,'2025-02-23 08:40:52','2025-02-23 09:13:30');
INSERT INTO `locations` VALUES (4,'TestLoc2',51.10605192,71.42823458,'2025-02-24 00:52:36','2025-02-24 00:52:36');
INSERT INTO `locations` VALUES (5,'TestLoc1',51.09940183,71.43156052,'2025-02-24 00:53:24','2025-02-24 00:53:24');
INSERT INTO `locations` VALUES (6,'TestLoc3',51.10998882,71.47653580,'2025-02-24 00:55:06','2025-02-24 00:55:06');
INSERT INTO `locations` VALUES (7,'OpenLib',51.49463427,-0.13139963,'2025-05-16 00:38:44','2025-05-16 00:38:44');
INSERT INTO `locations` VALUES (8,'NewLocation',51.12566903,71.43862009,'2025-05-23 12:17:49','2025-05-23 12:17:49');
INSERT INTO `locations` VALUES (9,'NewLocation',51.12566723,71.43846989,'2025-05-23 12:17:52','2025-05-23 12:17:52');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` VALUES (3,'2016_06_01_000001_create_oauth_auth_codes_table',1);
INSERT INTO `migrations` VALUES (4,'2016_06_01_000002_create_oauth_access_tokens_table',1);
INSERT INTO `migrations` VALUES (5,'2016_06_01_000003_create_oauth_refresh_tokens_table',1);
INSERT INTO `migrations` VALUES (6,'2016_06_01_000004_create_oauth_clients_table',1);
INSERT INTO `migrations` VALUES (7,'2016_06_01_000005_create_oauth_personal_access_clients_table',1);
INSERT INTO `migrations` VALUES (8,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` VALUES (9,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` VALUES (10,'2024_08_14_120736_create_employees_table',1);
INSERT INTO `migrations` VALUES (17,'2013_02_11_102920_create_roles_table',2);
INSERT INTO `migrations` VALUES (26,'2025_02_11_102920_create_roles_table',3);
INSERT INTO `migrations` VALUES (27,'2025_02_11_103046_add_column_role_id_to_users_table',3);
INSERT INTO `migrations` VALUES (28,'2025_02_11_103441_create_categories_table',3);
INSERT INTO `migrations` VALUES (29,'2025_02_11_103448_create_tags_table',3);
INSERT INTO `migrations` VALUES (30,'2025_02_11_103453_create_books_table',3);
INSERT INTO `migrations` VALUES (31,'2025_02_11_103702_create_book_tags_table',3);
INSERT INTO `migrations` VALUES (32,'2025_02_11_103817_create_reviews_table',3);
INSERT INTO `migrations` VALUES (33,'2025_02_11_103954_create_borrowed_books_table',3);
INSERT INTO `migrations` VALUES (34,'2025_02_11_104043_create_favourites_table',3);
INSERT INTO `migrations` VALUES (35,'2025_02_10_120635_create_locations_table',4);
INSERT INTO `migrations` VALUES (37,'2025_02_23_121046_create_location_books_table',5);
INSERT INTO `migrations` VALUES (40,'2025_02_23_182307_add_column_location_id_and_quantity_to_borrowed_books_table',6);
INSERT INTO `migrations` VALUES (41,'2025_05_14_045515_add_columns_to_borrowed_books_table',7);
INSERT INTO `migrations` VALUES (43,'2025_05_14_081230_create_black_lists_table',8);
INSERT INTO `migrations` VALUES (44,'2025_05_15_131118_add_fcm_token_to_users_table',9);
INSERT INTO `migrations` VALUES (45,'2025_05_20_061807_create_genres_table',10);
INSERT INTO `migrations` VALUES (46,'2025_05_20_062136_create_book_genres_table',10);
INSERT INTO `migrations` VALUES (47,'2025_05_22_052239_create_sliders_table',11);
INSERT INTO `migrations` VALUES (48,'2025_05_22_155459_add_profile_columns_to_users_table',12);
INSERT INTO `migrations` VALUES (49,'2025_05_22_205631_create_friendships_table',13);
INSERT INTO `migrations` VALUES (50,'2025_05_22_205646_create_chat_messages_table',13);
INSERT INTO `migrations` VALUES (51,'2025_05_23_101050_add_last_seen_to_users_table',14);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('0012cce58e4c69fd018f813f5a6d3030f99ea1c0fb3ed151a90c80b4aaaec64439df7a17bf300858',5,1,'Personal Access Token','[]',0,'2025-05-16 08:23:42','2025-05-16 08:23:42','2025-11-16 13:23:42');
INSERT INTO `oauth_access_tokens` VALUES ('0f63ea6daffc2f8134bb3affa85c8b2bddd56413014d8f1961a970222b16ebdc22da5cad2dc0e924',3,1,'Personal Access Token','[]',0,'2025-02-23 06:16:55','2025-02-23 06:16:55','2025-08-23 11:16:55');
INSERT INTO `oauth_access_tokens` VALUES ('10e5c5895f8d3c4f1ad2951a9b6eea81e6c8af39f2c395b1cdcf6ce1c68ee8e500625b23072e452b',6,1,'Personal Access Token','[]',0,'2025-05-16 08:25:49','2025-05-16 08:25:49','2025-11-16 13:25:49');
INSERT INTO `oauth_access_tokens` VALUES ('13d9efceb66734f6188a25c5c46997751a327b852173c29d3a19f5eb4cc422a12b9a988758d7750b',3,1,'Personal Access Token','[]',0,'2025-05-15 08:32:50','2025-05-15 08:32:50','2025-11-15 13:32:50');
INSERT INTO `oauth_access_tokens` VALUES ('1dc4022e12c9266b59285121bb93e8a897c156d44b79f7145ff33d8bd63f896f3862b0ae94575ab6',3,1,'Personal Access Token','[]',0,'2025-05-15 08:28:31','2025-05-15 08:28:31','2025-11-15 13:28:31');
INSERT INTO `oauth_access_tokens` VALUES ('1fd7dfa9342ccfeaa940d8a5b5907733f25bcae1348c219603cde4dead3e4ebea92b0ab4153f7add',3,1,'Personal Access Token','[]',0,'2025-02-23 16:04:27','2025-02-23 16:04:27','2025-08-23 21:04:27');
INSERT INTO `oauth_access_tokens` VALUES ('25a459b740a4e23164d45d979679c659b0ead0c22c4d47edde9d2e363a08c77470091626d1179687',7,1,'Personal Access Token','[]',0,'2025-05-20 01:00:20','2025-05-20 01:00:20','2025-11-20 06:00:20');
INSERT INTO `oauth_access_tokens` VALUES ('2784631635a1e02be0331866a07e9f314ac240d392077233df1faf3eca4d55ba69745b20ed831e15',3,1,'Personal Access Token','[]',0,'2025-02-20 06:51:37','2025-02-20 06:51:37','2025-08-20 11:51:37');
INSERT INTO `oauth_access_tokens` VALUES ('27b0bff26f1478a841afc86b63770c9fea49f411ceadd43b74435cff151cb08f6a823ac38d71d846',3,1,'Personal Access Token','[]',0,'2025-02-20 06:30:24','2025-02-20 06:30:24','2025-08-20 11:30:24');
INSERT INTO `oauth_access_tokens` VALUES ('3725f345010e7f9aefd6f1ab796052bc0091017bed769efc316b1287eb73f5e875b1ea946dd75231',7,1,'Personal Access Token','[]',0,'2025-05-20 00:58:02','2025-05-20 00:58:02','2025-11-20 05:58:02');
INSERT INTO `oauth_access_tokens` VALUES ('3753be35734e37e186cf79a8a8a4527f31844151ed99e9c750d236fa1c1ddb455e7b283856c997c3',7,1,'Personal Access Token','[]',0,'2025-05-23 07:53:52','2025-05-23 07:53:52','2025-11-23 12:53:52');
INSERT INTO `oauth_access_tokens` VALUES ('38be4a639f835a7b72c750ad4f7a3ba1ed52cdbc342252c7468e37d23a10618d0fbf2e53166fa63b',3,1,'Personal Access Token','[]',0,'2025-02-12 03:21:16','2025-02-12 03:21:16','2025-08-12 08:21:16');
INSERT INTO `oauth_access_tokens` VALUES ('412feab90c87233e8372e269ed751e508974ba0a258647c234ce4a87f30afb689e8dadf0ff27c2d0',7,1,'Personal Access Token','[]',0,'2025-05-23 08:49:38','2025-05-23 08:49:39','2025-11-23 13:49:38');
INSERT INTO `oauth_access_tokens` VALUES ('4137297cf00bb60627857d8707abcc98124b54e2659ee43bc6a79609741f26bf920d192e689a9039',3,1,'Personal Access Token','[]',0,'2025-05-15 08:30:48','2025-05-15 08:30:48','2025-11-15 13:30:48');
INSERT INTO `oauth_access_tokens` VALUES ('4cb77b268f4cf6cc8762066b03732a61ba76f254d46a6057414fea0d45b133523ead5812e904c37a',3,1,'Personal Access Token','[]',0,'2025-05-14 20:33:10','2025-05-14 20:33:11','2025-11-15 01:33:10');
INSERT INTO `oauth_access_tokens` VALUES ('4e20fa903afd00672258f6a1cf6dd2c4506770f7a4434ac2267a0629d468917d66ec233def672a76',3,1,'Personal Access Token','[]',0,'2025-02-22 23:55:24','2025-02-22 23:55:24','2025-08-23 04:55:24');
INSERT INTO `oauth_access_tokens` VALUES ('53c502c6fe6766f761699799c3b66f4641a08185f906c2bf9090b3d3ced9f6d1a23e89b79fc71537',7,1,'Personal Access Token','[]',0,'2025-05-23 08:14:04','2025-05-23 08:14:04','2025-11-23 13:14:04');
INSERT INTO `oauth_access_tokens` VALUES ('53c8c9494a3c8533d3f65f0f81a428c06f442bfdf14fe9ced2160198ddec4faaf31ea9ba6a02aa3d',3,1,'Personal Access Token','[]',0,'2025-02-20 06:30:20','2025-02-20 06:30:20','2025-08-20 11:30:20');
INSERT INTO `oauth_access_tokens` VALUES ('6097ccb99a402ba9632648a2332b6bf7c1126efc503d305d149d54416e4afbc5e954fea1f126b607',3,1,'Personal Access Token','[]',0,'2025-05-15 08:29:45','2025-05-15 08:29:45','2025-11-15 13:29:45');
INSERT INTO `oauth_access_tokens` VALUES ('6207eb675b51b95e3f519b3538c7baf0b3f0c1d1355cc2e750feed1f2864a3a37464544ca8a06b49',3,1,'Personal Access Token','[]',0,'2025-05-15 08:33:17','2025-05-15 08:33:17','2025-11-15 13:33:17');
INSERT INTO `oauth_access_tokens` VALUES ('6683d1992853fec2b2b1c7b2e637661b0e329d869a4b38b7bed436f219a7a77349c20ecbfb5f2c03',6,1,'Personal Access Token','[]',0,'2025-05-18 05:37:38','2025-05-18 05:37:39','2025-11-18 10:37:38');
INSERT INTO `oauth_access_tokens` VALUES ('672155b27418e395a72ce1d958659140e545b9a1790ac7e768ff3f4509b713154cc82f965b2ddab8',3,1,'Personal Access Token','[]',0,'2025-05-15 08:34:24','2025-05-15 08:34:24','2025-11-15 13:34:24');
INSERT INTO `oauth_access_tokens` VALUES ('68b4535ce69b42da516751cc29ef871619fa31e3aba02ad0b8c72ded5f2b1ef99dca92c7c6476b71',3,1,'Personal Access Token','[]',0,'2025-02-20 06:45:38','2025-02-20 06:45:38','2025-08-20 11:45:38');
INSERT INTO `oauth_access_tokens` VALUES ('692e3a92420fdb83438e43f8f3c51e320bd1a6956fa69566786c82d83fce2a75473e0fe4ab2dc061',3,1,'Personal Access Token','[]',0,'2025-05-15 08:37:23','2025-05-15 08:37:23','2025-11-15 13:37:23');
INSERT INTO `oauth_access_tokens` VALUES ('6c1c99c626be831a05d676bc97283e2a77183cd9c0807ef298d34333eca886fbdefc77ad41ccdacd',3,1,'Personal Access Token','[]',0,'2025-02-11 02:27:09','2025-02-11 02:27:09','2025-08-11 07:27:09');
INSERT INTO `oauth_access_tokens` VALUES ('6e5fbb83874c3b738e05b7515277311d46590d3a7d41a7aad47986790326512bbb78a3272935fcca',7,1,'Personal Access Token','[]',0,'2025-05-23 12:56:23','2025-05-23 12:56:23','2025-11-23 17:56:23');
INSERT INTO `oauth_access_tokens` VALUES ('6fa084840560eccb8c70a504fad396b8c04856cf82f956684220a35131a05477c19b2fdfc83d4463',3,1,'Personal Access Token','[]',0,'2025-02-20 06:44:58','2025-02-20 06:44:58','2025-08-20 11:44:58');
INSERT INTO `oauth_access_tokens` VALUES ('710acbefa26cbe3f0a6d38d637508cc709a7a5ecc5ba0332e977370476061fdb65b780c9e2a37901',3,1,'Personal Access Token','[]',0,'2025-02-20 06:34:28','2025-02-20 06:34:28','2025-08-20 11:34:28');
INSERT INTO `oauth_access_tokens` VALUES ('71d3ed6a365bd5be5894d0135a3135cb2acd99bc016aa57f6415820d29742ebb15da0bf4d5cdc27c',6,1,'Personal Access Token','[]',0,'2025-05-16 08:27:47','2025-05-16 08:27:47','2025-11-16 13:27:47');
INSERT INTO `oauth_access_tokens` VALUES ('721fbc1b2160774450479bfcbb012b10605bef9416d514528182638dc778e399566853e38b9e2aad',3,1,'Personal Access Token','[]',0,'2025-05-15 08:28:44','2025-05-15 08:28:44','2025-11-15 13:28:44');
INSERT INTO `oauth_access_tokens` VALUES ('7497b6c4c9f6a3b148bce19e44946c4b9e35f577df4b1d08cf3cc08cb717959db099e469448498ab',3,1,'Personal Access Token','[]',0,'2025-02-20 06:30:32','2025-02-20 06:30:32','2025-08-20 11:30:32');
INSERT INTO `oauth_access_tokens` VALUES ('7517778acf325cb31b129cc9c07117f945e760e58a4d37ebcea06c163bf95bf3bcb9bfb3002ea4e2',7,1,'Personal Access Token','[]',0,'2025-05-20 01:07:48','2025-05-20 01:07:48','2025-11-20 06:07:48');
INSERT INTO `oauth_access_tokens` VALUES ('79a230dfbd86224a079758b2b90e6f9c87eb7e584cf3f28635650fd0e92a76f31c9467dd3b90bcb3',3,1,'Personal Access Token','[]',0,'2025-02-23 06:43:10','2025-02-23 06:43:10','2025-08-23 11:43:10');
INSERT INTO `oauth_access_tokens` VALUES ('7d9bf9e547ff936d967c1b2facc93d73a83256eebba85e06593344cb3ae2127e56941839b812ed93',3,1,'Personal Access Token','[]',0,'2025-02-20 06:29:02','2025-02-20 06:29:02','2025-08-20 11:29:02');
INSERT INTO `oauth_access_tokens` VALUES ('811a39d0004a1ac15eb50be966c4abafa2888d2b28c98975291777c13b6f5139248fe48a4c51e2f9',7,1,'Personal Access Token','[]',0,'2025-05-24 05:13:37','2025-05-24 05:13:37','2025-11-24 10:13:37');
INSERT INTO `oauth_access_tokens` VALUES ('8204de50cb59ae7a0127e38902fa45fca9692cb56fa32ff76a8d32f4e29f8091c8d3e84449ccf9df',3,1,'Personal Access Token','[]',0,'2025-05-15 08:36:48','2025-05-15 08:36:48','2025-11-15 13:36:48');
INSERT INTO `oauth_access_tokens` VALUES ('82cd9f8a6b16cdf79fc1dce13af3c60ab5927155234a5b3de2a88896eb283f9127d0ed18ead6711e',7,1,'Personal Access Token','[]',0,'2025-05-23 12:11:35','2025-05-23 12:11:35','2025-11-23 17:11:35');
INSERT INTO `oauth_access_tokens` VALUES ('878717a9affb18b37a0ea2e51d6a589f7adf3f82b2e96b776e41ded0a922f9c8c24cf3ad16bd784f',7,1,'Personal Access Token','[]',0,'2025-05-23 07:19:42','2025-05-23 07:19:42','2025-11-23 12:19:42');
INSERT INTO `oauth_access_tokens` VALUES ('89b4b0ef229c73fbffed60149c73e7c27f10792c9e8bebb2167dcca39ceade17cfb35dfd72b49f3d',3,1,'Personal Access Token','[]',0,'2025-05-22 17:43:40','2025-05-22 17:43:40','2025-11-22 22:43:40');
INSERT INTO `oauth_access_tokens` VALUES ('89e5d30e30fac79b9df36fa4951f50410b22edb1ff67d346b76b1e6a6d59e026f14d5c90da9b26cd',7,1,'Personal Access Token','[]',0,'2025-05-19 04:31:06','2025-05-19 04:31:06','2025-11-19 09:31:06');
INSERT INTO `oauth_access_tokens` VALUES ('8fd2dc84fb67603b214e4d257fdf186e35c10a779c41223ce28e5076a7314359ffefbb9797f46617',7,1,'Personal Access Token','[]',0,'2025-05-22 17:52:52','2025-05-22 17:52:52','2025-11-22 22:52:52');
INSERT INTO `oauth_access_tokens` VALUES ('9040503e20ca6efc773bc60701cb41bbbdf4716d9801551c9be8a14544ef889abf96fadf35a8904d',3,1,'Personal Access Token','[]',0,'2025-02-11 02:27:30','2025-02-11 02:27:30','2025-08-11 07:27:30');
INSERT INTO `oauth_access_tokens` VALUES ('91805053ec942f38076f24a98e753bd00bb8b134c8e5b38570ebb70607f25059e23fba46f9ee2194',3,1,'Personal Access Token','[]',0,'2025-05-15 08:40:51','2025-05-15 08:40:51','2025-11-15 13:40:51');
INSERT INTO `oauth_access_tokens` VALUES ('94f48b7f11a2210dad42ef2152f0fbe23cc59e4a50fae2c1142dd5453f9140ee45374555009608c8',3,1,'Personal Access Token','[]',0,'2025-05-15 08:30:00','2025-05-15 08:30:00','2025-11-15 13:30:00');
INSERT INTO `oauth_access_tokens` VALUES ('9561c9801a9bd4d6010c94910e3b5200d86faa1b105904f551e4c5c2823f9d778998833526efc640',5,1,'Personal Access Token','[]',0,'2025-05-16 08:22:39','2025-05-16 08:22:39','2025-11-16 13:22:39');
INSERT INTO `oauth_access_tokens` VALUES ('970776bacd03afb56dbfcedbc48b8ab52ef8b4497be58a9a152bb04041f9319b8a766ddc0ee666cc',3,1,'Personal Access Token','[]',0,'2025-02-20 06:42:48','2025-02-20 06:42:48','2025-08-20 11:42:48');
INSERT INTO `oauth_access_tokens` VALUES ('9769672ed54dbc5e8776a3a3fb080efae888d855df1351b27497b0e7e2a968d02b6debfc3cdf946e',7,1,'Personal Access Token','[]',0,'2025-05-22 00:25:40','2025-05-22 00:25:40','2025-11-22 05:25:40');
INSERT INTO `oauth_access_tokens` VALUES ('99379155484e4e951fb34f55cedc3e314eab2f5cd8d163960952051eb2f1f31bd1a6212bb3c3a826',7,1,'Personal Access Token','[]',0,'2025-05-23 12:02:18','2025-05-23 12:02:18','2025-11-23 17:02:18');
INSERT INTO `oauth_access_tokens` VALUES ('9d72c8c2e842f90a70fed159d145774526b8cfdf90a5e1375d08666491cfc44ac02d6cce0870df51',7,1,'Personal Access Token','[]',0,'2025-05-20 01:05:02','2025-05-20 01:05:02','2025-11-20 06:05:02');
INSERT INTO `oauth_access_tokens` VALUES ('9f69002e83fbb1733cdbb1c9f07ef313fb57b0d4e30921df8865ac71d5fc7fc52ba045a53bcfc4a9',3,1,'Personal Access Token','[]',0,'2025-05-19 03:06:20','2025-05-19 03:06:21','2025-11-19 08:06:20');
INSERT INTO `oauth_access_tokens` VALUES ('a1bcfce3b629cf2bc4c3e87416d84ce80cd71347261b95e4b7ba33314ebc13bd05ce3dbf9f735b0f',3,1,'Personal Access Token','[]',0,'2025-02-21 02:03:15','2025-02-21 02:03:15','2025-08-21 07:03:15');
INSERT INTO `oauth_access_tokens` VALUES ('a9dd55fb6020e37695784606ea8a11fba2805234f5843b89b10f94317c6a6453065134795e6e1d74',3,1,'Personal Access Token','[]',0,'2025-05-15 08:33:15','2025-05-15 08:33:15','2025-11-15 13:33:15');
INSERT INTO `oauth_access_tokens` VALUES ('aad45d397f5019d6aa9159f46bfb6cd9f3339ae29af6d7d34576d165dff8fa47e704ab4b92846c9b',3,1,'Personal Access Token','[]',0,'2025-05-23 05:16:42','2025-05-23 05:16:42','2025-11-23 10:16:42');
INSERT INTO `oauth_access_tokens` VALUES ('ac07df6a8ec4408294345e5887b935caf931e2fc03846f285e06dfdbdd641264a9d08466076e0d10',7,1,'Personal Access Token','[]',0,'2025-05-24 04:10:45','2025-05-24 04:10:45','2025-11-24 09:10:45');
INSERT INTO `oauth_access_tokens` VALUES ('acc5ee2d32d72d32d76a9a0d961971a0f1d638d1414915d4c76f729ed4f73c58a36a070a172f568b',7,1,'Personal Access Token','[]',0,'2025-05-23 08:14:35','2025-05-23 08:14:35','2025-11-23 13:14:35');
INSERT INTO `oauth_access_tokens` VALUES ('b0190d1241289fe098e0eb361233085c3e92a30c49ebf8ebfbee5a266e2f1aca72ec9da0e6bb86ef',3,1,'Personal Access Token','[]',0,'2025-05-15 08:36:15','2025-05-15 08:36:15','2025-11-15 13:36:15');
INSERT INTO `oauth_access_tokens` VALUES ('b39687084478f1ca1a6688964fa9de7290e4ba4bb25f556ba04aaeddf5ed166f9b5734570daeeab7',7,1,'Personal Access Token','[]',0,'2025-05-22 11:20:24','2025-05-22 11:20:24','2025-11-22 16:20:24');
INSERT INTO `oauth_access_tokens` VALUES ('b4e82685bb23b84261d7d7f2e3b9c96b274cab4cbc84c15fde81b2b53d3864767754f762a540c815',3,1,'Personal Access Token','[]',0,'2025-02-20 06:24:14','2025-02-20 06:24:14','2025-08-20 11:24:14');
INSERT INTO `oauth_access_tokens` VALUES ('b5c98f231a0cef1837d1e4905a4455b90bb17a2acc3b4db7dfd6cf11a303a62f00eb9ae18b8add43',3,1,'Personal Access Token','[]',0,'2025-02-20 06:36:10','2025-02-20 06:36:10','2025-08-20 11:36:10');
INSERT INTO `oauth_access_tokens` VALUES ('b7e8ee0e90789002a93e4cd0a4e336e974d691208279b8de81c65194051aacbd36238e38d44d6f7c',3,1,'Personal Access Token','[]',0,'2025-02-10 07:44:06','2025-02-10 07:44:07','2025-08-10 12:44:06');
INSERT INTO `oauth_access_tokens` VALUES ('bd64d98c07dc3f624fc5746d0ae8dbecda574938957c9e7d6f6e348af65ed899b6962967aab0a870',3,1,'Personal Access Token','[]',0,'2025-02-20 06:44:04','2025-02-20 06:44:04','2025-08-20 11:44:04');
INSERT INTO `oauth_access_tokens` VALUES ('c3feea3b44f95b6028113834e698173d153dacddf48231c769daef402c9d15a68474f496411879b1',3,1,'Personal Access Token','[]',0,'2025-05-15 08:38:45','2025-05-15 08:38:45','2025-11-15 13:38:45');
INSERT INTO `oauth_access_tokens` VALUES ('c5bf08fd0a8c07103049dba98c48da82d0028f71e567822735257e0f128036ee1b66a571749bacf7',3,1,'Personal Access Token','[]',0,'2025-02-22 23:55:22','2025-02-22 23:55:23','2025-08-23 04:55:22');
INSERT INTO `oauth_access_tokens` VALUES ('c8224c6be97e8186330930d59da3403ecec3df359991feb3ad13e21e2002c3fbbde38c8caf23bc72',7,1,'Personal Access Token','[]',0,'2025-05-23 10:33:48','2025-05-23 10:33:48','2025-11-23 15:33:48');
INSERT INTO `oauth_access_tokens` VALUES ('cc2de586bae14f5a2b95e937b3dd439ec143a0a12ac645f0d2d4ba7ca36385a69e151c2adfed8d5c',7,1,'Personal Access Token','[]',0,'2025-05-22 12:22:26','2025-05-22 12:22:26','2025-11-22 17:22:26');
INSERT INTO `oauth_access_tokens` VALUES ('ce8085a09f221b28b31b896ac12c0abe2725c26988de6e42219a7355ad3e7ee431a2fc9efb3d5d96',3,1,'Personal Access Token','[]',0,'2025-05-23 09:53:19','2025-05-23 09:53:19','2025-11-23 14:53:19');
INSERT INTO `oauth_access_tokens` VALUES ('d634f816925e10f1a5a2061d3cf2e8bde340594b41a0bc6234af905db3722f4acf4fb51ea5e95f18',7,1,'Personal Access Token','[]',0,'2025-05-20 01:03:26','2025-05-20 01:03:26','2025-11-20 06:03:26');
INSERT INTO `oauth_access_tokens` VALUES ('d7a97c750e950d52257ff9ebeceb0c3580030a84952ef5f090941b10f92c5f49c9fb19f53e20c64f',3,1,'Personal Access Token','[]',0,'2025-05-15 08:30:51','2025-05-15 08:30:51','2025-11-15 13:30:51');
INSERT INTO `oauth_access_tokens` VALUES ('d9982d42cc82c8772cdfd97920595d836726b7403834fdda004cefe080f2b112896cedd7daa217ee',3,1,'Personal Access Token','[]',0,'2025-05-15 08:32:44','2025-05-15 08:32:44','2025-11-15 13:32:44');
INSERT INTO `oauth_access_tokens` VALUES ('da17f7868178e42e8a0efa80380fd3c202a9be969bb3a7d178d75c08a15bce8232e84637fa9afe63',3,1,'Personal Access Token','[]',0,'2025-05-15 08:33:13','2025-05-15 08:33:13','2025-11-15 13:33:13');
INSERT INTO `oauth_access_tokens` VALUES ('e2ac54dbac4a399207c52ea0c3121cef0cb92360887bc1b170f4d3dce7039c3380cebe88d5eff433',3,1,'Personal Access Token','[]',0,'2025-05-15 08:41:29','2025-05-15 08:41:29','2025-11-15 13:41:29');
INSERT INTO `oauth_access_tokens` VALUES ('e6cf5b74139fe1d67f05fd2839b876358e897e62e255d8e933141dbb426c934f23c7ced29fc8cb3d',7,1,'Personal Access Token','[]',0,'2025-05-22 00:28:29','2025-05-22 00:28:29','2025-11-22 05:28:29');
INSERT INTO `oauth_access_tokens` VALUES ('e725cc04beb43ae46e714ba5aa3778de10c672a14cf74dfb666f12dcf4716d0bbeb629da24e566b1',3,1,'Personal Access Token','[]',0,'2025-02-20 06:32:22','2025-02-20 06:32:22','2025-08-20 11:32:22');
INSERT INTO `oauth_access_tokens` VALUES ('e86ceb73b6a5b18ba9d59c4c3bb48941e7445bdc91ac13cd3cd208dfcfbcb50cdf2cb6207b889ad7',3,1,'Personal Access Token','[]',0,'2025-02-24 02:13:29','2025-02-24 02:13:29','2025-08-24 07:13:29');
INSERT INTO `oauth_access_tokens` VALUES ('ef42b306f322023d95edc0854e866feb9d4efc8fa3bf761e0b041c25c99c36f7153632278833e951',4,1,'api-token','[]',0,'2025-05-16 08:21:42','2025-05-16 08:21:43','2025-11-16 13:21:42');
INSERT INTO `oauth_access_tokens` VALUES ('f71e8ddeb57fbf3ef9182afad2548210470e90b986aebb354b8c508ce04ce85846c1dacf6c6c09be',3,1,'Personal Access Token','[]',0,'2025-02-24 02:13:26','2025-02-24 02:13:27','2025-08-24 07:13:26');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'Laravel Personal Access Client','rRPDbij8iHpVMUf7puBec0ttsIClcPC9ZmSL2PMu',NULL,'http://localhost',1,0,0,'2025-02-10 07:42:40','2025-02-10 07:42:40');
INSERT INTO `oauth_clients` VALUES (2,NULL,'Laravel Password Grant Client','rBAY8bUKEuQ85kOJkDdFWfPwEWBvhAtwZ2Ob4DqU','users','http://localhost',0,1,0,'2025-02-10 07:42:40','2025-02-10 07:42:40');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2025-02-10 07:42:40','2025-02-10 07:42:40');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `book_id` bigint unsigned DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_index` (`user_id`),
  KEY `reviews_book_id_index` (`book_id`),
  CONSTRAINT `reviews_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (2,7,12,'Good! Nice',5,'2025-05-21 08:16:51','2025-05-21 22:59:31');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin',NULL,NULL);
INSERT INTO `roles` VALUES (2,'Librarian',NULL,NULL);
INSERT INTO `roles` VALUES (3,'Member',NULL,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sliders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` VALUES (1,'sliders/yhJ3wxTgpm0ce7zleoFeIoOdtl1Lu3Og2vfHzlN0.jpg','2025-05-22','2025-05-31',1,'2025-05-22 01:20:47','2025-05-22 02:51:16');
INSERT INTO `sliders` VALUES (2,'sliders/jh10qvTL0RQOZdOyimWjlXJYUVFStq9VK9oEf8qU.jpg','2025-05-22','2025-05-30',1,'2025-05-22 02:41:21','2025-05-22 03:18:09');
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'TestTag1','2025-02-23 02:37:40','2025-02-23 02:37:51');
INSERT INTO `tags` VALUES (2,'NewTag','2025-02-23 02:37:46','2025-02-23 02:37:46');
INSERT INTO `tags` VALUES (3,'Classic','2025-05-20 04:52:20','2025-05-20 04:52:20');
INSERT INTO `tags` VALUES (4,'Award-Winning','2025-05-20 04:52:20','2025-05-20 04:52:20');
INSERT INTO `tags` VALUES (5,'Staff Pick','2025-05-20 04:52:20','2025-05-20 04:52:20');
INSERT INTO `tags` VALUES (6,'Bestseller','2025-05-20 04:52:20','2025-05-20 04:52:20');
INSERT INTO `tags` VALUES (8,'New Release','2025-05-20 04:56:45','2025-05-20 04:56:45');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `nationality` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcm_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `role_id` bigint unsigned DEFAULT NULL,
  `last_seen_at` timestamp NULL DEFAULT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_index` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test','test@test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$005nDWF/nNaYaZ.FoAewFOkxJBK23phBCtSu6SmAYTx5PuyfbBZ92',NULL,NULL,'2025-02-10 07:40:06','2025-02-10 07:40:06',0,1,NULL,0);
INSERT INTO `users` VALUES (2,'test','test@test1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$xfyMO/BjDNFYA9vd8x/eu.1j5LshhZycWETbz.5AUVBFMJQnryGJu',NULL,NULL,'2025-02-10 07:42:04','2025-02-10 07:42:04',0,1,NULL,0);
INSERT INTO `users` VALUES (3,'test123','test@test2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$C0tqtKFXcbr/qpc2zovQQOO4T9qROrW5hhPu8/zrx3AofAWXT8QeW',NULL,'epBbnai3mjbvBAQaQT0zUv:APA91bFTUqg31Yo3JlqOIH0g7_5tV6MQOovN5-_-Y2PMhhQm6f8SMUC-xMcwvnZ-HahHNC7MELXkY8npDR9Pz7KpHzajFj-oCMCXE8RwRHAZhmGY0zmKOYQ','2025-02-10 07:42:54','2025-05-23 10:50:38',0,1,'2025-05-23 06:50:49',0);
INSERT INTO `users` VALUES (7,'Zholaman Marshiitov','zholaman223@gmail.com','profile_pictures/eY5I5JHjnYefCvqbJxSu0wQvpmgSicha1BmY6a33.jpg','2025-05-23','kazakh','asdsad','77777777777','asd',NULL,'$2y$10$0Ch9lLhYcQSxLiBvIRXT2uiB7eW4rWqXRp6FoCIxgEeb2LOwljEoa',NULL,'eNnoTyKPn2MaSxxFhiWvjx:APA91bE76vw1Xf1GxJndQgvRavdee2WkK6QT3e9yvrMWnBslypWCk37io8qLKzmxlgtyiwAibkfK8qlg_B_YMDqJau-eh5smqEFcU3efnPnn_j6kWh9Rh2k','2025-05-19 04:31:06','2025-05-24 05:18:52',NULL,1,'2025-05-23 08:06:21',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-07 13:39:52
