# BiblioFinder - Documentación Completa

## Descripción General

**BiblioFinder** es una aplicación web desarrollada en Laravel que funciona como una biblioteca personal inteligente. La aplicación permite a los usuarios organizar, descubrir y gestionar su colección de libros de manera eficiente, con funcionalidades avanzadas de búsqueda semántica y organización personalizada.

### Características Principales

- **Gestión de Biblioteca Personal**: Los usuarios pueden agregar libros a su biblioteca personal y organizarlos en estanterías personalizadas
- **Búsqueda Inteligente**: Integración con APIs externas (Google Books, Open Library) y búsqueda semántica usando embeddings
- **Sistema de Estanterías**: Organización flexible con estanterías del sistema (por leer, leyendo, leídos, favoritos) y estanterías personalizadas
- **Importación de Datos**: Capacidad de importar listas de libros desde archivos Excel/CSV
- **Categorización**: Sistema de categorías globales y personalizadas por usuario
- **Estadísticas de Lectura**: Seguimiento del progreso de lectura y estadísticas personales
- **Autenticación Social**: Login con Google OAuth
- **Multilingüe**: Soporte para español e inglés

## Arquitectura Técnica

### Tecnologías Utilizadas

- **Backend**: Laravel 12 (PHP 8.2+)
- **Base de Datos**: PostgreSQL con extensión pgvector para búsqueda semántica
- **Frontend**: Blade templates con TailwindCSS
- **APIs Externas**: Google Books API, Open Library API
- **IA/ML**: OpenAI Embeddings API, Google AI Embeddings
- **Autenticación**: Laravel Sanctum, Google OAuth
- **Cache**: Laravel Cache
- **Colas**: Laravel Queue System

### Estructura del Proyecto

```
app/
├── Console/Commands/          # Comandos Artisan personalizados
├── Http/Controllers/          # Controladores de la aplicación
├── Models/                    # Modelos Eloquent
├── Services/                  # Servicios de negocio
└── Jobs/                      # Trabajos en cola

database/
├── migrations/               # Migraciones de base de datos
└── seeders/                  # Seeders para datos iniciales

resources/
├── views/                    # Vistas Blade
├── lang/                     # Archivos de idioma
└── css/                      # Estilos CSS

routes/
├── web.php                   # Rutas web
└── api.php                   # Rutas API
```

## Funcionalidades Detalladas

### 1. Sistema de Autenticación
- Registro e inicio de sesión tradicional
- Autenticación con Google OAuth
- Gestión de perfiles de usuario
- Configuración de preferencias

### 2. Gestión de Libros
- **Búsqueda Externa**: Integración con Google Books y Open Library
- **Búsqueda Local**: Búsqueda en la biblioteca personal del usuario
- **Búsqueda Semántica**: Búsqueda por similitud usando embeddings vectoriales
- **Detalles de Libros**: Información completa incluyendo portadas, descripciones, ratings

### 3. Sistema de Estanterías
- **Estanterías del Sistema**:
  - "Por Leer" (to-read)
  - "Leyendo" (reading) 
  - "Leídos" (read)
  - "Favoritos" (favorites)
- **Estanterías Personalizadas**: Los usuarios pueden crear estanterías personalizadas
- **Organización**: Posicionamiento manual de libros en estanterías

### 4. Sistema de Categorías
- **Categorías Globales**: Categorías predefinidas para todos los libros
- **Categorías de Usuario**: Categorías personalizadas por usuario
- **Sinónimos**: Sistema de sinónimos para mejorar la categorización

### 5. Importación de Datos
- Importación desde archivos Excel/CSV
- Plantillas predefinidas para facilitar la importación
- Procesamiento en cola para archivos grandes
- Enriquecimiento automático de datos usando APIs externas

### 6. Estadísticas y Seguimiento
- Contador de libros por estantería
- Progreso de lectura (páginas leídas)
- Fechas de inicio y fin de lectura
- Ratings personales

## Modelos de la Aplicación

