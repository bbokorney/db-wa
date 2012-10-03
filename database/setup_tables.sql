CREATE TABLE song (
	id INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255) NOT NULL,
	artist VARCHAR(255) NOT NULL,
	album VARCHAR(255) NOT NULL,
	genre ENUM('Blues','Classical','Country','Electronic/Indie','Folk','Jazz','Reggae','Rock','Unknown') NOT NULL DEFAULT 'Unknown',
	length INT NOT NULL,
	num_played INT NOT NULL DEFAULT 0,
	file_path TEXT NOT NULL,
	enabled BOOL NOT NULL DEFAULT 1,
	PRIMARY KEY (id)
);

CREATE TABLE playlist (
	playlistID INT NOT NULL,	
	songID INT NOT NULL
);

CREATE TABLE playlist_name (
	playlistID INT NOT NULL,
	playlistName VARCHAR(255) NOT NULL,
	PRIMARY KEY (playlistID)
);

CREATE TABLE queue (
	songID INT NOT NULL,
	priority INT NOT NULL DEFAULT 0,
	request_type BOOL NOT NULL DEFAULT 0,
	time_requested DATETIME NOT NULL DEFAULT 0,
	PRIMARY KEY (songID)
);

CREATE TABLE payment (
	table_num INT NOT NULL,
	id_num INT NOT NULL,
	num_requests INT NOT NULL,
	PRIMARY KEY (table_num)
);

