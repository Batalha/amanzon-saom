
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
        
     
## ADICIONA NOVOS CAMPOS PARA TABELA INSTALACOES

    ALTER TABLE  `instalacoes` ADD  `cabo_rj45` TINYINT NOT NULL ,
    ADD  `cabo_rj45_justificativa_sim` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
    ADD  `cabo_rj45_justificativa_nao` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
    
## ARRUMA CAMPOS CRIADOS PARA ACEITAREM NULL

    ALTER TABLE  `instalacoes` CHANGE  `cabo_rj45`  `cabo_rj45` TINYINT( 4 ) NULL ,
    CHANGE  `cabo_rj45_justificativa_sim`  `cabo_rj45_justificativa_sim` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
    CHANGE  `cabo_rj45_justificativa_nao`  `cabo_rj45_justificativa_nao` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;
    

## REPARO URGENTE - APLICACAO DA 'DATA FINAL COMISS' PARA A DATA QUE CONSTA NO TERMO DE ACEITE ENVIADO
    ## DATA DE APLICAÇÃO: 27-04-2012
    UPDATE instalacoes SET data_final_comiss = '2012-03-02' WHERE nome = 'SES-MEEL-0910';

    UPDATE instalacoes SET data_final_comiss = '2012-03-14' WHERE nome = 'SES-VAHA-0924';

    UPDATE instalacoes SET data_final_comiss = '2012-04-19' WHERE nome = 'SES-SAIA-3243';

    UPDATE instalacoes SET data_final_comiss = '2012-03-22' WHERE nome = 'SES-LUUZ-0909';

    UPDATE instalacoes SET data_final_comiss = '2012-02-09' WHERE nome = 'SES-SAAS-0781';

    UPDATE instalacoes SET data_final_comiss = '2012-03-01' WHERE nome = 'SES-SAEI-0820';

    UPDATE instalacoes SET data_final_comiss = '2012-04-12' WHERE nome = 'SES-SAIA-3231';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-MOLO-0823';

    UPDATE instalacoes SET data_final_comiss = '2012-04-20' WHERE nome = 'SES-SAIA-3238';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-SANO-0791';

    UPDATE instalacoes SET data_final_comiss = '2012-04-25' WHERE nome = 'SES-COAO-0954';

    UPDATE instalacoes SET data_final_comiss = '2012-04-17' WHERE nome = 'SES-AGAS-0934';

    UPDATE instalacoes SET data_final_comiss = '2012-04-23' WHERE nome = 'SES-SAIA-3255';

    UPDATE instalacoes SET data_final_comiss = '2012-02-29' WHERE nome = 'SES-BOAS-0802';

    UPDATE instalacoes SET data_final_comiss = '2012-02-29' WHERE nome = 'SES-SEIA-0795';

    UPDATE instalacoes SET data_final_comiss = '2012-03-20' WHERE nome = 'SES-SEES-0793';

    UPDATE instalacoes SET data_final_comiss = '2012-04-04' WHERE nome = 'SES-SAAS-0782';

    UPDATE instalacoes SET data_final_comiss = '2012-03-29' WHERE nome = 'SES-DOOS-0688';

    UPDATE instalacoes SET data_final_comiss = '2012-03-02' WHERE nome = 'SES-MEEL-0910';

    UPDATE instalacoes SET data_final_comiss = '2012-04-24' WHERE nome = 'SES-SAIA-3248';

    UPDATE instalacoes SET data_final_comiss = '2012-03-06' WHERE nome = 'SES-PRES-0836';

    UPDATE instalacoes SET data_final_comiss = '2012-04-03' WHERE nome = 'SES-EUIS-0900';

    UPDATE instalacoes SET data_final_comiss = '2012-03-12' WHERE nome = 'SES-PRIS-0778';

    UPDATE instalacoes SET data_final_comiss = '2012-04-19' WHERE nome = 'SES-SAIA-3237';

    UPDATE instalacoes SET data_final_comiss = '2012-02-28' WHERE nome = 'SES-SATE-0819';

    UPDATE instalacoes SET data_final_comiss = '2012-04-24' WHERE nome = 'SES-DOSO-3265';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-CONS-0894';

    UPDATE instalacoes SET data_final_comiss = '2012-04-17' WHERE nome = 'SES-SAIA-3246';

    UPDATE instalacoes SET data_final_comiss = '2012-03-21' WHERE nome = 'SES-SAEU-0783';

    UPDATE instalacoes SET data_final_comiss = '2012-04-11' WHERE nome = 'SES-CARA-0947';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-BIAS-0849';

    UPDATE instalacoes SET data_final_comiss = '2012-03-15' WHERE nome = 'SES-ANIA-0889';

    UPDATE instalacoes SET data_final_comiss = '2012-03-08' WHERE nome = 'SES-COTA-0682';

    UPDATE instalacoes SET data_final_comiss = '2012-03-21' WHERE nome = 'SES-ITCU-0870';

    UPDATE instalacoes SET data_final_comiss = '2012-03-29' WHERE nome = 'SES-ANOS-0937';

    UPDATE instalacoes SET data_final_comiss = '2012-03-02' WHERE nome = 'SES-DEOS-0859';

    UPDATE instalacoes SET data_final_comiss = '2012-03-28' WHERE nome = 'SES-CADE-0854';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-COIA-0796';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-TAAS-0881';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-SAIA-3242';

    UPDATE instalacoes SET data_final_comiss = '2012-04-20' WHERE nome = 'SES-SAIA-3235';

    UPDATE instalacoes SET data_final_comiss = '2012-04-19' WHERE nome = 'SES-SAIA-3243';

    UPDATE instalacoes SET data_final_comiss = '2012-03-22' WHERE nome = 'SES-LUUZ-0909';

    UPDATE instalacoes SET data_final_comiss = '2012-02-09' WHERE nome = 'SES-SAAS-0781';

    UPDATE instalacoes SET data_final_comiss = '2012-03-01' WHERE nome = 'SES-SAEI-0820';

    UPDATE instalacoes SET data_final_comiss = '2012-04-12' WHERE nome = 'SES-SAIA-3231';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-MOLO-0823';

    UPDATE instalacoes SET data_final_comiss = '2012-04-20' WHERE nome = 'SES-SAIA-3238';

    UPDATE instalacoes SET data_final_comiss = '2012-02-24' WHERE nome = 'SES-SANO-0791';

    UPDATE instalacoes SET data_final_comiss = '2012-04-25' WHERE nome = 'SES-COAO-0954';

    UPDATE instalacoes SET data_final_comiss = '2012-04-17' WHERE nome = 'SES-AGAS-0934';

    UPDATE instalacoes SET data_final_comiss = '2012-04-23' WHERE nome = 'SES-SAIA-3255';

    UPDATE instalacoes SET data_final_comiss = '2012-02-29' WHERE nome = 'SES-BOAS-0802';

    UPDATE instalacoes SET data_final_comiss = '2012-02-29' WHERE nome = 'SES-SEIA-0795';

    UPDATE instalacoes SET data_final_comiss = '2012-03-20' WHERE nome = 'SES-SEES-0793';

    UPDATE instalacoes SET data_final_comiss = '2012-04-04' WHERE nome = 'SES-SAAS-0782';

    UPDATE instalacoes SET data_final_comiss = '2012-03-29' WHERE nome = 'SES-DOOS-0688';

    UPDATE instalacoes SET data_final_comiss = '2012-03-02' WHERE nome = 'SES-MEEL-0910';

    UPDATE instalacoes SET data_final_comiss = '2012-04-24' WHERE nome = 'SES-SAIA-3248';

    UPDATE instalacoes SET data_final_comiss = '2012-03-06' WHERE nome = 'SES-PRES-0836';

    UPDATE instalacoes SET data_final_comiss = '2012-03-29' WHERE nome = 'SES-DINA-0811';

    UPDATE instalacoes SET data_final_comiss = '2012-03-20' WHERE nome = 'SES-SAHO-0785';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-AGIL-0886';

    UPDATE instalacoes SET data_final_comiss = '2012-03-14' WHERE nome = 'SES-VAHA-0924';

    UPDATE instalacoes SET data_final_comiss = '2012-04-19' WHERE nome = 'SES-SAIA-3243';

    UPDATE instalacoes SET data_final_comiss = '2012-03-22' WHERE nome = 'SES-LUUZ-0909';

    UPDATE instalacoes SET data_final_comiss = '2012-02-09' WHERE nome = 'SES-SAAS-0781';

    UPDATE instalacoes SET data_final_comiss = '2012-03-01' WHERE nome = 'SES-SAEI-0820';

    UPDATE instalacoes SET data_final_comiss = '2012-04-12' WHERE nome = 'SES-SAIA-3231';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-MOLO-0823';

    UPDATE instalacoes SET data_final_comiss = '2012-04-20' WHERE nome = 'SES-SAIA-3238';

    UPDATE instalacoes SET data_final_comiss = '2012-02-24' WHERE nome = 'SES-SANO-0791';

    UPDATE instalacoes SET data_final_comiss = '2012-04-25' WHERE nome = 'SES-COAO-0954';

    UPDATE instalacoes SET data_final_comiss = '2012-04-17' WHERE nome = 'SES-AGAS-0934';

    UPDATE instalacoes SET data_final_comiss = '2012-04-23' WHERE nome = 'SES-SAIA-3255';

    UPDATE instalacoes SET data_final_comiss = '2012-02-29' WHERE nome = 'SES-BOAS-0802';

    UPDATE instalacoes SET data_final_comiss = '2012-02-29' WHERE nome = 'SES-SEIA-0795';

    UPDATE instalacoes SET data_final_comiss = '2012-03-20' WHERE nome = 'SES-SEES-0793';

    UPDATE instalacoes SET data_final_comiss = '2012-04-04' WHERE nome = 'SES-SAAS-0782';

    UPDATE instalacoes SET data_final_comiss = '2012-03-29' WHERE nome = 'SES-DOOS-0688';

    UPDATE instalacoes SET data_final_comiss = '2012-03-02' WHERE nome = 'SES-MEEL-0910';

    UPDATE instalacoes SET data_final_comiss = '2012-03-20' WHERE nome = 'SES-SAHO-0785';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-AGIL-0886';

    UPDATE instalacoes SET data_final_comiss = '2012-03-14' WHERE nome = 'SES-VAHA-0924';

    UPDATE instalacoes SET data_final_comiss = '2012-04-19' WHERE nome = 'SES-SAIA-3243';

    UPDATE instalacoes SET data_final_comiss = '2012-03-22' WHERE nome = 'SES-LUUZ-0909';

    UPDATE instalacoes SET data_final_comiss = '2012-02-09' WHERE nome = 'SES-SAAS-0781';

    UPDATE instalacoes SET data_final_comiss = '2012-03-01' WHERE nome = 'SES-SAEI-0820';

    UPDATE instalacoes SET data_final_comiss = '2012-04-12' WHERE nome = 'SES-SAIA-3231';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-MOLO-0823';

    UPDATE instalacoes SET data_final_comiss = '2012-04-20' WHERE nome = 'SES-SAIA-3238';

    UPDATE instalacoes SET data_final_comiss = '2012-02-24' WHERE nome = 'SES-SANO-0791';

    UPDATE instalacoes SET data_final_comiss = '2012-04-25' WHERE nome = 'SES-COAO-0954';

    UPDATE instalacoes SET data_final_comiss = '2012-04-17' WHERE nome = 'SES-AGAS-0934';

    UPDATE instalacoes SET data_final_comiss = '2012-04-23' WHERE nome = 'SES-SAIA-3255';

    UPDATE instalacoes SET data_final_comiss = '2012-02-29' WHERE nome = 'SES-BOAS-0802';

    UPDATE instalacoes SET data_final_comiss = '2012-02-29' WHERE nome = 'SES-SEIA-0795';

    UPDATE instalacoes SET data_final_comiss = '2012-03-20' WHERE nome = 'SES-SEES-0793';

    UPDATE instalacoes SET data_final_comiss = '2012-04-04' WHERE nome = 'SES-SAAS-0782';

    UPDATE instalacoes SET data_final_comiss = '2012-03-29' WHERE nome = 'SES-DOOS-0688';

    UPDATE instalacoes SET data_final_comiss = '2012-03-02' WHERE nome = 'SES-MEEL-0910';

    UPDATE instalacoes SET data_final_comiss = '2012-03-20' WHERE nome = 'SES-SAHO-0785';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-AGIL-0886';

    UPDATE instalacoes SET data_final_comiss = '2012-03-14' WHERE nome = 'SES-VAHA-0924';

    UPDATE instalacoes SET data_final_comiss = '2012-04-19' WHERE nome = 'SES-SAIA-3243';

    UPDATE instalacoes SET data_final_comiss = '2012-03-22' WHERE nome = 'SES-LUUZ-0909';

    UPDATE instalacoes SET data_final_comiss = '2012-02-09' WHERE nome = 'SES-SAAS-0781';

    UPDATE instalacoes SET data_final_comiss = '2012-03-01' WHERE nome = 'SES-SAEI-0820';

    UPDATE instalacoes SET data_final_comiss = '2012-04-12' WHERE nome = 'SES-SAIA-3231';

    UPDATE instalacoes SET data_final_comiss = NULL WHERE nome = 'SES-MOLO-0823';

    UPDATE instalacoes SET data_final_comiss = '2012-04-22' WHERE nome = 'SES-SAIA-3238';

    UPDATE instalacoes SET data_final_comiss = '2012-02-24' WHERE nome = 'SES-SANO-0791';

    UPDATE instalacoes SET data_final_comiss = '2012-04-25' WHERE nome = 'SES-COAO-0954';

    UPDATE instalacoes SET data_final_comiss = '2012-04-17' WHERE nome = 'SES-AGAS-0934';

    UPDATE instalacoes SET data_final_comiss = '2012-04-23' WHERE nome = 'SES-SAIA-3255';

    UPDATE instalacoes SET data_final_comiss = '2012-02-29' WHERE nome = 'SES-BOAS-0802';

    UPDATE instalacoes SET data_final_comiss = '2012-02-29' WHERE nome = 'SES-SEIA-0795';

    UPDATE instalacoes SET data_final_comiss = '2012-03-20' WHERE nome = 'SES-SEES-0793';

    UPDATE instalacoes SET data_final_comiss = '2012-04-04' WHERE nome = 'SES-SAAS-0782';

    UPDATE instalacoes SET data_final_comiss = '2012-03-29' WHERE nome = 'SES-DOOS-0688';

    UPDATE instalacoes SET data_final_comiss = '2012-03-02' WHERE nome = 'SES-MEEL-0910';
    
    
