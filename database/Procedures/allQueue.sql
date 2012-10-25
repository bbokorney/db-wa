delimiter $$

CREATE DEFINER=``@`` PROCEDURE `allQueue`()
BEGIN
	SELECT *
	FROM song s, queue q
	WHERE s.id IN(
		SELECT q.songID 
		FROM queue) 
	ORDER BY priority DESC, request_type DESC, time_requested;
END$$

