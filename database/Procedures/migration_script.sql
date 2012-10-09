-- ----------------------------------------------------------------------------
-- Routine droidbox.allQueue
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `droidbox`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `allQueue`()
BEGIN
	SELECT *
	FROM song s, queue q
	WHERE s.id IN(
		SELECT q.songID 
		FROM queue) 
	ORDER BY priority DESC, request_type DESC, time_requested;
END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine droidbox.allSongs
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `droidbox`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `allSongs`()
BEGIN
	select * from song;
END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine droidbox.customerBill
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `droidbox`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `customerBill`(IN table_num INT)
BEGIN
	SELECT *
	FROM payment p
	WHERE p.table_num = table_num;
END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine droidbox.songsAlbum
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `droidbox`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `songsAlbum`(IN album VARCHAR(255))
BEGIN
	SELECT * 
	FROM song s
	WHERE album = s.album;
END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine droidbox.songsArtist
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `droidbox`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `songsArtist`(IN artist VARCHAR(255))
BEGIN
	SELECT * 
	FROM song s
	WHERE artist = s.artist;
END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine droidbox.songsFile_path
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `droidbox`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `songsFile_path`(IN file_path VARCHAR(255))
BEGIN
	SELECT * 
	FROM song s
	WHERE file_path = s.file_path;
END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine droidbox.songsGenre
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `droidbox`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `songsGenre`(IN genre VARCHAR(255))
BEGIN
	SELECT * 
	FROM song s
	WHERE genre = s.genre;
END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine droidbox.songsID
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `droidbox`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `songsID`(IN song VARCHAR(255))
BEGIN
	SELECT * 
	FROM song s
	WHERE id = s.id;
END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine droidbox.songsSong
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `droidbox`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `songsSong`(IN song VARCHAR(255))
BEGIN
	SELECT * 
	FROM song s
	WHERE song = s.song;
END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine droidbox.topQueue
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `droidbox`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `topQueue`(IN topRows INT)
BEGIN
	DROP TABLE IF EXISTS top4Queue;
	CREATE TEMPORARY TABLE top4Queue 
		SELECT songID 
		FROM queue 
		ORDER BY priority DESC, request_type DESC, time_requested
		LIMIT topRows;
	
	SELECT *
	FROM song s, queue q
	WHERE id in(
		SELECT songID 
		FROM top4Queue) AND s.id = q.songID
	ORDER BY priority DESC, request_type DESC, time_requested;
END$$

DELIMITER ;

