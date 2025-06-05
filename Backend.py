import mysql.connector

def conectar():
    try:
        conn = mysql.connector.connect(
            host='localhost',
            user='root',             # Cambia si tienes otro usuario
            password='',             # Pon tu contraseña si tienes una
            database='proyecto_transferencia'
        )
        print("✅ Conexión exitosa")
        return conn
    except mysql.connector.Error as err:
        print(f"❌ Error al conectar: {err}")
        return None

# Prueba de conexión
if __name__ == "__main__":
    conectar()
