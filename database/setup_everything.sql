use droidbox;

-- tables --------------------------------------------------

DROP TABLE IF EXISTS song;
CREATE TABLE song (
	id INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255) NOT NULL,
	artist VARCHAR(255) NOT NULL,
	album VARCHAR(255) NOT NULL,
	genre ENUM('Blues','Classical','Country','Electronic/Indie','Folk','Jazz','Reggae','Rock','Unknown') NOT NULL DEFAULT 'Unknown',
	length INT NOT NULL,
	num_played INT NOT NULL DEFAULT 0,
	file_path TEXT NOT NULL,
	enabled BOOL NOT NULL DEFAULT 1,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS playlist;
CREATE TABLE playlist (
	playlistID INT NOT NULL,	
	songID INT NOT NULL
);

DROP TABLE IF EXISTS playlist_name;
CREATE TABLE playlist_name (
	playlistID INT NOT NULL,
	playlistName VARCHAR(255) NOT NULL,
	PRIMARY KEY (playlistID)
);

DROP TABLE IF EXISTS queue;
CREATE TABLE queue (
	songID INT NOT NULL,
	priority INT NOT NULL DEFAULT 0,
	requested_by INT NOT NULL DEFAULT 0,
	request_type BOOL NOT NULL DEFAULT 0,
	time_requested DATETIME NOT NULL DEFAULT 0,
	PRIMARY KEY (songID)
);

DROP TABLE IF EXISTS payment;
CREATE TABLE payment (
	table_num INT NOT NULL,
	id_num INT NOT NULL,
    nickname nvarchar(255) NOT NULL,
	num_requests INT NOT NULL,
	PRIMARY KEY (table_num)
);

DROP TABLE IF EXISTS constants;
CREATE TABLE constants (
  constantKey nvarchar(255) NOT NULL,
  constantValue INT NOT NULL,
  PRIMARY KEY (`constantKey`)
);

-- Procedures -----------------------------------------------------------------

DROP PROCEDURE IF EXISTS check_credentials;
delimiter $$
CREATE PROCEDURE `check_credentials`(
	IN t_num int,
	IN t_code int,
	OUT success int,
	OUT message varchar(255)
)
BEGIN	
	DECLARE rc int;
	SET rc = (SELECT COUNT(*) FROM payment WHERE (table_num = t_num AND id_num = t_code));
	
	-- check that the table and table code match
	IF(rc != 1) THEN
		SET success = 1;
		-- if not, check if this table has been given a code
		SET rc = (SELECT COUNT(*) FROM payment WHERE table_num = t_num);
		IF(rc < 1) THEN
			SET message = "This table does not have a code yet.";
		ELSE
			SET message = "Incorrect table code for this table number.";
		END IF;				
	ELSE
		SET success = 0;
		SET message = "Success!";
	END IF;
END$$

DROP PROCEDURE IF EXISTS close_table;
$$
CREATE PROCEDURE `close_table`(
	IN table_number int(11),
	OUT success int,
	OUT message varchar(255),
	OUT num_req int(11)
)
proc:BEGIN
	-- check if this table is already open
	DECLARE rc int(11);
	SET rc = (SELECT COUNT(*) FROM payment WHERE payment.table_num = table_number);
	IF(rc <= 0) THEN
		-- this table is not open
		SET success = 1;
		SET message = "This table is not open.";
		SET num_req = -1;
		LEAVE proc;
	END IF;
	-- return the number of requests this table made
	SET success = 0;
	SET message = "Success!";
	SET num_req = (SELECT num_requests FROM payment WHERE payment.table_num = table_number);
	-- remove the row corresponding to this table
	DELETE FROM payment WHERE payment.table_num = table_number;
END$$

DROP PROCEDURE IF EXISTS get_next_song_queue;
$$
CREATE PROCEDURE `get_next_song_queue`(
	IN prev_song_id int(11)
)
BEGIN
	DECLARE cooldown int;
	SET cooldown = -3;
	-- increment the number of times played for previous song
	UPDATE song SET num_played = num_played + 1 WHERE id = prev_song_id;
	-- set the cooldown period for the previous song, change request type to cooldown
	-- if this was a paid request
	IF((SELECT request_type FROM queue WHERE songID = prev_song_id) = 0) THEN
		UPDATE queue SET priority = cooldown - 1, request_type = 2 WHERE songID = prev_song_id;
	ELSE
		UPDATE queue SET priority = cooldown - 1, time_requested = NOW() WHERE songID = prev_song_id;
	END IF;
	-- increment the priorities of the songs with negative priorities
	UPDATE queue SET priority = priority+1 WHERE priority < 0;
	-- remove all paid songs with a 0 priority
	DELETE FROM queue WHERE priority = 0 AND request_type = 2;	
