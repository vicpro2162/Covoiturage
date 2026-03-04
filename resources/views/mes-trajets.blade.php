@extends('layouts.app')

@section('title', 'Mes Trajets - Covoiturage Lomé')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">

    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
            <i class="fas fa-history text-blue-600 mr-3"></i> Mes Trajets
        </h1>
        <p class="text-gray-600">Consultez tous vos trajets proposés. Modifiez ou supprimez vos trajets selon vos besoins.</p>
    </div>

    <!-- Messages flash -->
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 text-green-800 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-red-50 text-red-800 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Bouton créer trajet -->
    @if(auth()->user()->vehicule)
        <div class="mb-6 flex justify-end">
            <a href="{{ route('trajets.create') }}" class="inline-flex items-center px-5 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-plus mr-2" style="color:blue"></i> <h6 style="color:blue">Proposer un trajet</h6>
            </a>
        </div>
    @else
        <div class="mb-6 px-4 py-3 rounded-lg bg-yellow-50 text-yellow-800 flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Vous devez enregistrer un véhicule pour proposer des trajets.
            <a href="{{ route('vehicule.create') }}" class="ml-2 font-semibold underline">Enregistrer mon véhicule</a>
        </div>
    @endif

    <!-- Filtres -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow border border-gray-200">
        <h5 class="font-semibold text-gray-900 mb-3 flex items-center">
            <i class="fas fa-filter text-blue-600 mr-2"></i> Filtrer mes trajets
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                <select id="statut" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" onchange="filterTrajets()">
                    <option value="tous">Tous les trajets</option>
                    <option value="futurs">Trajets à venir</option>
                    <option value="passes">Trajets passés</option>
                </select>
            </div>
            <div>
                <label for="tri" class="block text-sm font-medium text-gray-700">Trier par</label>
                <select id="tri" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" onchange="filterTrajets()">
                    <option value="date_desc">Date (plus récent)</option>
                    <option value="date_asc">Date (plus ancien)</option>
                    <option value="places">Places disponibles</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des trajets -->
    @if($trajets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="trajets-list">
            @foreach($trajets as $trajet)
                <div class="trajet-card bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-all"
                    data-date="{{ $trajet->date_trajet->format('Y-m-d H:i:s') }}"
                    data-statut="{{ $trajet->date_trajet >= now() ? 'futurs' : 'passes' }}"
                    data-places="{{ $trajet->places_disponibles }}">
                    
                    <div class="p-6">

                        <!-- Header -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    {{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    {{ $trajet->date_trajet->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 {{ $trajet->date_trajet >= now() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }} font-bold rounded-full text-sm">
                                {{ $trajet->places_disponibles }} place(s)
                            </span>
                        </div>

                        <!-- Lieux -->
                        <div class="space-y-3 mb-6">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="flex items-center text-red-600">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span class="font-semibold">Départ :</span> {{ $trajet->lieu_depart }}
                                </div>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="flex items-center text-green-600">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span class="font-semibold">Arrivée :</span> {{ $trajet->lieu_arrivee }}
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="border-t pt-4 mt-4 flex justify-between items-center">
                            <a href="{{ route('trajets.show', $trajet) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-sm">
                                Voir détails
                            </a>

                            <div class="space-x-2">
                                @if($trajet->date_trajet >= now())
                                    <a href="#" class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-lg text-sm" data-bs-toggle="modal" data-bs-target="#editTrajetModal{{ $trajet->id }}">Modifier</a>
                                    <form action="{{ route('trajets.destroy', $trajet) }}" method="POST" class="inline" onsubmit="return confirm('Voulez-vous supprimer ce trajet ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-200 text-red-800 rounded-lg text-sm">Supprimer</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20">
            <i class="fas fa-route text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl text-gray-700 mb-2">Vous n'avez pas encore proposé de trajet</h3>
            <p class="text-gray-500 mb-6">Proposez votre premier trajet pour aider d'autres personnes à se déplacer.</p>
            @if(auth()->user()->vehicule)
                <a href="{{ route('trajets.create') }}" class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                    Proposer un trajet
                </a>
            @else
                <a href="{{ route('vehicule.create') }}" class="px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition">
                    Enregistrer mon véhicule
                </a>
            @endif
        </div>
    @endif

</div>

<script>
function filterTrajets() {
    const statut = document.getElementById('statut').value;
    const tri = document.getElementById('tri').value;
    const trajets = document.querySelectorAll('.trajet-card');

    trajets.forEach(trajet => {
        const trajetStatut = trajet.getAttribute('data-statut');
        const isVisible = statut === 'tous' || statut === trajetStatut;
        trajet.style.display = isVisible ? 'block' : 'none';
    });

    // Trier les trajets visibles
    const container = document.getElementById('trajets-list');
    Array.from(container.children)
        .sort((a, b) => {
            switch(tri) {
                case 'date_desc': return new Date(b.dataset.date) - new Date(a.dataset.date);
                case 'date_asc': return new Date(a.dataset.date) - new Date(b.dataset.date);
                case 'places': return b.dataset.places - a.dataset.places;
            }
        })
        .forEach(node => container.appendChild(node));
}

document.addEventListener('DOMContentLoaded', filterTrajets);
</script>

<style>
.trajet-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.trajet-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
</style>
@endsection
