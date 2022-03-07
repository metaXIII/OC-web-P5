drop database if exists sudokusolver;

create database sudokusolver;

use sudokusolver;

CREATE TABLE `grid`
(
    `id`           int(11) NOT NULL,
    `grid_content` text    NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = latin1;

--
-- Déchargement des données de la table `grid`
--

INSERT INTO `grid` (`id`, `grid_content`)
VALUES (1,'a:9:{i:0;a:9:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:3;i:7;i:0;i:8;i:1;}i:1;a:9:{i:0;i:6;i:1;i:5;i:2;i:4;i:3;i:3;i:4;i:2;i:5;i:0;i:6;i:9;i:7;i:0;i:8;i:7;}i:2;a:9:{i:0;i:3;i:1;i:2;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;i:7;i:0;i:8;i:0;}i:3;a:9:{i:0;i:0;i:1;i:9;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;i:7;i:1;i:8;i:0;}i:4;a:9:{i:0;i:7;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:1;i:5;i:4;i:6;i:0;i:7;i:0;i:8;i:0;}i:5;a:9:{i:0;i:4;i:1;i:1;i:2;i:0;i:3;i:0;i:4;i:9;i:5;i:3;i:6;i:7;i:7;i:0;i:8;i:0;}i:6;a:9:{i:0;i:5;i:1;i:7;i:2;i:0;i:3;i:6;i:4;i:0;i:5;i:0;i:6;i:0;i:7;i:0;i:8;i:0;}i:7;a:9:{i:0;i:2;i:1;i:0;i:2;i:0;i:3;i:1;i:4;i:3;i:5;i:9;i:6;i:5;i:7;i:0;i:8;i:6;}i:8;a:9:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:7;i:5;i:8;i:6;i:0;i:7;i:4;i:8;i:9;}}'), (2, 'a:9:{i:0;a:9:{i:0;i:5;i:1;i:6;i:2;i:8;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;i:7;i:0;i:8;i:0;}i:1;a:9:{i:0;i:3;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;i:7;i:1;i:8;i:5;}i:2;a:9:{i:0;i:0;i:1;i:9;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:6;i:7;i:0;i:8;i:3;}i:3;a:9:{i:0;i:0;i:1;i:8;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:1;i:7;i:3;i:8;i:0;}i:4;a:9:{i:0;i:0;i:1;i:0;i:2;i:9;i:3;i:0;i:4;i:3;i:5;i:0;i:6;i:0;i:7;i:0;i:8;i:4;}i:5;a:9:{i:0;i:7;i:1;i:3;i:2;i:0;i:3;i:0;i:4;i:6;i:5;i:0;i:6;i:5;i:7;i:0;i:8;i:0;}i:6;a:9:{i:0;i:4;i:1;i:0;i:2;i:3;i:3;i:8;i:4;i:9;i:5;i:0;i:6;i:0;i:7;i:0;i:8;i:0;}i:7;a:9:{i:0;i:0;i:1;i:2;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:5;i:6;i:0;i:7;i:7;i:8;i:0;}i:8;a:9:{i:0;i:0;i:1;i:0;i:2;i:1;i:3;i:0;i:4;i:0;i:5;i:6;i:6;i:0;i:7;i:4;i:8;i:9;}}');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user`
(
    `id`       int(11)      NOT NULL,
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`)
VALUES (1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `grid`
--
ALTER TABLE `grid`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `grid`
--
ALTER TABLE `grid`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 38;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 15;
COMMIT;
