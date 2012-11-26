delimiter $$

CREATE PROCEDURE `get_nickname`(
	IN t_num int,
	OUT n_name varchar(255),
	OUT success tinyint(1),
	OUT message nvarchar(255))
proc: BEGIN
	DECLARE rc int(11);
	SET rc = (SELECT COUNT(*) FROM payment WHERE payment.table_num = t_num);
	IF(rc <= 0) THEN
		-- this table is not open
		SET success = 1;
		SET message = "This table is not open.";
		LEAVE proc;
	END IF;

	SET n_name = (SELECT nickname FROM payment WHERE payment.table_num = t_num);
END$$

