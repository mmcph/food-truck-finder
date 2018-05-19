ALTER DATABASE foodtruck CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS truckCategory;
DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS truck;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profileIsOwner TINYINT UNSIGNED NOT NULL,
 	profileFirstName VARCHAR(64) NOT NULL,
	profileLastName VARCHAR(64) NOT NULL,
	profileUserName VARCHAR(32) NOT NULL,
	UNIQUE(profileEmail),
	UNIQUE(profileUserName),
	INDEX(profileId),
	PRIMARY KEY(profileId)
);

CREATE TABLE category (
	categoryId TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	categoryName VARCHAR(32) NOT NULL,
	UNIQUE(categoryName),
	PRIMARY KEY(categoryId)
);

CREATE TABLE truck (
	truckId BINARY(16) NOT NULL,
	truckProfileId BINARY(16) NOT NULL,
	truckBio VARCHAR(1024),
	truckIsOpen TINYINT NOT NULL,
	truckLatitude DECIMAL(10,8),
	truckLongitude DECIMAL(11,8),
	truckName VARCHAR(64) NOT NULL,
	truckPhone VARCHAR(24),
	truckUrl VARCHAR(128),
	INDEX(truckProfileId),
	INDEX(truckName),
	FOREIGN KEY(truckProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(truckId)
);

CREATE TABLE vote (
	voteProfileId BINARY(16) NOT NULL,
	voteTruckId BINARY(16) NOT NULL,
	voteValue TINYINT NOT NULL,
	INDEX(voteProfileId),
	INDEX(voteTruckId),
	FOREIGN KEY(voteProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(voteTruckId) REFERENCES truck(truckId),
	PRIMARY KEY(voteProfileId, voteTruckId)
);

CREATE TABLE truckCategory (
	truckCategoryCategoryId TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	truckCategoryTruckId BINARY(16) NOT NULL,
	INDEX(truckCategoryCategoryId),
	INDEX(truckCategoryTruckId),
	FOREIGN KEY(truckCategoryCategoryId) REFERENCES category(categoryId),
	FOREIGN KEY(truckCategoryTruckId) REFERENCES truck(truckId),
	PRIMARY KEY(truckCategoryCategoryId, truckCategoryTruckId)
);

CREATE TABLE favorite (
	favoriteTruckId BINARY(16) NOT NULL,
  favoriteProfileId BINARY(16) NOT NULL,
  INDEX(favoriteTruckId),
	INDEX(favoriteProfileId),
	FOREIGN KEY(favoriteTruckId) REFERENCES truck(truckId),
	FOREIGN KEY(favoriteProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(favoriteTruckId, favoriteProfileId)
);

