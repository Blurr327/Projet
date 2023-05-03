-- ProjetIO2 fin de semestre *BLACKBOARD*
-- -----------------------------------------------------
-- Schema BaseBlackboard
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `BaseBlackboard` DEFAULT CHARACTER SET utf8 ;
USE `BaseBlackboard` ;

-- -----------------------------------------------------
-- Table `BaseBlackboard`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BaseBlackboard`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NOT NULL,
  `nickname` VARCHAR(45) NOT NULL,
  `password` VARCHAR(150) NOT NULL,
  `admin` TINYINT NULL DEFAULT 0,
  `signup_date` DATETIME NOT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `BaseBlackboard`.`follower_and_followed`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BaseBlackboard`.`follower_and_followed` (
  `follower_id` INT UNSIGNED NOT NULL,
  `followed_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`follower_id`, `followed_id`),
    FOREIGN KEY (`follower_id`)
    REFERENCES `BaseBlackboard`.`users` (`id`),
    FOREIGN KEY (`followed_id`)
    REFERENCES `BaseBlackboard`.`users` (`id`));


-- -----------------------------------------------------
-- Table `BaseBlackboard`.`posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BaseBlackboard`.`posts` (
  `post_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `author_id` INT UNSIGNED NOT NULL,
  `post` TEXT NOT NULL,
  `post_title` TEXT NOT NULL,
  `creation_date` DATETIME NOT NULL,
  PRIMARY KEY (`post_id`),
    FOREIGN KEY (`author_id`)
    REFERENCES `BaseBlackboard`.`users` (`id`));


-- -----------------------------------------------------
-- Table `BaseBlackboard`.`comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BaseBlackboard`.`comments` (
  `comment_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `author_id` INT UNSIGNED NOT NULL,
  `post_id` INT UNSIGNED NOT NULL,
  `creation_date` DATETIME NOT NULL,
  `comment` TEXT NULL,
  PRIMARY KEY (`comment_id`),
    FOREIGN KEY (`author_id`)
    REFERENCES `BaseBlackboard`.`users` (`id`),
    FOREIGN KEY (`post_id`)
    REFERENCES `BaseBlackboard`.`posts` (`post_id`));


-- -----------------------------------------------------
-- Table `BaseBlackboard`.`likes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BaseBlackboard`.`likes` (
  `liker_id` INT UNSIGNED NOT NULL,
  `liked_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`liker_id`, `liked_id`),
    FOREIGN KEY (`liker_id`)
    REFERENCES `BaseBlackboard`.`users` (`id`),
    FOREIGN KEY (`liked_id`)
    REFERENCES `BaseBlackboard`.`posts` (`post_id`));

INSERT INTO users(firstname,lastname,nickname,`password`,signup_date, `admin`) VALUES ('superuser','root','zayn','$2y$12$XyOBswFq/XZGFHbEY.my6OIyM4Qa5JGOTczkhf5PYXngVg1N1w.cK',NOW(),1);
