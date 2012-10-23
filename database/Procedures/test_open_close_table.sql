USE droidbox;
SET @table_number = 10;

-- open then close a table
CALL open_table(@table_number, @success, @message, @id_num);
SELECT @success, @message, @id_num;
CALL close_table(@table_number, @success, @message, @num_req);
SELECT @success, @message, @num_req;

-- close a table that isn't open
SET @table_number = 11;
CALL close_table(@table_number, @success, @message, @num_req);
SELECT @success, @message, @num_req;

-- open a table that is already open
CALL open_table(@table_number, @success, @message, @id_num);
SELECT @success, @message, @id_num;
CALL open_table(@table_number, @success, @message, @id_num);
SELECT @success, @message, @id_num;