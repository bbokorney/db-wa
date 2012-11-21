delimiter $$

CREATE PROCEDURE `check_credentials`(
	IN t_num int,
	IN t_code int,
	OUT success int,
	OUT message varchar(255)
)
BEGIN
	DECLARE rc int;
	SET rc = (SELECT COUNT(*) FROM payment WHERE (table_num = t_num AND id_num = t_code));
	
	-- check that the table and table code match
	IF(rc != 1) THEN
		SET success = 1;
		-- if not, check if this table has been given a code
		SET rc = (SELECT COUNT(*) FROM payment WHERE table_num = t_num);
		IF(rc < 1) THEN
			SET message = "This table does not have a code yet.";
		ELSE
			SET message = "Incorrect table code for this table number.";
		END IF;				
	ELSE
		SET success = 0;
		SET message = "Success!";
	END IF;
END$$

