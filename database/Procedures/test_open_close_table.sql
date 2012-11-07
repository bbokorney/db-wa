USE droidbox;

DROP TABLE IF EXISTS output;
CREATE TEMPORARY TABLE output (
	success int,
	message varchar(255),
	num int
);

SET @table_number = 12;

-- open then close a table
CALL open_table(@table_number, "The Marchini Family", @success, @message, @id_num);
INSERT INTO output VALUES(@success, @message, @id_num);
CALL close_table(@table_number, @success, @message, @num_req);
INSERT INTO output VALUES(@success, @message, @num_req);

-- close a table that isn't open
SET @table_number = 11;
CALL close_table(@table_number, @success, @message, @num_req);
INSERT INTO output VALUES(@success, @message, @num_req);

-- open a table that is already open
CALL open_table(@table_number, "Big Bowl's table", @success, @message, @id_num);
INSERT INTO output VALUES(@success, @message, @id_num);
CALL open_table(@table_number, "Dwayne", @success, @message, @id_num);
INSERT INTO output VALUES(@success, @message, @id_num);
SET @table_number = 1;
CALL close_table(@table_number, @success, @message, @num_req);
 INSERT INTO output VALUES(@success, @message, @num_req);

-- select the output
SELECT * FROM output;
DROP TABLE output;