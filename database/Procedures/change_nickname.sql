delimiter $$

CREATE PROCEDURE `change_nickname`(
		IN t_num int,
		IN t_code int,
		IN n_name varchar(255),
		OUT success int,
		OUT message varchar(255))
proc: BEGIN
	-- check if this table is already open
	DECLARE rc int(11);
	SET rc = (SELECT COUNT(*) FROM payment WHERE payment.table_num = t_num);
	IF(rc <= 0) THEN
		-- this table is not open
		SET success = 1;
		SET message = "This table is not open.";
		LEAVE proc;
	END IF;
	SET rc = (SELECT COUNT(*) FROM payment WHERE payment.table_num = t_num AND payment.id_num = t_code);
	IF(rc <= 0) THEN
		-- table exists, but not the right password
		SET success = 1;
		SET message = "This is not the right code for this table";
		LEAVE proc;
	END IF;
	-- update nickname
	SET success = 0;
	SET message = "Success!";
	UPDATE payment SET payment.nickname = n_name WHERE payment.table_num = t_num AND payment.id_num = t_code;

END$$

