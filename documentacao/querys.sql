
# CRIACAO DE TABELAS ### (antes dia 10/02/2012)

    #criacao da tabela 'relatorios' 
    create table relatorios(
      idrelatorios int not null auto_increment,
      nome varchar(100),
      endereco varchar(100),
      PRIMARY KEY (idrelatorios)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
    
    #criacao da tabela 'status_equipamentos' 
    CREATE TABLE IF NOT EXISTS status_equipamentos (
        idstatus_equipamentos int(11) NOT NULL AUTO_INCREMENT,
        nome varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
        PRIMARY KEY (idstatus_equipamentos)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
    
    #cria campo 'vsat' na tabela de equipamentos (10/02/2012)
    ALTER TABLE  equipamentos
        ADD  vsat VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL

    #cria campo 'usuario_confirm' na tabela 'agenda_instal' (14/02/2012)
    ALTER TABLE agenda_instal
        ADD usuario_confirm INT(11) DEFAULT NULL
        
    #cria campo 'atendimento_pai' na tabela 'atend_vsat' (17/02/2012)
    ALTER TABLE  `atend_vsat` 
        ADD  `atendimento_pai` INT DEFAULT NULL
        
    #criacao da tabela 'pausas' para atender as pausas das OS's (17/02/2012)
    CREATE TABLE pausas (
      idpausas INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
      tabela VARCHAR(100) NOT NULL,
      pausa_inicio DATETIME NOT NULL,
      pausa_fim DATETIME NULL,
      PRIMARY KEY(idpausas)
    );
    
    #cria campo 'chaveextrangeira' para tabela 'pausas' (17/02/2012)
    ALTER TABLE pausas
        ADD chaveextrangeira INT NOT NULL

    #alteracao na tabela 'pausas' (17/02/2012)
    ALTER TABLE  `pausas` CHANGE  `pausa_inicio`  `pausa_inicio` DATE NOT NULL ,
        CHANGE  `pausa_fim`  `pausa_fim` DATE NULL DEFAULT NULL

# LISTAS ### (antes dia 10/02/2012)

    #lista emrpesas
    select * from empresas
    
    #lista status_atend
    select * from status_atend
    
    #lista agenda_instal
    select idagenda_instal, os_idos, confirm from agenda_instal
    
    #lista tipo_equipamentos
    select * from tipo_equipamentos
    
    select * from equipamentos where sno = 'dsadsasdads'


# UPDATES ### (antes dia 10/02/2012)

    #muda minha empresa para nelta
    update usuarios set empresas_idempresas = 3 where idusuarios = 23;

    #voltando minha empresa apra vodanet
    update usuarios set empresas_idempresas = 1 where idusuarios = 23;
    
    #
    update usuarios set perfis_idperfis = 4 where idusuarios = 23;
    

# INCIDENTES ### (antes dia 10/02/2012)

    # CONTANDO O NUMERO DE INCIDENTES ABERTOS
    SELECT COUNT(i.idincidentes) total FROM incidentes i WHERE 
        EXISTS (
            SELECT idatend_vsat FROM atend_vsat a WHERE 
                a.incidentes_idincidentes = i.idincidentes AND
                a.status_atend_idstatus_atend = 1
        );
        
        #COM RESTRICAO DE EMPRESA
            SELECT COUNT(i.idincidentes) total FROM incidentes i WHERE 
            #busca empresa relacionada ao incidente através da busca do 
            #idinstalacao e buscando por sua referência na tabela 'os'
            (SELECT o.empresas_idempresas FROM os o WHERE idos = (SELECT inst.os_idos FROM instalacoes inst WHERE inst.idinstalacoes = i.instalacoes_idinstalacoes)) = 3 AND
            #busca existencia da instalacao na tabela de atendimento
            EXISTS (
                SELECT idatend_vsat FROM atend_vsat a WHERE 
                    a.incidentes_idincidentes = i.idincidentes AND
                    a.status_atend_idstatus_atend = 1
            );
        
    # CONTANDO O NUMERO DE INCIDENTES EM ATENDIMENTO
    SELECT COUNT(i.idincidentes) total FROM incidentes i WHERE 
        EXISTS (
            SELECT idatend_vsat FROM atend_vsat a WHERE 
                a.incidentes_idincidentes = i.idincidentes AND
                a.status_atend_idstatus_atend = 2
        );
        
    # CONTANDO O NUMERO DE INCIDENTES FINALIZADOS
    SELECT COUNT(i.idincidentes) total FROM incidentes i WHERE 
        EXISTS (
            SELECT idatend_vsat FROM atend_vsat a WHERE 
                a.incidentes_idincidentes = i.idincidentes AND
                a.status_atend_idstatus_atend = 3
        );
        
    # BUSCA DADOS DA OS E O NOME DO MUNICIPIO PELO ID DO INCIDENTE
    SELECT o.numos AS NUMOS, m.municipio AS CIDADE 
        FROM os o, municipios m WHERE 
            o.idos = 
                (SELECT inst.os_idos FROM instalacoes inst WHERE inst.idinstalacoes = 
                    (SELECT inci.instalacoes_idinstalacoes FROM incidentes inci WHERE inci.idincidentes = {ID DO INCIDENTE}) ) AND
            m.idmunicipios = 
                (SELECT o2.municipios_idcidade FROM os o2 WHERE o2.idos = 
                    (SELECT inst2.os_idos FROM instalacoes inst2 WHERE inst2.idinstalacoes = 
                        (SELECT inci2.instalacoes_idinstalacoes FROM incidentes inci2 WHERE inci2.idincidentes = {ID DO INCIDENTE}) ) )
            
        
        
# ORDEM DE SERVIÇOS (antes dia 10/02/2012)
    
    # CONTA O NUMERO DE OS's PENDENTES V
    SELECT COUNT( idos ) as total FROM os WHERE NOT EXISTS 
                ( SELECT * FROM agenda_instal WHERE agenda_instal.os_idos = idos )
        
        #com restrição de empresa
        SELECT COUNT( * ) as total FROM os WHERE empresas_idempresas = {$_SESSION['login']['empresas_idempresas']} AND NOT EXISTS 
                ( SELECT * FROM agenda_instal WHERE agenda_instal.os_idos = idos )
    
    # CONTA O NUMERO DE OS's COM CONFIRMAÇÃO PENDENTE 
    SELECT COUNT( o.idos ) as total FROM os o WHERE EXISTS 
        ( SELECT a.idagenda_instal, a.os_idos, a.confirm FROM agenda_instal a WHERE a.os_idos = o.idos AND a.confirm IS NULL)
    
    # CONTA O NUMERO DE OS's CONFIRMADAS
    SELECT COUNT( o.idos ) as total FROM os o WHERE EXISTS 
        ( SELECT a.idagenda_instal FROM agenda_instal a WHERE a.os_idos = o.idos AND a.confirm = 1)
    
    # CONTA O NUMERO DE OS's EM ANDAMENTO
    SELECT COUNT(o.idos) as total FROM os o WHERE NOT EXISTS 
        ( SELECT i.idinstalacoes FROM instalacoes i WHERE 
            i.os_idos = o.idos AND i.comiss = 1
        ) AND o.prazoInstal > CURDATE( )
    
    # CONTA O NUMERO DE OS's COM PRAZO DE INSTALAÇÃO VENCIDO
    SELECT COUNT(o.idos) as total FROM os o WHERE  
        NOT EXISTS ( SELECT i.idinstalacoes FROM instalacoes i WHERE 
            i.os_idos = o.idos AND i.comiss ) 
        AND o.prazoInstal < CURDATE( )
    
    # CONTA O NUMERO DE OS's COM INSTAÇLAÇÃO CONCLUÍDA
    SELECT COUNT(o.idos) as total FROM os o WHERE  
        EXISTS ( SELECT i.idinstalacoes FROM instalacoes i WHERE 
            i.os_idos = o.idos AND i.comiss)
            
    #LISTAGEM DE OS's (13/02/2012)
    SELECT 
        m.municipio AS municipios_municipio, 
        m.macroregiao AS municipios_macroregiao, 
        o.idos AS os_idos, 
        o.numOS AS os_numOS, 
        o.dataSolicitacao AS os_dataSolicitacao, 
        o.prazoInstal AS os_prazoInstal, 
        (SELECT empresa FROM empresas WHERE idempresas = o.empresas_idempresas) AS os_empresas_idempresas, 
        ag.mac AS agenda_instal_mac, 
        ag.idagenda_instal AS agenda_instal_idagenda_instal, 
        ag.confirm AS agenda_instal_confirm, 
        i.idinstalacoes AS instalacoes_idinstalacoes, 
        i.webnms AS instalacoes_webnms, 
        i.packetshapper AS instalacoes_packetshapper, 
        i.reglicenca AS instalacoes_reglicenca, 
        i.opmanager AS instalacoes_opmanager, 
        i.test_prtg AS instalacoes_prtg, 
        i.comiss AS instalacoes_comiss, 
        i.cod_anatel AS instalacoes_cod_anatel, 
        i.data_aceite AS instalacoes_data_aceite, 
        i.nome AS instalacoes_vsat 

    FROM os as o 

    LEFT JOIN instalacoes as i ON i.os_idos = o.idos 

    LEFT JOIN municipios as m ON o.municipios_idcidade = m.idmunicipios 

    LEFT JOIN agenda_instal as ag ON ag.os_idos = o.idos 

    ORDER BY i.data_aceite DESC


# INSTALAÇÕES (antes dia 10/02/2012)

    #PENDENTE PACKET SHAPPER
    SELECT COUNT(i.idinstalacoes) AS total FROM instalacoes i WHERE ISNULL(i.packetshapper)
    
    #PENDENTE WNMS
    SELECT COUNT(i.idinstalacoes) AS total FROM instalacoes i WHERE ISNULL(i.webnms)
    
    #INCOMPLETA
    SELECT COUNT(i.idinstalacoes) AS total FROM instalacoes i WHERE (ISNULL(i.webnms) OR ISNULL(i.packetshapper))
    
    #PENDENTE COMISSIONAMENTO
    SELECT COUNT(i.idinstalacoes) AS total FROM instalacoes i WHERE ISNULL(i.comiss)
    
        #restricao de empresa
        SELECT COUNT(i.idinstalacoes) AS total FROM instalacoes i WHERE 
     			(SELECT o.empresas_idempresas FROM os o WHERE o.idos = i.idinstalacoes) = 1 AND 
     			ISNULL(i.packetshapper)
                

#REPAROS - 09/02/2012

    #reparo para arrumar no banco a coluna 'odu' de instalacoes, onde esse valor é manual, 
    #e deve ser buscado na tabela 'tipo_equipamentos'
    UPDATE instalacoes SET odu = '2' WHERE odu = '4033'
    UPDATE instalacoes SET odu = '3' WHERE odu = '4035'
    
    #reparo na tabela de instalacoes mudando odu para o id quando for valor 4033 ou 4035
    
    

#UPDDATES - 10/02/2012

    #atualiza Local E Vsat Em Equipamentos (a partir de idinstalacoes)
    update equipamentos e set 
        e.vsat = (select i.nome from instalacoes i where i.idinstalacoes = {idinstalacoes}),
        e.local = (select m.municipio from municipios m where m.idmunicipios =
                    (select o.municipios_idcidade from os o where o.idos = 
                        (select inst.os_idos from instalacoes inst where inst.idinstalacoes = {idinstalacoes})
                    )
                  )
        where e.sno = {nsodu_comiss}
        
    #atualiza status de Equipamentos (a partir de idinstalacoes)
    UPDATE equipamentos e SET 
    
    #reparo para equipamentos
    UPDATE equipamentos SET status = 1 WHERE status = 'disponivel'
    
    
# RELATORIO 28022012
    SELECT i.nome AS VSAT, i.teccampo AS 'Tecnico Campo' FROM instalacoes i
    
    
    
# VERIFICACAO E MAC EM AGENDA_INSTAL

    SELECT IF(
                (SELECT count(*) FROM agenda_instal WHERE mac = '{$this->dadosP['form']['mac']}')>0,
                (SELECT IF(
                            (SELECT os_status_idos_status FROM os WHERE idos = 
                                (SELECT os_idos FROM agenda_instal WHERE mac = '{$this->dadosP['form']['mac']}')
                            )=2,
                            'disponivel',
                            'ocupado')
                          ),
                'disponivel'
             ) AS resultado;
             
# VERIFICAÇÃO DE QUANTAS VSATS EXISTEM SOB RESPONSA DO PERFIL NOC
    
    SELECT COUNT(*) FROM instalacoes i WHERE
        (SELECT perfis_idperfis FROM usuarios WHERE idusuarios = i.create_user_comiss) = 1
        AND (DATE(i.data_aceite) = DATE(NOW() ) OR i.data_aceite IS NULL OR i.data_aceite = '0000-00-00 00:00:00') 
        AND (i.create_user_comiss_time != '0000-00-00 00:00:00' AND i.create_user_comiss_time IS NOT NULL)
        
        
        select *
        from listcomiss
        WHERE  
            (DATE(data_fim) = DATE(NOW()) OR data_fim IS NULL OR data_fim = '0000-00-00')
            AND (data_inicio != '0000-00-00 00:00:00' AND data_inicio IS NOT NULL)
            AND comiss = 1
        order by tecnico desc
        limit 20
        
        
## RESGATA INSTALACOES E AGENDAMENTOS COM NS'S DIFERENTES MAS COM MESMO OS_IDOS

    SELECT 
        i.nome AS instalacao_nome,
        i.nsmodem_comiss AS ns_modem_instalacao,
        a.nsmodem AS ns_modem_agendamento,
        i.nsodu_comiss AS ns_odu_instalacao,
        a.nsodu AS ns_odu_agendamento,
        i.antena_ns_comiss AS ns_antena_instalacao,
        a.antena_ns AS ns_antena_agendamento,
        i.data_ativacao AS data_comissionamento,
        a.data AS data_agendamento
    FROM 
        instalacoes i
    LEFT JOIN agenda_instal AS a ON 
        i.os_idos = a.os_idos
        AND (
            i.nsmodem_comiss != a.nsmodem OR
            i.nsodu_comiss != a.nsodu OR
            i.antena_ns_comiss != a.antena_ns
        );
        
## RESGATA COORDENADAS REQUISITADAS PELO RONAN 17/05/2012

    SELECT 
        i.nome,
        i.latitude_graus,
        i.latitude_minutos,
        i.latitude_segundos,
        i.latitude_direcao,
        i.longitude_graus,
        i.longitude_minutos,
        i.longitude_segundos,
        i.longitude_direcao
    FROM instalacoes i
    WHERE i.nome = '';
        
        
        
        