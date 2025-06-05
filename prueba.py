from db import conectar

def insertar_usuario(email, password):
    conn = conectar()
    cursor = conn.cursor()
    query = "INSERT INTO usuarios (email, password) VALUES (%s, %s)"
    cursor.execute(query, (email, password))
    conn.commit()
    print("✅ Usuario insertado")
    cursor.close()
    conn.close()

def ver_usuarios():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM usuarios")
    for fila in cursor.fetchall():
        print(fila)
    cursor.close()
    conn.close()

# PRUEBA
insertar_usuario("pichon@menso.com", "contrasenaTemporal")
ver_usuarios()
