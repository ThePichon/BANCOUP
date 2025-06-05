import mysql.connector

def conectar():
    try:
        conn = mysql.connector.connect(
            host='localhost',
            user='root',
            password='',  # tu contraseña si tienes
            database='proyecto_transferencia'
        )
        return conn
    except mysql.connector.Error as err:
        print(f" Error al conectar: {err}")
        return None