### 1. User (Usuario)
**Tabla**: `users`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID único del usuario |
| `name` | string | Nombre del usuario |
| `email` | string | Email único del usuario |
| `email_verified_at` | timestamp | Fecha de verificación del email |
| `password` | string | Contraseña hasheada |
| `remember_token` | string | Token para recordar sesión |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de última actualización |

**Relaciones**:
- `hasMany(UserBook::class)` - Libros del usuario
- `hasMany(UserShelf::class)` - Estanterías del usuario
- `hasMany(UserCategory::class)` - Categorías personalizadas

### 2. Book (Libro)
**Tabla**: `books`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | uuid | ID único del libro |
| `external_id` | string | ID en API externa (Google Books, Open Library) |
| `source` | string | Fuente del libro (google_books, open_library, local) |
| `title` | string | Título del libro |
| `subtitle` | string | Subtítulo (opcional) |
| `authors` | json | Array de autores |
| `description` | text | Descripción del libro |
| `isbn` | string | ISBN-10 |
| `isbn13` | string | ISBN-13 |
| `publisher` | string | Editorial |
| `published_date` | date | Fecha de publicación |
| `page_count` | integer | Número de páginas |
| `language` | string | Idioma del libro |
| `categories` | json | Array de categorías |
| `tags` | json | Array de etiquetas |
| `rating` | decimal | Calificación promedio |
| `cover_url` | string | URL de la portada |
| `preview_url` | string | URL de vista previa |
| `info_url` | string | URL de información |
| `embedding_model` | string | Modelo usado para embeddings |
| `embedding_dim` | smallint | Dimensión del vector embedding |
| `embedding_updated_at` | timestamp | Fecha de actualización del embedding |
| `embedding` | vector | Vector de embedding para búsqueda semántica |
| `tsv` | tsvector | Vector de texto completo para búsqueda |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de última actualización |

**Relaciones**:
- `hasMany(UserBook::class)` - Relaciones usuario-libro
- `belongsToMany(Category::class)` - Categorías globales
- `belongsToMany(User::class, 'user_shelf_items')` - Usuarios que tienen el libro

### 3. UserBook (Libro de Usuario)
**Tabla**: `user_books`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID único |
| `user_id` | bigint | ID del usuario (FK) |
| `book_id` | uuid | ID del libro (FK) |
| `notes` | text | Notas personales del usuario |
| `tags` | json | Etiquetas personales |
| `user_rating` | integer | Calificación del usuario (1-5) |
| `started_reading` | date | Fecha de inicio de lectura |
| `finished_reading` | date | Fecha de fin de lectura |
| `current_page` | integer | Página actual |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de última actualización |

**Relaciones**:
- `belongsTo(User::class)` - Usuario propietario
- `belongsTo(Book::class)` - Libro relacionado
- `hasMany(UserShelfItem::class)` - Items en estanterías

### 4. UserShelf (Estantería de Usuario)
**Tabla**: `user_shelves`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID único |
| `user_id` | bigint | ID del usuario (FK) |
| `name` | string | Nombre de la estantería |
| `slug` | string | Slug único para la estantería |
| `icon` | string | Icono/emoji de la estantería |
| `color` | string | Color de la estantería |
| `is_system` | boolean | Si es estantería del sistema |
| `order` | integer | Orden de visualización |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de última actualización |

**Relaciones**:
- `belongsTo(User::class)` - Usuario propietario
- `hasMany(UserShelfItem::class)` - Items en la estantería
- `belongsToMany(Book::class, 'user_shelf_items')` - Libros en la estantería

### 5. UserShelfItem (Item de Estantería)
**Tabla**: `user_shelf_items`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID único |
| `user_id` | bigint | ID del usuario (FK) |
| `shelf_id` | bigint | ID de la estantería (FK) |
| `book_id` | uuid | ID del libro (FK) |
| `position` | integer | Posición en la estantería |
| `added_at` | datetime | Fecha de agregado |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de última actualización |

**Relaciones**:
- `belongsTo(User::class)` - Usuario propietario
- `belongsTo(UserShelf::class)` - Estantería
- `belongsTo(Book::class)` - Libro

