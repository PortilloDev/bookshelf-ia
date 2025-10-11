@extends('layouts.app')

@section('title', 'Aviso Legal')
@section('description', 'Información legal sobre BiblioFinder')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Aviso Legal</h1>
        
        <div class="prose prose-lg max-w-none dark:prose-invert">
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                <strong>Última actualización:</strong> {{ date('d/m/Y') }}
            </p>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Datos identificativos</h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                        <li><strong>Denominación social:</strong> BiblioFinder</li>
                        <li><strong>Responsable del Sitio Web:</strong> Iván Portillo Pérez</li>
                        <li><strong>NIF/CIF:</strong> 46929617A</li>
                        <li><strong>Correo de contacto:</strong> ivan.portillo@notasweb.me</li>
                        <li><strong>Domicilio:</strong> España</li>
                    </ul>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Objeto del sitio web</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    BiblioFinder es una aplicación web que permite a los usuarios organizar, gestionar y descubrir 
                    libros de manera inteligente. La plataforma ofrece las siguientes funcionalidades:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                    <li>Gestión de biblioteca personal</li>
                    <li>Búsqueda inteligente de libros con tecnología semántica</li>
                    <li>Organización en estanterías personalizadas</li>
                    <li>Importación de listas de libros</li>
                    <li>Sistema de categorización</li>
                    <li>Estadísticas de lectura</li>
                    <li>Autenticación social con Google</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Condiciones de uso</h2>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Acceso y uso del sitio</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        El acceso y uso de este sitio web es gratuito y no requiere registro previo para la consulta 
                        de información básica. Sin embargo, algunas funcionalidades requieren la creación de una cuenta.
                    </p>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Obligaciones del usuario</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        El usuario se compromete a:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                        <li>Utilizar el sitio web de conformidad con la ley y las buenas costumbres</li>
                        <li>No realizar actividades que puedan dañar, inutilizar o sobrecargar el sitio</li>
                        <li>No intentar acceder a áreas restringidas del sistema</li>
                        <li>Proporcionar información veraz y actualizada en su perfil</li>
                        <li>Respetar los derechos de propiedad intelectual</li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Prohibiciones</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Queda expresamente prohibido:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                        <li>El uso del sitio para fines ilegales o no autorizados</li>
                        <li>La transmisión de virus, malware o cualquier código dañino</li>
                        <li>La recopilación masiva de datos del sitio</li>
                        <li>La suplantación de identidad</li>
                        <li>El spam o envío de comunicaciones no solicitadas</li>
                    </ul>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Propiedad intelectual</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Todos los contenidos del sitio web, incluyendo textos, imágenes, logotipos, iconos, software, 
                    y cualquier otro material, están protegidos por derechos de propiedad intelectual e industrial.
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Los datos de libros provienen de fuentes públicas como Google Books API y Open Library API, 
                    y se utilizan conforme a sus respectivos términos de servicio.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Servicios de terceros</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Este sitio web utiliza los siguientes servicios de terceros:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                    <li><strong>Google OAuth:</strong> Para autenticación social</li>
                    <li><strong>Google Books API:</strong> Para búsqueda y obtención de información de libros</li>
                    <li><strong>Open Library API:</strong> Para datos adicionales de libros</li>
                    <li><strong>OpenAI API:</strong> Para funcionalidades de búsqueda semántica</li>
                    <li><strong>Google AI API:</strong> Para funcionalidades de búsqueda semántica</li>
                    <li><strong>Google Fonts:</strong> Para tipografías del sitio web</li>
                </ul>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    El uso de estos servicios está sujeto a sus respectivos términos de servicio y políticas de privacidad.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Limitación de responsabilidad</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    El responsable del sitio web no se hace responsable de:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                    <li>La disponibilidad continua del sitio web</li>
                    <li>Los daños que puedan derivarse del uso del sitio</li>
                    <li>La exactitud de la información proporcionada por terceros</li>
                    <li>Los contenidos de sitios web enlazados</li>
                    <li>Los fallos en el funcionamiento de servicios externos</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Modificaciones</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    El responsable se reserva el derecho de modificar, suspender o cancelar el sitio web, 
                    así como sus condiciones de uso, en cualquier momento y sin previo aviso.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Ley aplicable y jurisdicción</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Este aviso legal se rige por la legislación española. Para cualquier controversia, 
                    las partes se someten a los juzgados y tribunales de España.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Contacto</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Para cualquier consulta relacionada con este aviso legal, puede contactarnos:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 space-y-2">
                    <li><strong>Email:</strong> ivan.portillo@notasweb.me</li>
                    <li><strong>Responsable:</strong> Iván Portillo Pérez</li>
                    <li><strong>NIF:</strong> 46929617A</li>
                </ul>
            </section>
        </div>
    </div>
</div>
@endsection
