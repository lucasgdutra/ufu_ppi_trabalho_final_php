DROP TABLE IF EXISTS `animais` cascade;

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
);

LOCK TABLES `animais` WRITE;

INSERT INTO
  `animais`
VALUES
  (
    1,
    'arara-azul',
    'anodorhynchus hyacinthinus',
    'Ave',
    120,
    'Alto',
    'arara-azul',
    'A arara-azul é uma ave vistosa e barulhenta, conhecida por suas penas azuis brilhantes e seu bico forte. Vive em áreas de floresta tropical e tem uma dieta variada que inclui frutas, nozes e sementes.'
  ),
  (
    2,
    'boto-cor-de-rosa',
    'inia geoffrensis',
    'Mamífero',
    124,
    'Alto',
    'boto',
    'O boto-cor-de-rosa é um mamífero aquático encontrado na região amazônica. É conhecido por sua coloração rosada e é o maior golfinho de água doce do mundo.'
  ),
  (
    3,
    'jabuti',
    'chelonoidis denticulata',
    'Réptil',
    176,
    'Médio',
    'jabuti',
    'O jabuti é um réptil que possui carapaça óssea, e pode viver por muitos anos. É um animal lento e herbívoro, podendo viver tanto em florestas quanto em áreas abertas.'
  ),
  (
    4,
    'onça',
    'panthera onca',
    'Mamífero',
    100,
    'Baixo',
    'onca',
    'A onça-pintada é o maior felino das Américas e o terceiro maior do mundo, depois do tigre e do leão. É um animal solitário, territorialista e carnívoro.'
  ),
  (
    5,
    'pirarucu',
    'arapaima gigas',
    'Peixe',
    60,
    'Baixo',
    'pirarucu',
    'O pirarucu é um dos maiores peixes de água doce do mundo, podendo atingir até 3 metros de comprimento. É nativo da Amazônia e tem uma dieta carnívora, alimentando-se de outros peixes e até mesmo de pequenos animais.'
  ),
  (
    6,
    'tartaruga-de-casco-mole-gigante do rio yangtzé',
    'rafetus swinhoei',
    'Répteis',
    142,
    'Alto',
    'tartaruga-de-casco-mole',
    'A Tartaruga-de-casco-mole-gigante do Rio Yangtzé (Yangtze Giant Softshell Turtle) é uma espécie rara de tartaruga de água doce encontrada na China e no Vietnã. Ela é caracterizada por seu grande tamanho, pele macia e casco flexível.'
  ),
  (
    7,
    'borboleta Splitfin',
    'ameca splendens',
    'Actinopterygii',
    130,
    'Alto',
    'borboleta-splitfin',
    'A borboleta-Splitfin é um peixe de água doce colorido, conhecido por suas nadadeiras divididas e natureza pacífica. É nativa do México e é uma escolha popular para aquaristas devido à sua aparência atraente e comportamento amigável.'
  ),
  (
    8,
    'sapo das Terras Altas de Itatiaia',
    'holoaden bradei',
    'Amphibia',
    136,
    'Alto',
    'sapo-das-terras-altas',
    'O sapo das terras altas de itaiaia é uma pequena rã encontrada exclusivamente nas montanhas do Parque Nacional do Itatiaia, no Brasil. Ela possui coloração marrom ou verde, vive em áreas de altitude elevada, em florestas úmidas e riachos de água limpa.'
  ),
  (
    9,
    'partula clara',
    'partula clara',
    'Gastropoda',
    159,
    'Alto',
    'partula-clara',
    'O partula clara é uma espécie de caracol terrestre pertencente ao gênero Partula, e seu nome científico é o mesmo que seu nome comum.'
  ),
  (
    10,
    'pangásio Gigante',
    'pangasius sanitwongsei',
    'Actinopterygii',
    110,
    'Alto',
    'pangasio-gigante',
    'O pangásio gigante é conhecido por seu tamanho impressionante, podendo atingir mais de 3 metros de comprimento e pesar mais de 200 quilos. Possui uma forma alongada, barbatanas dorsais curtas e uma boca voltada para baixo.'
  ),
  (
    11,
    'langur de Delacour',
    'trachypithecus delacouri',
    'Mammalia',
    144,
    'Alto',
    'langur-de-delacour',
    'O langur de Delacour é um macaco de médio porte, com pelagem principalmente negra e manchas brancas distintas em seu rosto. Sua cauda é longa e peluda.'
  ),
  (
    12,
    'coelho Pincel San José',
    'sylvilagus mansuetus',
    'Mammalia',
    136,
    'Alto',
    'coelho-pincel-san-jose',
    'O san josé Brush Rabbit é uma espécie de coelho pequeno, endêmico da Califórnia,  ele possui uma pelagem acinzentada e é conhecido por sua vida nas áreas de arbustos e matagais.'
  ),
  (
    13,
    'pomba-fruta Rapa',
    'ptilinopus huttoni',
    'Ave',
    168,
    'Alto',
    'pomba-fruta-rapa',
    'O rapa fruit-dove é uma ave com plumagem vibrante,  sua coloração inclui tons de verde, roxo e branco. Alimenta-se principalmente de frutas,  só pode ser encontrada em Rapa.'
  ),
  (
    14,
    'tucano',
    'ramphastos toco',
    'Ave',
    198,
    'Médio',
    'tucano',
    'O tucano é uma ave conhecida por seu bico grande e colorido. Vive em florestas tropicais, e alimenta-se de frutas, insetos e, ocasionalmente, de pequenos vertebrados.'
  ),
  (
    15,
    'crocodilo de focinho fino',
    'mecistops cataphractus',
    'Reptilia',
    202,
    'Alto',
    'crocodilo_focinho_fino',
    'O crocodilo de focinho fino é um réptil aquático de porte médio a grande, caracterizado por seu focinho estreito e alongado. Possui uma coloração geralmente escura e uma morfologia adaptada para a vida aquática, com olhos e narinas posicionados no topo da cabeça.'
  ),
  (
    16,
    'crocodilo do Orinoco',
    'crocodylus intermedius',
    'Reptilia',
    222,
    'Alto',
    'crocodilo_orinoco',
    'O crocodilo do orinoco é uma espécie de crocodilo encontrada na região do rio Orinoco, na América do Sul. Essa espécie é notável por seu tamanho impressionante, podendo atingir comprimentos significativos.'
  ),
  (
    17,
    'gambá pigmeu da montanha',
    'burramys parvus',
    'Mammalia',
    210,
    'Alto',
    'gamba_pigmeu_montanha',
    'O gambá-pigmeu-da-montanha e seus ancestrais diretos são reconhecidos imediatamente pelo dente pré-molar bastante distinto, de aparência bem estranha e perigosa.'
  ),
  (
    18,
    'mico-arelejado',
    'saguinus bicolor',
    'Mammalia',
    112,
    'Alto',
    'mico_arelejado',
    'O mico-arelejado é um pequeno primata da América do Sul, conhecido por sua pelagem colorida e marcante, com tons de preto e branco. Estes macacos são ágeis e vivem em grupos familiares nas florestas tropicais, alimentando-se principalmente de frutas, insetos e pequenos vertebrados.'
  ),
  (
    19,
    'íbis anão',
    'bostrychia bocagei',
    'Ave',
    246,
    'Alto',
    'ibis_anao',
    'A íbis-anã é uma ave aquática de pequeno porte, caracterizada por suas pernas longas, bico curvo e penas em tons de marrom e branco. Encontrada em áreas úmidas, como pântanos e manguezais, essa espécie se alimenta de pequenos invertebrados aquáticos.'
  ),
  (
    20,
    'sapo folha reticulada',
    'pithecopus ayeaye',
    'Amphibia',
    200,
    'Alto',
    'sapo_folha_reticulada',
    'O sapo-folha reticulado é um anfíbio fascinante que habita regiões tropicais da América do Sul, especialmente na Amazônia. Seu nome deriva da incrível semelhança com uma folha seca, apresentando uma coloração verde-acastanhada e uma textura que imita veias foliares.'
  ),
  (
    21,
    'abutre Encapuzado',
    'necrosyrtes monachus',
    'Ave',
    150,
    'Alto',
    'abutre_encapuzado',
    'O Abutre Encapuzado é uma espécie de abutre encontrada principalmente na África subsaariana. Possui uma plumagem distintiva, com a cabeça e o pescoço cobertos por penas escuras, formando uma espécie de \"capuz\". Esses abutres têm um bico forte e curvo, adaptado para se alimentarem de restos de animais.'
  ),
  (
    22,
    'sapo de Cárpatos',
    'pelophylax cerigensis',
    'Amphibia',
    138,
    'Alto',
    'sapo_carpatos',
    'O sapo de Cárpatos, é endêmico da ilha de Karpathos, na Grécia, e encontrado apenas em um único rio no norte da ilha. Esta rã é em grande parte aquática e pode ser encontrada em riachos lentos e águas paradas permanentes.'
  ),
  (
    23,
    'addax',
    'addax nasomaculatus',
    'Mammalia',
    98,
    'Alto',
    'addax',
    'O Addax é uma espécie de antílope adaptada a ambientes desérticos e semiáridos, sendo nativa do Saara, no norte da África. Este antílope é conhecido por sua aparência distintiva, com chifres longos e curvados, que podem atingir até 1 metro de comprimento em ambos os sexos. Sua pelagem é de cor areia a cinza pálido, o que proporciona camuflagem em seu ambiente árido.'
  ),
  (
    24,
    'grande tubarão-martelo',
    'sphyrna mokarran',
    'Chondrichthyes',
    66,
    'Alto',
    'grande_tubarao_martelo',
    'O Grande Tubarão Martelo, pertencente à família Sphyrnidae, é conhecido por sua distintiva cabeça achatada em forma de martelo. Essa estrutura única é chamada de \"cefalópode\" e possui olhos em extremidades opostas, proporcionando uma visão panorâmica que ajuda na caça.'
  ),
  (
    25,
    'guaxinim pigmeu',
    'procyon pygmaeus',
    'Mammalia',
    44,
    'Alto',
    'guaxinim_pigmeu',
    'O guaxinim-pigmeu é uma espécie de guaxinim encontrada exclusivamente na ilha de Cozumel, no México. Distinto por seu tamanho menor em comparação com outros guaxinins, possui uma pelagem cinza e marrom, com uma máscara facial característica.'
  ),
  (
    26,
    'abutre de bico fino',
    'gyps tenuirostris',
    'Ave',
    10,
    'Alto',
    'abutre_bico_fino',
    'O abutre de bico fino é uma espécie de abutre encontrada principalmente no sul da Ásia. Esta ave de rapina tem um bico longo e estreito, daí o nome \"slender-billed\" (bico fino). Sua plumagem é geralmente marrom, e eles têm uma envergadura impressionante.'
  ),
  (
    27,
    'iguana Menor das Antilhas',
    'iguana delicatissima',
    'Reptilia',
    34,
    'Alto',
    'iguana_menor_antilhas',
    'A iguana das Pequenas Antilhas é uma espécie de iguana que habita as ilhas do Caribe, especificamente nas Pequenas Antilhas. Essas iguanas são conhecidas por sua coloração vibrante, que varia de verde a marrom, e algumas podem exibir tons mais intensos durante a época de reprodução.'
  ),
  (
    28,
    'rinoceronte negro',
    'diceros bicornis',
    'Mammalia',
    150,
    'Alto',
    'rinoceronte_negro',
    'O rinoceronte-negro, é uma das duas espécies de rinocerontes encontradas na África, a outra sendo o White Rhino (Rinoceronte-Branco). O Black Rhino é caracterizado por sua boca em formato de bico, adaptada para alimentação seletiva de folhas e brotos de plantas.'
  ),
  (
    29,
    'saola',
    'pseudoryx nghetinhensis',
    'Mammalia',
    100,
    'Alto',
    'saola',
    'O saola, também conhecido como \"Unicórnio Asiático\" devido aos chifres longos e afiados, é um mamífero ungulado encontrado nas montanhas remotas da Indochina, abrangendo o Vietnã e Laos.'
  ),
  (
    30,
    'cinclodes Reais',
    'cinclodes aricomae',
    'Ave',
    270,
    'Alto',
    'cinclodes_reais',
    'O Royal Cinclodes é uma espécie de pássaro passeriforme encontrado nos Andes do Peru. É conhecido por sua distribuição geográfica restrita, sendo encontrado em altitudes elevadas, acima da linha das árvores, em áreas de vegetação rala e pedregosa.'
  );

