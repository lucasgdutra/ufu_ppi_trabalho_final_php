CREATE TABLE `animais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `nome_cientifico` varchar(255) DEFAULT NULL,
  `classe` varchar(255) DEFAULT NULL,
  `numero_individuos` int(11) DEFAULT NULL,
  `risco_extincao` varchar(255) DEFAULT NULL,
  `imagem_url` varchar(255) DEFAULT NULL,
  `descricao` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO mariadb.animais (nome,nome_cientifico,classe,numero_individuos,risco_extincao,imagem_url,descricao) VALUES
	 ('arara-azul','anodorhynchus hyacinthinus','Ave',NULL,'Alto','arara-azul','A arara-azul é uma ave vistosa e barulhenta, conhecida por suas penas azuis brilhantes e seu bico forte. Vive em áreas de floresta tropical e tem uma dieta variada que inclui frutas, nozes e sementes.'),
	 ('boto-cor-de-rosa','inia geoffrensis','Mamífero',NULL,'Alto','boto','O boto-cor-de-rosa é um mamífero aquático encontrado na região amazônica. É conhecido por sua coloração rosada e é o maior golfinho de água doce do mundo.'),
	 ('jabuti','chelonoidis denticulata','Réptil',NULL,'Médio','jabuti','O jabuti é um réptil que possui carapaça óssea, e pode viver por muitos anos. É um animal lento e herbívoro, podendo viver tanto em florestas quanto em áreas abertas.'),
	 ('onça','panthera onca','Mamífero',NULL,'Baixo','onca','A onça-pintada é o maior felino das Américas e o terceiro maior do mundo, depois do tigre e do leão. É um animal solitário, territorialista e carnívoro.'),
	 ('pirarucu','arapaima gigas','Peixe',NULL,'Baixo','pirarucu','O pirarucu é um dos maiores peixes de água doce do mundo, podendo atingir até 3 metros de comprimento. É nativo da Amazônia e tem uma dieta carnívora, alimentando-se de outros peixes e até mesmo de pequenos animais.'),
	 ('tucano','ramphastos toco','Ave',NULL,'Médio','tucano','O tucano é uma ave conhecida por seu bico grande e colorido. Vive em florestas tropicais, e alimenta-se de frutas, insetos e, ocasionalmente, de pequenos vertebrados.');

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `senha` char(255) DEFAULT NULL,
  `pontos` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `imagem` blob DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `recorde_segundos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO mariadb.usuarios (nome,senha,pontos,email,imagem,isAdmin,recorde_segundos) VALUES
	 ('Mark',NULL,40,'mark@mail.com',NULL,0,86),
	 ('Jacob',NULL,30,'jacob@mail.com',NULL,0,90),
	 ('Larry',NULL,20,'larry@mail.com',NULL,0,95);
