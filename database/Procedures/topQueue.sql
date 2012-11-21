delimiter $$

CREATE PROCEDURE `topQueue`(IN topRows INT)
BEGIN
	select *
	from song,queue 
	WHERE id = songID 
	ORDER BY priority desc,request_type desc,time_requested 
	LIMIT topRows OFFSET 1;
END$$

