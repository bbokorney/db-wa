USE droidbox;

SET show_queue = 1;

DROP TABLE IF EXISTS output;
CREATE TEMPORARY TABLE output (
	success int,
	message varchar(255),
	prev_song_id int,
	next_song_id int
);

-- clear song and queue tables
	songID int,
	priority int,
	request_type int,
	time_requested datetime
);
TRUNCATE queue;
TRUNCATE song;
-- insert songs 1-6 into the library
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);
INSERT INTO song VALUES (0, "title", "artist", "album", "rock", 0, 0, "filepath", 1);

-- insert test songs into queue
-- insert paid songs
INSERT INTO queue VALUES (1, -3, 0, now());
INSERT INTO queue VALUES (2, 0, 0, now());
INSERT INTO queue VALUES (3, 0, 0, now());

-- insert unpaid songs
INSERT INTO queue VALUES (4, 0, 1, now());
INSERT INTO queue VALUES (5, 1, 1, now());
INSERT INTO queue VALUES (6, 2, 1, now());

SET @prev_song_id = 0;
SET @next_song_id = 0;

SET @prev_song_id = 2;
CALL get_next_song_queue(@prev_song_id, @success, @message, @next_song_id);
INSERT INTO output VALUES (@success, @message, @next_song_id, @prev_song_id);
SET @prev_song_id = @next_song_id;

SELECT * FROM (output, queue, song);
DROP TABLE output;
