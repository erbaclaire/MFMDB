use mfmdb;
SET foreign_key_checks = 0; -- can create and drop in any order now.

-- Drop Tables (if they exist)
DROP TABLE IF EXISTS Episode;
DROP TABLE IF EXISTS Cases;
DROP TABLE IF EXISTS Crime;
DROP TABLE IF EXISTS Weapon;
DROP TABLE IF EXISTS Victim;
DROP TABLE IF EXISTS Evidence;
DROP TABLE IF EXISTS Suspect;
DROP TABLE IF EXISTS Charged;
DROP TABLE IF EXISTS Plea;
DROP TABLE IF EXISTS TrialVerdict;
DROP TABLE IF EXISTS Sentence;
DROP TABLE IF EXISTS EpisodeDiscussesCase;
DROP TABLE IF EXISTS CrimeCarriedOutWithWeapon;
DROP TABLE IF EXISTS EvidenceImplicatesSuspect;
DROP TABLE IF EXISTS SuspectHasRelationshipToVictim;

-- Create Tables
CREATE TABLE Episode(
       EpisodeNumber INT(5) PRIMARY KEY NOT NULL,
       Title VARCHAR(100) NOT NULL,
       DateAired DATE NOT NULL,
       RecLocation VARCHAR(75) NOT NULL,
       Link VARCHAR(400) NOT NULL,
       EpisodeLength DECIMAL(5,2) NOT NULL
);

CREATE TABLE Cases(
       CaseColloquialName VARCHAR(150) PRIMARY KEY NOT NULL,
       Picture VARCHAR(1000) NOT NULL,
       InfoLink VARCHAR(1000) NOT NULL
);

CREATE TABLE Crime(
       CaseColloquialName VARCHAR(150) NOT NULL,
       CrimeNo INT(3) NOT NULL,
       CrimeName VARCHAR(100) NOT NULL,
       StartDate DATE NOT NULL,
       EndDate DATE NOT NULL,
       LocDesc VARCHAR(200),
       Street VARCHAR(100),
       City VARCHAR(75) NOT NULL,
       State_Territory VARCHAR(10) NOT NULL,
       Zip VARCHAR(16),
       Country CHAR(2) NOT NULL,
       Solved BIT NOT NULL,
       FOREIGN KEY (CaseColloquialName) REFERENCES Cases(CaseColloquialName) ON UPDATE CASCADE ON DELETE CASCADE,
       PRIMARY KEY (CaseColloquialName, CrimeNo)
);

CREATE TABLE Weapon(
       WeaponID INT(8) PRIMARY KEY NOT NULL AUTO_INCREMENT,
       WeaponName VARCHAR(100) NOT NULL
);

CREATE TABLE Victim(
       CaseColloquialName VARCHAR(150) NOT NULL,
       CrimeNo INT(3) NOT NULL,
       VictimNo INT(3) NOT NULL,
       FirstName VARCHAR(100) NOT NULL,
       MiddleName VARCHAR(100),
       LastName VARCHAR(100) NOT NULL,
       Gender CHAR(1) NOT NULL,
       Race VARCHAR(40) NOT NULL,
       Age INT(3) NOT NULL,
       Harm VARCHAR(200) NOT NULL,
       FOREIGN KEY (CaseColloquialName, CrimeNo) REFERENCES Crime(CaseColloquialName, CrimeNo) ON UPDATE CASCADE ON DELETE CASCADE,
       PRIMARY KEY (CaseColloquialName, CrimeNo, VictimNo)
);

CREATE TABLE Evidence(
       CaseColloquialName VARCHAR(150) NOT NULL,
       CrimeNo INT(3) NOT NULL,
       EvidenceItemNo INT(3) NOT NULL,
       EType VARCHAR(50) NOT NULL,
       Item VARCHAR(100) NOT NULL,
       Description VARCHAR(1000) NOT NULL,
       Picture VARCHAR(1000),
       Video VARCHAR(1000),
       FOREIGN KEY (CaseColloquialName, CrimeNo) REFERENCES Crime(CaseColloquialName, CrimeNo) ON UPDATE CASCADE ON DELETE CASCADE,
       PRIMARY KEY (CaseColloquialName, CrimeNo, EvidenceItemNo)
);

CREATE TABLE Suspect(
       CaseColloquialName VARCHAR(150) NOT NULL,
       CrimeNo INT(3) NOT NULL,
       SuspectNo INT(3) NOT NULL,
       FirstName VARCHAR(100),
       MiddleName VARCHAR(100),
       LastName VARCHAR(100) NOT NULL,
       Gender CHAR(1),
       Race VARCHAR(30),
       Age INT(3),
       Motive VARCHAR(1000) NOT NULL,
       Alibi VARCHAR(1000),
       FOREIGN KEY (CaseColloquialName, CrimeNo) REFERENCES Crime(CaseColloquialName, CrimeNo) ON UPDATE CASCADE ON DELETE CASCADE,
       PRIMARY KEY (CaseColloquialName, CrimeNo, SuspectNo)
);

CREATE TABLE Charged(
       CaseColloquialName VARCHAR(150) NOT NULL,
       CrimeNo INT(3) NOT NULL,
       SuspectNo INT(3) NOT NULL,
       ChargeDate DATE NOT NULL,
       FOREIGN KEY (CaseColloquialName, CrimeNo, SuspectNo) REFERENCES Suspect(CaseColloquialName, CrimeNo, SuspectNo) ON UPDATE CASCADE ON DELETE CASCADE,
       PRIMARY KEY (CaseColloquialName, CrimeNo, SuspectNo)
);

