<?php

return [
    'name' => 'BookShelf',
    'tagline' => 'Your intelligent personal library',
    
    'common' => [
        'loading' => 'Loading...',
        'error' => 'Error',
        'success' => 'Success',
        'cancel' => 'Cancel',
        'save' => 'Save',
        'delete' => 'Delete',
        'edit' => 'Edit',
        'add' => 'Add',
        'search' => 'Search',
        'filter' => 'Filter',
        'close' => 'Close',
        'back' => 'Back',
        'next' => 'Next',
        'previous' => 'Previous',
        'yes' => 'Yes',
        'no' => 'No',
        'or' => 'or',
        'and' => 'and'
    ],
    
    'navigation' => [
        'title' => 'Navigation',
        'home' => 'Home',
        'search' => 'Search Books',
        'dashboard' => 'Dashboard',
        'library' => 'My Library',
        'import' => 'Import Excel',
        'profile' => 'Profile',
        'settings' => 'Settings',
        'logout' => 'Logout',
        'login' => 'Login',
        'register' => 'Register'
    ],
    
    'auth' => [
        'login' => [
            'title' => 'Login',
            'subtitle' => 'Access your personal library',
            'welcome_back' => 'Welcome back',
            'description' => 'Enter your credentials to access your account',
            'email' => 'Email',
            'password' => 'Password',
            'email_placeholder' => 'your@example.com',
            'password_placeholder' => 'Enter your password',
            'forgot_password' => 'Forgot your password?',
            'no_account' => "Don't have an account?",
            'register_here' => 'Register here',
            'continue_with_google' => 'Continue with Google',
            'continue_with_email' => 'Or continue with email',
            'signing_in' => 'Signing in...',
            'back_to_home' => '← Back to home'
        ],
        'register' => [
            'title' => 'Create Account',
            'subtitle' => 'Join our community of readers',
            'welcome' => 'Welcome!',
            'description' => 'Create your free account to start organizing your books',
            'name' => 'Full name',
            'name_placeholder' => 'Your full name',
            'email' => 'Email',
            'email_placeholder' => 'your@example.com',
            'password' => 'Password',
            'password_placeholder' => 'Minimum 6 characters',
            'confirm_password' => 'Confirm password',
            'confirm_password_placeholder' => 'Repeat your password',
            'accept_terms' => 'I accept the',
            'terms' => 'terms and conditions',
            'privacy' => 'privacy policy',
            'has_account' => 'Already have an account?',
            'login_here' => 'Login here',
            'continue_with_google' => 'Continue with Google',
            'continue_with_email' => 'Or create an account with email',
            'creating' => 'Creating account...',
            'back_to_home' => '← Back to home'
        ]
    ],
    
    'landing' => [
        'hero' => [
            'title' => 'Organize, Discover and Enjoy',
            'subtitle' => 'The definitive platform to manage your personal library, discover new books and connect with a community passionate about reading.',
            'start_free' => 'Start Free',
            'explore_books' => 'Explore Books',
            'no_credit' => 'No credit card required · Setup in 2 minutes'
        ],
        'stats' => [
            'books_available' => 'Available Books',
            'active_users' => 'Active Users',
            'reviews_written' => 'Reviews Written',
            'lists_created' => 'Lists Created'
        ],
        'features' => [
            'title' => 'Everything you need to be a better reader',
            'subtitle' => 'Powerful tools and an intuitive experience designed for passionate readers like you.',
            'organize' => [
                'title' => 'Organize your Library',
                'description' => 'Create custom shelves: to read, reading, read, favorites and custom categories.'
            ],
            'search' => [
                'title' => 'Search and Discover',
                'description' => 'Access millions of books from Google Books and Open Library. Find your perfect next read.'
            ],
            'notes' => [
                'title' => 'Notes and Reviews',
                'description' => 'Add personal notes, write reviews and share your opinions with the community.'
            ],
            'import' => [
                'title' => 'Import from Excel',
                'description' => 'Upload book lists from Excel or CSV with custom categories quickly and easily.'
            ],
            'stats' => [
                'title' => 'Reading Statistics',
                'description' => 'Visualize your progress, pages read, books per year and maintain your reading habit.'
            ],
            'community' => [
                'title' => 'Reading Community',
                'description' => 'Connect with other readers, discover recommendations and participate in literary discussions.'
            ]
        ],
        'books' => [
            'title' => 'Popular Books',
            'subtitle' => 'Discover the most read and highly rated books by our community.',
            'explore_more' => 'Explore More Books'
        ],
        'cta' => [
            'title' => 'Ready to transform your reading experience?',
            'subtitle' => 'Join thousands of readers who already organize and enjoy their books with BookShelf. It\'s free and always will be.',
            'create_account' => 'Create Free Account',
            'explore_without' => 'Explore without Registration'
        ]
    ],
    
    'search' => [
        'title' => 'Search Books',
        'subtitle' => 'Explore millions of books from Google Books and Open Library',
        'placeholder' => 'Search by title, author, ISBN...',
        'searching' => 'Searching books...',
        'types' => [
            'general' => 'General Search',
            'title' => 'By Title',
            'author' => 'By Author',
            'isbn' => 'By ISBN',
            'subject' => 'By Subject'
        ],
        'languages' => [
            'all' => 'All languages',
            'es' => 'Spanish',
            'en' => 'English',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian'
        ],
        'sorting' => [
            'relevance' => 'Relevance',
            'newest' => 'Newest'
        ],
        'popular_searches' => 'Popular searches:',
        'results' => [
            'found' => ':count results for ":query"',
            'showing' => 'Showing :current of :total',
            'no_results' => 'No results found',
            'no_results_desc' => 'Try different search terms or check spelling.',
            'clear_search' => 'Clear search',
            'load_more' => 'Load More Books'
        ]
    ],
    
    'dashboard' => [
        'welcome' => 'Hello, :name! 👋',
        'subtitle' => 'Here\'s a summary of your reading activity',
        'stats' => [
            'total_books' => 'Total Books',
            'total_books_desc' => 'in your library',
            'read_books' => 'Books Read',
            'read_books_desc' => 'completed',
            'reading_now' => 'Reading Now',
            'reading_now_desc' => 'in progress',
            'favorites' => 'Favorites',
            'favorites_desc' => 'marked'
        ],
        'recent_activity' => [
            'title' => 'Recent Activity',
            'empty' => [
                'title' => 'Your library is empty',
                'description' => 'Start by adding some books to your collection',
                'action' => 'Add Books'
            ]
        ],
        'quick_actions' => [
            'title' => 'Quick Actions',
            'search_books' => 'Search New Books',
            'view_library' => 'View My Library',
            'import_excel' => 'Import from Excel'
        ]
    ],
    
    'library' => [
        'title' => 'My Library',
        'subtitle' => ':count books in your collection',
        'search_placeholder' => 'Search in your library...',
        'all_categories' => 'All categories (:count)',
        'add_books' => 'Add Books',
        'import_excel' => 'Import Excel',
        'empty' => [
            'title' => 'Your library is empty',
            'description' => 'Start by adding some books to your personal collection',
            'search_books' => 'Search Books',
            'import_excel' => 'Import from Excel'
        ],
        'no_results' => [
            'title' => 'No books found',
            'by_search' => 'Try other search terms',
            'by_category' => 'No books in this category',
            'clear_search' => 'Clear search'
        ],
        'results' => [
            'found' => ':count book found for ":query"',
            'books' => ':count books'
        ]
    ],
    
    'books' => [
        'categories' => [
            'to_read' => 'To Read',
            'reading' => 'Reading',
            'read' => 'Read',
            'favorites' => 'Favorites',
            'wishlist' => 'Wishlist'
        ],
        'actions' => [
            'add_to_library' => 'Add to Library',
            'mark_as_reading' => 'Mark as Reading',
            'mark_as_read' => 'Mark as Read',
            'add_to_favorites' => 'Add to Favorites',
            'view_details' => 'View Details',
            'adding' => 'Adding...',
            'select_category' => 'Select category',
            'optional_notes' => 'Notes (optional)',
            'notes_placeholder' => 'Add your notes about this book...'
        ],
        'info' => [
            'pages' => 'pages',
            'reviews' => 'reviews',
            'year' => 'year',
            'rating' => 'rating',
            'no_description' => 'No description available',
            'no_cover' => 'No cover'
        ],
        'messages' => [
            'added' => 'Book added!',
            'added_desc' => '":title" has been added to your library.'
        ]
    ],
    
    'footer' => [
        'support' => 'Support',
        'help' => 'Help',
        'contact' => 'Contact',
        'privacy' => 'Privacy',
        'terms' => 'Terms',
        'rights' => 'All rights reserved.',
        'made_with' => 'Made with',
        'in_spain' => 'in Spain'
    ],
    
    'errors' => [
        'general' => 'An unexpected error occurred',
        'network' => 'Connection error. Check your internet.',
        'not_found' => 'The requested resource was not found',
        'unauthorized' => 'You do not have permission for this action',
        'validation' => 'Please verify the entered data'
    ]
];
