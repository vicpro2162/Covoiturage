
@extends('layouts.app')

@section('title', 'Modifier mon véhicule')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-car mr-2 text-blue-600"></i>
                        Modifier mon véhicule
                    </h1>
                    <p class="text-gray-600">
                        Mettez à jour les informations de votre véhicule.
                    </p>
                </div>
                
                {{-- Aperçu de la photo actuelle --}}
                @if($vehicule->photo)
                <div class="mb-6">
                    <p class="text-sm font-medium text-gray-700 mb-2">Photo actuelle :</p>
                    <img src="{{ asset('storage/' . $vehicule->photo) }}"
                        alt="Véhicule"
                        class="w-64 h-auto rounded-lg shadow">
                </div>
                @endif
                
                <form action="{{ route('vehicule.update', $vehicule) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        {{-- Nouvelle photo --}}
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Changer la photo
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label for="photo" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-camera text-3xl text-gray-400 mb-3"></i>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Nouvelle photo</span>
                                        </p>
                                        <p class="text-xs text-gray-500">Laisser vide pour garder l'actuelle</p>
                                    </div>
                                    <input id="photo" name="photo" type="file" class="hidden" accept="image/*" />
                                </label>
                            </div>
                        </div>
                        
                        {{-- Plaque --}}
                        <div>
                            <label for="plaque" class="block text-sm font-medium text-gray-700 mb-2">
                                Numéro de plaque <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                name="plaque"
                                id="plaque"
                                value="{{ old('plaque', $vehicule->plaque) }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            @error('plaque')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description"
                                    id="description"
                                    rows="4"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>{{ old('description', $vehicule->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Boutons --}}
                        <div class="flex justify-between pt-6">
                            <a href="{{ route('home') }}"
                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                                Retour à l'accueil
                            </a>
                            <div class="space-x-4">
                                <a href="{{ route('vehicule.create') }}"
                                class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                                    Annuler
                                </a>
                                <button type="submit"
                                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                    <i class="fas fa-sync mr-2"></i>
                                    Mettre à jour
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection