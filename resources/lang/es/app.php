<?php

return [
    'name' => 'BookShelf',
    'tagline' => 'Tu biblioteca personal inteligente',
    
    'common' => [
        'loading' => 'Cargando...',
        'error' => 'Error',
        'success' => 'Éxito',
        'cancel' => 'Cancelar',
        'category' =>[
            'add' => 'Añadir Categoría',
            'delete' => 'Eliminar Categoría',
            'close' => 'Cerrar',
        ] ,
        'save' => 'Guardar',
        'delete' => 'Eliminar',
        'edit' => 'Editar',
        'add' => 'Añadir',
        'search' => 'Buscar',
        'filter' => 'Filtrar',
        'close' => 'Cerrar',
        'back' => 'Volver',
        'next' => 'Siguiente',
        'previous' => 'Anterior',
        'yes' => 'Sí',
        'no' => 'No',
        'or' => 'o',
        'and' => 'y'
    ],
    
    'navigation' => [
        'title' => 'Navegación',
        'home' => 'Inicio',
        'search' => 'Buscar Libros',
        'dashboard' => 'Dashboard',
        'library' => 'Mi Biblioteca',
        'import' => 'Importar Excel',
        'profile' => 'Perfil',
        'settings' => 'Configuración',
        'logout' => 'Cerrar Sesión',
        'login' => 'Iniciar Sesión',
        'register' => 'Registrarse'
    ],
    
    'landing' => [
        'hero' => [
            'title' => 'Organiza, Descubre y Disfruta',
            'subtitle' => 'La plataforma definitiva para gestionar tu biblioteca personal, descubrir nuevos libros y conectar con una comunidad apasionada por la lectura.',
            'start_free' => 'Comenzar Gratis',
            'explore_books' => 'Explorar Libros',
            'no_credit' => 'No se requiere tarjeta de crédito · Configuración en 2 minutos'
        ],
        'stats' => [
            'books_available' => 'Libros Disponibles',
            'active_users' => 'Usuarios Activos',
            'reviews_written' => 'Reseñas Escritas',
            'lists_created' => 'Listas Creadas'
        ],
        'features' => [
            'title' => 'Todo lo que necesitas para ser un mejor lector',
            'subtitle' => 'Herramientas potentes y una experiencia intuitiva diseñada para lectores apasionados como tú.',
            'organize' => [
                'title' => 'Organiza tu Biblioteca',
                'description' => 'Crea estanterías personalizadas: por leer, leyendo, leídos, favoritos y categorías personalizadas.'
            ],
            'search' => [
                'title' => 'Busca y Descubre',
                'description' => 'Accede a millones de libros desde Google Books y Open Library. Encuentra tu próxima lectura perfecta.'
            ],
            'notes' => [
                'title' => 'Notas y Reseñas',
                'description' => 'Añade notas personales, escribe reseñas y comparte tus opiniones con la comunidad.'
            ],
            'import' => [
                'title' => 'Importa desde Excel',
                'description' => 'Sube listas de libros desde Excel o CSV con categorías personalizadas de forma rápida y sencilla.'
            ],
            'stats' => [
                'title' => 'Estadísticas de Lectura',
                'description' => 'Visualiza tu progreso, páginas leídas, libros por año y mantén el hábito de lectura.'
            ],
            'community' => [
                'title' => 'Comunidad Lectora',
                'description' => 'Conecta con otros lectores, descubre recomendaciones y participa en discusiones literarias.'
            ]
        ],
        'books' => [
            'title' => 'Libros Populares',
            'subtitle' => 'Descubre los libros más leídos y mejor valorados por nuestra comunidad.',
            'explore_more' => 'Explorar Más Libros'
        ],
        'cta' => [
            'title' => '¿Listo para transformar tu experiencia de lectura?',
            'subtitle' => 'Únete a miles de lectores que ya organizan y disfrutan sus libros con BookShelf. Es gratuito y siempre lo será.',
            'create_account' => 'Crear Cuenta Gratis',
            'explore_without' => 'Explorar sin Registro'
        ]
    ],
    
    'search' => [
        'title' => 'Buscar Libros',
        'subtitle' => 'Explora millones de libros desde Google Books y Open Library',
        'placeholder' => 'Buscar por título, autor, ISBN...',
        'searching' => 'Buscando libros...',
        'types' => [
            'general' => 'Búsqueda General',
            'title' => 'Por Título',
            'author' => 'Por Autor',
            'isbn' => 'Por ISBN',
            'subject' => 'Por Tema'
        ],
        'languages' => [
            'all' => 'Todos los idiomas',
            'es' => 'Español',
            'en' => 'Inglés',
            'fr' => 'Francés',
            'de' => 'Alemán',
            'it' => 'Italiano'
        ],
        'sorting' => [
            'relevance' => 'Relevancia',
            'newest' => 'Más Recientes'
        ],
        'popular_searches' => 'Búsquedas populares:',
        'results' => [
            'found' => ':count resultados para ":query"',
            'showing' => 'Mostrando :current de :total',
            'no_results' => 'No se encontraron resultados',
            'no_results_desc' => 'Intenta con diferentes términos de búsqueda o revisa la ortografía.',
            'clear_search' => 'Limpiar búsqueda',
            'load_more' => 'Cargar Más Libros'
        ]
    ],
    
    'auth' => [
        'login' => [
            'title' => 'Iniciar Sesión',
            'subtitle' => 'Accede a tu biblioteca personal',
            'email' => 'Email',
            'password' => 'Contraseña',
            'email_placeholder' => 'tu@ejemplo.com',
            'password_placeholder' => 'Ingresa tu contraseña',
            'forgot_password' => '¿Olvidaste tu contraseña?',
            'no_account' => '¿No tienes una cuenta?',
            'register_here' => 'Regístrate aquí',
            'continue_with_google' => 'Continuar con Google',
            'continue_with_email' => 'O continúa con email',
            'remember_me' => 'Recordarme'
        ],
        'register' => [
            'title' => 'Crear Cuenta',
            'subtitle' => 'Únete a nuestra comunidad de lectores',
            'name' => 'Nombre completo',
            'name_placeholder' => 'Tu nombre completo',
            'email' => 'Email',
            'email_placeholder' => 'tu@ejemplo.com',
            'password' => 'Contraseña',
            'password_placeholder' => 'Mínimo 6 caracteres',
            'confirm_password' => 'Confirmar contraseña',
            'confirm_password_placeholder' => 'Repite tu contraseña',
            'accept_terms' => 'Acepto los',
            'terms' => 'términos y condiciones',
            'privacy' => 'política de privacidad',
            'has_account' => '¿Ya tienes una cuenta?',
            'login_here' => 'Inicia sesión aquí',
            'continue_with_google' => 'Continuar con Google',
            'continue_with_email' => 'O crea una cuenta con email'
        ],
        'profile' => [
            'title' => 'Mi Perfil',
            'member_since' => 'Miembro desde'
        ],
        'settings' => [
            'title' => 'Configuración',
            'subtitle' => 'Gestiona tu cuenta y preferencias',
            'profile' => [
                'title' => 'Información Personal'
            ],
            'password' => [
                'title' => 'Cambiar Contraseña',
                'current' => 'Contraseña Actual',
                'current_placeholder' => 'Ingresa tu contraseña actual',
                'new' => 'Nueva Contraseña',
                'new_placeholder' => 'Ingresa tu nueva contraseña',
                'confirm' => 'Confirmar Contraseña',
                'confirm_placeholder' => 'Confirma tu nueva contraseña',
                'update' => 'Actualizar Contraseña'
            ],
            'preferences' => [
                'title' => 'Preferencias',
                'language' => 'Idioma',
                'theme' => 'Tema'
            ]
        ]
    ],
    
    'dashboard' => [
        'welcome' => 'Hola, :name! 👋',
        'subtitle' => 'Aquí tienes un resumen de tu actividad de lectura',
        'stats' => [
            'total_books' => 'Total de Libros',
            'total_books_desc' => 'en tu biblioteca',
            'read_books' => 'Libros Leídos',
            'read_books_desc' => 'completados',
            'reading_now' => 'Leyendo Ahora',
            'reading_now_desc' => 'en progreso',
            'favorites' => 'Favoritos',
            'favorites_desc' => 'marcados'
        ],
        'recent_activity' => [
            'title' => 'Actividad Reciente',
            'empty' => [
                'title' => 'Tu biblioteca está vacía',
                'description' => 'Comienza añadiendo algunos libros a tu colección',
                'action' => 'Añadir Libros'
            ]
        ],
        'quick_actions' => [
            'title' => 'Acciones Rápidas',
            'search_books' => 'Buscar Nuevos Libros',
            'view_library' => 'Ver Mi Biblioteca',
            'import_excel' => 'Importar desde Excel'
        ]
    ],
    
    'books' => [
        'in_library' => 'En tu biblioteca',
        'categories' => [
            'title' => 'Categorías',
            'to_read' => 'Por Leer',
            'reading' => 'Leyendo',
            'read' => 'Leídos',
            'favorites' => 'Favoritos',
            'wishlist' => 'Lista de Deseos'
        ],
        'actions' => [
            'add_to_library' => 'Añadir a Biblioteca',
            'mark_as_reading' => 'Marcar como Leyendo',
            'mark_as_read' => 'Marcar como Leído',
            'add_to_favorites' => 'Añadir a Favoritos',
            'view_details' => 'Ver Detalles',
            'edit' => 'Editar',
            'delete' => 'Eliminar',
            'confirm_delete' => '¿Estás seguro de que quieres eliminar este libro de tu biblioteca?',
            'rating' => 'Mi Valoración',
            'notes' => 'Notas',
            'adding' => 'Añadiendo...',
            'select_category' => 'Seleccionar categoría',
            'optional_notes' => 'Notas (opcional)',
            'notes_placeholder' => 'Añade tus notas sobre este libro...',
            'no_rating' => 'Sin valorar',
            'login_to_add' => 'Inicia sesión para añadir libros a tu biblioteca',
            'preview' => 'Vista Previa',
            'more_info' => 'Más Información',
            'manage_categories' => 'Gestionar Categorías'
        ],
        'details' => [
            'authors' => 'Autores',
            'publisher' => 'Editorial',
            'published' => 'Publicado',
            'pages' => 'Páginas',
            'isbn' => 'ISBN',
            'rating' => 'Valoración',
            'categories' => 'Categorías',
            'description' => 'Descripción'
        ],
        'info' => [
            'pages' => 'págs.',
            'reviews' => 'reseñas',
            'year' => 'año',
            'rating' => 'valoración',
            'no_description' => 'Sin descripción disponible',
            'no_cover' => 'Sin portada'
        ],
        'messages' => [
            'added' => '¡Libro añadido!',
            'updated' => '¡Libro actualizado!',
            'already_added' => 'Este libro ya está en tu biblioteca',
            'added_desc' => '":title" se ha añadido a tu biblioteca.',
            'deleted' => 'Libro eliminado de tu biblioteca',
            'not_found' => 'Libro no encontrado'
        ],
        'added' => 'Añadido'
    ],
    
    'shelves' => [
        'title' => 'Mis Estanterías',
        'manage' => 'Gestionar Estanterías',
        'system' => 'Estanterías del Sistema',
        'custom' => 'Estanterías Personalizadas',
        'no_custom' => 'No tienes estanterías personalizadas',
        'assign' => 'Asignar a Estanterías',
        'create' => 'Crear Estantería',
        'edit' => 'Editar Estantería',
        'delete' => 'Eliminar Estantería',
        'name' => 'Nombre',
        'color' => 'Color',
        'icon' => 'Icono',
    ],
    
    'categories' => [
        'title' => 'Categorías',
        'global' => 'Categorías Globales',
        'description' => 'Las categorías son géneros/temas globales de los libros',
    ],
    
    'template' => [
        'download' => 'Descargar Plantilla',
        'upload' => 'Subir Plantilla',
        'messages' => [
            'template_uploaded' => 'Plantilla subida correctamente'
        ]
    ],
    
    'library' => [
        'title' => 'Mi Biblioteca',
        'subtitle' => 'Tienes :count libros en tu biblioteca',
        'add_books' => 'Añadir Libros',
        'import_excel' => 'Importar Excel',
        'search_placeholder' => 'Buscar en tu biblioteca...',
        'all_books' => 'Todos los libros (:count)',
        'all_categories' => 'Todas las categorías (:count)',
        'empty' => [
            'title' => 'Tu biblioteca está vacía',
            'description' => 'Comienza añadiendo algunos libros a tu colección',
            'search_books' => 'Buscar Libros',
            'import_excel' => 'Importar desde Excel'
        ],
        'no_results' => [
            'title' => 'No se encontraron libros',
            'by_search' => 'No hay libros que coincidan con tu búsqueda',
            'by_category' => 'No hay libros en esta categoría',
            'clear_search' => 'Limpiar búsqueda'
        ],
        'results' => [
            'books' => 'libros',
            'found' => 'encontrados para ":query"'
        ]
    ],
    
    'import' => [
        'title' => 'Importar Libros',
        'subtitle' => 'Sube tu lista de libros desde un archivo Excel o CSV',
        'instructions' => [
            'format' => [
                'title' => 'Formatos Soportados',
                'csv' => 'Archivos CSV (.csv)',
                'excel' => 'Archivos Excel (.xlsx, .xls)',
                'size' => 'Tamaño máximo: 10MB'
            ],
            'columns' => [
                'title' => 'Columnas Requeridas',
                'required' => 'Título (obligatorio)',
                'optional' => 'Autor, ISBN (opcional)',
                'metadata' => 'Fecha de publicación, páginas',
                'personal' => 'Notas, categoría, rating personal'
            ],
            'note' => '¿No tienes un archivo? Descarga nuestra plantilla de ejemplo o sube tu archivo existente.'
        ],
        'upload' => [
            'title' => 'Selecciona tu archivo',
            'description' => 'Arrastra y suelta tu archivo aquí o haz clic para seleccionar',
            'supports' => 'Soporta archivos CSV, XLSX y XLS hasta 10MB',
            'process_file' => 'Procesar Archivo'
        ],
        'options' => [
            'title' => 'Opciones de Importación',
            'create_categories' => 'Crear categorías automáticamente',
            'skip_duplicates' => 'Omitir libros duplicados',
            'validate_isbn' => 'Validar códigos ISBN'
        ],
        'messages' => [
            'success' => 'Archivo importado exitosamente',
            'error' => 'Error al procesar el archivo',
            'invalid_format' => 'Formato de archivo no válido',
            'file_too_large' => 'El archivo es demasiado grande',
            'no_books_found' => 'No se encontraron libros en el archivo'
        ]
    ],
    
    'footer' => [
        'support' => 'Soporte',
        'help' => 'Ayuda',
        'contact' => 'Contacto',
        'privacy' => 'Privacidad',
        'terms' => 'Términos',
        'rights' => 'Todos los derechos reservados.',
        'made_with' => 'Hecho con',
        'in_spain' => 'en España'
    ],

    'emails' => [
        'welcome' => [
            'subject' => '¡Bienvenido a :app! Comienza a organizar tu biblioteca',
            'title' => '¡Bienvenido a :app!',
            'subtitle' => 'Tu biblioteca personal te espera',
            'greeting' => '¡Hola :name!',
            'message' => 'Gracias por unirte a nuestra comunidad de lectores apasionados. Estamos emocionados de ayudarte a organizar, descubrir y disfrutar tus libros como nunca antes.',
            'philosophy_title' => 'Nuestra Pasión por los Libros',
            'philosophy_message' => 'Los libros tienen el poder de transformar vidas, expandir mentes y conectarnos a través de culturas y tiempo. Creemos que todos deberían tener acceso a herramientas que les ayuden a descubrir, organizar y atesorar su biblioteca personal.',
            'philosophy_vision' => 'Por eso hemos creado :app como una plataforma gratuita y abierta - porque el amor por la lectura debería ser accesible para todos, en todas partes.',
            'features_title' => 'Lo que puedes hacer con :app:',
            'feature_1' => 'Organiza tus libros en estanterías personalizadas',
            'feature_2' => 'Descubre millones de libros desde Google Books y Open Library',
            'feature_3' => 'Añade notas personales y valoraciones a tus libros',
            'feature_4' => 'Importa tus listas de libros existentes desde Excel',
            'get_started' => '¿Listo para comenzar? Haz clic en el botón de abajo para acceder a tu dashboard y comenzar a organizar tu biblioteca.',
            'cta_button' => 'Ir al Dashboard',
            'footer_message' => 'Si tienes alguna pregunta, no dudes en contactarnos. ¡Estamos aquí para ayudarte!'
        ]
    ]
];
