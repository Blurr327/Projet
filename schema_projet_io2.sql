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
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NOT NULL,
  `nickname` VARCHAR(45) NOT NULL,
  `password` VARCHAR(150) NOT NULL,
  `admin` TINYINT NULL DEFAULT 0,
  `blackboard` TEXT NOT NULL DEFAULT 'Eureka',
  `signup_date` DATETIME NOT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `BaseBlackboard`.`follower_and_followed`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BaseBlackboard`.`follower_and_followed` (
  `follower_id` INT NOT NULL,
  `followed_id` INT NOT NULL,
  PRIMARY KEY (`follower_id`, `followed_id`),
    FOREIGN KEY (`follower_id`)
    REFERENCES `BaseBlackboard`.`users` (`id`),
    FOREIGN KEY (`followed_id`)
    REFERENCES `BaseBlackboard`.`users` (`id`));


-- -----------------------------------------------------
-- Table `BaseBlackboard`.`posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BaseBlackboard`.`posts` (
  `post_id` INTEGER NOT NULL AUTO_INCREMENT,
  `author_id` INT NOT NULL,
  `creation_date` DATETIME NOT NULL,
  PRIMARY KEY (`post_id`),
    FOREIGN KEY (`author_id`)
    REFERENCES `BaseBlackboard`.`users` (`id`));


-- -----------------------------------------------------
-- Table `BaseBlackboard`.`comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `BaseBlackboard`.`comments` (
  `comment_id` INT NOT NULL AUTO_INCREMENT,
  `author_id` INT NOT NULL,
  `post_id` INT NOT NULL,
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
  `liker_id` INT NOT NULL,
  `liked_id` INT NOT NULL,
  PRIMARY KEY (`liker_id`, `liked_id`),
    FOREIGN KEY (`liker_id`)
    REFERENCES `BaseBlackboard`.`users` (`id`),
    FOREIGN KEY (`liked_id`)
    REFERENCES `BaseBlackboard`.`posts` (`post_id`));



