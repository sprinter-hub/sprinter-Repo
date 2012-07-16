CREATE TABLE users
(
	userId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	# Email id of the user
	fbId INT UNSIGNED,
	username VARCHAR(40) NOT NULL,
	displayName VARCHAR(20),
	firstName VARCHAR(20),
	lastName VARCHAR(20),
	avatar VARCHAR(200),
	# Date of birth
	dob DATE NOT NULL,
	gender ENUM('F','M') NOT NULL,
	isActivated bool,
	activationCode VARCHAR(200),
	PRIMARY KEY (userId),
	UNIQUE KEY (username)
) ENGINE = InnoDB;

