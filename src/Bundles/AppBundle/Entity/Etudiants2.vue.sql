CREATE
VIEW `etudiants2` AS
SELECT
`etudiants`.`Année Univ` AS `Année Univ`, `etudiants`.`Centre gestion` AS `Centre gestion`, `etudiants`.`Composante` AS `Composante`,
`etudiants`.`Code dip` AS `Code dip`, `etudiants`.`Code VDI` AS `Code VDI`, `etudiants`.`Lib dip` AS `Lib dip`, `etudiants`.`Code étape` AS `Code étape`,
`etudiants`.`Code VET` AS `Code VET`, `etudiants`.`Lib étape` AS `Lib étape`, `etudiants`.`Date IAE` AS `Date IAE`, `etudiants`.`Nb inscr cycle` AS `Nb inscr cycle`,
`etudiants`.`Nb inscr dip` AS `Nb inscr dip`, `etudiants`.`Nb inscr etp` AS `Nb inscr etp`, `etudiants`.`Code statut` AS `Code statut`, `etudiants`.`Lib statut` AS `Lib statut`,
`etudiants`.`Code profil` AS `Code profil`, `etudiants`.`Lib profil` AS `Lib profil`, `etudiants`.`Code régime` AS `Code régime`, `etudiants`.`Lib régime` AS `Lib régime`,
`etudiants`.`Code_shn` AS `Code_shn`, `etudiants`.`Lib_shn` AS `Lib_shn`, `etudiants`.`Tem_web` AS `Tem_web`, `etudiants`.`Tem_cursus_amenage` AS `Tem_cursus_amenage`,
`etudiants`.`Code etu` AS `Code etu`, `etudiants`.`Etat civ` AS `Etat civ`, `etudiants`.`Nom` AS `Nom`, `etudiants`.`Nom marital` AS `Nom marital`, `etudiants`.`Prénom 1` AS `Prénom 1`,
`etudiants`.`Prénom 2` AS `Prénom 2`, `etudiants`.`Prénom 3` AS `Prénom 3`, `etudiants`.`Date naiss` AS `Date naiss`, `etudiants`.`Pays/dept naiss` AS `Pays/dept naiss`, `etudiants`.
`Ville naiss` AS `Ville naiss`, `etudiants`.`Nationalité` AS `Nationalité`, `etudiants`.`Code sit fam` AS `Code sit fam`, `etudiants`.`Lib sit fam` AS `Lib sit fam`, `etudiants`.
`Nbr enf` AS `Nbr enf`, `etudiants`.`Code_handi` AS `Code_handi`, `etudiants`.`Lib_handi` AS `Lib_handi`, `etudiants`.`Adresse annuelle` AS `Adresse annuelle`,
`etudiants`.`Ada rue 2` AS `Ada rue 2`, `etudiants`.`Ada rue 3` AS `Ada rue 3`, `etudiants`.`Ada code BDI` AS `Ada code BDI`, `etudiants`.`Ada lib commune` AS `Ada lib commune`,
`etudiants`.`Ada adresse` AS `Ada adresse`, `etudiants`.`Ada lib pays` AS `Ada lib pays`, `etudiants`.`Ada Num tél` AS `Ada Num tél`, `etudiants`.`Num tél port` AS `Num tél port`,
`etudiants`.`Email perso` AS `Email perso`, `etudiants`.`Adresse fixe` AS `Adresse fixe`, `etudiants`.`Adf rue2` AS `Adf rue2`, `etudiants`.`Adf rue3` AS `Adf rue3`, `etudiants`.`Adf code BDI` AS `Adf code BDI`,
`etudiants`.`Adf lib commune` AS `Adf lib commune`, `etudiants`.`Adf adresse` AS `Adf adresse`, `etudiants`.`Adf lib pays` AS `Adf lib pays`, `etudiants`.`Adf num tél` AS `Adf num tél`,
`etudiants`.`Aide financière` AS `Aide financière`, `etudiants`.`Lib aide finan` AS `Lib aide finan`, `etudiants`.`Code bourse` AS `Code bourse`, `etudiants`.`Lib bourse` AS `Lib bourse`,
`etudiants`.`Quotité travail` AS `Quotité travail`, `etudiants`.`Lib quotité travail` AS `Lib quotité travail`, `etudiants`.`Code CSP étudiant` AS `Code CSP étudiant`, `etudiants`.`Lib CSP étudiant` AS `Lib CSP étudiant`,
`etudiants`.`Code CSP parent` AS `Code CSP parent`, `etudiants`.`Lib CSP parent` AS `Lib CSP parent`, `etudiants`.`Code bac` AS `Code bac`, `etudiants`.`Lib bac` AS `Lib bac`, `etudiants`.`Code mention` AS `Code mention`,
`etudiants`.`Lib mention` AS `Lib mention`, `etudiants`.`Année obt bac` AS `Année obt bac`, `etudiants`.`Code dpt bac` AS `Code dpt bac`, `etudiants`.`Code etb bac` AS `Code etb bac`, `etudiants`.`Code_type_CGE` AS `Code_type_CGE`,
`etudiants`.`Lib_type_CGE` AS `Lib_type_CGE`, `etudiants`.`Lib etb bac` AS `Lib etb bac`, `etudiants`.`Dip autre cursus` AS `Dip autre cursus`, `etudiants`.`Lib dac` AS `Lib dac`, `etudiants`.`Code étab dac` AS `Code étab dac`,
`etudiants`.`Lib étab dac` AS `Lib étab dac`, `etudiants`.`Type étab dac` AS `Type étab dac`, `etudiants`.`Dpt/pays dac` AS `Dpt/pays dac`, `etudiants`.`Année suivi dac` AS `Année suivi dac`,
`etudiants`.`Commentaire` AS `Commentaire`, `etudiants`.`Type étab ant` AS `Type étab ant`, `etudiants`.`Lib étab ant` AS `Lib étab ant`, `etudiants`.`Dpt étab ant` AS `Dpt étab ant`,
`etudiants`.`Année etab ant` AS `Année etab ant`, `etudiants`.`Nat. tit acc` AS `Nat tit acc`, `etudiants`.`Dip. tit acc` AS `Dip tit acc`, `etudiants`.`Inscr  parallele/chgt inscr` AS `Inscr  parallele/chgt inscr`,
`etudiants`.`Type étab` AS `Type étab`, `etudiants`.`Lib étab` AS `Lib étab`, `etudiants`.`Pg échange` AS `Pg échange`, `etudiants`.`Sens échange` AS `Sens échange`, `etudiants`.`Lib étab ech` AS `Lib étab ech` FROM `etudiants` ;