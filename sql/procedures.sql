-- 1.
-- Crime, Suspect, Victim and Evidence have CrimeNo, SuspectNo, VictimNo, and EvidenceItemNo, respectively -- these are not serial/autoincrement fields.
-- Say a user deleted Crime 2 in a Crime that has 5 cases. We want each CrimeNo to move up one.
-- Deleting Crime 2, because of my foreign keys, will remove any reference to Crime 2 in any of the other tables.
-- But if we leave it as that we will have Crimes 1, 3, 4, and 5. I intend to have drop down menus for users to choose a crime number and this would look odd. Therefore, we want to move 3, 4, and 5 up one.
-- Since I have a cascade effect on all tables that reference Crime, these tables will be updated, as well.

-- Crime No Move Up
DROP PROCEDURE IF EXISTS MoveCrimeNoUp;
DELIMITER |
CREATE PROCEDURE MoveCrimeNoUp(
IN CCN VARCHAR(150),
IN CrimeNoRemoved INT(3)
)
BEGIN
        DECLARE CrNo INT(3);
        DECLARE CaseCN VARCHAR(150);
        DECLARE flag INT DEFAULT 0;

        DECLARE CrimesAfterRemovedCrime CURSOR FOR
                SELECT CaseColloquialName, CrimeNo
                FROM Crime
                WHERE CaseColloquialName = CCN AND CrimeNo > CrimeNoRemoved;

        DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = 1;

        OPEN CrimesAfterRemovedCrime;
        REPEAT
                FETCH CrimesAfterRemovedCrime
                INTO CaseCN, CrNo;
                        IF CrNo > CrimeNoRemoved THEN
                                UPDATE Crime
                                SET CrimeNo = CrNo - 1
                                WHERE CaseColloquialName = CaseCN AND CrimeNo = CrNo;
                        END IF;
                UNTIL flag = 1
        END REPEAT;
        CLOSE CrimesAfterRemovedCrime;
END; |
DELIMITER ;

-- The following are the same procedure as above but for other tables, as I will need this for my final project.

-- Victim No Move Up
DROP PROCEDURE IF EXISTS MoveVictimNoUp;
DELIMITER |
CREATE PROCEDURE MoveVictimNoUp(
IN CCN VARCHAR(150),
IN Cr INT(3),
IN VictimNoRemoved INT(3)
)
BEGIN
        DECLARE CrNo INT(3);
        DECLARE CaseCN VARCHAR(150);
        DECLARE VicNo INT(3);
        DECLARE flag INT DEFAULT 0;

        DECLARE VictimsAfterRemovedVictim CURSOR FOR
                SELECT CaseColloquialName, CrimeNo, VictimNo
                FROM Victim
                WHERE CaseColloquialName = CCN AND CrimeNo = Cr AND VictimNo > VictimNoRemoved;

        DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = 1;

        OPEN VictimsAfterRemovedVictim;
        REPEAT
                FETCH VictimsAfterRemovedVictim
                INTO CaseCN, CrNo, VicNo;
                        IF VicNo > VictimNoRemoved THEN
                                UPDATE Victim
                                SET VictimNo = VicNo - 1
                                WHERE CaseColloquialName = CaseCN AND CrimeNo = CrNo AND VictimNo = VicNo;
                        END IF;
                UNTIL flag = 1
        END REPEAT;
        CLOSE VictimsAfterRemovedVictim;
END; |
DELIMITER ;

-- Suspect No Move Up
DROP PROCEDURE IF EXISTS MoveSuspectNoUp;
DELIMITER |
CREATE PROCEDURE MoveSuspectNoUp(
IN CCN VARCHAR(150),
IN Cr INT(3),
IN SuspectNoRemoved INT(3)
)
BEGIN
        DECLARE CrNo INT(3);
        DECLARE CaseCN VARCHAR(150);
        DECLARE SusNo INT(3);
        DECLARE flag INT DEFAULT 0;

        DECLARE SuspectsAfterRemovedSuspect CURSOR FOR
                SELECT CaseColloquialName, CrimeNo, SuspectNo
                FROM Suspect
                WHERE CaseColloquialName = CCN AND CrimeNo = Cr AND SuspectNo > SuspectNoRemoved;

        DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = 1;

        OPEN SuspectsAfterRemovedSuspect;
        REPEAT
                FETCH SuspectsAfterRemovedSuspect
                INTO CaseCN, CrNo, SusNo;
                        IF SusNo > SuspectNoRemoved THEN
                                UPDATE Suspect
                                SET SuspectNo = SusNo - 1
                                WHERE CaseColloquialName = CaseCN AND CrimeNo = CrNo AND SuspectNo = SusNo;
                        END IF;
                UNTIL flag = 1
        END REPEAT;
        CLOSE SuspectsAfterRemovedSuspect;
END; |
DELIMITER ;

DROP PROCEDURE IF EXISTS MoveEvidenceNoUp;
DELIMITER |
CREATE PROCEDURE MoveEvidenceNoUp(
IN CCN VARCHAR(150),
IN Cr INT(3),
IN EvidenceNoRemoved INT(3)
)
BEGIN
        DECLARE CrNo INT(3);
        DECLARE CaseCN VARCHAR(150);
        DECLARE ENo INT(3);
        DECLARE flag INT DEFAULT 0;

        DECLARE EvidenceAfterRemovedEvidence CURSOR FOR
                SELECT CaseColloquialName, CrimeNo, EvidenceItemNo
                FROM Evidence
                WHERE CaseColloquialName = CCN AND CrimeNo = Cr AND EvidenceItemNo > EvidenceNoRemoved;

        DECLARE CONTINUE HANDLER FOR NOT FOUND SET flag = 1;

        OPEN EvidenceAfterRemovedEvidence;
        REPEAT
                FETCH EvidenceAfterRemovedEvidence
                INTO CaseCN, CrNo, ENo;
                        IF ENo > EvidenceNoRemoved THEN
                                UPDATE Evidence
                                SET EvidenceItemNo = ENo - 1
                                WHERE CaseColloquialName = CaseCN AND CrimeNo = CrNo AND EvidenceItemNo = ENo;
                        END IF;
                UNTIL flag = 1
        END REPEAT;
        CLOSE EvidenceAfterRemovedEvidence;
END; |
DELIMITER ;