### 6. Category (Categoría Global)
**Tabla**: `categories`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID único |
| `slug` | string | Slug único de la categoría |
| `name` | string | Nombre de la categoría |
| `synonyms` | json | Array de sinónimos |
| `description` | text | Descripción de la categoría |
| `icon` | string | Icono de la categoría |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de última actualización |

**Relaciones**:
- `belongsToMany(Book::class, 'book_category')` - Libros en esta categoría

### 7. UserCategory (Categoría de Usuario)
**Tabla**: `user_categories`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID único |
| `user_id` | bigint | ID del usuario (FK) |
| `name` | string | Nombre de la categoría |
| `color` | string | Color de la categoría |
| `icon` | string | Icono de la categoría |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de última actualización |

**Relaciones**:
- `belongsTo(User::class)` - Usuario propietario
- `belongsToMany(UserBook::class, 'user_book_categories')` - Libros del usuario en esta categoría

### 8. UserBookEvent (Evento de Libro)
**Tabla**: `user_book_events`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | uuid | ID único |
| `user_id` | bigint | ID del usuario (FK) |
| `book_id` | uuid | ID del libro (FK) |
| `event_type` | string | Tipo de evento |
| `weight` | decimal | Peso del evento |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de última actualización |

**Relaciones**:
- `belongsTo(User::class)` - Usuario
- `belongsTo(Book::class)` - Libro

### 9. BookRaw (Libro Raw)
**Tabla**: `book_raw`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | uuid | ID único |
| `source` | string | Fuente de los datos |
| `external_id` | string | ID externo |
| `payload_json` | json | Datos completos del libro |
| `checksum` | string | Checksum de los datos |
| `status` | string | Estado del procesamiento |
| `fetched_at` | datetime | Fecha de obtención |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de última actualización |

### 10. QueryEmbedding (Embedding de Consulta)
**Tabla**: `query_embeddings`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID único |
| `hash` | string | Hash único de la consulta |
| `query_norm` | string | Consulta normalizada |
| `provider` | string | Proveedor de embeddings |
| `model` | string | Modelo usado |
| `dim` | integer | Dimensión del vector |
| `vector_literal` | text | Vector como string literal |
| `expires_at` | datetime | Fecha de expiración |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de última actualización |

## Servicios Principales

### 1. BookSearchService
**Ubicación**: `app/Services/BookSearchService.php`

Servicio encargado de la búsqueda de libros desde múltiples fuentes:
- Búsqueda en base de datos local
- Integración con Google Books API
- Integración con Open Library API
- Filtrado de duplicados
- Formateo de resultados

**Métodos principales**:
- `searchBooks($query, $options)` - Búsqueda general
- `getBookDetails($bookId, $source)` - Obtener detalles de un libro
- `searchLocalBooks($query, $options)` - Búsqueda local
- `searchGoogleBooks($query, $options)` - Búsqueda en Google Books
- `searchOpenLibrary($query, $options)` - Búsqueda en Open Library

### 2. EmbeddingService
**Ubicación**: `app/Services/EmbeddingService.php`

Servicio para manejo de embeddings vectoriales:
- Generación de embeddings para documentos y consultas
- Soporte para OpenAI y Google AI
- Cache de embeddings con TTL
- Normalización de texto

**Métodos principales**:
- `embedDocument($text)` - Embedding para documentos
- `embedQuery($text)` - Embedding para consultas
- `embedQueryCached($query, $ttlSeconds)` - Embedding con cache
- `normalize($text)` - Normalización de texto

## Controladores Principales

### 1. HomeController
- Página principal con libros populares
- Cache de libros destacados

### 2. SearchController
- Búsqueda de libros
- Detalles de libros
- Integración con servicios de búsqueda

### 3. LibraryController
- Gestión de biblioteca personal
- Manejo de estanterías
- Categorías personalizadas
- Estadísticas de lectura

### 4. DashboardController
- Panel principal del usuario
- Estadísticas de lectura
- Libros recientes

