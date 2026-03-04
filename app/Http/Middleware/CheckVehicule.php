<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasVehicule
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->vehicule) {
            return redirect()->route('vehicule.create')
                ->with('warning', 'Vous devez enregistrer un véhicule avant de pouvoir proposer des trajets.');
        }

        return $next($request);
    }
}