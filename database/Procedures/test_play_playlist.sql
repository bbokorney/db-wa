-- queue in the beginning
select * from queue;

-- delete everything in queue, then add playlist 1
CALL play_playlist(1, 1, @success, @message);
select @message;
select @success;
select * from queue;

-- delete everything in queue, then add playlist 2
CALL play_playlist(1, 2, @success, @message);
select @message;
select @success;
select * from queue;

-- don't delete anything in the queue, add playlist 1
CALL play_playlist(0, 1, @success, @message);
select @message;
select @success;
select * from queue;

-- try to add playlist that doesn't exist
CALL play_playlist(1, 44, @success, @message);
select @message;
select @success;
select * from queue;