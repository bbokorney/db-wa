delimiter $$

CREATE DEFINER=``@`` PROCEDURE `cancel_request`(
	IN song_id int(11),
	IN t_num int(11),
	IN req_type tinyint(1),
	IN user_type int(11),					-- 0 is user, 1 is waiter or admin
	OUT success tinyint(1),
	OUT message nvarchar(255)
)
BEGIN
	DECLARE ch int;

	-- check if song is in the queue
	SET ch = (SELECT COUNT(*) FROM queue WHERE ( song_id = songID ));
	IF(ch < 1) THEN
		SET success = 1;
		SET message = "This song is no longer in the queue, or was never selected.";
	ELSE
		-- Determine what kind of user is attempting to cancel the request
		IF(user_type = 1) THEN -- waitress/admin trying to remove the song
			DELETE FROM queue WHERE song_id = songID;
			UPDATE payment SET num_requests = num_requests-1 WHERE table_num = t_num;
			SET success = 0;
			SET message = "Success!";
		ELSE	-- user trying to remove the song.  Right now there is no way for a user to remove a song 
				-- since a song in the queue cannot identify what table number requested it.  If you want, you can have a user 
				-- remove any song, even if he didn't request it.  However, users should not be able to remove other people's songs! 
				-- That's why I didn't implement that in.
			SET success = 1;
			SET message = "Please contact a waiter/waitress in order to cancel a song request.";
		END IF;
	END IF;

END$$

