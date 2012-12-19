CREATE TABLE dbo.lnks
     ( 
        member_uid        INT              NOT NULL  , 
        link_itm          VARCHAR(15)      NOT NULL  , 
        guid              CHAR(21)         NOT NULL  , 
        mnu_cat           VARCHAR(25)      NOT NULL  , 
        link              VARCHAR(255)     NOT NULL  , 
        link_label        VARCHAR(25)      NOT NULL  , 
        new_window_flg    CHAR(1)              NULL  , 
        link_status_flg   CHAR(1)              NULL  , 
        public_flg        CHAR(1)              NULL  , 
        archive_flg       CHAR(1)              NULL  , 
        entrydate         DATETIME         NOT NULL  DEFAULT ('0000-00-00 00:00:00') , 
        mnuonly_flg       CHAR(1)              NULL  , 
        CONSTRAINT PK_lnks PRIMARY KEY CLUSTERED (member_uid ASC, link_itm ASC, mnu_cat ASC, link_label ASC) ON [PRIMARY] 
     )
GO 


CREATE UNIQUE NONCLUSTERED INDEX IX_lnks_guid
ON     dbo.lnks(guid ASC)
ON     [PRIMARY] 

GO

