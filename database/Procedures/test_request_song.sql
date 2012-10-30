use droidbox;

DROP TABLE IF EXISTS output;
CREATE TEMPORARY TABLE output (
	success int,
	message varchar(255),
	row_count int,
	song_id int,
	priority int,
	request_type int,
	time_requested datetime,
	table_id int,
	num_requests int
);
SET @t_num = 0;
SET @t_code = 0;
SET @t_code0 = 0;
SET @t_code1 = 0;
SET @t_num_invalid = -1;
SET @t_code_invalid = -1;
SET @req_type = 0;
SET @req_type_paid = 0;
SET @req_type_unpaid = 1;
SET @song_id = 1;
-- create songs with ids 1 through 6
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);

SET @t_num = 0;
CALL open_table(@t_num, @success, @message, @t_code0);
-- open table for table number 1
SET @t_num = 1;
CALL open_table(@t_num, @success, @message, @t_code1);

-- request a song not in queue (normal)
SET @song_id = 1;
SET @t_num = 0;
SET @t_code = @t_code0;
SET @req_type = @req_type_paid;
CALL request_song(@song_id, @t_num, @t_code, @req_type, @success, @message);
INSERT INTO output VALUES (
	@success,
	@message,
	(SELECT COUNT(*) FROM queue),
	@song_id,
	(SELECT priority FROM queue WHERE @song_id = songID),
	(SELECT request_type FROM queue WHERE @song_id = songID),
	(SELECT time_requested FROM queue WHERE @song_id = songID),
	@t_num,
	(SELECT num_requests FROM payment WHERE @t_num = table_num)
);

-- request another song not in the queue (normal)
SET @song_id = 2;
CALL request_song(@song_id, @t_num, @t_code, @req_type, @success, @message);
INSERT INTO output VALUES (
	@success,
	@message,
	(SELECT COUNT(*) FROM queue),
	@song_id,
	(SELECT priority FROM queue WHERE @song_id = songID),
	(SELECT request_type FROM queue WHERE @song_id = songID),
	(SELECT time_requested FROM queue WHERE @song_id = songID),
	@t_num,
	(SELECT num_requests FROM payment WHERE @t_num = table_num)
);

-- vote on a song in queue (normal)
-- insert an unpaid request into the queue to be voted on
INSERT INTO queue VALUES (3, 0, 1, NOW());
SET @song_id = 3;
SET @req_type = @req_type_unpaid;
CALL request_song(@song_id, @t_num, @t_code, @req_type, @success, @message);
INSERT INTO output VALUES (
	@success,
	@message,
	(SELECT COUNT(*) FROM queue),
	@song_id,
	(SELECT priority FROM queue WHERE @song_id = songID),
	(SELECT request_type FROM queue WHERE @song_id = songID),
	(SELECT time_requested FROM queue WHERE @song_id = songID),
	@t_num,
	(SELECT num_requests FROM payment WHERE @t_num = table_num)
);

-- request a song not in the queue as user 1 (normal)
SET @song_id = 4;
SET @t_num = 1;
SET @t_code = @t_code1;
SET @req_type = @req_type_paid;
CALL request_song(@song_id, @t_num, @t_code, @req_type, @success, @message);
INSERT INTO output VALUES (
	@success,
	@message,
	(SELECT COUNT(*) FROM queue),
	@song_id,
	(SELECT priority FROM queue WHERE @song_id = songID),
	(SELECT request_type FROM queue WHERE @song_id = songID),
	(SELECT time_requested FROM queue WHERE @song_id = songID),
	@t_num,
	(SELECT num_requests FROM payment WHERE @t_num = table_num)
);

--  vote on an unpaid song with table 1 (normal)
SET @song_id = 3;
SET @req_type = @req_type_unpaid;
CALL request_song(@song_id, @t_num, @t_code, @req_type, @success, @message);
INSERT INTO output VALUES (
	@success,
	@message,
	(SELECT COUNT(*) FROM queue),
	@song_id,
	(SELECT priority FROM queue WHERE @song_id = songID),
	(SELECT request_type FROM queue WHERE @song_id = songID),
	(SELECT time_requested FROM queue WHERE @song_id = songID),
	@t_num,
	(SELECT num_requests FROM payment WHERE @t_num = table_num)
);

-- request song not in queue with invalid table number and table code (error)
SET @song_id = 5;
SET @req_type = @req_type_paid;
SET @t_code = @t_code_invalid;
CALL request_song(@song_id, @t_num, @t_code, @req_type, @success, @message);
INSERT INTO output VALUES (
	@success,
	@message,
	(SELECT COUNT(*) FROM queue),
	@song_id,
	(SELECT priority FROM queue WHERE @song_id = songID),
	(SELECT request_type FROM queue WHERE @song_id = songID),
	(SELECT time_requested FROM queue WHERE @song_id = songID),
	@t_num,
	(SELECT num_requests FROM payment WHERE @t_num = table_num)
);

-- vote with invalid table number and table code (error)
SET @t_num = @t_num_invalid;
CALL request_song(@song_id, @t_num, @t_code, @req_type, @success, @message);
INSERT INTO output VALUES (
	@success,
	@message,
	(SELECT COUNT(*) FROM queue),
	@song_id,
	(SELECT priority FROM queue WHERE @song_id = songID),
	(SELECT request_type FROM queue WHERE @song_id = songID),
	(SELECT time_requested FROM queue WHERE @song_id = songID),
	@t_num,
	(SELECT num_requests FROM payment WHERE @t_num = table_num)
);

-- request a paid song in queue (error)
SET @t_num = 0;
SET @t_code = @t_code0;
SET @song_id = 1;
CALL request_song(@song_id, @t_num, @t_code, @req_type, @success, @message);
INSERT INTO output VALUES (
	@success,
	@message,
	(SELECT COUNT(*) FROM queue),
	@song_id,
	(SELECT priority FROM queue WHERE @song_id = songID),
	(SELECT request_type FROM queue WHERE @song_id = songID),
	(SELECT time_requested FROM queue WHERE @song_id = songID),
	@t_num,
	(SELECT num_requests FROM payment WHERE @t_num = table_num)
);

-- vote on a paid song in queue (error)
SET @req_type = @req_type_unpaid;
CALL request_song(@song_id, @t_num, @t_code, @req_type, @success, @message);
INSERT INTO output VALUES (
	@success,
	@message,
	(SELECT COUNT(*) FROM queue),
	@song_id,
	(SELECT priority FROM queue WHERE @song_id = songID),
	(SELECT request_type FROM queue WHERE @song_id = songID),
	(SELECT time_requested FROM queue WHERE @song_id = songID),
	@t_num,
	(SELECT num_requests FROM payment WHERE @t_num = table_num)
);

-- vote on song not in queue (error)
SET @song_id = -1;
CALL request_song(@song_id, @t_num, @t_code, @req_type, @success, @message);
INSERT INTO output VALUES (
	@success,
	@message,
	(SELECT COUNT(*) FROM queue),
	@song_id,
	(SELECT priority FROM queue WHERE @song_id = songID),
	(SELECT request_type FROM queue WHERE @song_id = songID),
	(SELECT time_requested FROM queue WHERE @song_id = songID),
	@t_num,
	(SELECT num_requests FROM payment WHERE @t_num = table_num)
);


SELECT * FROM output;
DROP TABLE output;
-- truncate payment;
truncate song;
truncate queue;
truncate payment;