-- 1.
-- This view is used to display results about cases to the user.
DROP VIEW IF EXISTS CaseLookup;
CREATE VIEW CaseLookup AS
SELECT DISTINCT ca.CaseColloquialName, cr.CrimeNo, cr.CrimeName, cr.StartDate, cr.EndDate, cr.LocDesc, cr.Street, cr.City, cr.State_Territory, cr.Zip, cr.Country, 
	 CASE
  	WHEN cr.Solved = 0 THEN 'No'
  	WHEN cr.Solved = 1 THEN 'Yes'
	 END AS Solved, 
   GROUP_CONCAT(w.WeaponName SEPARATOR ", ") AS WeaponName,
    vi.VictimNo, vi.FirstName AS VFirstName, vi.MiddleName AS VMiddleName, vi.LastName AS VLastName, vi.Gender AS VGender, vi.Race AS VRace, vi.Age AS VAge, vi.Harm,
    a.SuspectNo, a.SFirstName, a.SMiddleName, a.SLastName, a.SGender, a.SRace, a.SAge, a.Motive, a.Alibi, ch.ChargeDate,
    a.Relationship,
    b.EvidenceItemNo, b.EType, b.Item, b.Description, b.Picture, b.Video,
    pl.LegalCount, pl.Guilty_NoContest, pl.PleaDate,
    se.SentenceType AS PleaSentenceType, se.SentenceLength AS PleaSentenceLength,
    CASE 
    	WHEN se.ParoleEligible = 0 THEN 'No'
    	WHEN se.ParoleEligible = 1 THEN 'Yes'
    END AS PleaParoleEligible,
    tv.TrialName, tv.CourtName, tv.TrialStartDate, tv.TrialEndDate, tv.Verdict,
    se2.SentenceType AS TrialSentenceType, se2.SentenceLength AS TrialSentenceLength,
    CASE
    	WHEN se2.ParoleEligible = 0 THEN 'No'
    	WHEN se2.ParoleEligible = 1 THEN 'Yes' 
    END AS TrialParoleEligible
    FROM Cases ca
    LEFT OUTER JOIN Crime cr ON ca.CaseColloquialName = cr.CaseColloquialName
    LEFT OUTER JOIN Victim vi ON vi.CaseColloquialName = cr.CaseColloquialName AND vi.CrimeNo = cr.CrimeNo 
    LEFT OUTER JOIN (SELECT su.CaseColloquialName, su.CrimeNo, su.SuspectNo, su.FirstName AS SFirstName, su.MiddleName AS SMiddleName, su.LastName AS SLastName, su.Gender AS SGender, su.Race AS SRace, su.Age AS SAge, su.Motive, su.Alibi, 
                             shrtv.CaseColloquialNameV, shrtv.CrimeNoV, shrtv.VictimNo, shrtv.Relationship
                     FROM Suspect su 
                     LEFT OUTER JOIN SuspectHasRelationshipToVictim shrtv ON su.CaseColloquialName = shrtv.CaseColloquialNameS AND su.CrimeNo = shrtv.CrimeNoS AND su.SuspectNo = shrtv.SuspectNo
                     ) a ON a.CaseColloquialNameV = vi.CaseColloquialName AND a.CrimeNoV = vi.CrimeNo AND a.VictimNo = vi.VictimNo
    LEFT OUTER JOIN (SELECT ev.EvidenceItemNo, ev.EType, ev.Item, ev.Description, ev.Picture, ev.Video,
        						 eis.CaseColloquialNameS, eis.CrimeNoS, eis.SuspectNo
        				    FROM Evidence ev 
        				    LEFT OUTER JOIN EvidenceImplicatesSuspect eis ON ev.CaseColloquialName = eis.CaseColloquialNameE AND ev.CrimeNo = eis.CrimeNoE AND ev.EvidenceItemNo = eis.EvidenceItemNo
        				    ) b ON b.CaseColloquialNameS = a.CaseColloquialName AND b.CrimeNoS = a.CrimeNo AND b.SuspectNo = a.SuspectNo
   LEFT OUTER JOIN Charged ch ON ch.CaseColloquialName = a.CaseColloquialName AND ch.CrimeNo = a.CrimeNo AND ch.SuspectNo = a.SuspectNo
   LEFT OUTER JOIN Plea pl ON pl.CaseColloquialName = a.CaseColloquialName AND pl.CrimeNo = a.CrimeNo AND pl.SuspectNo = a.SuspectNo
   LEFT OUTER JOIN TrialVerdict tv ON tv.CaseColloquialName = a.CaseColloquialName AND tv.CrimeNo = a.CrimeNo AND tv.SuspectNo = a.SuspectNo
   LEFT OUTER JOIN Sentence se ON se.SentenceID = pl.SentenceID
   LEFT OUTER JOIN Sentence se2 ON se2.SentenceID = tv.SentenceID
   LEFT OUTER JOIN CrimeCarriedOutWithWeapon ccoww ON ccoww.CaseColloquialName = cr.CaseColloquialName AND ccoww.CrimeNo = cr.CrimeNo
   LEFT OUTER JOIN Weapon w ON w.WeaponID = ccoww.WeaponID
   GROUP BY ca.CaseColloquialName, cr.CrimeNo, cr.CrimeName, cr.StartDate, cr.EndDate, cr.LocDesc, cr.Street, cr.City, cr.State_Territory, cr.Zip, cr.Country, cr.Solved,
  		  vi.VictimNo, vi.FirstName, vi.MiddleName, vi.LastName, vi.Gender, vi.Race, vi.Age, vi.Harm,
  		  a.SuspectNo, a.SFirstName, a.SMiddleName, a.SLastName, a.SGender, a.SRace, a.SAge, a.Motive, a.Alibi, ch.ChargeDate,
  		  a.Relationship,
  		  b.EvidenceItemNo, b.EType, b.Item, b.Description, b.Picture, b.Video,
  		  pl.LegalCount, pl.Guilty_NoContest, pl.PleaDate,
  		  PleaSentenceType, PleaSentenceLength, PleaParoleEligible,
  		  tv.TrialName, tv.CourtName, tv.TrialStartDate, tv.TrialEndDate, tv.Verdict,
  		  TrialSentenceType, TrialSentenceLength, TrialParoleEligible;

