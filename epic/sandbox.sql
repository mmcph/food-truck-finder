
/**ALTER DATABASE database_name? CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE profile (
	profileId BINARY(16) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profileIsOwner BOOLEAN NOT NULL,
	profileUserName VARCHAR(32) NOT NULL,
	profileFirstName VARCHAR(64) NOT NULL,
	profileLastName VARCHAR(64) NOT NULL,
	UNIQUE(profileId),
	UNIQUE(profileEmail),
	UNIQUE(profileUserName),
	PRIMARY KEY(profileId)
)

CREATE TABLE favorite (
	favoriteTruckId BINARY(16) NOT NULL,
	favoriteProfileId BINARY(16) NOT NULL,
	UNIQUE(favoriteTruckId),
	UNIQUE(favoriteProfileId),
	FOREIGN KEY(favoriteTruckId) REFERENCES truck(truckId),
	FOREIGN KEY(favoriteProfileId) REFERENCES profile(profileId)
)

CREATE TABLE vote (
	voteProfileId BINARY(16) NOT NULL,
	voteTruckId BINARY(16) NOT NULL,
	voteValue TINYINT NOT NULL,
	UNIQUE(voteProfileId),
	UNIQUE(voteTruckId),
	INDEX(voteValue),
	FOREIGN KEY(voteProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(voteTruckId) REFERENCES truck (truckId)
)
**/

