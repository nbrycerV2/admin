# Sistema de Gestión de Empresas y Equipos

Este proyecto es un sistema desarrollado principalmente en PHP que gestiona un listado de empresas, un sistema de aterramientos, y un sistema de equipos dieléctricos. El sistema está diseñado para facilitar la administración y seguimiento de estos componentes clave.

## Componentes Principales

### 1. Listado de Empresas

Este componente presenta una tabla que lista todas las empresas registradas en el sistema. Permite la búsqueda, filtrado y edición de los datos de cada empresa.

### 2. Sistema de Aterramientos

Este módulo se encarga de la gestión de los sistemas de aterramientos. Está dividido en dos subcomponentes:

- **Nuevos:** Para la gestión de nuevos sistemas de aterramientos.
- **Mantenimiento:** Para el seguimiento y mantenimiento de sistemas de aterramientos existentes.

### 3. Sistema de Equipos Dieléctricos

Este módulo gestiona los equipos dieléctricos de la empresa. Al igual que el sistema de aterramientos, está dividido en dos subcomponentes:

- **Nuevos:** Para la incorporación y gestión de nuevos equipos dieléctricos.
- **Mantenimiento:** Para el seguimiento y mantenimiento de los equipos dieléctricos en uso.

## Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/nbrycerV2/admin.git
   ```
2. Configura tu entorno de desarrollo local (XAMPP, WAMP, etc.).
3. Importa la base de datos utilizando los archivos sql incluido en la carpeta db_structure (solo estructura, llenar datos en tabla_user con usuarios para que funcione algunas secciones del codigo).

- Se incluye archivo llamado sistema_dielectricos2.sql
- Se incluye archivo emp_main_lista.sql (Es posible que sea necesario cambiar los archivos conexion.php para poder usar esta tabla)
- Se incluye archivo tabla_user (Es posible que sea necesario cambiar los archivos conexion.php para poder usar esta tabla)

4. Accede al sistema a través de http://localhost/tu-proyecto.

## Características

- Listado completo y editable de empresas.
- Gestión de nuevos sistemas de aterramientos y seguimiento de los existentes.
- Gestión de nuevos equipos dieléctricos y su mantenimiento.

## Usado por

Este proyecto es usado por la compañia Logytec S.A.
