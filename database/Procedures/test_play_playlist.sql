-- queue in the beginning
select * from queue;
-- Make it so that queue is erased before adding a playlist to the queue
UPDATE constants SET constantValue := 1 WHERE constantKey = "clear_queue";
-- view current constants
SELECT * from constants;

-- add playlist 1 
CALL play_playlist(1, @success, @message);
select @message;
select @success;
select * from queue;

-- add playlist 2
CALL play_playlist(2, @success, @message);
select @message;
select @success;
select * from queue;

-- Make it so that queue is not erased when adding a playlist to the queue
UPDATE constants SET constantValue := 0 WHERE constantKey = "clear_queue";
SELECT * from constants;

-- add playlist 1
CALL play_playlist(1, @success, @message);
select @message;
select @success;
select * from queue;

-- try to add playlist that doesn't exist
CALL play_playlist(44, @success, @message);
select @message;
select @success;
select * from queue;