## quando a data final for maior que a data aceite a data final passa a ser igual a data aceite

    UPDATE instalacoes SET data_final_comiss = data_aceite WHERE data_final_comiss > data_aceite;
    
    
## aplica checkbox positivo para as instalacoes com 'termo_aceite' vazio

    UPDATE instalacoes i
    SET
        i.autocomiss = 1,
        i.test_software = 1,
        i.test_antena = 1,
        i.test_buc = 1,
        i.test_tx = 1,
        i.test_calibrate = 1,
        i.test_cabo = 1,
        i.test_clima = 1,
        i.test_prtg = 1,
        i.test_info_rx_tx = 1,
        i.test_f_termo_aceite = 1,
        i.test_notificacao_inicio = 1
    WHERE
        data_aceite IS NOT NULL;
        
## aplica 'test_e_termo_aceite' positivo para instalacoes com termo_aceite

    UPDATE instalacoes i
    SET
        i.test_e_termo_aceite = 1
    WHERE
        termo_aceite != '';
        
        
## adiciona coluna na tabela os para eutelsat_code

    ALTER TABLE  `os` ADD  `eutelsat_code` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;


## nova coluna em agenda_instal "para_teste"
    
    ALTER TABLE  `agenda_instal` ADD  `para_teste` TINYINT NOT NULL;


## busca quem tem data em agendaInstal

    SELECT 
        (
            SELECT numOS
            FROM os
            WHERE idos = a.os_idos
        )AS os,
        (
            SELECT nome 
            FROM instalacoes
            WHERE os_idos = a.os_idos
        ) AS vsat,
        a.mac,
        a.data
    FROM agenda_instal a
    WHERE 
        a.para_teste = '1' AND
        (a.data != '' AND a.data IS NOT NULL AND a.data != '0000-00-00');
        
## adicao de novo campo em 'instalacoes'

    ALTER TABLE  `instalacoes` ADD  `test_sl2000` TINYINT NOT NULL;