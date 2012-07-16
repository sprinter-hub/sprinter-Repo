CREATE TABLE passwords
(
	username VARCHAR(40) NOT NULL,
	password VARCHAR(40) NOT NULL,
	FOREIGN KEY (username) REFERENCES users (username),
	PRIMARY KEY (username)
) ENGINE = InnoDB;

