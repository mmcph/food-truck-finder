ALTER DATABASE foodtruck CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS truckCategory;
DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS truck;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId BINARY(16) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profileIsOwner TINYINT NOT NULL,
	profileUserName VARCHAR(32) NOT NULL,
	profileFirstName VARCHAR(64) NOT NULL,
	profileLastName VARCHAR(64) NOT NULL,
	UNIQUE(profileId),
	UNIQUE(profileEmail),
	UNIQUE(profileUserName),
	INDEX(profileId),
	PRIMARY KEY(profileId)
);

CREATE TABLE category (
	categoryId TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	categoryName VARCHAR(32) NOT NULL,
	UNIQUE(categoryId),
	UNIQUE(categoryName),
	INDEX(categoryId),
	INDEX(categoryName),
	PRIMARY KEY(categoryId)
);

CREATE TABLE truck (
	truckId BINARY(16) NOT NULL,
	truckProfileId BINARY(16) NOT NULL,
	truckName VARCHAR(64) NOT NULL,
	truckLongitude DECIMAL(11,8),
	truckLatitude DECIMAL(10,8),
	truckIsOpen TINYINT NOT NULL,
	truckBio VARCHAR(1024),
	truckPhone VARCHAR(24),
	truckUrl VARCHAR(128),
	UNIQUE(truckId),
	UNIQUE(truckProfileId),
	-- UNIQUE(truckName), <—maybe not? for companies with multiple trucks under the same company name (same for truckProfileId
	INDEX(truckId),
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
	INDEX(voteValue),
	FOREIGN KEY(voteProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(voteTruckId) REFERENCES truck(truckId)
);

CREATE TABLE truckCategory (
	truckCategoryCategoryId TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	truckCategoryTruckId BINARY(16) NOT NULL,
	INDEX(truckCategoryCategoryId),
	INDEX(truckCategoryTruckId),
	FOREIGN KEY(truckCategoryCategoryId) REFERENCES category(categoryId),
	FOREIGN KEY(truckCategoryTruckId) REFERENCES truck(truckId)
);

CREATE TABLE favorite (
	favoriteTruckId BINARY(16) NOT NULL,
	favoriteProfileId BINARY(16) NOT NULL,
	INDEX(favoriteTruckId),
	INDEX(favoriteProfileId),
	FOREIGN KEY(favoriteTruckId) REFERENCES truck(truckId),
	FOREIGN KEY(favoriteProfileId) REFERENCES profile(profileId)
);

