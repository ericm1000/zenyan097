CREATE TABLE dbo.connmgr
     ( 
        conn_name      CHAR(30)        NOT NULL  , 
        host           VARCHAR(100)        NULL  , 
        logn           VARCHAR(15)         NULL  , 
        pwd            VARCHAR(10)         NULL  , 
        db             VARCHAR(50)     NOT NULL  , 
        dbms           VARCHAR(20)         NULL  , 
        inactive_flg   CHAR(1)             NULL  , 
        conn_type      CHAR(1)             NULL  , 
        verify_user    INT                 NULL  , 
        verify_flg     CHAR(1)             NULL  , 
        CONSTRAINT PK_connmgr PRIMARY KEY CLUSTERED (conn_name ASC, db ASC) ON [PRIMARY] 
     )
GO 