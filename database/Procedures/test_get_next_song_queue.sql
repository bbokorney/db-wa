USE droidbox;

DROP TABLE IF EXISTS output;
CREATE TEMPORARY TABLE output (
	prev_song_id int,
	next_song_id int
);

-- clear song and queue tables
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
-- sleeps are to make sure songs have different times requested
-- insert paid songs
INSERT INTO queue VALUES (1, -3, 2, now());
SELECT SLEEP(1);
INSERT INTO queue VALUES (2, 1, 0, now());
SELECT SLEEP(1);
INSERT INTO queue VALUES (3, 1, 0, now());
SELECT SLEEP(1);

-- insert unpaid songs
INSERT INTO queue VALUES (4, 0, 1, now());
SELECT SLEEP(1);
INSERT INTO queue VALUES (5, 0, 1, now());
SELECT SLEEP(1);
INSERT INTO queue VALUES (6, 0, 1, now());
SELECT SLEEP(1);

SET @prev_song_id = 0;
SET @next_song_id = 0;

SET @prev_song_id = 2;
CALL get_next_song_queue(@prev_song_id, @next_song_id);
INSERT INTO output VALUES (@prev_song_id, @next_song_id);
SET @prev_song_id = @next_song_id;
SELECT * FROM queue;

CALL get_next_song_queue(@prev_song_id, @next_song_id);
INSERT INTO output VALUES (@prev_song_id, @next_song_id);
SET @prev_song_id = @next_song_id;
SELECT * FROM queue;

CALL get_next_song_queue(@prev_song_id, @next_song_id);
INSERT INTO output VALUES (@prev_song_id, @next_song_id);
SET @prev_song_id = @next_song_id;
SELECT * FROM queue;

CALL get_next_song_queue(@prev_song_id, @next_song_id);
INSERT INTO output VALUES (@prev_song_id, @next_song_id);
SET @prev_song_id = @next_song_id;
SELECT * FROM queue;

CALL get_next_song_queue(@prev_song_id, @next_song_id);
INSERT INTO output VALUES (@prev_song_id, @next_song_id);
SET @prev_song_id = @next_song_id;
SELECT * FROM queue;

CALL get_next_song_queue(@prev_song_id, @next_song_id);
INSERT INTO output VALUES (@prev_song_id, @next_song_id);
SET @prev_song_id = @next_song_id;
SELECT * FROM queue;

CALL get_next_song_queue(@prev_song_id, @next_song_id);
INSERT INTO output VALUES (@prev_song_id, @next_song_id);
SET @prev_song_id = @next_song_id;
SELECT * FROM queue;

CALL get_next_song_queue(@prev_song_id, @next_song_id);
INSERT INTO output VALUES (@prev_song_id, @next_song_id);
SET @prev_song_id = @next_song_id;
SELECT * FROM queue;

TRUNCATE queue;
TRUNCATE songs;
SELECT * FROM output;
DROP TABLE output;
