from db import conectar
from datetime import datetime

def hacer_transferencia(cuenta_origen, cuenta_destino, monto, concepto):
    conn = conectar()
    cursor = conn.cursor(dictionary=True)

    try:
        # Validar que las dos cuentas existen
        cursor.execute("SELECT * FROM cuentas WHERE numero_cuenta = %s", (cuenta_origen,))
        origen = cursor.fetchone()

        cursor.execute("SELECT * FROM cuentas WHERE numero_cuenta = %s", (cuenta_destino,))
        destino = cursor.fetchone()

        if not origen or not destino:
            print(" Una o ambas cuentas no existen")
            return

        if origen['id'] == destino['id']:
            print(" No puedes transferirte a ti mismo")
            return

        if monto < 500:
            print(" El monto mínimo es $500.00")
            return

        if origen['saldo'] < monto:
            print("Saldo insuficiente")
            estatus = "Error"
            descripcion = "Saldo insuficiente"
        else:
            estatus = "Exitosa"
            descripcion = ""

        # Fecha y hora actual
        fecha_hora_actual = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

        # Guardar la transferencia con fecha explícita
        query = """
            INSERT INTO transferencias (
                cuenta_remitente_id, cuenta_destinataria_id, monto,
                concepto, estatus, descripcion, fecha_hora
            ) VALUES (%s, %s, %s, %s, %s, %s, %s)
        """
        cursor.execute(query, (
            origen['id'], destino['id'], monto,
            concepto, estatus, descripcion, fecha_hora_actual
        ))

        # Si exitosa, actualizar saldos
        if estatus == "Exitosa":
            nuevo_saldo_origen = origen['saldo'] - monto
            nuevo_saldo_destino = destino['saldo'] + monto

            cursor.execute("UPDATE cuentas SET saldo = %s WHERE id = %s", (nuevo_saldo_origen, origen['id']))
            cursor.execute("UPDATE cuentas SET saldo = %s WHERE id = %s", (nuevo_saldo_destino, destino['id']))

            print(f"Transferencia exitosa")
            print(f"Fecha: {fecha_hora_actual}")
            print(f"Cuenta origen ({cuenta_origen}): antes = ${origen['saldo']:.2f} | ahora = ${nuevo_saldo_origen:.2f}")
            print(f"Cuenta destino ({cuenta_destino}): antes = ${destino['saldo']:.2f} | ahora = ${nuevo_saldo_destino:.2f}")
        else:
            print("Transferencia fallida:", descripcion)

        conn.commit()
    except Exception as e:
        print(" Error en la transferencia:", e)
        conn.rollback()
    finally:
        cursor.close()
        conn.close()

# EJEMPLO:
if __name__ == "__main__":
    hacer_transferencia("1001000001", "1001000004", 1000, "Pago de Universidad")
