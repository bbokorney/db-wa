delimiter $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `make_table_code`(
	IN table_number int(11),
	OUT success int,
	OUT id_number int(11)
)
proc:BEGIN
	DECLARE row_count int(11); 
	SET row_count = (SELECT COUNT(*) FROM payment WHERE payment.table_num = table_number);
	IF(row_count > 0) THEN
		-- table already has a code
		SET success = 1;
		SET id_number = -1;
		LEAVE proc;
	END IF;
	
	-- insert new row for this table, set table code and request count to 0
	-- generate random number between 1000 and 9999
	SET success = 0;
	SET id_number = 0;
	WHILE(id_number = 0) DO
		SET id_number = (SELECT FLOOR(1000 + RAND() * 8999));
		-- check if this random number is already being used as an ID
		SET row_count = (SELECT COUNT(*) FROM payment WHERE id_num = id_number);
		-- if this number is being used, then generate another random number
		IF(row_count > 0) THEN
			SET id_number = 0;
		END IF;
	END WHILE;

	-- insert row for this table
	INSERT INTO payment VALUES (
			table_number,
			id_number,
			0
		);
END$$

SELECT * FROM droidbox.payment;