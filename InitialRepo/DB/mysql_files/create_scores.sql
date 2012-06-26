CREATE TABLE scores
(
	username VARCHAR(40) NOT NULL,
	score  INT UNSIGNED NOT NULL,
	FOREIGN KEY (username) REFERENCES users (username),
	PRIMARY KEY (username)
) ENGINE = InnoDB;