END$$

DROP PROCEDURE IF EXISTS open_table;
$$
CREATE PROCEDURE `open_table`(
	IN table_number int(11),
	OUT success int,
	OUT message varchar(255),
	OUT id_number int(11)
)
proc:BEGIN
	DECLARE row_count int(11); 
	SET row_count = (SELECT COUNT(*) FROM payment WHERE payment.table_num = table_number);
	IF(row_count > 0) THEN
		-- table already has a code
		SET success = 1;
		SET message = "This table has already been opened.";
		SET id_number = -1;
		LEAVE proc;
	END IF;
	
	-- insert new row for this table, set table code and request count to 0
	-- generate random number between 1000 and 9999
	SET success = 0;
	SET message = "Success!";
	SET id_number = 0;
	WHILE(id_number = 0) DO
		SET id_number = (SELECT FLOOR(1000 + RAND() * 8999));
		-- check if this random number is already being used as an ID
		SET row_count = (SELECT COUNT(*) FROM payment WHERE id_num = id_number);
		-- if this number is being used, then generate another random number
		IF(row_count > 0) THEN
			SET id_number = 0;
		END IF;
	END WHILE;

	-- insert row for this table
	INSERT INTO payment VALUES (
			table_number,
			id_number,
			"anon",
			0
		);
END$$

DROP PROCEDURE IF EXISTS change_nickname;
$$
CREATE PROCEDURE change_nickname (
		IN t_num int,
		IN t_code int,
		IN n_name varchar(255),
		OUT success int,
		OUT message varchar(255))
proc: BEGIN
	-- check if this table is already open
	DECLARE rc int(11);
	SET rc = (SELECT COUNT(*) FROM payment WHERE payment.table_num = t_num);
	IF(rc <= 0) THEN
		-- this table is not open
		SET success = 1;
		SET message = "This table is not open.";
		LEAVE proc;
	END IF;
	SET rc = (SELECT COUNT(*) FROM payment WHERE payment.table_num = t_num AND payment.id_num = t_code);
	IF(rc <= 0) THEN
		-- table exists, but not the right password
		SET success = 1;
		SET message = "This is not the right code for this table";
		LEAVE proc;
	END IF;
	-- update nickname
	SET success = 0;
	SET message = "Success!";
	UPDATE payment SET payment.nickname = n_name WHERE payment.table_num = t_num AND payment.id_num = t_code;

END$$

DROP PROCEDURE IF EXISTS play_playlist
$$
CREATE PROCEDURE `play_playlist`(
IN playlist_ID int(11),
	OUT success tinyint(1),
	OUT message nvarchar(255)
)
proc:BEGIN
	DECLARE temp int(11);
	-- what playlist is being used; put into temp
	SET temp = (SELECT COUNT(*) FROM playlist WHERE ( playlist_ID = playlistID ));

	IF(temp < 1) THEN			
		SET success = 1;
		SET message = "This playlist does not exist.";
		LEAVE proc;
	ELSE
		-- check if we want to clear the queue first; put into temp.
		SET temp = (SELECT constantValue FROM constants WHERE constantKey = "clear_queue");

		IF(temp = 1) THEN
			TRUNCATE queue;
		END IF;

		-- add playlist to queue
		INSERT INTO queue
		SELECT songID, floor(rand() * 10) + 10 as randNum, 0, 0 FROM playlist WHERE ( playlist_ID = playlistID );  -- assigns random priority to each song.  This would shuffle
																											   -- the songs.  They are assigned low priorities so that when a 
																											  --  customer selects a song, it will beat out all the songs from the
																												-- playlist
		SET success = 0;
		SET message = "Playlist successfully added to the queue!";

END IF;

END$$

