@extends('layouts.app')

@section('title', 'Política de Privacidad')
@section('description', 'Información sobre el tratamiento de datos personales en BiblioFinder')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Política de Privacidad</h1>
        
        <div class="prose prose-lg max-w-none dark:prose-invert">
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                <strong>Última actualización:</strong> {{ date('d/m/Y') }}
            </p>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Responsable del tratamiento</h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                        <li><strong>Responsable:</strong> Iván Portillo Pérez</li>
                        <li><strong>NIF:</strong> 46929617A</li>
                        <li><strong>Email:</strong> ivan.portillo@notasweb.me</li>
                        <li><strong>Domicilio:</strong> España</li>
                    </ul>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Datos que recopilamos</h2>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Datos de registro</h3>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                        <li>Nombre de usuario</li>
                        <li>Dirección de correo electrónico</li>
                        <li>Contraseña (encriptada)</li>
                        <li>Fecha de registro</li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Datos de autenticación social (Google)</h3>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                        <li>Nombre completo</li>
                        <li>Dirección de correo electrónico</li>
                        <li>Avatar/foto de perfil</li>
                        <li>ID único de Google</li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Datos de uso</h3>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                        <li>Libros agregados a la biblioteca personal</li>
                        <li>Notas y reseñas de libros</li>
                        <li>Progreso de lectura</li>
                        <li>Estanterías y categorías personalizadas</li>
                        <li>Búsquedas realizadas</li>
                        <li>Preferencias de configuración</li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Datos técnicos</h3>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                        <li>Dirección IP</li>
                        <li>Información del navegador</li>
                        <li>Cookies y tecnologías similares</li>
                        <li>Logs de acceso y errores</li>
                    </ul>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Finalidad del tratamiento</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Tratamos sus datos personales para las siguientes finalidades:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                    <li><strong>Gestión de cuenta:</strong> Crear y mantener su cuenta de usuario</li>
                    <li><strong>Autenticación:</strong> Verificar su identidad y permitir el acceso seguro</li>
                    <li><strong>Funcionalidades del servicio:</strong> Proporcionar las funcionalidades de la biblioteca personal</li>
                    <li><strong>Búsqueda inteligente:</strong> Mejorar los resultados de búsqueda usando tecnología semántica</li>
                    <li><strong>Personalización:</strong> Adaptar la experiencia según sus preferencias</li>
                    <li><strong>Comunicación:</strong> Enviar notificaciones importantes del servicio</li>
                    <li><strong>Seguridad:</strong> Proteger contra fraudes y abusos</li>
                    <li><strong>Mejoras:</strong> Analizar el uso para mejorar el servicio</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Base legal del tratamiento</h2>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                    <li><strong>Consentimiento:</strong> Para el registro y uso de funcionalidades opcionales</li>
                    <li><strong>Ejecución contractual:</strong> Para proporcionar los servicios solicitados</li>
                    <li><strong>Interés legítimo:</strong> Para mejorar el servicio y garantizar la seguridad</li>
                    <li><strong>Cumplimiento legal:</strong> Para cumplir con obligaciones legales aplicables</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Compartir datos con terceros</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Compartimos datos con los siguientes terceros para proporcionar nuestros servicios:
                </p>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Proveedores de servicios</h3>
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                        <li><strong>Google:</strong> Para autenticación OAuth, búsqueda de libros y funcionalidades de IA</li>
                        <li><strong>OpenAI:</strong> Para funcionalidades de búsqueda semántica</li>
                        <li><strong>Proveedores de hosting:</strong> Para el alojamiento y funcionamiento del servicio</li>
                    </ul>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <p class="text-yellow-800 dark:text-yellow-200 text-sm">
                        <strong>Importante:</strong> No vendemos, alquilamos ni compartimos sus datos personales 
                        con terceros para fines comerciales sin su consentimiento explícito.
                    </p>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Transferencias internacionales</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Algunos de nuestros proveedores de servicios pueden estar ubicados fuera del Espacio Económico Europeo. 
                    En estos casos, nos aseguramos de que existan las garantías adecuadas para la protección de sus datos:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                    <li>Decisiones de adecuación de la Comisión Europea</li>
                    <li>Cláusulas contractuales tipo</li>
                    <li>Certificaciones de privacidad reconocidas</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Conservación de datos</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Conservamos sus datos personales durante los siguientes períodos:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                    <li><strong>Datos de cuenta:</strong> Hasta que elimine su cuenta o solicite la supresión</li>
                    <li><strong>Datos de uso:</strong> Durante la duración de su cuenta</li>
                    <li><strong>Logs técnicos:</strong> Máximo 12 meses</li>
                    <li><strong>Datos de facturación:</strong> Según la legislación fiscal aplicable</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Sus derechos</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Como titular de los datos, tiene los siguientes derechos:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                    <li><strong>Acceso:</strong> Conocer qué datos tenemos sobre usted</li>
                    <li><strong>Rectificación:</strong> Corregir datos inexactos o incompletos</li>
                    <li><strong>Supresión:</strong> Solicitar la eliminación de sus datos</li>
                    <li><strong>Limitación:</strong> Restringir el tratamiento de sus datos</li>
                    <li><strong>Portabilidad:</strong> Recibir sus datos en formato estructurado</li>
                    <li><strong>Oposición:</strong> Oponerse al tratamiento de sus datos</li>
                    <li><strong>Retirada del consentimiento:</strong> En cualquier momento</li>
                </ul>
                
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mt-4">
                    <p class="text-blue-800 dark:text-blue-200 text-sm">
                        <strong>Ejercicio de derechos:</strong> Para ejercer cualquiera de estos derechos, 
                        puede contactarnos en ivan.portillo@notasweb.me. Responderemos en un plazo máximo de 30 días.
                    </p>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Seguridad de los datos</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Implementamos medidas técnicas y organizativas apropiadas para proteger sus datos:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-4 space-y-2">
                    <li>Encriptación de datos en tránsito y en reposo</li>
                    <li>Controles de acceso estrictos</li>
                    <li>Monitoreo de seguridad continuo</li>
                    <li>Copias de seguridad regulares</li>
                    <li>Formación del personal en protección de datos</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Menores de edad</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Nuestro servicio no está dirigido a menores de 16 años. No recopilamos conscientemente 
                    datos personales de menores. Si descubrimos que hemos recopilado datos de un menor, 
                    los eliminaremos inmediatamente.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Cambios en esta política</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Podemos actualizar esta política de privacidad ocasionalmente. Le notificaremos sobre 
                    cambios significativos a través del sitio web o por correo electrónico. Le recomendamos 
                    revisar esta política periódicamente.
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Autoridad de control</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Si considera que el tratamiento de sus datos personales no es adecuado, puede presentar 
                    una reclamación ante la Agencia Española de Protección de Datos (AEPD):
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 space-y-2">
                    <li><strong>Web:</strong> www.aepd.es</li>
                    <li><strong>Dirección:</strong> C/ Jorge Juan, 6, 28001 Madrid</li>
                    <li><strong>Teléfono:</strong> 901 100 099</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Contacto</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Para cualquier consulta sobre esta política de privacidad o el tratamiento de sus datos:
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
