use droidbox;
SET @table_num = 10;
CALL make_table_code(@table_num, @success, @id_num);
SELECT @success, @id_num;