DROP PROCEDURE IF EXISTS cancel_request
$$
CREATE PROCEDURE `cancel_request`(
	IN song_id int(11),
	IN t_num int(11),
	IN t_code int(11),
	IN req_type tinyint(1),
	IN user_type int(11),					-- 0 is user, 1 is waiter or admin
	OUT success tinyint(1),
	OUT message nvarchar(255)
)
BEGIN
	DECLARE ch int;

	-- check if song is in the queue
	SET ch = (SELECT COUNT(*) FROM queue WHERE ( song_id = songID AND t_num = requested_by));
	IF(ch < 1) THEN
		SET success = 1;
		SET message = "The song selected by this user is no longer in the queue, or was never selected.";
	ELSE
		-- Determine what kind of user is attempting to cancel the request
		IF(user_type = 1) THEN -- waitress/admin trying to remove the song
			DELETE FROM queue WHERE song_id = songID AND t_num = requested_by;
			UPDATE payment SET num_requests = num_requests-1 WHERE table_num = t_code;
			SET success = 0;
			SET message = "Song removed from queue";
		ELSE	
			SET success = 1;
			SET message = "Please contact a waiter/waitress in order to cancel a song request.";
		END IF;
	END IF;

END$$

DROP PROCEDURE request_song
$$
CREATE PROCEDURE `request_song`(
	IN song_id int(11),
	IN t_num int(11),
	IN t_code int(11),
	IN req_type tinyint(1),
	OUT success tinyint(1),
	OUT message nvarchar(255)
)
proc:BEGIN
	DECLARE rc int;
	SET rc = (SELECT COUNT(*) FROM payment WHERE (table_num = t_num AND id_num = t_code));
	
	-- check that the table and table code match
	IF(rc != 1) THEN
		SET success = 1;
		-- if not, check if this table has been given a code
		SET rc = (SELECT COUNT(*) FROM payment WHERE table_num = t_num);
		IF(rc < 1) THEN
			SET message = "This table does not have a code yet.";
		ELSE
			SET message = "Incorrect table code for this table number.";
		END IF;		
		LEAVE proc;
	END IF;

	-- check if paid request or vote
	IF(req_type = 0) THEN -- if request is paid
		-- check if song is already in queue
		SET rc = (SELECT COUNT(*) FROM queue WHERE songID = song_id);
		IF(rc > 0) THEN
			-- check if this song is paid request
			SET rc = (SELECT request_type FROM queue WHERE songID = song_id);
			IF(rc = 0) THEN -- the song is in the queue and a paid request
				SET success = 1;
				SET message = "The requested song is already in the queue.";
				LEAVE proc;	
			ELSE -- this song an unpaid song in the queue, make it a paid request
				UPDATE queue SET request_type = 0, priority = 0, time_requested = NOW() WHERE songID = song_id;
			END IF;
		ELSE -- this song is not in queue, insert song into queue
			INSERT INTO queue VALUES (song_id, 1, t_num, 0, NOW());
		END IF;		
		-- increase the number of requests this table has made
		UPDATE payment SET num_requests = num_requests+1 WHERE table_num = t_num;
	
	ELSE -- if requeest is a vote
		-- check that this song is in the queue
		SET rc = (SELECT COUNT(*) FROM queue WHERE songID = song_id);
		IF(rc < 1) THEN
			SET success = 1;
			SET message = "The requested song to vote on is not in queue.";
			LEAVE proc;
		END IF;
		-- check if this song is a paid request
		SET rc = (SELECT request_type FROM queue WHERE songID = song_id);
		IF(rc = 0) THEN
			SET success = 1;
			SET message = "The requested song to vote on is already a paid request.";
			LEAVE proc;
		END IF;
		-- increase the priority of this song
		UPDATE queue SET priority = priority+1 WHERE songID = song_id;
	END IF;

	SET success = 0;
	SET message = "Success!";
END$$

DROP PROCEDURE IF EXISTS allQueue
$$
CREATE PROCEDURE `allQueue`()
BEGIN
	SELECT *
	FROM song s, queue q
	WHERE s.id IN(
		SELECT q.songID 
		FROM queue) 
	ORDER BY priority DESC, request_type DESC, time_requested;
END$$

DROP PROCEDURE IF EXISTS topQueue
$$
CREATE PROCEDURE `topQueue`(IN topRows INT)
BEGIN
	select *
	from song,queue 
	WHERE id = songID 
	ORDER BY priority desc,request_type desc,time_requested 
	LIMIT topRows OFFSET 1;
END$$