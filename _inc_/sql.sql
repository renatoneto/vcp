ALTER TABLE `login` ADD `vcp_pontos` INT NOT NULL DEFAULT '0';

--
-- Estrutura da tabela `vcp_tops`
--

CREATE TABLE IF NOT EXISTS `vcp_tops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  `url` varchar(100) NOT NULL,
  `minutos` smallint(8) NOT NULL,
  `pontos` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `vcp_tops`
--

--
-- Estrutura da tabela `vcp_bruteforce`
--

CREATE TABLE IF NOT EXISTS `vcp_bruteforce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(20) NOT NULL DEFAULT '',
  `data` int(11) NOT NULL,
  `block` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `vcp_bruteforce`
--

--
-- Estrutura da tabela `vcp_votos`
--

CREATE TABLE IF NOT EXISTS `vcp_votos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `top_id` int(11) NOT NULL,
  `data` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `vcp_votos`
--

--
-- Estrutura da tabela `vcp_itens`
--

CREATE TABLE IF NOT EXISTS `vcp_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `quantidade` int(11) NOT NULL,
  `pontos` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `vcp_itens`
--