-- 2. 
-- This procedure is similar to the one above, except it deals with suspects that don't have relationships to victims.
-- This could happen, for instance, if there are no victims of a crime.
-- These suspects would not show up in the above view but we need them for some queries so this view produces those suspects.
DROP VIEW IF EXISTS SuspectLookup;
CREATE VIEW SuspectLookup AS
SELECT cr.CaseColloquialName, cr.CrimeNo, cr.CrimeName, s.SuspectNo, s.FirstName, s.MiddleName, s.LastName, s.Gender, s.Race, s.Age, s.Motive, s.Alibi, ch.ChargeDate, LegalCount, Guilty_NoContest, PleaDate, sen.SentenceType AS PleaSentenceType, sen.SentenceLength AS PleaSentenceLength,
   CASE
      WHEN sen.ParoleEligible = 0 THEN 'No'
      WHEN sen.ParoleEligible = 1 THEN 'Yes'
   END AS PleaParoleEligible,
   TrialName, CourtName, TrialStartDate, TrialEndDate, Verdict, sen2.SentenceType AS TrialSentenceType, sen2.SentenceLength AS TrialSentenceLength,
   CASE
      WHEN sen2.ParoleEligible = 0 THEN 'No'
      WHEN sen2.ParoleEligible = 1 THEN 'Yes'
   END AS TrialParoleEligible
   FROM Suspect s
   JOIN Crime cr ON s.CaseColloquialName = cr.CaseColloquialName AND s.CrimeNo = cr.CrimeNo
   LEFT OUTER JOIN Charged ch ON s.CaseColloquialName = ch.CaseColloquialName AND s.CrimeNo = ch.CrimeNo AND s.SuspectNo = ch.SuspectNo
   LEFT OUTER JOIN Plea p ON p.CaseColloquialName = s.CaseColloquialName AND p.CrimeNo = s.CrimeNo AND p.SuspectNo = s.SuspectNo
   LEFT OUTER JOIN TrialVerdict tv ON tv.CaseColloquialName = s.CaseColloquialName AND tv.CrimeNo = s.CrimeNo AND tv.SuspectNo = s.SuspectNo
   LEFT OUTER JOIN Sentence sen ON sen.SentenceID = p.SentenceID
   LEFT OUTER JOIN Sentence sen2 ON sen2.SentenceID = tv.SentenceID;

