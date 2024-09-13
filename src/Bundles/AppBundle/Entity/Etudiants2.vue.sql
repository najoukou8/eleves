CREATE
VIEW `etudiants2` AS
SELECT
`etudiants`.`Ann�e Univ` AS `Ann�e Univ`, `etudiants`.`Centre gestion` AS `Centre gestion`, `etudiants`.`Composante` AS `Composante`,
`etudiants`.`Code dip` AS `Code dip`, `etudiants`.`Code VDI` AS `Code VDI`, `etudiants`.`Lib dip` AS `Lib dip`, `etudiants`.`Code �tape` AS `Code �tape`,
`etudiants`.`Code VET` AS `Code VET`, `etudiants`.`Lib �tape` AS `Lib �tape`, `etudiants`.`Date IAE` AS `Date IAE`, `etudiants`.`Nb inscr cycle` AS `Nb inscr cycle`,
`etudiants`.`Nb inscr dip` AS `Nb inscr dip`, `etudiants`.`Nb inscr etp` AS `Nb inscr etp`, `etudiants`.`Code statut` AS `Code statut`, `etudiants`.`Lib statut` AS `Lib statut`,
`etudiants`.`Code profil` AS `Code profil`, `etudiants`.`Lib profil` AS `Lib profil`, `etudiants`.`Code r�gime` AS `Code r�gime`, `etudiants`.`Lib r�gime` AS `Lib r�gime`,
`etudiants`.`Code_shn` AS `Code_shn`, `etudiants`.`Lib_shn` AS `Lib_shn`, `etudiants`.`Tem_web` AS `Tem_web`, `etudiants`.`Tem_cursus_amenage` AS `Tem_cursus_amenage`,
`etudiants`.`Code etu` AS `Code etu`, `etudiants`.`Etat civ` AS `Etat civ`, `etudiants`.`Nom` AS `Nom`, `etudiants`.`Nom marital` AS `Nom marital`, `etudiants`.`Pr�nom 1` AS `Pr�nom 1`,
`etudiants`.`Pr�nom 2` AS `Pr�nom 2`, `etudiants`.`Pr�nom 3` AS `Pr�nom 3`, `etudiants`.`Date naiss` AS `Date naiss`, `etudiants`.`Pays/dept naiss` AS `Pays/dept naiss`, `etudiants`.
`Ville naiss` AS `Ville naiss`, `etudiants`.`Nationalit�` AS `Nationalit�`, `etudiants`.`Code sit fam` AS `Code sit fam`, `etudiants`.`Lib sit fam` AS `Lib sit fam`, `etudiants`.
`Nbr enf` AS `Nbr enf`, `etudiants`.`Code_handi` AS `Code_handi`, `etudiants`.`Lib_handi` AS `Lib_handi`, `etudiants`.`Adresse annuelle` AS `Adresse annuelle`,
`etudiants`.`Ada rue 2` AS `Ada rue 2`, `etudiants`.`Ada rue 3` AS `Ada rue 3`, `etudiants`.`Ada code BDI` AS `Ada code BDI`, `etudiants`.`Ada lib commune` AS `Ada lib commune`,
`etudiants`.`Ada adresse` AS `Ada adresse`, `etudiants`.`Ada lib pays` AS `Ada lib pays`, `etudiants`.`Ada Num t�l` AS `Ada Num t�l`, `etudiants`.`Num t�l port` AS `Num t�l port`,
`etudiants`.`Email perso` AS `Email perso`, `etudiants`.`Adresse fixe` AS `Adresse fixe`, `etudiants`.`Adf rue2` AS `Adf rue2`, `etudiants`.`Adf rue3` AS `Adf rue3`, `etudiants`.`Adf code BDI` AS `Adf code BDI`,
`etudiants`.`Adf lib commune` AS `Adf lib commune`, `etudiants`.`Adf adresse` AS `Adf adresse`, `etudiants`.`Adf lib pays` AS `Adf lib pays`, `etudiants`.`Adf num t�l` AS `Adf num t�l`,
`etudiants`.`Aide financi�re` AS `Aide financi�re`, `etudiants`.`Lib aide finan` AS `Lib aide finan`, `etudiants`.`Code bourse` AS `Code bourse`, `etudiants`.`Lib bourse` AS `Lib bourse`,
`etudiants`.`Quotit� travail` AS `Quotit� travail`, `etudiants`.`Lib quotit� travail` AS `Lib quotit� travail`, `etudiants`.`Code CSP �tudiant` AS `Code CSP �tudiant`, `etudiants`.`Lib CSP �tudiant` AS `Lib CSP �tudiant`,
`etudiants`.`Code CSP parent` AS `Code CSP parent`, `etudiants`.`Lib CSP parent` AS `Lib CSP parent`, `etudiants`.`Code bac` AS `Code bac`, `etudiants`.`Lib bac` AS `Lib bac`, `etudiants`.`Code mention` AS `Code mention`,
`etudiants`.`Lib mention` AS `Lib mention`, `etudiants`.`Ann�e obt bac` AS `Ann�e obt bac`, `etudiants`.`Code dpt bac` AS `Code dpt bac`, `etudiants`.`Code etb bac` AS `Code etb bac`, `etudiants`.`Code_type_CGE` AS `Code_type_CGE`,
`etudiants`.`Lib_type_CGE` AS `Lib_type_CGE`, `etudiants`.`Lib etb bac` AS `Lib etb bac`, `etudiants`.`Dip autre cursus` AS `Dip autre cursus`, `etudiants`.`Lib dac` AS `Lib dac`, `etudiants`.`Code �tab dac` AS `Code �tab dac`,
`etudiants`.`Lib �tab dac` AS `Lib �tab dac`, `etudiants`.`Type �tab dac` AS `Type �tab dac`, `etudiants`.`Dpt/pays dac` AS `Dpt/pays dac`, `etudiants`.`Ann�e suivi dac` AS `Ann�e suivi dac`,
`etudiants`.`Commentaire` AS `Commentaire`, `etudiants`.`Type �tab ant` AS `Type �tab ant`, `etudiants`.`Lib �tab ant` AS `Lib �tab ant`, `etudiants`.`Dpt �tab ant` AS `Dpt �tab ant`,
`etudiants`.`Ann�e etab ant` AS `Ann�e etab ant`, `etudiants`.`Nat. tit acc` AS `Nat tit acc`, `etudiants`.`Dip. tit acc` AS `Dip tit acc`, `etudiants`.`Inscr  parallele/chgt inscr` AS `Inscr  parallele/chgt inscr`,
`etudiants`.`Type �tab` AS `Type �tab`, `etudiants`.`Lib �tab` AS `Lib �tab`, `etudiants`.`Pg �change` AS `Pg �change`, `etudiants`.`Sens �change` AS `Sens �change`, `etudiants`.`Lib �tab ech` AS `Lib �tab ech` FROM `etudiants` ;