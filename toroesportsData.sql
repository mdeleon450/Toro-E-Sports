INSERT INTO `esportsladdersystem`.`user` (`iduser`, `username`, `password`)
VALUES 
(1, "thriftyRuffs5", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(2, "annoyedGelding4", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(3, "crushedBuck8", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(4, "anxiousCur0", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(5, "dreadfulThrush2", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(6, "awedBuzzard4", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(7, "excludedBuzzard7", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(8, "drearyChough8", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(9, "solidJaguar0", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(10, "humorousCur1", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(11, "thrilledLollies2", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(13, "fondTomatoe7", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(14, "gleefulUnicorn5", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(15, "euphoricWasp5", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(16, "pitifulPonie0", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(17, "betrayedOtter5", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(18, "joyfulLard0", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS"),
(19, "puzzledOcelot8", "$2y$10$iWKMXTLsV54ya8JlP.et.u37kJjtZeSKghvF3E409VZgLNb4cIHPS");

INSERT INTO `esportsladdersystem`.`user_image`
(`idimage`, `is_set`, `image_dir`, `iduser`)
VALUES
(1, 1, "thriftyRuffs5.png", 1),
(3, 1, "crushedBuck8.png", 3),
(5, 1, "dreadfulThrush2.png", 5),
(7, 1, "excludedBuzzard7.png", 7),
(15, 1, "euphoricWasp5.png", 15),
(18, 1, "joyfulLard0.png", 18);

INSERT INTO `esportsladdersystem`.`user_image`
(`idimage`, `iduser`)
VALUES
(2, 2),
(4, 4),
(6, 6),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(13, 13),
(14, 14),
(16, 16),
(17, 17),
(19, 19);

INSERT INTO `esportsladdersystem`.`game`
(`idgame`, `game_name`, `game_image`)
VALUES
(1, "FIFA 20", "fifa20.png"),
(2, "Super Smash Bros. Ultimate", "smashultimate.png"),
(3, "Call of Duty: Warzone", "codwar.png"),
(4, "Rocket League", "rocketleague.png"),
(5, "Fortnite", "fortnite.png");

INSERT INTO `esportsladdersystem`.`ladder`
(`idladder`, `ladderType`)
VALUES
(1, "Single Ladder"),
(2, "Double Ladder"),
(3, "Trio Ladder"),
(4, "Quad Ladder");

INSERT INTO `esportsladdersystem`.`game_has_ladder`
(`idgame`, `idladder`)
VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(3, 4),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(5, 1),
(5, 2),
(5, 4);

INSERT INTO `esportsladdersystem`.`team` 
(`idteam`,`team_name`,`team_owner`,`team_type`, `idgame`)
VALUES 
(1, "The Fellas", "thriftyRuffs5", "Quad Ladder", 3),
(2, "Sindoze", "dreadfulThrush2", "Double Ladder", 4),
(3, "I Carry", "excludedBuzzard7", "Single Ladder", 3),
(4, "SoaR Gaming", "drearyChough8", "Quad Ladder", 3),
(5, "Galaxy", "fondTomatoe7", "Double Ladder", 4),
(6, "M0ZILL4", "euphoricWasp5", "Single Ladder", 3),
(7, "CR7 Fan", "pitifulPonie0", "Single Ladder", 1),
(8, "American Ducks", "betrayedOtter5", "Single Ladder", 1),
(9, "TSM", "joyfulLard0", "Single Ladder", 1),
(10, "Sidemen", "puzzledOcelot8", "Single Ladder", 1);

INSERT INTO `esportsladdersystem`.`user_has_team` 
(`iduser`, `idteam`)
VALUES 
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 2),
(6, 2),
(7, 3),
(8, 4),
(9, 4),
(10, 4),
(11, 4),
(13, 5),
(14, 5),
(15, 6),
(16, 7),
(17, 8),
(18, 9),
(19, 10);

INSERT INTO `esportsladdersystem`.`team_in_ladder`
(`idteam`, `idladder`, `idgame`)
VALUES
(1, 4, 3),
(2, 2, 4),
(3, 1, 3),
(4, 4, 3),
(5, 2, 4),
(6, 1, 3),
(7, 1, 1),
(8, 1, 1),
(9, 1, 1),
(10, 1, 1);

INSERT INTO `esportsladdersystem`.`match`
(`idmatch`, `matchStatus`, `idgame`, `idladder`, `idteam`)
VALUES
(1,'Done', 3, 4, 1),
(2,'Done', 3, 1, 3),
(3, 'Posted', 3, 1, 6),
(4, 'Rejected', 1, 1, 7),
(5, 'Disputed', 1, 1, 8),
(6,'Done', 4, 2, 5),
(7, 'Disputed', 1, 1, 9),
(8, 'Done', 1, 1, 10),
(9, 'Done', 1, 1, 8),
(10,'Done', 3, 4, 4);

INSERT INTO `esportsladdersystem`.`team_has_match`
(`idteam`, `idmatch`, `idgame`, `idladder`, `team1Score`, `team2Score`)
VALUES
-- COD 4 VS 4 TEAM 1 VS TEAM 4
(1, 1, 3, 4, 23, 16),
(4, 1, 3, 4, 16, 23),

-- COD 1 VS 1 TEAM 3 VS TEAM 6
(3, 2, 3, 1, 2, 3),
(6, 2, 3, 1, 3, 2),

-- FIFA 1 VS 1 TEAM 8 VS TEAM 9
(8, 5, 1, 1, 3, 0),
(9, 5, 1, 1, 4, 1),

-- ROCKET 2 VS 2 TEAM 5 VS TEAM 2
(5, 6, 4, 2, 5, 2),
(2, 6, 4, 2, 2, 5),

-- FIFA 1 VS 1 TEAM 9 VS TEAM 10
(9, 7, 1, 1, 5, 0),
(10, 7, 1, 1, 3, 1),

-- FIFA 1 VS 1 TEAM 10 VS TEAM 7
(10, 8, 1, 1, 3, 1),
(7, 8, 1, 1, 1, 3),
-- COD 4 VS 4 TEAM 4 VS TEAM 1
(4, 10, 3, 4, 15, 6),
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