### 5. ImportController
- Importación de archivos Excel/CSV
- Procesamiento de datos
- Enriquecimiento automático

### 6. BookController (API)
- CRUD de libros
- Búsqueda y filtrado
- Endpoints para frontend

## Rutas de la Aplicación

### Rutas Web
- `/` - Página principal
- `/search` - Búsqueda de libros
- `/dashboard` - Panel del usuario
- `/library` - Biblioteca personal
- `/import` - Importación de datos
- `/profile` - Perfil del usuario
- `/settings` - Configuración

### Rutas API
- `GET /api/books` - Listar libros
- `POST /api/books` - Crear libro
- `GET /api/books/search` - Buscar libros
- `GET /api/books/{id}` - Obtener libro
- `PUT /api/books/{id}` - Actualizar libro
- `DELETE /api/books/{id}` - Eliminar libro

## Configuración y Despliegue

### Requisitos del Sistema
- PHP 8.2 o superior
- PostgreSQL con extensión pgvector
- Composer
- Node.js y npm (para assets)

### Variables de Entorno Importantes
```env
# Base de datos
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=bibliofinder
DB_USERNAME=usuario
DB_PASSWORD=contraseña

# APIs externas
GOOGLE_BOOKS_API_KEY=tu_api_key
OPENAI_API_KEY=tu_api_key
GOOGLE_AI_API_KEY=tu_api_key

# Configuración de embeddings
EMBEDDINGS_PROVIDER=openai
EMBEDDINGS_MODEL=text-embedding-3-small
```

### Comandos de Instalación
```bash
# Instalar dependencias
composer install
npm install

# Configurar base de datos
php artisan migrate
php artisan db:seed

# Compilar assets
npm run build

# Iniciar servidor
php artisan serve
```

## Características Avanzadas

### 1. Búsqueda Semántica
- Uso de embeddings vectoriales para búsqueda por similitud
- Soporte para múltiples proveedores (OpenAI, Google AI)
- Cache inteligente de embeddings
- Búsqueda híbrida (texto + semántica)

### 2. Sistema de Colas
- Procesamiento asíncrono de importaciones
- Generación de embeddings en background
- Enriquecimiento automático de datos

### 3. Internacionalización
- Soporte para español e inglés
- Cambio dinámico de idioma
- Traducción de interfaz completa

### 4. Optimización de Rendimiento
- Cache de consultas frecuentes
- Índices de base de datos optimizados
- Búsqueda full-text con PostgreSQL
- Lazy loading de relaciones

## Seguridad

### Medidas Implementadas
- Autenticación robusta con Laravel Sanctum
- Validación de entrada en todos los endpoints
- Protección CSRF
- Sanitización de datos
- Rate limiting en APIs
- Encriptación de datos sensibles

### OAuth con Google
- Integración completa con Google OAuth 2.0
- Manejo seguro de tokens
- Sincronización de datos de perfil

## Monitoreo y Logs

### Sistema de Logs
- Logs de errores detallados
- Tracking de operaciones importantes
- Monitoreo de APIs externas
- Métricas de rendimiento

### Comandos Artisan Personalizados
- `EnrichImportedBooks` - Enriquecimiento de libros importados
- `ResetFailedBooks` - Reset de libros con errores
- Comandos de mantenimiento de embeddings

## Futuras Mejoras

### Funcionalidades Planificadas
- Sistema de recomendaciones basado en ML
- Análisis de sentimientos en reseñas
- Integración con más APIs de libros
- Sistema de notificaciones
- Exportación de datos
- API pública para desarrolladores
- Aplicación móvil

### Optimizaciones Técnicas
- Implementación de Redis para cache
- Optimización de consultas vectoriales
- CDN para imágenes de portadas
- Compresión de assets
- Implementación de WebSockets para actualizaciones en tiempo real

---

Esta documentación proporciona una visión completa de la aplicación BiblioFinder, incluyendo su arquitectura, funcionalidades, modelos de datos y aspectos técnicos. La aplicación está diseñada para ser escalable, mantenible y rica en funcionalidades para la gestión de bibliotecas personales.
