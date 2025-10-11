@extends('layouts.app')

@section('title', 'Política de Cookies')
@section('description', 'Información sobre el uso de cookies en BiblioFinder')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Política de Cookies</h1>
        
        <div class="prose prose-lg max-w-none dark:prose-invert">
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                <strong>Última actualización:</strong> {{ date('d/m/Y') }}
            </p>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">¿Qué son las cookies?</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Las cookies son pequeños archivos de texto que se almacenan en su dispositivo cuando visita nuestro sitio web. 
                    Estas cookies nos ayudan a mejorar su experiencia de navegación y a proporcionar funcionalidades personalizadas.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Tipos de cookies que utilizamos</h2>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Cookies técnicas (necesarias)</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Estas cookies son esenciales para el funcionamiento básico del sitio web y no se pueden desactivar:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                        <li><strong>Cookies de sesión:</strong> Mantienen su sesión activa mientras navega por el sitio</li>
                        <li><strong>Cookies de seguridad:</strong> Protegen contra ataques CSRF y mantienen la seguridad</li>
                        <li><strong>Cookies de preferencias:</strong> Recuerdan su tema (claro/oscuro) y configuración de idioma</li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Cookies de terceros</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Utilizamos servicios de terceros que pueden establecer sus propias cookies:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                        <li><strong>Google OAuth:</strong> Para la autenticación con Google (cuando se utiliza)</li>
                        <li><strong>Google Fonts:</strong> Para cargar las fuentes del sitio web</li>
                        <li><strong>Google Books API:</strong> Para búsqueda y obtención de información de libros</li>
                        <li><strong>Google AI / OpenAI:</strong> Para funcionalidades de búsqueda semántica</li>
                    </ul>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Finalidad del uso de cookies</h2>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                    <li>Mantener su sesión de usuario activa</li>
                    <li>Recordar sus preferencias de tema y idioma</li>
                    <li>Proporcionar funcionalidades de autenticación social</li>
                    <li>Mejorar la experiencia de búsqueda de libros</li>
                    <li>Analizar el uso del sitio web para mejoras</li>
                    <li>Garantizar la seguridad del sitio web</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Gestión de cookies</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Puede gestionar las cookies de las siguientes maneras:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                    <li><strong>Configuración del navegador:</strong> La mayoría de navegadores permiten controlar las cookies a través de su configuración</li>
                    <li><strong>Preferencias del sitio:</strong> Puede cambiar su tema y idioma desde la configuración de su perfil</li>
                    <li><strong>Desactivación de servicios:</strong> Puede optar por no utilizar la autenticación con Google</li>
                </ul>
                
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mt-4">
                    <p class="text-blue-800 dark:text-blue-200 text-sm">
                        <strong>Nota importante:</strong> Desactivar ciertas cookies puede afectar la funcionalidad del sitio web. 
                        Las cookies técnicas son necesarias para el funcionamiento básico.
                    </p>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Cookies específicas utilizadas</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                        <thead class="bg-gray-50 dark:bg-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Cookie</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Finalidad</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Duración</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">laravel_session</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">Mantener sesión de usuario</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">Sesión</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">XSRF-TOKEN</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">Protección CSRF</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">Sesión</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">theme</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">Preferencia de tema</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">1 año</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">locale</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">Idioma preferido</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">Sesión</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Contacto</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Si tiene preguntas sobre nuestra política de cookies, puede contactarnos:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 space-y-2">
                    <li><strong>Email:</strong> ivan.portillo@notasweb.me</li>
                    <li><strong>Responsable:</strong> Iván Portillo Pérez</li>
                    <li><strong>NIF:</strong> 46929617A</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Actualizaciones</h2>
                <p class="text-gray-600 dark:text-gray-300">
                    Esta política de cookies puede ser actualizada periódicamente. Le recomendamos revisar esta página 
                    regularmente para estar informado de cualquier cambio. La fecha de la última actualización se 
                    muestra al inicio de este documento.
                </p>
            </section>
        </div>
    </div>
</div>
@endsection
