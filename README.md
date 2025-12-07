# VintedClone 🛍️

Para ver el pryecto busca en tu navegador [telosabes](https://telosabes.com/javi/vinted/)
Un marketplace de compraventa de artículos de segunda mano desarrollado en **PHP nativo**.  
Este proyecto replica las funcionalidades básicas de plataformas como Vinted, permitiendo a los usuarios registrarse, publicar productos y realizar compras simuladas.

---

## 📋 Tabla de Contenidos

- [Descripción del Sistema](#descripción-del-sistema)  
- [Stack Tecnológico](#stack-tecnológico)  
- [Arquitectura](#arquitectura)  
- [Estructura del Proyecto](#estructura-del-proyecto)  
- [Instalación y Uso](#instalación-y-uso)  
- [Funcionalidades Principales](#funcionalidades-principales)  
- [⚠️ Aviso de Seguridad](#-aviso-de-seguridad)  

---

## 📖 Descripción del Sistema

**VintedClone** es una aplicación web que implementa un modelo de mercado dual (compradores y vendedores).  
El sistema gestiona sesiones de usuario, catálogos de productos y carritos de compra sin el uso de frameworks modernos, confiando en el renderizado del lado del servidor.

### Flujos de Usuario

- **Vendedor**: Puede subir productos, gestionar listados y ver su panel de ventas.  
- **Comprador**: Navega el catálogo (sin ver sus propios productos) y realiza compras simuladas vía PayPal.

---

## 🛠 Stack Tecnológico

| Capa       | Tecnología                | Propósito                                         |
|------------|--------------------------|--------------------------------------------------|
| Frontend   | HTML5, Bootstrap 5.3.2   | Interfaz responsive vía CDN                       |
| Backend    | PHP (Nativo)             | Lógica del servidor y gestión de sesiones       |
| Base de Datos | MySQL                  | Persistencia de usuarios (`javiusers`) y productos (`javiproductos`) |
| Pagos      | PayPal Standard           | Integración mediante formularios POST (_xclick) |
| Almacenamiento | Sistema de Archivos    | Imágenes en directorio `uploads/`               |

---

## 🏗 Arquitectura

El proyecto sigue una arquitectura en **tres capas** para separar presentación, lógica de negocio e infraestructura.

```mermaid
graph TD
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
