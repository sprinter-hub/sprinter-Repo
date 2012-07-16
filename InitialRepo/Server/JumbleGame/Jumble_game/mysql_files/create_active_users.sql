CREATE TABLE active_users
(
	username VARCHAR(40) NOT NULL,
	device_id INT UNSIGNED NOT NULL,
	FOREIGN KEY (username) REFERENCES users (username),
	PRIMARY KEY (username)
) ENGINE = InnoDB;

