USE droidbox;

-- this script can be used to generate data for testing
-- highlight the section corresponding to what you want
-- added to the database and cllick the lighting bolt button
-- to execute only the statements you have highlighted

-- add the first 6 songs from the libray to queue
-- works assuming you have songs with ids 1-6 in the library
-- songs 1-3 are paid requests
INSERT INTO queue VALUES (1, 0, 0, now());
INSERT INTO queue VALUES (2, 0, 0, now());
INSERT INTO queue VALUES (3, 0, 0, now());

-- songs 4-6 are unpaid songs which can be voted on
INSERT INTO queue VALUES (4, 0, 1, now());
INSERT INTO queue VALUES (5, 0, 1, now());
INSERT INTO queue VALUES (6, 0, 1, now());



-- use this to open a table
-- change the value set to table_num to open a different table
-- in the output window, you will see the code that has been
-- generated for the table under the "@t_code" column
SET @table_num = 1;
CALL open_table(@table_num, @success, @message, @t_code);
SELECT @success, @message, @t_code;

-- close a table
-- the number of requests made by this table number will
-- be displayed in the output window under the "@num_req" column
SET @table_num = 1;
CALL close_table(@table_num, @success, @message, @num_req);
SELECT @success, @message, @num_req;