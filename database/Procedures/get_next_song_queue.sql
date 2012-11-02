delimiter $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_next_song_queue`(
	IN prev_song_id int(11),
	OUT next_song_id int(11)
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
	-- if this song was unpaid
	ELSE
		UPDATE queue SET priority = cooldown - 1 WHERE songID = prev_song_id;
	END IF;
	-- increment the priorities of the songs with negative priorities
	UPDATE queue SET priority = priority+1 WHERE priority < 0;
	-- remove all paid songs with a 0 priority
	DELETE FROM queue WHERE priority = 0 AND request_type = 2;
	-- select the next song to be played
	SET next_song_id = (SELECT songID FROM queue ORDER BY 
						request_type, 
						priority DESC, 
						time_requested
						LIMIT 1);
END$$

