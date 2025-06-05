# BANCOUP
Este proyecto consiste en el desarrollo del frontend de un sistema de transferencias para el Banco UP, implementado utilizando únicamente HTML y CSS. El diseño respeta la identidad visual de la Universidad Panamericana, incorporando sus colores institucionales y un estilo moderno, limpio y responsivo.

# Descripción General
El sistema permite que los clientes del banco puedan realizar transferencias entre cuentas, así como consultar su estado de cuenta. Además, incluye un módulo administrativo desde el cual los administradores pueden dar de alta y baja usuarios y consultar los movimientos de cada cliente.

# Funcionalidades Principales
Página de inicio (Lobby) para elegir entre iniciar sesión o registrarse

Inicio de sesión con opción para usuarios o administradores

Registro de nuevos usuarios

Transferencias entre cuentas (solo clientes)

Consulta de estado de cuenta con historial de transferencias

Panel administrativo con acceso a:

Alta de usuarios

Baja de usuarios

Consulta de estados de cuenta de todos los clientes

Botón de regreso en cada vista para mejorar la navegación

El logo/título "Banco UP" lleva siempre de vuelta al lobby principal

Diseño responsive para que se vea bien en celulares, tablets y escritorio

# Estructura de Archivos
index.html: Página principal (lobby)

login.html: Inicio de sesión

registro.html: Registro de nuevos usuarios

transferencia.html: Realizar transferencia (clientes)

estado.html: Consultar estado de cuenta (clientes)

admin.html: Lobby del administrador

admin_alta.html: Alta de usuarios

admin_baja.html: Baja de usuarios

admin_estado.html: Consulta de estados de cuenta

estilos.css: Archivo con todos los estilos (colores, botones, tarjetas, etc.)

# Tecnologías
HTML5

CSS3 (sin frameworks, todo desde cero)

Diseño responsivo con media queries

# Consideraciones
Este sistema está diseñado únicamente para el frontend. La lógica de autenticación, validación de datos, conexión con la base de datos y control de transferencias deberá implementarse posteriormente con un lenguaje de backend como PHP, Node.js, Python (Flask/Django), etc.
