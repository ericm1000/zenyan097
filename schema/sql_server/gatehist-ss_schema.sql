CREATE TABLE dbo.gatehist
     ( 
        uid                     INT              NOT NULL  , 
        requestdate             DATETIME         NOT NULL  DEFAULT (getdate()) , 
        lname                   VARCHAR(80)      NOT NULL  , 
        pwd                     CHAR(32)         NOT NULL  , 
        firstname               VARCHAR(18)          NULL  , 
        lastname                VARCHAR(25)          NULL  , 
        crudtype                CHAR(1)              NULL  , 
        country                 VARCHAR(25)          NULL  , 
        state                   CHAR(2)              NULL  , 
        chall_qst               VARCHAR(60)          NULL  , 
        chall_ans               VARCHAR(35)          NULL  , 
        curr_email_addr         VARCHAR(80)          NULL  , 
        confrm_email_sent_flg   CHAR(1)              NULL  , 
        inactive_flg            CHAR(1)              NULL  , 
        contributor_name        VARCHAR(45)          NULL  , 
        contributor_url         VARCHAR(100)         NULL  , 
        contributor_short_bio   VARCHAR(255)         NULL  , 
        guid                    CHAR(21)             NULL  , 
        mbrshpstat              CHAR(1)              NULL  , 
        chall_hint              VARCHAR(35)          NULL  , 
        mbrshpconfirm           CHAR(12)             NULL  , 
        cstm1                   CHAR(1)              NULL  , 
        cstm2                   CHAR(1)              NULL  , 
        cstm3                   CHAR(1)              NULL  , 
        referral                VARCHAR(40)          NULL  , 
        entity_typ_flg          CHAR(8)              NULL  , 
        admin_flg               CHAR(1)              NULL  , 
        skin_bg                 CHAR(1)              NULL  , 
        skin_tabs               CHAR(1)              NULL  , 
        CONSTRAINT PK_GATEHIST PRIMARY KEY CLUSTERED (uid ASC, requestdate ASC) ON [PRIMARY] 
     )
GO 


