@extends('layouts.app')

@section('title', __('app.import.title') . ' - ' . __('app.name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold mb-4">{{ __('app.import.title') }}</h1>
            <p class="text-lg text-muted-foreground">
                {{ __('app.import.subtitle') }}
            </p>
        </div>

        <!-- Instructions -->
        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <!-- Format Instructions -->
            <div class="border rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('app.import.instructions.format.title') }}</h3>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    <li>• {{ __('app.import.instructions.format.csv') }}</li>
                    <li>• {{ __('app.import.instructions.format.excel') }}</li>
                    <li>• {{ __('app.import.instructions.format.size') }}</li>
                </ul>
            </div>

            <!-- Column Instructions -->
            <div class="border rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('app.import.instructions.columns.title') }}</h3>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    <li>• {{ __('app.import.instructions.columns.required') }}</li>
                    <li>• {{ __('app.import.instructions.columns.optional') }}</li>
                    <li>• {{ __('app.import.instructions.columns.metadata') }}</li>
                    <li>• {{ __('app.import.instructions.columns.personal') }}</li>
                </ul>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="max-w-2xl mx-auto">
            <form method="POST" action="{{ route('import.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- File Upload -->
                <div id="dropzone" class="border-2 border-dashed border-input rounded-lg p-8 text-center hover:border-primary transition-colors">
                    <svg class="mx-auto h-12 w-12 text-muted-foreground mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <h3 class="text-lg font-semibold mb-2">{{ __('app.import.upload.title') }}</h3>
                    <p class="text-sm text-muted-foreground mb-4">
                        {{ __('app.import.upload.description') }}
                    </p>
                    
                    <input type="file" 
                           id="file-input"
                           name="file" 
                           accept=".csv,.xlsx,.xls" 
                           required
                           class="block w-full text-sm text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-primary file:text-primary-foreground hover:file:bg-primary/90">
                    
                    <p id="file-name" class="text-xs text-muted-foreground mt-2">
                        {{ __('app.import.upload.supports') }}
                    </p>
                </div>

                <!-- Processing Options -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">{{ __('app.import.options.title') }}</h3>
                    
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="create_categories" value="1" checked class="h-4 w-4 text-primary focus:ring-ring border-input rounded">
                            <span class="ml-2 text-sm text-foreground">{{ __('app.import.options.create_categories') }}</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" name="skip_duplicates" value="1" checked class="h-4 w-4 text-primary focus:ring-ring border-input rounded">
                            <span class="ml-2 text-sm text-foreground">{{ __('app.import.options.skip_duplicates') }}</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" name="validate_isbn" value="1" class="h-4 w-4 text-primary focus:ring-ring border-input rounded">
                            <span class="ml-2 text-sm text-foreground">{{ __('app.import.options.validate_isbn') }}</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" 
                            class="px-8 py-3 bg-primary text-primary-foreground rounded-md text-lg font-medium hover:bg-primary/90 transition-colors">
                        {{ __('app.import.upload.process_file') }}
                    </button>
                </div>
            </form>

            <!-- Template Actions -->
            <div class="text-center mt-8">
                <p class="text-sm text-muted-foreground mb-4">
                    {{ __('app.import.instructions.note') }}
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <!-- Download Template -->
                    <a href="{{ route('template.download') }}" 
                       class="inline-flex items-center px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ __('app.template.download') }}
                    </a>
                    
                    <!-- Upload Template -->
                    <form method="POST" action="{{ route('template.upload') }}" enctype="multipart/form-data" class="inline">
                        @csrf
                        <label class="inline-flex items-center px-4 py-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground rounded-md text-sm font-medium transition-colors cursor-pointer">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            {{ __('app.template.upload') }}
                            <input type="file" name="template_file" accept=".csv,.xlsx,.xls" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Drag and drop functionality
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('file-input');
    const fileName = document.getElementById('file-name');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropzone.classList.add('border-primary', 'bg-primary/5');
    }

    function unhighlight(e) {
        dropzone.classList.remove('border-primary', 'bg-primary/5');
    }

    // Handle dropped files
    dropzone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            fileInput.files = files;
            updateFileName(files[0].name);
        }
    }

    // Update file name when file is selected
    fileInput.addEventListener('change', function(e) {
        if (this.files.length > 0) {
            updateFileName(this.files[0].name);
        }
    });

    function updateFileName(name) {
        fileName.textContent = 'Archivo seleccionado: ' + name;
        fileName.classList.add('font-semibold', 'text-foreground');
    }

    // Click on dropzone to trigger file input
    dropzone.addEventListener('click', function(e) {
        if (e.target !== fileInput) {
            fileInput.click();
        }
    });
</script>
@endsection