CREATE TABLE Plea(
       PleaID INT(8) PRIMARY KEY NOT NULL AUTO_INCREMENT,
       CaseColloquialName VARCHAR(150) NOT NULL,
       CrimeNo INT(3) NOT NULL,
       SuspectNo INT(3) NOT NULL,
       LegalCount VARCHAR(100) NOT NULL,
       Guilty_NoContest VARCHAR(30) NOT NULL,
       PleaDate DATE NOT NULL,
       SentenceID INT(8),
       FOREIGN KEY (CaseColloquialName, CrimeNo, SuspectNo) REFERENCES Charged(CaseColloquialName, CrimeNo, SuspectNo) ON UPDATE CASCADE ON DELETE CASCADE,
       FOREIGN KEY (SentenceID) REFERENCES Sentence(SentenceID) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE TrialVerdict(
       TrialVerdictID INT(8) PRIMARY KEY NOT NULL AUTO_INCREMENT,
       CaseColloquialName VARCHAR(150) NOT NULL,
       CrimeNo INT(3) NOT NULL,
       SuspectNo INT(3) NOT NULL,
       TrialName VARCHAR(200) NOT NULL,
       CourtName VARCHAR(150),
       TrialStartDate DATE,
       TrialEndDate DATE,
       Verdict VARCHAR(20),
       SentenceID INT(8),
       FOREIGN KEY (CaseColloquialName, CrimeNo, SuspectNo) REFERENCES Charged(CaseColloquialName, CrimeNo, SuspectNo) ON UPDATE CASCADE ON DELETE CASCADE,
       FOREIGN KEY (SentenceID) REFERENCES Sentence(SentenceID) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE Sentence(
       SentenceID INT(8) PRIMARY KEY NOT NULL AUTO_INCREMENT,
       SentenceType VARCHAR(50) NOT NULL,
       SentenceLength VARCHAR(100),
       ParoleEligible BIT
);

CREATE TABLE EpisodeDiscussesCase(
       EpisodeNumber INT(5) NOT NULL,
       CaseColloquialName VARCHAR(150) NOT NULL,
       FOREIGN KEY (EpisodeNumber) REFERENCES Episode(EpisodeNumber) ON UPDATE CASCADE ON DELETE CASCADE,
       FOREIGN KEY (CaseColloquialName) REFERENCES Cases(CaseColloquialName) ON UPDATE CASCADE ON DELETE CASCADE,
       PRIMARY KEY (EpisodeNumber, CaseColloquialName)
);

CREATE TABLE CrimeCarriedOutWithWeapon(
       CaseColloquialName VARCHAR(150) NOT NULL,
       CrimeNo INT(3) NOT NULL,
       WeaponID INT(8) NOT NULL,
       FOREIGN KEY (CaseColloquialName, CrimeNo) REFERENCES Crime(CaseColloquialName, CrimeNo) ON UPDATE CASCADE ON DELETE CASCADE,
       FOREIGN KEY (WeaponID) REFERENCES Weapon(WeaponID) ON UPDATE CASCADE ON DELETE CASCADE,
       PRIMARY KEY (CaseColloquialName, CrimeNo, WeaponID)
);

CREATE TABLE EvidenceImplicatesSuspect(
       CaseColloquialNameE VARCHAR(150) NOT NULL,
       CrimeNoE INT(3) NOT NULL,
       EvidenceItemNo INT(3) NOT NULL,
       CaseColloquialNameS VARCHAR(150) NOT NULL,
       CrimeNoS INT(3) NOT NULL,
       SuspectNo INT(3) NOT NULL,
       FOREIGN KEY (CaseColloquialNameS, CrimeNoS, SuspectNo) REFERENCES Suspect(CaseColloquialName, CrimeNo, SuspectNo) ON UPDATE CASCADE ON DELETE CASCADE,
       FOREIGN KEY (CaseColloquialNameE, CrimeNoE, EvidenceItemNo) REFERENCES Evidence(CaseColloquialName, CrimeNo, EvidenceItemNo) ON UPDATE CASCADE ON DELETE CASCADE,
       PRIMARY KEY (CaseColloquialNameS, CrimeNoS, CaseColloquialNameE, CrimeNoE, EvidenceItemNo, SuspectNo)
);

CREATE TABLE SuspectHasRelationshipToVictim(
       CaseColloquialNameS VARCHAR(150) NOT NULL,
       CrimeNoS INT(3) NOT NULL,
       SuspectNo INT(3) NOT NULL,
       CaseColloquialNameV VARCHAR(150) NOT NULL,
       CrimeNoV INT(3) NOT NULL,
       VictimNo INT(3) NOT NULL,
       Relationship VARCHAR(50) NOT NULL,
       FOREIGN KEY (CaseColloquialNameS, CrimeNoS, SuspectNo) REFERENCES Suspect(CaseColloquialName, CrimeNo, SuspectNo) ON UPDATE CASCADE ON DELETE CASCADE,
       FOREIGN KEY (CaseColloquialNameV, CrimeNoV, VictimNo) REFERENCES Victim(CaseColloquialName, CrimeNo, VictimNo) ON UPDATE CASCADE ON DELETE CASCADE,
       PRIMARY KEY (CaseColloquialNameS, CrimeNoS, CaseColloquialNameV, CrimeNoV, SuspectNo, VictimNo)
);

SET foreign_key_checks = 1; 