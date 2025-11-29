VintedClone 🛍️Un marketplace de compraventa de artículos de segunda mano desarrollado en PHP nativo. Este proyecto replica las funcionalidades core de plataformas como Vinted, permitiendo a los usuarios registrarse, publicar productos y realizar compras simuladas.📋 Tabla de ContenidosDescripción del SistemaStack TecnológicoArquitecturaEstructura del ProyectoInstalación y UsoFuncionalidades Principales⚠️ Aviso de Seguridad📖 Descripción del SistemaVintedClone es una aplicación web que implementa un modelo de mercado dual (compradores y vendedores). El sistema gestiona sesiones de usuario, catálogos de productos y carritos de compra sin el uso de frameworks modernos, confiando en el renderizado del lado del servidor.Flujos de UsuarioEl sistema distingue inteligentemente entre roles basado en el contexto:Vendedor: Puede subir productos, gestionar sus listados y ver su panel de ventas.Comprador: Navega el catálogo (que excluye automáticamente sus propios productos) y realiza compras vía PayPal.🛠 Stack TecnológicoEl proyecto sigue una arquitectura LAMP clásica, priorizando la simplicidad y el aprendizaje de los fundamentos web.CapaTecnologíaPropósitoFrontendHTML5, Bootstrap 5.3.2Interfaz de usuario responsive (CDN).BackendPHP (Nativo)Lógica del servidor y gestión de sesiones.Base de DatosMySQLPersistencia de usuarios (javiusers) y productos (javiproductos).PagosPayPal StandardIntegración mediante formularios POST (_xclick).AlmacenamientoSistema de ArchivosImágenes guardadas en directorio uploads/.🏗 ArquitecturaEl código está organizado en tres capas lógicas para separar la presentación de la lógica de negocio y la infraestructura.Fragmento de códigograph TD
    User((Usuario))
    
    subgraph "Capa de Presentación (Entry Points)"
        Index[index.php]
        Login[login.php]
        Vender[vender.php]
    end
    
    subgraph "Capa de Acción (Scripts)"
        CartAction[alcarrito.php]
        EmptyCart[vaciarcarrito.php]
    end
    
    subgraph "Infraestructura"
        Conn[conexion.php]
        Utils[funciones.php]
    end
    
    DB[(MySQL Database)]
    
    User --> Index
    User --> Login
    User --> Vender
    
    Index --> CartAction
    Vender --> Conn
    Index --> Utils
    CartAction --> Utils
    
    Conn --> DB
Patrones de DiseñoEntry Points: Páginas que renderizan HTML completo (ej. index.php, detalle.php).Action Scripts: Scripts pequeños que modifican el estado (añadir al carrito) y redirigen sin mostrar HTML.Infrastructure: Servicios compartidos como conexión a BD y funciones de cabecera.📂 Estructura del ProyectoEl repositorio sigue una estructura plana (Flat File Organization):Plaintextvinted/
├── index.php           # Catálogo principal (Punto de entrada)
├── login.php           # Autenticación de usuarios
├── registro.php        # Registro de nuevos usuarios
├── detalle.php         # Vista de detalle de producto
├── vender.php          # Panel del vendedor (Crear anuncios)
├── modificar.php       # Edición de productos existentes
├── carrito.php         # Vista del carrito de compras
├── comprarcarrito.php  # Integración con PayPal
├── alcarrito.php       # Script: Añadir al carrito
├── vaciarcarrito.php   # Script: Vaciar carrito
├── conexion.php        # Conexión a BD e inicialización automática
├── funciones.php       # Utilidades (Header, contar items)
└── uploads/            # Directorio de almacenamiento de imágenes
🚀 Instalación y UsoPrerrequisitosServidor Web (Apache/Nginx).PHP 7.4 o superior.MySQL Server.PasosClonar el repositorio:Bashgit clone https://github.com/javigalii/vinted.git
Configuración de Base de Datos:El archivo conexion.php está configurado para conectarse a localhost con el usuario root (sin contraseña por defecto en XAMPP).Nota: El sistema auto-inicializa la base de datos vinted y las tablas necesarias (javiusers, javiproductos) en la primera ejecución.Usuario Admin:Si la tabla de usuarios está vacía, se creará automáticamente un usuario admin:User: adminEmail: admin@admin.es✨ Funcionalidades PrincipalesAutenticación: Login y Registro con variables de sesión $_SESSION.Gestión de Productos:Subida de imágenes al servidor.Edición y visualización de detalles.Regla de negocio: Los vendedores no ven sus propios productos en el catálogo de compra.Carrito de Compras:Persistencia basada en sesión (no en BD).Cálculo automático de totales.Pagos: Redirección a PayPal con los datos del carrito.⚠️ Aviso de SeguridadIMPORTANTE: Este proyecto tiene fines educativos y no debe ser utilizado en un entorno de producción.El código contiene vulnerabilidades conocidas documentadas intencionalmente o por simplicidad académica:❌ Inyección SQL: Las consultas en login.php y registro.php no están parametrizadas.❌ Contraseñas en Texto Plano: Las contraseñas se almacenan sin hashear en la base de datos.❌ Subida de Archivos: No hay validación estricta en uploads/, permitiendo ejecución de archivos arbitrarios.❌ CSRF/XSS: Falta de tokens de protección en formularios y saneamiento de salidas.
