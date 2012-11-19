Gestion-adresses-IP
===================

Petit site pour gérer les adresses IP d'un réseau

Pour l'exemple voici ma configuration :
-------------------------------------
serveur de bdd          : localhost
Login de la bdd         : login
Mot de passe de la bdd  : password

Nom de la bdd           : nom_de_la_bdd
Nom de la table         : nom_de_la_table

Champs de la table :
------------------
CREATE TABLE IF NOT EXISTS `nom_de_la_table` (
  `num` int(3) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `hostname` varchar(100) NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;