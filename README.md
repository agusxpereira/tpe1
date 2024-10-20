# TPE 1
Biblioteca

## Despliegue en un servidor con XAMPP y MySQL

### Requisitos previos

Antes de desplegar el sitio en un servidor, asegúrate de tener instalado lo siguiente:

1. **XAMPP**: Debes tener XAMPP instalado y en funcionamiento. Esto incluye Apache y MySQL.
2. **PHP**: Verifica que la versión de PHP en XAMPP sea compatible con el proyecto.

### Paso a paso para el despliegue

1. **Clonar el repositorio del proyecto:**

   ```bash
   git clone https://github.com/usuario/proyecto.git
   cd proyecto
   ```

2. **Configurar XAMPP:**

   - Copia la carpeta del proyecto al directorio de **htdocs** en tu instalación de XAMPP. Por ejemplo:
   
     - En Windows: `C:\xampp\htdocs\proyecto`
     - En Linux: `/opt/lampp/htdocs/proyecto`
   
   - Abre **XAMPP Control Panel** y asegúrate de que los servicios de **Apache** y **MySQL** estén activos.

3. **Base de Datos MySQL:**
   
   El sistema cuenta con un modelo base que, al ejecutarse, verifica si la base de datos está creada. Si no lo está, la crea automáticamente y realiza el despliegue de las tablas necesarias.

   Asegúrate de tener las credenciales correctas para conectarte a MySQL en el archivo de configuración del proyecto, llamado `config.php`. Aquí un ejemplo básico:

   ```

  MYSQL_HOST = 'localhost';
  MYSQL_USER = 'root';
  MYSQL_PASS = '';
  MYSQL_DB = 'BD_Biblioteca_Grupo_99';
   ```

   Al ejecutar el sitio por primera vez, se comprobará si la base de datos existe. Si no, se creará automáticamente junto con las tablas necesarias.

4. **Usuarios y Contraseñas de Administrador:**
   
   Para ingresar como administrador, los siguientes credenciales predeterminados estarán disponibles después de la primera ejecución:
   
   - **Usuario:** `webadmin`
   - **Contraseña:** `admin`

5. **Permisos:**
   
   Asegúrate de que las carpetas de almacenamiento y logs tengan los permisos adecuados (esto es más importante en Linux):

   ```bash
   sudo chown -R www-data:www-data /opt/lampp/htdocs/proyecto/storage
   sudo chmod -R 775 /opt/lampp/htdocs/proyecto/storage
   ```

   En Windows, usualmente no es necesario cambiar permisos.

6. **Comprobación final:**

   - Abre tu navegador y navega a `http://localhost/proyecto`. Si todo está correctamente configurado, deberías ver el sitio en funcionamiento.

### Notas adicionales

- Si realizas cambios en el archivo `config.php`, recuerda reiniciar Apache desde el **XAMPP Control Panel** para que los cambios tomen efecto.
  
- Cualquier configuración adicional o paquetes necesarios deben estar especificados en la sección de "Dependencias" del proyecto.




## Participantes

- Agustin Pereira
- Sebastian Ulibarri
