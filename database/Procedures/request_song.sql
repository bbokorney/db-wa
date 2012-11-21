delimiter $$

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