-- 3.
-- This view allows us to find the number of times a certain crime was committed for a given suspect and case.
DROP VIEW IF EXISTS SuspectCrimeCountLookup;
CREATE VIEW SuspectCrimeCountLookup AS
SELECT DISTINCT s.CaseColloquialName, s.CrimeNo, CrimeName, s.SuspectNo, FirstName, MiddleName, LastName, Gender, Race, Age, ChargeDate, Motive, Alibi, COUNT(*) AS NumberOfTimes
FROM Suspect s
NATURAL JOIN Crime
LEFT OUTER JOIN Charged ch ON ch.CaseColloquialName = s.CaseColloquialName AND ch.CrimeNo = s.CrimeNo AND ch.SuspectNo = s.SuspectNo
GROUP BY s.CaseColloquialName, s.CrimeNo, CrimeName, s.SuspectNo, FirstName, MiddleName, LastName, Gender, Race, Age, ChargeDate, Motive, Alibi
ORDER BY s.CaseColloquialName, s.CrimeNo, s.SuspectNo;

-- 4.
-- This view allows us to search pleas but also have information on the victims of the crime the suspect is pleading to.
DROP VIEW IF EXISTS PleaLookup;
CREATE VIEW PleaLookup AS
SELECT DISTINCT sl.CaseColloquialName, sl.CrimeNo, sl.CrimeName, VictimConcat, SuspectNo, FirstName, MiddleName, LastName, Age, Race, Gender, Motive, Alibi, ChargeDate, LegalCount, Guilty_NoContest, PleaDate, PleaSentenceType, PleaSentenceLength, PleaParoleEligible
FROM SuspectLookup sl
JOIN (SELECT cr.CaseColloquialName, cr.CrimeNo, CrimeName, COALESCE(GROUP_CONCAT(CONCAT(FirstName, ' ', LastName) SEPARATOR ', '), '[No Victim Given]') AS VictimConcat
     FROM Crime cr
     LEFT OUTER JOIN Victim v ON cr.CaseColloquialName = v.CaseColloquialName AND cr.CrimeNo = v.CrimeNo
     GROUP BY cr.CaseColloquialName, cr.CrimeNo, CrimeName) a ON a.CaseColloquialName = sl.CaseColloquialName AND a.CrimeNo = sl.CrimeNo;
         
-- 5.
-- This views allows us to search trials but also have information on the victims of the crime the suspect went to trial for.
DROP VIEW IF EXISTS TrialLookup;
CREATE VIEW TrialLookup AS
SELECT DISTINCT sl.CaseColloquialName, sl.CrimeNo, sl.CrimeName, VictimConcat, sl.SuspectNo, FirstName, MiddleName, LastName, Age, Race, Gender, Motive, Alibi, ChargeDate, sl.TrialName, CourtName, sl.TrialStartDate, TrialEndDate, Verdict, TrialSentenceType, TrialSentenceLength, TrialParoleEligible
FROM SuspectLookup sl
JOIN (SELECT cr.CaseColloquialName, cr.CrimeNo, CrimeName, COALESCE(GROUP_CONCAT(CONCAT(FirstName, ' ', LastName) SEPARATOR ', '), '[No Victim Given]') AS VictimConcat
      FROM Crime cr
      LEFT OUTER JOIN Victim v ON cr.CaseColloquialName = v.CaseColloquialName AND cr.CrimeNo = v.CrimeNo
      GROUP BY cr.CaseColloquialName, cr.CrimeNo, CrimeName) a ON a.CaseColloquialName = sl.CaseColloquialName AND a.CrimeNo = sl.CrimeNo
LEFT OUTER JOIN (SELECT DISTINCT CaseColloquialName, CrimeNo, SuspectNo, TrialName, TrialStartDate
		 FROM TrialVerdict) tv ON tv.CaseColloquialName = sl.CaseColloquialName AND tv.CrimeNo = sl.CrimeNo AND tv.SuspectNo = sl.SuspectNo AND tv.TrialName = sl.TrialName AND tv.TrialStartDate = sl.TrialStartDate;
