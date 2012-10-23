use droidbox;
SET @table_num = 11;
CALL open_table(@table_num, @success, @message, @id_num);
SELECT @success, @message, @id_num;