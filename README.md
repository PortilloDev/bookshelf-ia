# Backend Laravel - BiblioFinder

Este es el backend en Laravel para la aplicación BiblioFinder que complementa el frontend React.

## Configuración

### Requisitos
- PHP 8.1 o superior
- Composer
- Base de datos (MySQL/SQLite)

### Instalación

1. Instalar dependencias:
```bash
composer install
```

2. Configurar variables de entorno:
```bash
cp .env.example .env
php artisan key:generate
```

3. Configurar base de datos en `.env`:
```env
# Para MySQL (cuando esté disponible)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=33006
DB_DATABASE=test
DB_USERNAME=sail
DB_PASSWORD=password

# Para SQLite (desarrollo)
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite
```

4. Ejecutar migraciones:
```bash
php artisan migrate
```

5. Poblar base de datos con datos de ejemplo:
```bash
php artisan db:seed --class=BookSeeder
```

6. Iniciar servidor de desarrollo:
```bash
php artisan serve
```

El servidor estará disponible en `http://localhost:8000`

## API Endpoints

### Libros

- `GET /api/books` - Listar todos los libros (con paginación y filtros)
- `POST /api/books` - Crear un nuevo libro
- `GET /api/books/{id}` - Obtener un libro específico
- `PUT /api/books/{id}` - Actualizar un libro
- `DELETE /api/books/{id}` - Eliminar un libro
- `GET /api/books/search?q={query}` - Buscar libros
- `GET /api/books/category/{category}` - Obtener libros por categoría

### Parámetros de consulta para `/api/books`:

- `search` - Buscar en título, autor y descripción
- `category` - Filtrar por categoría
- `author` - Filtrar por autor
- `sort_by` - Campo para ordenar (default: title)
- `sort_order` - Orden ascendente/descendente (asc/desc)
- `per_page` - Número de resultados por página (default: 15)

### Ejemplo de respuesta:

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "El Quijote",
      "author": "Miguel de Cervantes",
      "description": "La obra maestra de la literatura española...",
      "isbn": "978-84-376-0494-7",
      "cover_image": "https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400",
      "publisher": "Editorial Castalia",
      "published_date": "1605-01-01",
      "page_count": 863,
      "language": "es",
      "rating": "4.50",
      "rating_count": 1250,
      "category": "Clásicos",
      "tags": ["clásico", "aventura", "literatura española"],
      "is_available": true,
      "created_at": "2025-08-29T16:30:00.000000Z",
      "updated_at": "2025-08-29T16:30:00.000000Z"
    }
  ],
  "pagination": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 8
  }
}
```

## Estructura de la base de datos

### Tabla `books`:
- `id` - ID único
- `title` - Título del libro
- `author` - Autor
- `description` - Descripción
- `isbn` - ISBN (único)
- `cover_image` - URL de la imagen de portada
- `publisher` - Editorial
- `published_date` - Fecha de publicación
- `page_count` - Número de páginas
- `language` - Idioma
- `rating` - Calificación promedio
- `rating_count` - Número de calificaciones
- `category` - Categoría
- `tags` - Etiquetas (JSON)
- `is_available` - Disponibilidad
- `created_at` - Fecha de creación
- `updated_at` - Fecha de actualización

## CORS

El backend está configurado para aceptar peticiones desde:
- `http://localhost:3000`
- `http://127.0.0.1:3000`

## Desarrollo

Para desarrollo, se recomienda usar SQLite que ya está configurado. Para producción, cambiar a MySQL con los parámetros especificados en el `.env`.
