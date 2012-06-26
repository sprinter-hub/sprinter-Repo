CREATE TABLE friends
(
	username VARCHAR(40) NOT NULL,
	friendname VARCHAR(40) NOT NULL,
	confirmed boolean,
	FOREIGN KEY (username) REFERENCES users (username),
	FOREIGN KEY (friendname) REFERENCES users (username),
	PRIMARY KEY (username, friendname)
) ENGINE = InnoDB;