UNLOCK TABLES;

DROP TABLE IF EXISTS `dificuldade` cascade;

CREATE TABLE `dificuldade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

LOCK TABLES `dificuldade` WRITE;

INSERT INTO
  `dificuldade`
VALUES
  (1, 'Muito Fácil'),
  (2, 'Fácil'),
  (3, 'Médio'),
  (4, 'Difícil'),
  (5, 'Muito Difícil'),
  (6, 'Desafio');

UNLOCK TABLES;

DROP TABLE IF EXISTS `jogos` cascade;

CREATE TABLE `jogos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `id_dificuldade` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_dificuldade` (`id_dificuldade`),
  CONSTRAINT `jogos_ibfk_1` FOREIGN KEY (`id_dificuldade`) REFERENCES `dificuldade` (`id`)
);

LOCK TABLES `jogos` WRITE;

INSERT INTO
  `jogos`
VALUES
  (1, 'teste', 1),
  (2, 'variados', 2),
  (3, 'variados 2', 3),
  (4, 'variados 3', 4);

UNLOCK TABLES;

DROP TABLE IF EXISTS `relacoes_animais_jogos` cascade;

CREATE TABLE `relacoes_animais_jogos` (
  `id_animal` int(11) NOT NULL,
  `id_jogo` int(11) NOT NULL,
  PRIMARY KEY (`id_animal`, `id_jogo`)
);

LOCK TABLES `relacoes_animais_jogos` WRITE;

INSERT INTO
  `relacoes_animais_jogos`
VALUES
  (1, 3),
  (2, 3),
  (3, 3),
  (4, 3),
  (5, 3),
  (6, 3),
  (7, 1),
  (7, 2),
  (8, 1),
  (8, 2),
  (9, 2),
  (10, 2),
  (11, 2),
  (12, 2),
  (13, 3),
  (14, 3),
  (15, 3),
  (16, 4),
  (17, 4),
  (18, 4),
  (19, 4),
  (20, 4),
  (21, 4),
  (22, 4),
  (23, 4),
  (24, 4),
  (25, 4),
  (26, 4),
  (27, 4),
  (28, 4),
  (29, 4),
  (30, 4);

UNLOCK TABLES;

DROP TABLE IF EXISTS `usuarios` cascade;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `senha` char(255) NOT NULL,
  `pontos` int(11) DEFAULT 0,
  `email` varchar(255) NOT NULL,
  `caminho_imagem` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `recorde_segundos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

LOCK TABLES `usuarios` WRITE;

INSERT INTO
  `usuarios`
VALUES
  (
    16,
    'Mark',
    '$2y$10$m0d59R4j4P2VocfWmh1TVOhgUSBSjtusr/UTAiMSc80L8tHFi8urW',
    40,
    'mark@mail.com',
    NULL,
    0,
    86
  ),
  (
    17,
    'Jacob',
    '$2y$10$m0d59R4j4P2VocfWmh1TVOhgUSBSjtusr/UTAiMSc80L8tHFi8urW',
    30,
    'jacob@mail.com',
    NULL,
    0,
    90
  ),
  (
    18,
    'Larry',
    '$2y$10$m0d59R4j4P2VocfWmh1TVOhgUSBSjtusr/UTAiMSc80L8tHFi8urW',
    20,
    'larry@mail.com',
    NULL,
    0,
    95
  ),
  (
    19,
    'admin',
    '$2y$10$m0d59R4j4P2VocfWmh1TVOhgUSBSjtusr/UTAiMSc80L8tHFi8urW',
    40,
    'admin@mail.com',
    NULL,
    1,
    86
  );

UNLOCK TABLES;