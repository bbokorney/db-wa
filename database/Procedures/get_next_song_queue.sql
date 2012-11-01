delimiter $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_next_song_queue`(
	IN prev_song_id int(11),
	OUT success int,
	OUT message varchar(255),
	OUT next_song_id int(11)
)
BEGIN

END$$

