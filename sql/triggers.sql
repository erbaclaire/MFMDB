-- NOTE: These triggers allow for logging of removed and added data. Foreign key contsraints that have DELETE on DELETE will not be put in the log tables so it is up to the user to recognize
--       say, Crime 1 is removed, then all Victims, Suspects, Trials, Pleas, Evidence associated with that crime will also be removed.
-- 1.
-- Maintain change logs of added and removed episodes
-- Change logs
DROP TABLE IF EXISTS AddedEpisodes;
CREATE TABLE AddedEpisodes(
  EpisodeNumber INT(5) NOT NULL,
  Title VARCHAR(100) NOT NULL,
  DateAired DATE NOT NULL,
  RecLocation VARCHAR(75) NOT NULL,
  Link VARCHAR(400) NOT NULL,
  EpisodeLength DECIMAL(5,2) NOT NULL,
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (EpisodeNumber, UserMakingChange, DateChanged)
);
DROP TABLE IF EXISTS DeletedEpisodes;
CREATE TABLE DeletedEpisodes(
    EpisodeNumber INT(5) NOT NULL,
    Title VARCHAR(100) NOT NULL,
    DateAired DATE NOT NULL,
    RecLocation VARCHAR(75) NOT NULL,
    Link VARCHAR(400) NOT NULL,
    EpisodeLength DECIMAL(5,2) NOT NULL,
    UserMakingChange VARCHAR(200) NOT NULL,
    DateChanged DATETIME NOT NULL,
    PRIMARY KEY (EpisodeNumber, UserMakingChange, DateChanged)
);
   
