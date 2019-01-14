
# REPARO 28/02/2012 - todos os prazos de 2012 são para 45 dias a frente da data de solicitação
    UPDATE os 
    SET prazoInstal = DATE_ADD(dataSolicitacao,INTERVAL 45 DAY) 
    WHERE YEAR(dataSolicitacao) = 2012
    
    
    
##

    UPDATE instalacoes 
    SET  
        odu = '4',
        packetshapper = '1',
        webnms = '1',
        reglicenca = '1',
        opmanager = '1',
        ope_eutelsat = 'Reny',
        val_crosspol = '27',
        azimute_comiss = '46',
        elevacao_comiss = '48',
        snr_comiss = '14',
        nsmodem_comiss = '0411020302',
        mac_comiss = '00:20:0E:10:48:56',
        nsodu_comiss = '10480404020308070509',
        antena_comiss = 'patriot',
        antena_ns_comiss = 'ng143630084',
        autocomiss = '1',
        test_software = '1',
        ebno_comiss = '13.5',
        eirp_comiss = '46',
        comp_cabo_comiss = '25m',
        desc_clima_comiss = 'ensolarado',
        data_aceite = '2012-03-02',
        teccampo = 'Airton Gabriel do Nascimento Mouro',
        teccampo_tel = '(31)9324-0153',
        registro_concessionaria = NULL,
        latitude_graus = '19',
        latitude_minutos = '37',
        latitude_segundos = '51',
        longitude_graus = '43',
        longitude_minutos = '59',
        longitude_segundos = '12',
        latitude_direcao = 'S',
        longitude_direcao = 'W',
        last_user_comiss = '23',
        last_user_comiss_time = '2012-03-02 14:37:17',
        idinstalacoes = '124'  
    WHERE idinstalacoes = '124';
    
    

