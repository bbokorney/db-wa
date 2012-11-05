delimiter $$

CREATE DEFINER=``@`` PROCEDURE `play_playlist`(
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