-- Triggers
DROP TRIGGER IF EXISTS AddedEpisodeTrigger;
DELIMITER |
CREATE TRIGGER AddedEpisodeTrigger
AFTER INSERT ON Episode
FOR EACH ROW
BEGIN
	INSERT INTO AddedEpisodes(EpisodeNumber, Title, DateAired, RecLocation, Link, EpisodeLength, UserMakingChange, DateChanged)
	VALUES(NEW.EpisodeNumber, NEW.Title, NEW.DateAired, NEW.RecLocation, NEW.Link, NEW.EpisodeLength, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;
DROP TRIGGER IF EXISTS DeletedEpisodeTrigger;
DELIMITER |
CREATE TRIGGER DeletedEpisodeTrigger
AFTER DELETE ON Episode
FOR EACH ROW
BEGIN
	INSERT INTO DeletedEpisodes(EpisodeNumber, Title, DateAired, RecLocation, Link, EpisodeLength, UserMakingChange, DateChanged)
	VALUES(OLD.EpisodeNumber, OLD.Title, OLD.DateAired, OLD.RecLocation, OLD.Link, OLD.EpisodeLength, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;


-- 2.
-- Maintain change logs of added and removed cases
-- Change logs
DROP TABLE IF EXISTS AddedCases;
CREATE TABLE AddedCases(
  CaseColloquialName VARCHAR(150) NOT NULL,
  Picture VARCHAR(1000) NOT NULL,
  InfoLink VARCHAR(1000) NOT NULL,
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (CaseColloquialName, UserMakingChange, DateChanged)
);
DROP TABLE IF EXISTS DeletedCases;
CREATE TABLE DeletedCases(
  CaseColloquialName VARCHAR(150) NOT NULL,
  Picture VARCHAR(1000) NOT NULL,
  InfoLink VARCHAR(1000) NOT NULL,
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (CaseColloquialName, UserMakingChange, DateChanged)
);    
 
-- Triggers  
DROP TRIGGER IF EXISTS AddedCaseTrigger;
DELIMITER |
CREATE TRIGGER AddedCaseTrigger
AFTER INSERT ON Cases
FOR EACH ROW
BEGIN
	INSERT INTO AddedCases(CaseColloquialName, Picture, InfoLink, UserMakingChange, DateChanged)
	VALUES(NEW.CaseColloquialName, NEW.Picture, NEW.InfoLink, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;
DROP TRIGGER IF EXISTS DeletedCaseTrigger;
DELIMITER |
CREATE TRIGGER DeletedCaseTrigger
AFTER DELETE ON Cases
FOR EACH ROW
BEGIN
	INSERT INTO DeletedCases(CaseColloquialName, Picture, InfoLink, UserMakingChange, DateChanged)
	VALUES(OLD.CaseColloquialName, OLD.Picture, OLD.InfoLink, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;

-- 3.
-- Maintain change logs of added and removed crimes
-- Change logs
DROP TABLE IF EXISTS AddedCrimes;
CREATE TABLE AddedCrimes(
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
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (CaseColloquialName, CrimeNo, UserMakingChange, DateChanged)
);
DROP TABLE IF EXISTS DeletedCrimes;
CREATE TABLE DeletedCrimes(
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
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (CaseColloquialName, CrimeNo, UserMakingChange, DateChanged)
);

-- Triggers
DROP TRIGGER IF EXISTS AddedCrimeTrigger;
DELIMITER |
CREATE TRIGGER AddedCrimeTrigger
AFTER INSERT ON Crime
FOR EACH ROW
BEGIN
	INSERT INTO AddedCrimes(CaseColloquialName, CrimeNo, CrimeName, StartDate, EndDate, LocDesc, Street, City, State_Territory, Zip, Country, Solved, UserMakingChange, DateChanged)
	VALUES(NEW.CaseColloquialName, NEW.CrimeNo, NEW.CrimeName, NEW.StartDate, NEW.EndDate, NEW.LocDesc, NEW.Street, NEW.City, NEW.State_Territory, NEW.Zip, NEW.Country, NEW.Solved, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;
DROP TRIGGER IF EXISTS DeletedCrimeTrigger;
DELIMITER |
CREATE TRIGGER DeletedCrimeTrigger
AFTER DELETE ON Crime
FOR EACH ROW
BEGIN
	INSERT INTO DeletedCrimes(CaseColloquialName, CrimeNo, CrimeName, StartDate, EndDate, LocDesc, Street, City, State_Territory, Zip, Country, Solved, UserMakingChange, DateChanged)
	VALUES(OLD.CaseColloquialName, OLD.CrimeNo, OLD.CrimeName, OLD.StartDate, OLD.EndDate, OLD.LocDesc, OLD.Street, OLD.City, OLD.State_Territory, OLD.Zip, OLD.Country, OLD.Solved, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;

-- 4.
-- Maintain change logs of added and removed victims
-- Change logs
DROP TABLE IF EXISTS AddedVictims;
CREATE TABLE AddedVictims(
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
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,  
  PRIMARY KEY (CaseColloquialName, CrimeNo, VictimNo, UserMakingChange, DateChanged)
);
DROP TABLE IF EXISTS DeletedVictims;
CREATE TABLE DeletedVictims(
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
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,  
  PRIMARY KEY (CaseColloquialName, CrimeNo, VictimNo, UserMakingChange, DateChanged)
);

-- Triggers
DROP TRIGGER IF EXISTS AddedVictimTrigger;
DELIMITER |
CREATE TRIGGER AddedVictimTrigger
AFTER INSERT ON Victim
FOR EACH ROW
BEGIN
  INSERT INTO AddedVictims(CaseColloquialName, CrimeNo, VictimNo, FirstName, MiddleName, LastName, Gender, Race, Age, Harm, UserMakingChange, DateChanged)
  VALUES(NEW.CaseColloquialName, NEW.CrimeNo, NEW.VictimNo, NEW.FirstName, NEW.MiddleName, NEW.LastName, NEW.Gender, NEW.Race, NEW.Age, NEW.Harm, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;
DROP TRIGGER IF EXISTS DeletedVictimTrigger;
DELIMITER |
CREATE TRIGGER DeletedVictimTrigger
AFTER DELETE ON Victim
FOR EACH ROW
BEGIN
  INSERT INTO DeletedVictims(CaseColloquialName, CrimeNo, VictimNo, FirstName, MiddleName, LastName, Gender, Race, Age, Harm, UserMakingChange, DateChanged)
  VALUES(OLD.CaseColloquialName, OLD.CrimeNo, OLD.VictimNo, OLD.FirstName, OLD.MiddleName, OLD.LastName, OLD.Gender, OLD.Race, OLD.Age, OLD.Harm, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;

-- 5.
-- Maintain change logs of added and removed evidence
-- Change logs
DROP TABLE IF EXISTS AddedEvidence;
CREATE TABLE AddedEvidence(
  CaseColloquialName VARCHAR(150) NOT NULL,
  CrimeNo INT(3) NOT NULL,
  EvidenceItemNo INT(3) NOT NULL,
  EType VARCHAR(50) NOT NULL,
  Item VARCHAR(100) NOT NULL,
  Description VARCHAR(1000) NOT NULL,
  Picture VARCHAR(1000),
  Video VARCHAR(1000),
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL, 
  PRIMARY KEY (CaseColloquialName, CrimeNo, EvidenceItemNo, UserMakingChange, DateChanged)
);
DROP TABLE IF EXISTS DeletedEvidence;
CREATE TABLE DeletedEvidence(
  CaseColloquialName VARCHAR(150) NOT NULL,
  CrimeNo INT(3) NOT NULL,
  EvidenceItemNo INT(3) NOT NULL,
  EType VARCHAR(50) NOT NULL,
  Item VARCHAR(100) NOT NULL,
  Description VARCHAR(1000) NOT NULL,
  Picture VARCHAR(1000),
  Video VARCHAR(1000),
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL, 
  PRIMARY KEY (CaseColloquialName, CrimeNo, EvidenceItemNo, UserMakingChange, DateChanged)
);

-- Triggers
DROP TRIGGER IF EXISTS AddedEvidenceTrigger;
DELIMITER |
CREATE TRIGGER AddedEvidenceTrigger
AFTER INSERT ON Evidence
FOR EACH ROW
BEGIN
  INSERT INTO AddedEvidence(CaseColloquialName, CrimeNo, EvidenceItemNo, EType, Item, Description, Picture, Video, UserMakingChange, DateChanged)
  VALUES(NEW.CaseColloquialName, NEW.CrimeNo, NEW.EvidenceItemNo, NEW.EType, NEW.Item, NEW.Description, NEW.Picture, NEW.Video, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;
DROP TRIGGER IF EXISTS DeletedEvidenceTrigger;
DELIMITER |
CREATE TRIGGER DeletedEvidenceTrigger
AFTER DELETE ON Evidence
FOR EACH ROW
BEGIN
  INSERT INTO DeletedEvidence(CaseColloquialName, CrimeNo, EvidenceItemNo, EType, Item, Description, Picture, Video, UserMakingChange, DateChanged)
  VALUES(OLD.CaseColloquialName, OLD.CrimeNo, OLD.EvidenceItemNo, OLD.EType, OLD.Item, OLD.Description, OLD.Picture, OLD.Video, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;

-- 6.
-- Maintain change logs of added and removed suspects
-- Change logs
DROP TABLE IF EXISTS AddedSuspects;
CREATE TABLE AddedSuspects(
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
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL, 
  PRIMARY KEY (CaseColloquialName, CrimeNo, SuspectNo, UserMakingChange, DateChanged)
);
DROP TABLE IF EXISTS DeletedSuspects;
CREATE TABLE DeletedSuspects(
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
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL, 
  PRIMARY KEY (CaseColloquialName, CrimeNo, SuspectNo, UserMakingChange, DateChanged)
);

-- Triggers
DROP TRIGGER IF EXISTS AddedSuspectTrigger;
DELIMITER |
CREATE TRIGGER AddedSuspectTrigger
AFTER INSERT ON Suspect
FOR EACH ROW
BEGIN
  INSERT INTO AddedSuspects(CaseColloquialName, CrimeNo, SuspectNo, FirstName, MiddleName, LastName, Gender, Race, Age, Motive, Alibi, UserMakingChange, DateChanged)
  VALUES(NEW.CaseColloquialName, NEW.CrimeNo, NEW.SuspectNo, NEW.FirstName, NEW.MiddleName, NEW.LastName, NEW.Gender, NEW.Race, NEW.Age, NEW.Motive, NEW.Alibi, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;
DROP TRIGGER IF EXISTS DeletedSuspectTrigger;
DELIMITER |
CREATE TRIGGER DeletedSuspectTrigger
AFTER DELETE ON Suspect
FOR EACH ROW
BEGIN
  INSERT INTO DeletedSuspects(CaseColloquialName, CrimeNo, SuspectNo, FirstName, MiddleName, LastName, Gender, Race, Age, Motive, Alibi, UserMakingChange, DateChanged)
  VALUES(OLD.CaseColloquialName, OLD.CrimeNo, OLD.SuspectNo, OLD.FirstName, OLD.MiddleName, OLD.LastName, OLD.Gender, OLD.Race, OLD.Age, OLD.Motive, OLD.Alibi, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;

-- 7.
-- Maintain change logs of added charged individuals
-- Change logs
DROP TABLE IF EXISTS AddedCharged;
CREATE TABLE AddedCharged(
  CaseColloquialName VARCHAR(150) NOT NULL,
  CrimeNo INT(3) NOT NULL,
  SuspectNo INT(3) NOT NULL,
  ChargeDate DATE NOT NULL,
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (CaseColloquialName, CrimeNo, SuspectNo, UserMakingChange, DateChanged)
);

-- Triggers
DROP TRIGGER IF EXISTS AddedChargedTrigger;
DELIMITER |
CREATE TRIGGER AddedChargedTrigger
AFTER INSERT ON Charged
FOR EACH ROW
BEGIN
  INSERT INTO AddedCharged(CaseColloquialName, CrimeNo, SuspectNo, ChargeDate, UserMakingChange, DateChanged)
  VALUES(NEW.CaseColloquialName, NEW.CrimeNo, NEW.SuspectNo, NEW.ChargeDate, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;

-- 8.
-- Maintain change logs of added and removed pleas
-- Change logs
DROP TABLE IF EXISTS AddedPleas;
CREATE TABLE AddedPleas(
  PleaID INT(8) NOT NULL,
  CaseColloquialName VARCHAR(150) NOT NULL,
  CrimeNo INT(3) NOT NULL,
  SuspectNo INT(3) NOT NULL,
  LegalCount VARCHAR(100) NOT NULL,
  Guilty_NoContest VARCHAR(30) NOT NULL,
  PleaDate DATE NOT NULL,
  SentenceID INT(8),
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (PleaID, UserMakingChange, DateChanged)       
);
DROP TABLE IF EXISTS DeletedPleas;
CREATE TABLE DeletedPleas(
  PleaID INT(8) NOT NULL,
  CaseColloquialName VARCHAR(150) NOT NULL,
  CrimeNo INT(3) NOT NULL,
  SuspectNo INT(3) NOT NULL,
  LegalCount VARCHAR(100) NOT NULL,
  Guilty_NoContest VARCHAR(30) NOT NULL,
  PleaDate DATE NOT NULL,
  SentenceID INT(8),
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (PleaID, UserMakingChange, DateChanged)       
);

-- Triggers
DROP TRIGGER IF EXISTS AddedPleaTrigger;
DELIMITER |
CREATE TRIGGER AddedPleaTrigger
AFTER INSERT ON Plea
FOR EACH ROW
BEGIN
  INSERT INTO AddedPleas(PleaID, CaseColloquialName, CrimeNo, SuspectNo, LegalCount, Guilty_NoContest, PleaDate, SentenceID, UserMakingChange, DateChanged)
  VALUES(NEW.PleaID, NEW.CaseColloquialName, NEW.CrimeNo, NEW.SuspectNo, NEW.LegalCount, NEW.Guilty_NoContest, NEW.PleaDate, NEW.SentenceID, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;
DROP TRIGGER IF EXISTS DeletedPleaTrigger;
DELIMITER |
CREATE TRIGGER DeletedPleaTrigger
AFTER DELETE ON Plea
FOR EACH ROW
BEGIN
  INSERT INTO DeletedPleas(PleaID, CaseColloquialName, CrimeNo, SuspectNo, LegalCount, Guilty_NoContest, PleaDate, SentenceID, UserMakingChange, DateChanged)
  VALUES(OLD.PleaID, OLD.CaseColloquialName, OLD.CrimeNo, OLD.SuspectNo, OLD.LegalCount, OLD.Guilty_NoContest, OLD.PleaDate, OLD.SentenceID, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;

-- 8.
-- Maintain change logs of added and removed trials
-- Change logs
DROP TABLE IF EXISTS AddedTrials;
CREATE TABLE AddedTrials(
  TrialVerdictID INT(8) NOT NULL,
  CaseColloquialName VARCHAR(150) NOT NULL,
  CrimeNo INT(3) NOT NULL,
  SuspectNo INT(3) NOT NULL,
  TrialName VARCHAR(200) NOT NULL,
  CourtName VARCHAR(150),
  TrialStartDate DATE,
  TrialEndDate DATE,
  Verdict VARCHAR(20),
  SentenceID INT(8),
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (TrialVerdictID, UserMakingChange, DateChanged)   
);
DROP TABLE IF EXISTS DeletedTrials;
CREATE TABLE DeletedTrials(
  TrialVerdictID INT(8) NOT NULL,
  CaseColloquialName VARCHAR(150) NOT NULL,
  CrimeNo INT(3) NOT NULL,
  SuspectNo INT(3) NOT NULL,
  TrialName VARCHAR(200) NOT NULL,
  CourtName VARCHAR(150),
  TrialStartDate DATE,
  TrialEndDate DATE,
  Verdict VARCHAR(20),
  SentenceID INT(8),
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (TrialVerdictID, UserMakingChange, DateChanged)   
);

-- Triggers
DROP TRIGGER IF EXISTS AddedTrialTrigger;
DELIMITER |
CREATE TRIGGER AddedTrialTrigger
AFTER INSERT ON TrialVerdict
FOR EACH ROW
BEGIN
  INSERT INTO AddedTrials(TrialVerdictID, CaseColloquialName, CrimeNo, SuspectNo, TrialName, CourtName, TrialStartDate, TrialEndDate, Verdict, SentenceID, UserMakingChange, DateChanged)
  VALUES(NEW.TrialVerdictID, NEW.CaseColloquialName, NEW.CrimeNo, NEW.SuspectNo, NEW.TrialName, NEW.CourtName, NEW.TrialStartDate, NEW.TrialEndDate, NEW.Verdict, NEW.SentenceID, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;
DROP TRIGGER IF EXISTS DeletedTrialTrigger;
DELIMITER |
CREATE TRIGGER DeletedTrialTrigger
AFTER DELETE ON TrialVerdict 
FOR EACH ROW
BEGIN
  INSERT INTO DeletedTrials(TrialVerdictID, CaseColloquialName, CrimeNo, SuspectNo, TrialName, CourtName, TrialStartDate, TrialEndDate, Verdict, SentenceID, UserMakingChange, DateChanged)
  VALUES(OLD.TrialVerdictID, OLD.CaseColloquialName, OLD.CrimeNo, OLD.SuspectNo, OLD.TrialName, OLD.CourtName, OLD.TrialStartDate, OLD.TrialEndDate, OLD.Verdict, OLD.SentenceID, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;

-- 8.
-- Maintain change log of added sentences
-- Change log
DROP TABLE IF EXISTS AddedSentences;
CREATE TABLE AddedSentences(
  SentenceID INT(8) NOT NULL,
  SentenceType VARCHAR(50) NOT NULL,
  SentenceLength VARCHAR(100),
  ParoleEligible BIT,
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (SentenceID, UserMakingChange, DateChanged)   
);

-- Trigger
DROP TRIGGER IF EXISTS AddedSentenceTrigger;
DELIMITER |
CREATE TRIGGER AddedSentenceTrigger
AFTER INSERT ON Sentence 
FOR EACH ROW
BEGIN
  INSERT INTO AddedSentences(SentenceID, SentenceType, SentenceLength, ParoleEligible, UserMakingChange, DateChanged)
  VALUES(NEW.SentenceID, NEW.SentenceType, NEW.SentenceLength, NEW.ParoleEligible, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;

-- 9.
-- Maintain change log of added weapons
-- Change log
DROP TABLE IF EXISTS AddedWeapons;
CREATE TABLE AddedWeapons(
  WeaponID INT(8) NOT NULL,
  WeaponName VARCHAR(50) NOT NULL,
  UserMakingChange VARCHAR(200) NOT NULL,
  DateChanged DATETIME NOT NULL,
  PRIMARY KEY (WeaponID, UserMakingChange, DateChanged)   
);

-- Trigger
DROP TRIGGER IF EXISTS AddedWeaponTrigger;
DELIMITER |
CREATE TRIGGER AddedWeaponTrigger
AFTER INSERT ON Weapon
FOR EACH ROW
BEGIN
  INSERT INTO AddedWeapons(WeaponID, WeaponName, UserMakingChange, DateChanged)
  VALUES(NEW.WeaponID, NEW.WeaponName, CURRENT_USER(), CURRENT_TIMESTAMP());
END; |
DELIMITER ;

