CREATE TABLE admin (
  id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(40) NOT NULL,
  email VARCHAR(40) NOT NULL,
  senha VARCHAR(60) NOT NULL
);

CREATE TABLE cidade (
  id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(40) NOT NULL,
  uf VARCHAR(2) NOT NULL
);

CREATE TABLE imagem (
  id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  caminho TEXT NOT NULL,
  tipo INTEGER(1) NOT NULL
);

CREATE TABLE empresa (
  id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome_usuario VARCHAR(40) NOT NULL,
  email VARCHAR(40) NOT NULL UNIQUE KEY,
  senha VARCHAR(60) NOT NULL,
  razao_social VARCHAR(20) NOT NULL,
  nome_fantasia VARCHAR(20) NOT NULL,
  cnpj VARCHAR(18) NOT NULL UNIQUE KEY,
  celular VARCHAR(14) NOT NULL,
  data_cadastro DATE NOT NULL,
  dias_bloqueio INTEGER UNSIGNED NOT NULL,
  estado INTEGER(1) NOT NULL
);

CREATE TABLE endereco (
  id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  empresa_id INTEGER UNSIGNED NOT NULL,
  rua VARCHAR(60) NOT NULL,
  num INTEGER(5) UNSIGNED NOT NULL,
  complemento VARCHAR(20) NULL,
  cep VARCHAR(10) NOT NULL,
  bairro VARCHAR(30) NOT NULL,
  cidade_id INTEGER UNSIGNED NOT NULL,
  latitude TEXT NOT NULL,
  longitude TEXT NOT NULL,
  telefone VARCHAR(14) NULL,
  FOREIGN KEY(empresa_id)REFERENCES empresa(id),
  FOREIGN KEY(cidade_id)REFERENCES cidade(id)
);

CREATE TABLE usuario (
  id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(40) NOT NULL,
  email VARCHAR(40) NOT NULL,
  senha VARCHAR(60) NOT NULL,
  celular VARCHAR(14) NOT NULL,
  genero INTEGER(1) NOT NULL,
  nascimento DATE NOT NULL,
  dias_bloqueio INTEGER UNSIGNED NOT NULL,
  token TEXT NOT NULL
);

CREATE TABLE tipo (
  id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(30) NULL
);

CREATE TABLE cupom (
  id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  empresa_id INTEGER UNSIGNED NOT NULL,
  endereco_id INTEGER UNSIGNED NOT NULL,
  imagem_id INTEGER UNSIGNED NOT NULL,
  titulo VARCHAR(50) NOT NULL,
  regras TEXT NOT NULL,
  descricao TEXT NOT NULL,
  preco_normal DOUBLE NOT NULL,
  preco_cupom DOUBLE NOT NULL,
  prazo DATETIME NOT NULL,
  quantidade INTEGER UNSIGNED NOT NULL,
  pagamento INTEGER(1) UNSIGNED NOT NULL,
  delivery INTEGER(1) UNSIGNED NOT NULL,
  estado INTEGER(1) NOT NULL,
  FOREIGN KEY(empresa_id)REFERENCES empresa(id),
  FOREIGN KEY(endereco_id)REFERENCES endereco(id),
  FOREIGN KEY(imagem_id)REFERENCES imagem(id)
);

CREATE TABLE cupom_has_tipo (
  id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  tipo_id INTEGER UNSIGNED NOT NULL,
  cupom_id INTEGER UNSIGNED NOT NULL,
  FOREIGN KEY(tipo_id)REFERENCES tipo(id),
  FOREIGN KEY(cupom_id)REFERENCES cupom(id)
);

CREATE TABLE usuario_has_cupom (
  id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  cupom_id INTEGER UNSIGNED NOT NULL,
  usuario_id INTEGER UNSIGNED NOT NULL,
  estado INTEGER(1) UNSIGNED NOT NULL,
  preco_normal DOUBLE NOT NULL,
  preco_cupom DOUBLE NOT NULL,
  prazo DATETIME NOT NULL,
  pagamento INTEGER(1) NOT NULL,
  delivery INTEGER(1) NOT NULL,
  data_resgate DATETIME NOT NULL,
  produto INTEGER(1) NULL,
  atendimento INTEGER(1) NULL,
  ambiente INTEGER(1) NULL,
  comentarios TEXT NULL,
  FOREIGN KEY(usuario_id)REFERENCES usuario(id),
  FOREIGN KEY(cupom_id)REFERENCES cupom(id)
);

CREATE TABLE notificacao (
  id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  cupom_id INTEGER UNSIGNED NOT NULL,
  tipo INTEGER UNSIGNED NOT NULL,
  visualizado INTEGER UNSIGNED NOT NULL,
  FOREIGN KEY(cupom_id)REFERENCES cupom(id)
);

INSERT INTO `imagem` VALUES
(1, 'breakfast-1.jpg', 1),
(2, 'breakfast-2.jpg', 1),
(3, 'breakfast-3.jpg', 1),
(4, 'breakfast-4.jpg', 1),
(5, 'breakfast-5.jpg', 1),
(6, 'breakfast-6.jpg', 1),
(7, 'drink-1.jpg', 1),
(8, 'drink-2.jpg', 1),
(9, 'drink-3.jpg', 1),
(10, 'drink-4.jpg', 1),
(11, 'drink-5.jpg', 1),
(12, 'meals-1.jpg', 1),
(13, 'meals-2.jpg', 1),
(14, 'meals-3.jpg', 1),
(15, 'meat-1.jpg', 1),
(16, 'meat-2.jpg', 1),
(17, 'meat-3.jpg', 1),
(18, 'meat-4.jpg', 1),
(19, 'meat-5.jpg', 1),
(20, 'meat-6.jpg', 1),
(21, 'seafood-1.jpg', 1),
(22, 'seafood-2.jpg', 1),
(23, 'seafood-3.jpg', 1),
(24, 'seafood-4.jpg', 1),
(25, 'snack-1.jpg', 1),
(26, 'snack-2.jpg', 1),
(27, 'snack-3.jpg', 1),
(28, 'snack-4.jpg', 1),
(29, 'snack-5.jpg', 1);