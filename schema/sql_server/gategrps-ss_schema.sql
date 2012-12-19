CREATE TABLE [dbo].[gategrps]
     ( 
        [inactive_flg]   CHAR(1)             NULL  , 
        [admin_flg]      CHAR(1)             NULL  , 
        [admin_array]    VARCHAR(255)        NULL  , 
        [parent_uid]     INT             NOT NULL  , 
        [child_uid]      INT             NOT NULL  , 
        CONSTRAINT PK_GATEGRPS PRIMARY KEY CLUSTERED ([parent_uid] ASC, [child_uid] ASC)
     )
GO 
