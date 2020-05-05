-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema esportsladdersystem
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema esportsladdersystem
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `esportsladdersystem` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `esportsladdersystem` ;

-- -----------------------------------------------------
-- Table `esportsladdersystem`.`game`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esportsladdersystem`.`game` (
  `idgame` INT NOT NULL AUTO_INCREMENT,
  `game_name` VARCHAR(45) NOT NULL,
  `game_image` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idgame`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `esportsladdersystem`.`ladder`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esportsladdersystem`.`ladder` (
  `idladder` INT NOT NULL AUTO_INCREMENT,
  `ladderType` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idladder`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `esportsladdersystem`.`game_has_ladder`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esportsladdersystem`.`game_has_ladder` (
  `idgame` INT NOT NULL,
  `idladder` INT NOT NULL,
  PRIMARY KEY (`idgame`, `idladder`),
  INDEX `fk_game_has_ladder_ladder1_idx` (`idladder` ASC) VISIBLE,
  INDEX `fk_game_has_ladder_game1_idx` (`idgame` ASC) VISIBLE,
  CONSTRAINT `fk_game_has_ladder_game1`
    FOREIGN KEY (`idgame`)
    REFERENCES `esportsladdersystem`.`game` (`idgame`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_game_has_ladder_ladder1`
    FOREIGN KEY (`idladder`)
    REFERENCES `esportsladdersystem`.`ladder` (`idladder`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `esportsladdersystem`.`team`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esportsladdersystem`.`team` (
  `idteam` INT NOT NULL AUTO_INCREMENT,
  `team_name` VARCHAR(45) NOT NULL,
  `team_owner` VARCHAR(45) NOT NULL,
  `team_type` VARCHAR(45) NOT NULL,
  `team_matches` INT NULL DEFAULT '0',
  `team_wins` INT NULL DEFAULT '0',
  `team_losses` INT NULL DEFAULT '0',
  PRIMARY KEY (`idteam`))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `esportsladdersystem`.`match`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esportsladdersystem`.`match` (
  `idmatch` INT NOT NULL AUTO_INCREMENT,
  `matchTime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `matchStatus` VARCHAR(45) NOT NULL DEFAULT 'Posted',
  `idgame` INT NOT NULL,
  `idladder` INT NOT NULL,
  `idteam` INT NOT NULL,
  PRIMARY KEY (`idmatch`, `idgame`, `idladder`, `idteam`),
  INDEX `fk_match_game_has_ladder1_idx` (`idgame` ASC, `idladder` ASC) VISIBLE,
  INDEX `fk_match_team1_idx` (`idteam` ASC) VISIBLE,
  CONSTRAINT `fk_match_game_has_ladder1`
    FOREIGN KEY (`idgame` , `idladder`)
    REFERENCES `esportsladdersystem`.`game_has_ladder` (`idgame` , `idladder`),
  CONSTRAINT `fk_match_team1`
    FOREIGN KEY (`idteam`)
    REFERENCES `esportsladdersystem`.`team` (`idteam`))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `esportsladdersystem`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esportsladdersystem`.`user` (
  `iduser` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `user_wins` INT NULL DEFAULT '0',
  `user_matches` INT NULL DEFAULT '0',
  `user_losses` INT NULL DEFAULT '0',
  PRIMARY KEY (`iduser`))
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `esportsladdersystem`.`messages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esportsladdersystem`.`messages` (
  `from_iduser` INT NOT NULL,
  `to_iduser` INT NOT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `message` LONGTEXT NULL DEFAULT NULL,
  `receive_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `fk_player_has_player_player2_idx` (`to_iduser` ASC) VISIBLE,
  INDEX `fk_player_has_player_player1_idx` (`from_iduser` ASC) VISIBLE,
  CONSTRAINT `fk_player_has_player_player1`
    FOREIGN KEY (`from_iduser`)
    REFERENCES `esportsladdersystem`.`user` (`iduser`),
  CONSTRAINT `fk_player_has_player_player2`
    FOREIGN KEY (`to_iduser`)
    REFERENCES `esportsladdersystem`.`user` (`iduser`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `esportsladdersystem`.`team_has_match`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esportsladdersystem`.`team_has_match` (
  `idteam` INT NOT NULL,
  `idmatch` INT NOT NULL,
  `idgame` INT NOT NULL,
  `idladder` INT NOT NULL,
  `team1Score` INT NULL DEFAULT NULL,
  `team2Score` INT NULL DEFAULT NULL,
  PRIMARY KEY (`idteam`, `idmatch`, `idgame`, `idladder`),
  INDEX `fk_team_has_match_match1_idx` (`idmatch` ASC, `idgame` ASC, `idladder` ASC) VISIBLE,
  INDEX `fk_team_has_match_team1_idx` (`idteam` ASC) VISIBLE,
  CONSTRAINT `fk_team_has_match_match1`
    FOREIGN KEY (`idmatch` , `idgame` , `idladder`)
    REFERENCES `esportsladdersystem`.`match` (`idmatch` , `idgame` , `idladder`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_team_has_match_team1`
    FOREIGN KEY (`idteam`)
    REFERENCES `esportsladdersystem`.`team` (`idteam`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `esportsladdersystem`.`team_in_ladder`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esportsladdersystem`.`team_in_ladder` (
  `idteam` INT NOT NULL,
  `idladder` INT NOT NULL,
  PRIMARY KEY (`idteam`, `idladder`),
  INDEX `fk_team_has_Ladder_Ladder1_idx` (`idladder` ASC) VISIBLE,
  INDEX `fk_team_has_Ladder_team1_idx` (`idteam` ASC) VISIBLE,
  CONSTRAINT `fk_team_has_Ladder_Ladder1`
    FOREIGN KEY (`idladder`)
    REFERENCES `esportsladdersystem`.`ladder` (`idladder`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_team_has_Ladder_team1`
    FOREIGN KEY (`idteam`)
    REFERENCES `esportsladdersystem`.`team` (`idteam`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `esportsladdersystem`.`user_has_team`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `esportsladdersystem`.`user_has_team` (
  `iduser` INT NOT NULL,
  `idteam` INT NOT NULL,
  PRIMARY KEY (`iduser`, `idteam`),
  INDEX `fk_user_has_team_team1_idx` (`idteam` ASC) VISIBLE,
  INDEX `fk_user_has_team_user1_idx` (`iduser` ASC) VISIBLE,
  CONSTRAINT `fk_user_has_team_team1`
    FOREIGN KEY (`idteam`)
    REFERENCES `esportsladdersystem`.`team` (`idteam`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_has_team_user1`
    FOREIGN KEY (`iduser`)
    REFERENCES `esportsladdersystem`.`user` (`iduser`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (1, "thriftyRuffs5", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (2, "annoyedGelding4", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (3, "crushedBuck8", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (4, "anxiousCur0", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (5, "dreadfulThrush2", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (6, "awedBuzzard4", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (7, "excludedBuzzard7", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (8, "drearyChough8", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (9, "solidJaguar0", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (10, "humorousCur1", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (11, "thrilledLollies2", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (13, "fondTomatoe7", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (14, "gleefulUnicorn5", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (15, "euphoricWasp5", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (16, "pitifulPonie0", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (17, "betrayedOtter5", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (18, "joyfulLard0", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES (19, "puzzledOcelot8", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`team` 
(`idteam`,`team_name`,`team_owner`,`team_type`)
VALUES (1, "The Fellas", "thriftyRuffs5", "Quad Ladder");

INSERT INTO `esportsladdersystem`.`team` 
(`idteam`,`team_name`,`team_owner`,`team_type`)
VALUES (2, "Sindoze", "dreadfulThrush2", "Double Ladder");

INSERT INTO `esportsladdersystem`.`team` 
(`idteam`,`team_name`,`team_owner`,`team_type`)
VALUES (3, "I Carry", "excludedBuzzard7", "Single Ladder");

INSERT INTO `esportsladdersystem`.`team` 
(`idteam`,`team_name`,`team_owner`,`team_type`)
VALUES (4, "SoaR Gaming", "drearyChough8", "Quad Ladder");

INSERT INTO `esportsladdersystem`.`team` 
(`idteam`,`team_name`,`team_owner`,`team_type`)
VALUES (5, "Galaxy", "fondTomatoe7", "Double Ladder");

INSERT INTO `esportsladdersystem`.`team` 
(`idteam`,`team_name`,`team_owner`,`team_type`)
VALUES (6, "M0ZILL4", "euphoricWasp5", "Single Ladder");

INSERT INTO `esportsladdersystem`.`team` 
(`idteam`,`team_name`,`team_owner`,`team_type`)
VALUES (7, "CR7 Fan", "pitifulPonie0", "Single Ladder");

INSERT INTO `esportsladdersystem`.`team` 
(`idteam`,`team_name`,`team_owner`,`team_type`)
VALUES (8, "American Ducks", "betrayedOtter5", "Single Ladder");

INSERT INTO `esportsladdersystem`.`team` 
(`idteam`,`team_name`,`team_owner`,`team_type`)
VALUES (9, "TSM", "joyfulLard0", "Single Ladder");

INSERT INTO `esportsladdersystem`.`team` 
(`idteam`,`team_name`,`team_owner`,`team_type`)
VALUES (10, "Sidemen", "puzzledOcelot8", "Single Ladder");

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (1, 1);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (2, 1);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (3, 1);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (4, 1);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (5, 2);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (6, 2);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (7, 3);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (8, 4);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (9, 4);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (10, 4);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (11, 4);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (13, 5);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (14, 5);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (15, 6);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (16, 7);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (17, 8);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (18, 9);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES (19, 10);

INSERT INTO `esportsladdersystem`.`game`
(`idgame`, `game_name`, `game_image`)
VALUES
(1, "FIFA 20", "fifa20.png");

INSERT INTO `esportsladdersystem`.`game`
(`idgame`, `game_name`, `game_image`)
VALUES
(2, "Super Smash Bros. Ultimate", "smashultimate.png");

INSERT INTO `esportsladdersystem`.`game`
(`idgame`, `game_name`, `game_image`)
VALUES
(3, "Call of Duty: Warzone", "codwar.png");

INSERT INTO `esportsladdersystem`.`game`
(`idgame`, `game_name`, `game_image`)
VALUES
(4, "Rocket League", "rocketleague.png");

INSERT INTO `esportsladdersystem`.`ladder`
(`idladder`, `ladderType`)
VALUES
(1, "Single Ladder");

INSERT INTO `esportsladdersystem`.`ladder`
(`idladder`, `ladderType`)
VALUES
(2, "Double Ladder");

INSERT INTO `esportsladdersystem`.`ladder`
(`idladder`, `ladderType`)
VALUES
(3, "Trio Ladder");

INSERT INTO `esportsladdersystem`.`ladder`
(`idladder`, `ladderType`)
VALUES
(4, "Quad Ladder");

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(1, 1);

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(1, 2);

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(2, 1);

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(2, 2);

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(3, 1);

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(3, 2);

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(3, 4);

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(4, 1);

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(4, 2);

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(4, 3);

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(4, 4);

INSERT INTO `esportsladdersystem`.`team_in_ladder`
(`idteam`, `idladder`)
VALUES
(1, 4);

INSERT INTO `esportsladdersystem`.`team_in_ladder`
(`idteam`, `idladder`)
VALUES
(2, 2);

INSERT INTO `esportsladdersystem`.`team_in_ladder`
(`idteam`, `idladder`)
VALUES
(3, 1);

INSERT INTO `esportsladdersystem`.`team_in_ladder`
(`idteam`, `idladder`)
VALUES
(4, 4);


INSERT INTO `esportsladdersystem`.`match`
(`idmatch`, `matchStatus`, `idgame`, `idladder`, `idteam`)
VALUES
(1,'Done', 3, 4, 1);

INSERT INTO `esportsladdersystem`.`match`
(`idmatch`, `matchStatus`, `idgame`, `idladder`, `idteam`)
VALUES
(2,'Done', 1, 1, 3);

INSERT INTO `esportsladdersystem`.`match`
(`idmatch`, `matchStatus`, `idgame`, `idladder`, `idteam`)
VALUES
(3, 'Posted', 1, 1, 6);

INSERT INTO `esportsladdersystem`.`match`
(`idmatch`, `matchStatus`, `idgame`, `idladder`, `idteam`)
VALUES
(4, 'Rejected', 2, 1, 7);

INSERT INTO `esportsladdersystem`.`match`
(`idmatch`, `matchStatus`, `idgame`, `idladder`, `idteam`)
VALUES
(5, 'Disputed', 1, 1, 8);

INSERT INTO `esportsladdersystem`.`match`
(`idmatch`, `matchStatus`, `idgame`, `idladder`, `idteam`)
VALUES
(6,'Done', 4, 2, 5);

INSERT INTO `esportsladdersystem`.`match`
(`idmatch`, `matchStatus`, `idgame`, `idladder`, `idteam`)
VALUES
(7, 'Disputed', 1, 1, 9);

INSERT INTO `esportsladdersystem`.`match`
(`idmatch`, `matchStatus`, `idgame`, `idladder`, `idteam`)
VALUES
(8, 'Done', 1, 1, 10);

INSERT INTO `esportsladdersystem`.`match`
(`idmatch`, `matchStatus`, `idgame`, `idladder`, `idteam`)
VALUES
(9, 'Done', 1, 1, 8);

INSERT INTO `esportsladdersystem`.`match`
(`idmatch`, `matchStatus`, `idgame`, `idladder`, `idteam`)
VALUES
(10,'Done', 3, 4, 4);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(1, 1, 3, 4, 23, 16);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(4, 1, 3, 4, 16, 23);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(3, 2, 1, 1, 2, 3);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(6, 2, 1, 1, 3, 2);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(8, 5, 1, 1, 3, 0);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(9, 5, 1, 1, 4, 1);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(5, 6, 4, 2, 5, 2);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(2, 6, 4, 2, 2, 5);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(9, 7, 1, 1, 5, 0);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(10, 7, 1, 1, 3, 1);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(10, 8, 1, 1, 3, 1);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(7, 8, 1, 1, 1, 3);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(8, 9, 1, 1, 4, 2);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(6, 9, 1, 1, 2, 4);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(4, 10, 3, 4, 15, 6);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
(1, 10, 3, 4, 6, 15);


UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_wins` = `team_wins`+1
WHERE `idteam` = 1;

UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_losses` = `team_losses`+1
WHERE `idteam` = 4;

UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_wins` = `team_wins`+1
WHERE `idteam` = 6;

UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_losses` = `team_losses`+1
WHERE `idteam` = 3;

UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_wins` = `team_wins`+1
WHERE `idteam` = 5;

UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_losses` = `team_losses`+1
WHERE `idteam` = 2;

UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_wins` = `team_wins`+1
WHERE `idteam` = 10;

UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_losses` = `team_losses`+1
WHERE `idteam` = 7;

UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_wins` = `team_wins`+1
WHERE `idteam` = 8;

UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_losses` = `team_losses`+1
WHERE `idteam` = 6;

UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_wins` = `team_wins`+1
WHERE `idteam` = 4;

UPDATE `esportsladdersystem`.`team`
SET
`team_matches` = `team_matches`+1,
`team_losses` = `team_losses`+1
WHERE `idteam` = 1;

UPDATE `esportsladdersystem`.`user`
SET
`user_wins` = `user_wins`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 1 OR `iduser` = 2 OR `iduser` = 3 OR `iduser` = 4;

UPDATE `esportsladdersystem`.`user`
SET
`user_losses` = `user_losses`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 8 OR `iduser` = 9 OR `iduser` = 10 OR `iduser` = 11;

UPDATE `esportsladdersystem`.`user`
SET
`user_wins` = `user_wins`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 15;

UPDATE `esportsladdersystem`.`user`
SET
`user_losses` = `user_losses`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 7;

UPDATE `esportsladdersystem`.`user`
SET
`user_wins` = `user_wins`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 13 OR `iduser` = 14;

UPDATE `esportsladdersystem`.`user`
SET
`user_losses` = `user_losses`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 5 OR `iduser` = 6;


UPDATE `esportsladdersystem`.`user`
SET
`user_wins` = `user_wins`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 19;

UPDATE `esportsladdersystem`.`user`
SET
`user_losses` = `user_losses`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 16;

UPDATE `esportsladdersystem`.`user`
SET
`user_wins` = `user_wins`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 17;

UPDATE `esportsladdersystem`.`user`
SET
`user_losses` = `user_losses`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 15;

UPDATE `esportsladdersystem`.`user`
SET
`user_wins` = `user_wins`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 8 OR `iduser` = 9 OR `iduser` = 10 OR `iduser` = 11;

UPDATE `esportsladdersystem`.`user`
SET
`user_losses` = `user_losses`+1,
`user_matches` = `user_matches`+1
WHERE `iduser` = 1 OR `iduser` = 2 OR `iduser` = 3 OR `iduser` = 4;