## REPARO 07/03/2012 -> criacao de campo status para os e nova tabela para esse status

    ##campo fk para outra tabela
    ALTER TABLE  `os` ADD  `os_status_idos_status` INT( 11 ) NOT NULL;
    
    ##tabela de status
    create table os_status(
      idos_status int not null auto_increment,
      status varchar(100),
      descricao text,
      PRIMARY KEY (idos_status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
    
    ##primeiros status's
    INSERT INTO os_status (status,descricao) 
        VALUES ('ativa','OS em andamento.'),
        ('cancelada','OS cancelada.');
        
        
## REPARO 22/03/2012 -> cadastro de novo campo para comissionamento (instalacoes)
    ALTER TABLE  `instalacoes` ADD  `data_final_comiss` DATETIME NOT NULL;
    
    SELECT IF(
                (SELECT data_final_comiss FROM instalacoes WHERE idinstalacoes = '{$this->dadosP['form']['idinstalacoes']}') IS NULL OR
                (SELECT data_final_comiss FROM instalacoes WHERE idinstalacoes = '{$this->dadosP['form']['idinstalacoes']}') = '',
                'finalizado',
                'andamento'
             )
    
    ## aplicando o idinstalacao de atendimento ao mesmo de seus incidentes
    UPDATE atend_vsat a SET instalacoes_idinstalacoes = (SELECT instalacoes_idinstalacoes FROM incidentes WHERE idincidentes = a.incidentes_idincidentes);
    
    
## ATUALIZA ADICIONANDO UM NOVO CAMPO EM PERFIL (SUBPERFIL) E MUDA 
## SUPERVISOR PARA APENAS 'SUPERVISOR' E NÃO 'SUPERVISOR NOC'
    ALTER TABLE  `usuarios` ADD  `subperfil_idsubperfil` INT( 11 ) NOT NULL;
    
    UPDATE perfis SET perfil = 'Supervisor' , descricao = 'Supervisor' WHERE idperfis = 5;
    

## CRIANDO ACOES INICIAIS PARA LOG

    INSERT INTO log_acao (nome) 
        VALUES ('INSERT'), ('UPDATE');
    
## ADICIONA NOVO CAMPO EM INSTALACOES

    ALTER TABLE  `instalacoes` ADD  `ipdvb` VARCHAR( 100 ) 
            CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
    ## campo cancelado para instalacoes
        
    ## campo aplicado em os
    ALTER TABLE  `os` ADD  `ipdvb` VARCHAR( 100 ) 
            CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
            
            
## APLICA final_tarefa DO CRONOMETRO CORRESPONDENTE A data_aceite DA PRODEMGE EM INSTALACOES

    UPDATE instalacoes i SET data_final_comiss = data_aceite
        WHERE data_final_comiss IS NULL OR data_final_comiss = '0000-00-00 00:00:00';
        
    SELECT nome, data_aceite, data_final_comiss FROM instalacoes i WHERE data_aceite IS NOT NULL AND data_final_comiss = '0000-00-00 00:00:00';
    
## CRIA NOVO CAMPO PARA GESTÃO DE ARQUIVOS DOS SUPERVISORES

    ALTER TABLE  `usuarios` ADD  `arquivo_supervisor` TINYINT NOT NULL;
    
## CRIA TABELA DO COMPARTILHAMENTO
    
    CREATE  TABLE IF NOT EXISTS compartilhamento (
      idcompartilhamento INT NOT NULL ,
      endereco VARCHAR(100) NULL ,
      data_envio DATETIME NULL ,
      usuario_envio INT(11) NULL ,
      PRIMARY KEY (idcompartilhamento),
      INDEX fk_compartilhamento_usuarios (usuario_envio ASC) ,
      CONSTRAINT fk_compartilhamento_usuarios
        FOREIGN KEY (usuario_envio )
        REFERENCES usuarios (idusuarios )
        ON DELETE NO ACTION
        ON UPDATE NO ACTION )
    ENGINE = InnoDB;
    
    ALTER TABLE  `compartilhamento` CHANGE  `idcompartilhamento`  `idcompartilhamento` INT( 11 ) NOT NULL AUTO_INCREMENT;
    
    
## RECOLOCA DATA FINAL COMISS PARA AS INSTALACOES QUE ESTAO COM ESSA DATA ZERADA

    UPDATE instalacoes 
        SET data_final_comiss = data_aceite 
        WHERE data_final_comiss = '0000-00-00 00:00:00';
    

## NOVO CAMPO EM INSTALACOES

    ALTER TABLE  `instalacoes` ADD  `justificativa_mod_data_aceite` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
    

## ATUALIZA TABELA DE EQUIPAMENTOS

    UPDATE 
        equipamentos
    SET 
        sno = REPLACE(sno,'1048044','104804040'),
        sno = REPLACE(sno,'104840203','10484040203'),
        sno = REPLACE(sno,'10480402003','104804040203');
        


#####################################################################################
############## MDIFICACOES PARA SAOM UNIFICADO ######################################
#####################################################################################

# CRIA TABELA 'SAOM'

    CREATE TABLE IF NOT EXISTS `saom` (
      `id_saom` int(11) NOT NULL AUTO_INCREMENT,
      `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
      PRIMARY KEY (`id_saom`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;
    
    

    INSERT INTO `saom` (`id_saom`, `nome`) VALUES
    (1, 'prodemge'),
    (2, 'sp');


# ADICIONA CAMPO 'SAOM' EM TABELAS QUE TERÃO SISTEMA DIFERECIADO

    #adiciona coluna
    ALTER TABLE  `os` ADD  `saom` INT DEFAULT 1;
    ALTER TABLE  `instalacoes` ADD  `saom` INT DEFAULT 1;
    ALTER TABLE  `incidentes` ADD  `saom` INT DEFAULT 1;
    ALTER TABLE  `atend_vsat` ADD  `saom` INT DEFAULT 1;
    ALTER TABLE  `agenda_instal` ADD  `saom` INT DEFAULT 1;
    ALTER TABLE  `usuarios` ADD  `saom` INT DEFAULT 1;
    
    #muda pra valor válido em chave extrangeira
    UPDATE os SET saom = 1;
    UPDATE instalacoes SET saom = 1;
    UPDATE incidentes SET saom = 1;
    UPDATE atend_vsat SET saom = 1;
    UPDATE agenda_instal SET saom = 1;
    UPDATE usuarios SET saom = 1;
    
    #transforma em chave extrangeira
    ALTER TABLE os ADD FOREIGN KEY (saom) REFERENCES saom (id_saom);
    ALTER TABLE instalacoes ADD FOREIGN KEY (saom) REFERENCES saom (id_saom);
    ALTER TABLE incidentes ADD FOREIGN KEY (saom) REFERENCES saom (id_saom);
    ALTER TABLE atend_vsat ADD FOREIGN KEY (saom) REFERENCES saom (id_saom);
    ALTER TABLE agenda_instal ADD FOREIGN KEY (saom) REFERENCES saom (id_saom);
    ALTER TABLE usuarios ADD FOREIGN KEY (saom) REFERENCES saom (id_saom);
    
# ATUALIZA USUARIOS TODOS PARA PRODEMGE

    UPDATE usuarios SET saom = 1;
    
# CRIA TABELA 'GRUPOS' 

    CREATE TABLE IF NOT EXISTS `grupos` (
      `id_grupos` int(11) NOT NULL AUTO_INCREMENT,
      `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
      PRIMARY KEY (`id_grupos`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
    
# CRIA TABELA 'GRUPOS_USUARIOS'

    CREATE TABLE IF NOT EXISTS `grupos_usuarios` (
      `id_grupos_usuarios` int(11) NOT NULL AUTO_INCREMENT,
      `id_grupos` int(11) NOT NULL,
      `id_usuarios` int(11) NOT NULL,
      PRIMARY KEY (`id_grupos_usuarios`),
      KEY `id_grupos` (`id_grupos`),
      KEY `id_usuarios` (`id_usuarios`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

# REGISTRA ASSOCIACOES

    ALTER TABLE grupos_usuarios ADD FOREIGN KEY (id_grupos) REFERENCES grupos (id_grupos);
    ALTER TABLE grupos_usuarios ADD FOREIGN KEY (id_usuarios) REFERENCES usuarios (id_usuarios);
    
    
    
#####################################################################################
######## MODIFICAÇÕES PARA GESTAO DE EQUIPAMENTOS COM HISTÓRICO #####################
#####################################################################################

    # RETIRA CAMPO vsat DE equipamentos
    ALTER TABLE `equipamentos` DROP `vsat`;
    
    # RETIRA CAMPO instalacoes_idinstalacoes DE equipamentos
    ## OBS.: é necessário tirar relacionamento
    ALTER TABLE `equipamentos` DROP `instalacoes_idinstalacoes`;
    
    # RETIRA CAMPO local DE equipamentos
    ALTER TABLE `equipamentos` DROP `local`;
    
    #CRIA TABELA equipamentos_locais
    CREATE TABLE IF NOT EXISTS `equipamentos_locais` (
      `idequipamentos_locais` int(11) NOT NULL AUTO_INCREMENT,
      `idequipamentos` int(11) NOT NULL,
      `idlocais_equipamentos` int(11) NOT NULL,
      `data_movimentacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      `tabela_localidade` varchar(50) NULL,
      PRIMARY KEY (`idequipamentos_locais`),
      KEY `idequipamentos` (`idequipamentos`,`idlocais_equipamentos`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
    
    #CRIA TABELA locais_equipamentos
    CREATE TABLE IF NOT EXISTS `locais_equipamentos` (
      `idlocais_equipamentos` int(11) NOT NULL AUTO_INCREMENT,
      `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
      `descricao` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
      `municipios_idmunicipios` int(11) NOT NULL,
      `locais_equipamentos_idlocais_equipamentos` int(11) NOT NULL,
      PRIMARY KEY (`idlocais_equipamentos`),
      KEY `municipios_idmunicipios` (`municipios_idmunicipios`,`locais_equipamentos_idlocais_equipamentos`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
    
    #SETANDO RELACIONAMENTOS DE locais_equipamentos
    ALTER TABLE  `locais_equipamentos` ADD FOREIGN KEY (  `municipios_idmunicipios` ) REFERENCES  `vodanet_online`.`municipios` (
    `idmunicipios`
    ) ON DELETE NO ACTION ON UPDATE NO ACTION ;
    ALTER TABLE  `locais_equipamentos` ADD FOREIGN KEY (  `locais_equipamentos_idlocais_equipamentos` ) REFERENCES  `vodanet_online`.`locais_equipamentos` (
    `idlocais_equipamentos`
    ) ON DELETE NO ACTION ON UPDATE NO ACTION ;
    
    #NOVA VIEW DE LISTAGEM DE EQUIPAMENTOS
    CREATE VIEW listequipamentos AS
    SELECT 
        e.idequipamentos AS idequipamentos,#idequipamentos
        e.sno AS sno,#sno
        e.mac AS mac,#mac
        (
            SELECT IF(
                e.status = 1,
                'Disponível',
                'Em uso'
            )
        )AS status,#status
        (
            SELECT IF(
                (SELECT COUNT(*) FROM instalacoes WHERE idinstalacoes = el.idlocais_equipamentos) > 0,
                (SELECT nome FROM instalacoes WHERE idinstalacoes = el.idlocais_equipamentos),
                '-'
            )
        )AS vsat,#vsat
        (
            SELECT IF(
                el.tabela_localidade != '',
                (
                    SELECT IF( # nivel 1: municipios
                        (SELECT COUNT(*) FROM municipios WHERE idmunicipios = el.idlocais_equipamentos) > 0,
                        (SELECT municipio FROM municipios WHERE idmunicipios = el.idlocais_equipamentos),
                        (
                            SELECT IF( # nivel 2: locais_equipamentos
                                (SELECT COUNT(*) FROM locais_equipamentos WHERE idlocais_equipamentos = el.idlocais_equipamentos) > 0,
                                (SELECT nome FROM locais_equipamentos WHERE idlocais_equipamentos = el.idlocais_equipamentos),
                                (
                                    SELECT IF( # nivel 3: instalacoes
                                        (SELECT COUNT(*) FROM instalacoes WHERE idinstalacoes = el.idlocais_equipamentos) > 0,
                                        (
                                            #municipio
                                            SELECT municipio 
                                            FROM municipios 
                                            WHERE (
                                                #os
                                                SELECT municipios_idcidade
                                                FROM os
                                                WHERE idos = (
                                                    #instalacoes
                                                    SELECT os_idos 
                                                    FROM instalacoes 
                                                    WHERE idinstalacoes = el.idlocais_equipamentos
                                                )
                                            ) = idmunicipios
                                        ),
                                        '-'
                                    )
                                )
                            )
                        )
                    )
                ),
                '(sem local)'
            )
        ) AS local,#local
        e.observacoes AS observacoes, #observacoes
        (
            SELECT nome
            FROM tipo_equipamentos
            WHERE idtipo_equipamentos = e.tipo_equipamentos_idtipo_equipamentos
        )AS nome_tipo_equipamentos #nome do tipo de equipamento
    FROM
        equipamentos AS e
    LEFT JOIN equipamentos_locais AS el ON el.idequipamentos = e.idequipamentos
    ORDER BY idequipamentos DESC;
    
        
    
#####################################################################################
######## ATUALIZACAO DE EQUIPAMENTOS ################################################
#####################################################################################
    
    ## tira macs de equipamentos 4033 e 4035
    UPDATE equipamentos e 
    SET e.mac = ''
    WHERE
        e.tipo_equipamentos_idtipo_equipamentos = 2 OR
        e.tipo_equipamentos_idtipo_equipamentos = 3;
    
    ## libera equipamentos sem referencia em 'equipamentos_locais' 
    ## e sem equipamentos.vsat e sem equipamentos.local
    UPDATE equipamentos e
    SET
        e.status = 1
    WHERE
        ( e.local = '' OR e.local = NULL ) AND
        ( e.vsat = '' OR e.vsat = NULL ) AND
        ( 
            SELECT COUNT(*) 
            FROM equipamentos_locais
            WHERE idequipamentos = e.idequipamentos
        ) = 0;
        
        
#####################################################################################
######## EQUIPAMENTOS - ANTENAS #####################################################
#####################################################################################

    ## criacao de tabelas #### 
    
    ## equipamentos_antenas
    CREATE TABLE IF NOT EXISTS `equipamentos_antenas` (
      `idequipamentos_antenas` int(11) NOT NULL AUTO_INCREMENT,
      `tipo_equipamentos_antenas` int(11) NOT NULL,
      `numero_antenas` int(11) NOT NULL,
      PRIMARY KEY (`idequipamentos_antenas`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
    
    ## equipamentos_antenas_locais
    CREATE TABLE IF NOT EXISTS `equipamentos_antenas_locais` (
      `idequipamentos_antenas_locais` int(11) NOT NULL AUTO_INCREMENT,
      `idequipamentos_antenas_tipo` int(11) NOT NULL,
      `idlocais_equipamentos` int(11) NOT NULL,
      `data_movimentacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `tabela_localidade` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
      PRIMARY KEY (`idequipamentos_antenas_locais`),
      KEY `idequipamentos` (`idequipamentos_antenas`,`idlocais_equipamentos`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;
    
    ## adiçao de campo 'especie_equipamento_idespecie_equipamento' (fk)
    ALTER TABLE  `tipo_equipamentos` ADD  `especie_equipamento_idespecie_equipamento` INT NOT NULL DEFAULT  '1';
    
    ## cria tabela 'especie_equipamento'
    CREATE TABLE IF NOT EXISTS `especie_equipamento` (
      `idespecie_equipamento` int(11) NOT NULL AUTO_INCREMENT,
      `nome` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
      PRIMARY KEY (`idespecie_equipamento`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
    
    ## seta fk no campo 'especie_equipamento_idespecie_equipamento'
    ALTER TABLE  `tipo_equipamentos` ADD INDEX (  `especie_equipamento_idespecie_equipamento` );
    INSERT INTO  `vodanet_online`.`especie_equipamento` (
        `idespecie_equipamento` ,
        `nome`
    )
    VALUES (
        NULL ,  'odu'
    ), (
        NULL ,  'modem'
    ), (
        NULL ,  'antena'
    );
    ALTER TABLE  `tipo_equipamentos` ADD FOREIGN KEY (  `especie_equipamento_idespecie_equipamento` ) REFERENCES  `vodanet_online`.`especie_equipamento` (
        `idespecie_equipamento`
    ) ON DELETE NO ACTION ON UPDATE NO ACTION ;
    

#########################################################################################
## ASSOCIACAO COM EQUIPAMENTOS ########################################################## -- 02/07/2012
#########################################################################################

    ALTER TABLE  `equipamentos_locais` ADD  `tipo_associacao` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
