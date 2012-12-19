BEGIN TRANSACTION
GO
INSERT INTO [dbo].[connmgr]
     (
        conn_name    ,
        host         ,
        logn         ,
        pwd          ,
        db           ,
        dbms         ,
        inactive_flg ,
        conn_type    ,
        verify_user  ,
        verify_flg   
     ) 
VALUES
     (
        'elixir                        ' , 
        '' , 
        'sa' , 
        'homeboy1' , 
        'elixir' , 
        'SQL Server' , 
        NULL , 
        'O' , 
        2 , 
        'y' 
     ) 
GO
INSERT INTO [dbo].[connmgr]
     (
        conn_name    ,
        host         ,
        logn         ,
        pwd          ,
        db           ,
        dbms         ,
        inactive_flg ,
        conn_type    ,
        verify_user  ,
        verify_flg   
     ) 
VALUES
     (
        'master                        ' , 
        '' , 
        'sa' , 
        'homeboy1' , 
        'elixir' , 
        'SQL Server' , 
        NULL , 
        'O' , 
        2 , 
        'y' 
     ) 
GO
INSERT INTO [dbo].[connmgr]
     (
        conn_name    ,
        host         ,
        logn         ,
        pwd          ,
        db           ,
        dbms         ,
        inactive_flg ,
        conn_type    ,
        verify_user  ,
        verify_flg   
     ) 
VALUES
     (
        'mysql                         ' , 
        '127.0.0.1' , 
        'root' , 
        'mysqldev' , 
        'mysql' , 
        'Mysql-Direct' , 
        NULL , 
        'D' , 
        2 , 
        'y' 
     ) 
GO
COMMIT TRANSACTION
GO
