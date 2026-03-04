@extends('layouts.app')

@section('title', 'Enregistrer mon véhicule')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-car mr-2 text-blue-600"></i>
                        Enregistrer mon véhicule
                    </h1>
                    <p class="text-gray-600">
                        Vous devez enregistrer un véhicule avant de pouvoir proposer des trajets.
                    </p>
                </div>
                {{-- Afficher TOUTES les erreurs --}}
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <h4 class="font-bold">Erreurs :</h4>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Afficher les anciennes valeurs --}}
@php
    \Log::info('Old values:', old());
@endphp
                <form action="{{ route('vehicule.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-6">
                        {{-- Photo du véhicule --}}
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Photo du véhicule
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label for="photo" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-php5 pb-6">
                                        <i class="fas fa-camera text-4xl text-gray-400 mb-4"></i>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Cliquez pour uploader</span>
                                            ou glissez-déposez
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG (Max. 2MB)</p>
                                    </div>
                                    <input id="photo" name="photo" type="file" class="hidden" accept="image/*" />
                                </label>
                            </div>
                            <div id="photo-preview" class="mt-4 hidden">
                                <p class="text-sm text-gray-700 mb-2">Aperçu :</p>
                                <img id="preview-image" class="max-w-xs rounded-lg shadow">
                            </div>
                        </div>
                        
                        {{-- Plaque d'immatriculation --}}
                        <div>
                            <label for="plaque" class="block text-sm font-medium text-gray-700 mb-2">
                                Numéro de plaque <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="plaque" id="plaque" value="{{ old('plaque') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ex: AB-123-CD" required>
                            @error('plaque')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description du véhicule <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="4" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Modèle, couleur, nombre de places, particularités..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Boutons --}}
                        <div class="flex justify-end space-x-4 pt-6">
                            <a href="{{ route('home') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                <i class="fas fa-save mr-2"></i>
                                Enregistrer mon véhicule
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Prévisualisation de la photo
    document.getElementById('photo').addEventListener('change', function(e) {
        const preview = document.getElementById('photo-preview');
        const previewImage = document.getElementById('preview-image');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.remove('hidden');
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection