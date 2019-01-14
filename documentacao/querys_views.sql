

# CRIACAO DA VIEW DE LIST DA OS (listos)
    CREATE VIEW listos AS
        SELECT 
            m.municipio AS municipios_municipio, 
            m.macroregiao AS municipios_macroregiao, 
            o.idos AS os_idos, 
            o.numOS AS os_numOS, 
            o.dataSolicitacao AS os_dataSolicitacao, 
            o.prazoInstal AS os_prazoInstal, 
            o.identificador AS identificador,
            o.empresas_idempresas AS empresa,
            (
                SELECT empresa 
                FROM empresas 
                WHERE idempresas = o.empresas_idempresas
            ) AS os_empresas_idempresas, 
            i.idinstalacoes AS instalacoes_idinstalacoes, 
            i.webnms AS instalacoes_webnms, 
            i.packetshapper AS instalacoes_packetshapper, 
            i.reglicenca AS instalacoes_reglicenca, 
            i.opmanager AS instalacoes_opmanager, 
            i.test_prtg AS instalacoes_prtg, 
            i.comiss AS instalacoes_comiss, 
            i.cod_anatel AS instalacoes_cod_anatel, 
            i.data_aceite AS instalacoes_data_aceite, 
            i.nome AS instalacoes_vsat,
            ( 
                SELECT IF (
                        ag.idagenda_instal,
                        ( 
                            SELECT IF (
                                        ag.confirm=1,
                                        'Confirmado',
                                        ( 
                                            SELECT IF (
                                                        ag.para_teste = 1,
                                                        'TESTE',
                                                        (
                                                            SELECT IF (
                                                                        ag.data != '' AND ag.data != '0000-00-00',
                                                                        'Não Confirmado',
                                                                        'Sem Data'
                                                            )
                                                        )
                                            )
                                        )
                            )
                        ),
                        'Não'
                ) 
            ) AS agendamento,
            ( SELECT IF(i.comiss=1,
                        (SELECT IF(
                            i.test_e_termo_aceite=1,
                            i.data_final_comiss,
                            'Em Andamento'
                        )),
                        'Não'
                        )
            ) AS comiss,
            ( SELECT IF(instalacoes_idinstalacoes,
                            (SELECT IF (instalacoes_packetshapper != 1 OR instalacoes_packetshapper IS NULL,
                                            'Pendente Packet Shapper',
                                            (SELECT IF (instalacoes_webnms != 1 OR instalacoes_webnms IS NULL,
                                                            'Pendente WebNms',
                                                            (SELECT IF (instalacoes_reglicenca != 1 OR instalacoes_reglicenca IS NULL,
                                                                            'Pendente Registro da licença',
                                                                            (SELECT IF (instalacoes_opmanager != 1 OR instalacoes_opmanager IS NULL,
                                                                                            'Pendente Opmanager',
                                                                                            (SELECT IF(instalacoes_prtg != 1 OR instalacoes_prtg IS NULL,
                                                                                                            'Pendente PRTG',
                                                                                                            'Completa'
                                                                                                      )
                                                                                            )
                                                                                        )
                                                                            )
                                                                        )
                                                            )
                                                        )
                                            )
                                        )
                            ),
                            'Não') 
            ) AS vsatCriada,
            ( SELECT IF(instalacoes_idinstalacoes,
                            (SELECT IF(instalacoes_cod_anatel,
                                            instalacoes_cod_anatel,
                                            'Não'
                                       )
                            ),
                            'Não'
                        ) 
            ) AS codAnatel,
            CAST(( SELECT IF(instalacoes_data_aceite,
                            (SELECT IF(instalacoes_data_aceite,
                                            instalacoes_data_aceite,
                                            'Não'
                                       )
                            ),
                            'Não'
                        ) 
            ) AS CHAR) AS aceiteProdemge,
            (SELECT IF(
                (SELECT COUNT(idpausas)
                FROM pausas
                WHERE
                    tabela = 'OS' AND
                    chaveextrangeira = o.idos AND
                    pausa_fim IS NULL) > 0,
                    'Sim',
                    'Não'
                )
            ) AS paralisado,
            o.saom
        FROM os as o 
        LEFT JOIN instalacoes as i ON i.os_idos = o.idos 
        LEFT JOIN municipios as m ON o.municipios_idcidade = m.idmunicipios 
        LEFT JOIN agenda_instal as ag ON ag.os_idos = o.idos 
        ORDER BY i.data_aceite DESC;
        
# CRIACAO DA VIEW DE LIST DOS AGENDAMENTOS (listAgendamentos)
    CREATE VIEW listagendamentos AS
        SELECT
            a.idagenda_instal AS idagenda_instal,
            a.os_idos AS agenda_instal_os_idos,
            o.numOS AS os_numos,
            o.empresas_idempresas AS empresa_filtro,
            o.cidade AS os_cidade,
            a.data AS data,
            a.contato AS contato,
            a.tel AS tel,
            a.confirm AS agenda_instal_confirm,
            (SELECT IF (agenda_instal_confirm=1,'Sim','Não')) AS confirm,
            (SELECT IF(o.empresas_idempresas!='',
                       (SELECT e.empresa FROM empresas e WHERE e.idempresas = o.empresas_idempresas),
                       ''
                      )
            ) AS empresa,
            a.saom
        FROM agenda_instal as a
        LEFT JOIN os AS o ON o.idos = a.os_idos
        WHERE 
            (SELECT IF (
                (
                    SELECT COUNT(*)
                    FROM pausas
                    WHERE 
                        tabela = 'OS' AND
                        chaveextrangeira = a.os_idos AND
                        pausa_fim IS NULL
                ) > 0,
                1,
                0
            )) = 0
        ORDER BY a.confirm ASC;
        
# CRIACAO DA VIEW DE LIST DAS INSTALACOES (listInstalacoes)
    CREATE VIEW listinstalacoes AS
        SELECT
            i.idinstalacoes AS idinstalacoes,
            i.nome AS nome,
            o.numOS AS numos,
            o.empresas_idempresas AS empresa,
            i.mac AS mac,
            i.cod_anatel AS cod_anatel,
            (SELECT IF(
                      i.webnms,
                      (SELECT IF (
                                 i.packetshapper,
                                 (SELECT IF(
                                            i.reglicenca,
                                            'Completa',
                                            'Pendente Registro a Licença'
                                           )
                                 ),
                                 'Pendente Packet Shapper'
                                 )
                      ),
                      'Pendente WebNms'
                      )
            ) AS status,
            (SELECT IF (i.comiss!=1,'Não','Sim')) AS comiss,
            (SELECT IF (i.data_aceite,i.data_aceite,'Não')) AS aceite_prodemge,
            i.saom
        FROM instalacoes as i
        LEFT JOIN os AS o ON o.idos = i.os_idos;
        
# CRIACAO DA VIEW DE LIST DOS INCIDENTES (listIncidentes)
    CREATE VIEW listincidentes AS
        SELECT 
            inci.idincidentes AS idincidentes,
            inst.nome AS instalacoes_nome,
            inci.data AS data,
            inci.prioridade AS prioridade,
            CONCAT(SUBSTRING(inci.descricao,1,50),'...') AS descricao,
            CONCAT(SUBSTRING(atend.atendimento,1,50),'...') AS atendimento,
            inci.idprodemge AS idprodemge,
            (SELECT IF(
                        (SELECT COUNT(*) 
                            FROM atend_vsat atend2 
                            WHERE atend2.status_atend_idstatus_atend=1 
                            AND inci.idincidentes = atend2.incidentes_idincidentes
                        )>0,
                        'Aberto',
                        (SELECT IF(
                                    (SELECT COUNT(*) 
                                    FROM atend_vsat atend3 
                                    WHERE atend3.status_atend_idstatus_atend=2 
                                    AND inci.idincidentes = atend3.incidentes_idincidentes)>0,
                                    'Em Atendimento',
                                    (
                                    SELECT IF(
                                                (SELECT COUNT(*) 
                                                    FROM atend_vsat atend4 
                                                    WHERE atend4.status_atend_idstatus_atend=3 
                                                    AND inci.idincidentes = atend4.incidentes_idincidentes)>0,
                                                'Finalizado',
                                                'Sem Atendimento'
                                             )
                                    ) 
                                  )
                        )
                      )
            ) AS status,
            u.nome AS nomeTecnico,
            inci.saom
        FROM incidentes inci
        LEFT JOIN atend_vsat AS atend ON atend.incidentes_idincidentes = inci.idincidentes
        LEFT JOIN usuarios AS u ON inci.tecnicoNoc = u.idusuarios
        LEFT JOIN instalacoes AS inst ON inci.instalacoes_idinstalacoes = inst.idinstalacoes;
        
# CRIACAO DA VIEW DE LIST DOS EQUIPAMENTOS (listEquipamentos) - atualizada 15062012
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
        
##CRIACAO DE VIEW PARA CHAMADOS QUE CONSTEM COMISS E ATEND
    
    ## para atend
    CREATE VIEW listchamadosfull AS
        SELECT 
            ##campos buscados para atendimentos
            a.idatend_vsat AS idatendimento,
            a.data AS atendimento,
            (
                SELECT IF(
                    a.incidentes_idincidentes=0,
                    'Sem Incidente',
                    a.incidentes_idincidentes
                )
            ) AS incidente,
            (
                SELECT nome 
                FROM instalacoes 
                WHERE idinstalacoes = 
                    (
                        SELECT instalacoes_idinstalacoes 
                        FROM incidentes 
                        WHERE idincidentes = a.incidentes_idincidentes
                    )
            ) AS vsat,
            u.nome AS tecnico,
            u.idusuarios AS idtecnico,
            (
                SELECT perfil 
                FROM perfis 
                WHERE idperfis = u.perfis_idperfis
            ) AS perfil_usuario,
            (  
                SELECT IF(
                    u.perfis_idperfis=5,
                    u.subperfil_idsubperfil,
                    u.perfis_idperfis
                )
            ) AS idperfil_usuario,
            u.empresas_idempresas AS empresa,
            s.status AS status,
            (
                SELECT IF(
                    a.resposta_agilis!='' AND a.resposta_agilis IS NOT NULL,
                    1,
                    0
                )
            ) AS resposta_agilis,
            (
                SELECT TIMEDIFF(
                    IF(
                        c.final_tarefa IS NULL,
                        NOW(),
                        c.final_tarefa
                    ), 
                    c.inicio_tarefa 
                )
            ) AS tempo_vencimento,
            c.inicio_tarefa AS data_inicio,
            (
                SELECT IF(
                    c.final_tarefa IS NULL,
                    '',
                    c.final_tarefa
                )
            ) AS data_fim,
            c.final_tarefa AS fim_cronometro,
            inst.data_aceite AS data_aceite,
            inst.saom AS saom
        FROM atend_vsat a
        LEFT JOIN incidentes AS i ON i.idincidentes = a.incidentes_idincidentes
        LEFT JOIN instalacoes AS inst ON inst.idinstalacoes = i.instalacoes_idinstalacoes
        LEFT JOIN usuarios AS u ON u.idusuarios = a.usuarios_idusuarios
        LEFT JOIN status_atend AS s ON s.idstatus_atend = a.status_atend_idstatus_atend
        LEFT JOIN cronometro AS c ON c.idreferencia = a.idatend_vsat AND tabelareferencia = 'atend_vsat'
        WHERE 
            a.incidentes_idincidentes != 0 ## que tenha id de incidentes
            AND (
                SELECT COUNT(*) 
                FROM incidentes 
                WHERE idincidentes = a.incidentes_idincidentes
            ) > 0 ## que tenha mais de 0 incidentes associado
        ORDER BY a.atendimento DESC;
        
        ## busca nova baseada em parametros:
            ## 1.busca instalacoes de forma paralela a incidentes
        
        
        
        ## AND (DATE(fim_cronometro) = DATE(NOW() ) OR fim_cronometro IS NULL OR fim_cronometro = '0000-00-00 00:00:00')
        
    ## para comiss
    CREATE VIEW listcomiss AS
        SELECT
            i.os_idos AS idos,
            i.idinstalacoes AS idinstalacoes,
            i.nome AS vsat,
            u.nome AS tecnico,
            i.create_user_comiss_time AS data_inicio,
            (SELECT IF(
                i.data_final_comiss = '0000-00-00 00:00:00' OR i.data_final_comiss IS NULL,
                '',
                i.data_final_comiss
            )) AS data_fim,
            (SELECT DATEDIFF(i.data_aceite,i.create_user_comiss_time)) AS tempo,
            i.comiss AS comiss,
            (SELECT IF(
                        i.comiss=1,
                        (SELECT IF(
                            i.test_e_termo_aceite=1,
                            'Finalizado',
                            'Em Andamento'
                        )),
                        'Inexistente'
                      )
            ) AS status,
            (SELECT perfis_idperfis FROM usuarios WHERE idusuarios = i.create_user_comiss) AS idperfil_usuario,
            (SELECT TIMEDIFF( 
                    IF( 
                        i.data_final_comiss IS NULL OR i.data_final_comiss = '0000-00-00 00:00:00',
                        NOW(),
                        i.data_final_comiss
                    ),
                    i.create_user_comiss_time 
                )
            ) AS tempo_vencimento,
            i.data_aceite AS data_aceite,
            i.saom AS saom
        FROM instalacoes i
        LEFT JOIN usuarios AS u ON u.idusuarios = i.create_user_comiss;
        
## LISTA PARA GERIR 'SAT VSAT CODE' da tabela de 'instalacoes'

    CREATE VIEW listeutelsatcode AS
        SELECT
            o.idos AS id,
            o.numOS AS os,
            (
                SELECT municipio 
                FROM municipios 
                WHERE idmunicipios = o.municipios_idcidade
            ) AS localidade,
            i.nome,
            o.eutelsat_code AS eutelsat_code
        FROM 
            os o
        LEFT JOIN instalacoes AS i ON i.os_idos = o.idos;
        
        
## LISTA DE ATENDIMENTOS

    CREATE VIEW listatendimentos AS
        SELECT
            a.idatend_vsat AS idatend_vsat,
            a.incidentes_idincidentes AS idincidentes,
            (
                SELECT municipio
                FROM municipios 
                WHERE idmunicipios = (
                    SELECT municipios_idcidade 
                    FROM os 
                    WHERE idos = (
                        SELECT os_idos 
                        FROM instalacoes 
                        WHERE idinstalacoes = a.instalacoes_idinstalacoes
                    )
                )
            ) AS localidade,
            (
                SELECT nome
                FROM instalacoes
                WHERE idinstalacoes = a.instalacoes_idinstalacoes
            ) AS nome_vsat,
            'Prodemge' AS hub,
            (
                SELECT nome 
                FROM usuarios
                WHERE idusuarios = usuarios_idusuarios
            ) AS usuario,
            (
                SELECT status 
                FROM status_atend
                WHERE idstatus_atend = a.status_atend_idstatus_atend
            ) AS status,
            (
                SELECT inicio_tarefa
                FROM cronometro
                WHERE 
                    tabelareferencia = 'atend_vsat' AND
                    idreferencia = a.idatend_vsat
            )AS inicio,
            (
                SELECT final_tarefa
                FROM cronometro
                WHERE
                    tabelareferencia = 'atend_vsat' AND
                    idreferencia = a.idatend_vsat
            )AS fim,
            (
                SELECT TIMEDIFF( 
                    (SELECT IF(
                                (
                                    SELECT final_tarefa
                                    FROM cronometro
                                    WHERE
                                        tabelareferencia = 'atend_vsat' AND
                                        idreferencia = a.idatend_vsat
                                ) IS NULL,
                                NOW(),
                                (
                                    SELECT final_tarefa
                                    FROM cronometro
                                    WHERE
                                        tabelareferencia = 'atend_vsat' AND
                                        idreferencia = a.idatend_vsat
                                )
                              )
                    ),
                    (
                        SELECT inicio_tarefa
                        FROM cronometro
                        WHERE 
                            tabelareferencia = 'atend_vsat' AND
                            idreferencia = a.idatend_vsat
                    )
                )
            ) AS tempo_passado,
            a.saom AS saom
        FROM
            atend_vsat a
        WHERE
            (
                SELECT inicio_tarefa
                FROM cronometro
                WHERE 
                    tabelareferencia = 'atend_vsat' AND
                    idreferencia = a.idatend_vsat
            ) IS NOT NULL AND 
            (
                SELECT inicio_tarefa
                FROM cronometro
                WHERE 
                    tabelareferencia = 'atend_vsat' AND
                    idreferencia = a.idatend_vsat
            ) != ''
        ORDER BY idatend_vsat DESC;
        
        
## relatorio de ativacao de vsats para periodos especificos

    SELECT 
        i.idinstalacoes AS id,
        i.nome AS nome,
        i.os_idos AS os_idos
    FROM instalacoes i
    WHERE data_ativacao = '2012-01-10';



        