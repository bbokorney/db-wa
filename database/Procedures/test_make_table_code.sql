use droidbox;
SET @table_num = 11;
-- SELECT COUNT(*) FROM payment WHERE table_num = @table_num;
 CALL make_table_code(@table_num, @success, @id_num);
 SELECT @success, @id_num;