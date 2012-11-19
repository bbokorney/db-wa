delimiter $$

CREATE PROCEDURE `close_table`(
	IN table_number int(11),
	OUT success int,
	OUT message varchar(255),
	OUT num_req int(11)
)
proc:BEGIN
	-- check if this table is already open
	DECLARE rc int(11);
	SET rc = (SELECT COUNT(*) FROM payment WHERE payment.table_num = table_number);
	IF(rc <= 0) THEN
		-- this table is not open
		SET success = 1;
		SET message = "This table is not open.";
		SET num_req = -1;
		LEAVE proc;
	END IF;
	-- return the number of requests this table made
	SET success = 0;
	SET message = "Success!";
	SET num_req = (SELECT num_requests FROM payment WHERE payment.table_num = table_number);
	-- remove the row corresponding to this table
	DELETE FROM payment WHERE payment.table_num = table_number;
END$$

