CREATE TABLE users
(
	user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	# Email id of the user
	username VARCHAR(40) NOT NULL,
	display_name VARCHAR(20),
	first_name VARCHAR(20),
	last_name VARCHAR(20),
	avatar VARCHAR(200),
	# Date of birth
	dob DATE NOT NULL,
	gender ENUM('F','M') NOT NULL,
	PRIMARY KEY (user_id),
	UNIQUE KEY (username)
) ENGINE = InnoDB;

