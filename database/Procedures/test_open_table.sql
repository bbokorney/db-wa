use droidbox;
SET @table_num = 10;
CALL open_table(@table_num, @success, @id_num);
SELECT @success, @id_num;