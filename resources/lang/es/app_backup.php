<?php

return [
    'name' => 'BookShelf',
    'tagline' => 'Tu biblioteca personal inteligente',
    
    'common' => [
        'loading' => 'Cargando...',
        'error' => 'Error',
        'success' => 'Éxito',
        'cancel' => 'Cancelar',
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
    
    'auth' => [
        'login' => [
            'title' => 'Iniciar Sesión',
            'subtitle' => 'Accede a tu biblioteca personal',
            'welcome_back' => 'Bienvenido de vuelta',
            'description' => 'Ingresa tus credenciales para acceder a tu cuenta',
            'email' => 'Email',
            'password' => 'Contraseña',
            'email_placeholder' => 'tu@ejemplo.com',
            'password_placeholder' => 'Ingresa tu contraseña',
            'forgot_password' => '¿Olvidaste tu contraseña?',
            'no_account' => '¿No tienes una cuenta?',
            'register_here' => 'Regístrate aquí',
            'continue_with_google' => 'Continuar con Google',
            'continue_with_email' => 'O continúa con email',
            'signing_in' => 'Iniciando sesión...',
            'back_to_home' => '← Volver al inicio'
        ],
        'register' => [
            'title' => 'Crear Cuenta',
            'subtitle' => 'Únete a nuestra comunidad de lectores',
            'welcome' => '¡Bienvenido!',
            'description' => 'Crea tu cuenta gratuita para empezar a organizar tus libros',
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
            'continue_with_email' => 'O crea una cuenta con email',
            'creating' => 'Creando cuenta...',
            'back_to_home' => '← Volver al inicio'
        ]
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
    
    'dashboard' => [
        'welcome' => '¡Hola, :name! 👋',
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
    
    'library' => [
        'title' => 'Mi Biblioteca',
        'subtitle' => ':count libros en tu colección',
        'search_placeholder' => 'Buscar en tu biblioteca...',
        'all_categories' => 'Todas las categorías (:count)',
        'add_books' => 'Añadir Libros',
        'import_excel' => 'Importar Excel',
        'empty' => [
            'title' => 'Tu biblioteca está vacía',
            'description' => 'Comienza añadiendo algunos libros a tu colección personal',
            'search_books' => 'Buscar Libros',
            'import_excel' => 'Importar desde Excel'
        ],
        'no_results' => [
            'title' => 'No se encontraron libros',
            'by_search' => 'Intenta con otros términos de búsqueda',
            'by_category' => 'No hay libros en esta categoría',
            'clear_search' => 'Limpiar búsqueda'
        ],
        'results' => [
            'found' => ':count libro encontrado para ":query"',
            'books' => ':count libros'
        ]
    ],
    
    'books' => [
        'categories' => [
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
            'adding' => 'Añadiendo...',
            'select_category' => 'Seleccionar categoría',
            'optional_notes' => 'Notas (opcional)',
            'notes_placeholder' => 'Añade tus notas sobre este libro...'
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
            'added_desc' => '":title" se ha añadido a tu biblioteca.'
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
    
    'errors' => [
        'general' => 'Ocurrió un error inesperado',
        'network' => 'Error de conexión. Verifica tu internet.',
        'not_found' => 'No se encontró el recurso solicitado',
        'unauthorized' => 'No tienes permisos para esta acción',
        'validation' => 'Por favor, verifica los datos ingresados'
    ]
];
