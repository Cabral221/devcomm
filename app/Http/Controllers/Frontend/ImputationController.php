<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Domains\Imputation\Mail\Acknowledgment;
use App\Domains\Imputation\Mail\RequestImputation;
use App\Domains\Imputation\Services\ImputationService;

class ImputationController extends Controller
{

    public function index()
    {
        return view('frontend.pages.imputation');
    }

    public function store(Request $request, ImputationService $imputationService)
    {
        $request->agent = $request->first_name . ' ' . $request->last_name;

        // Valider les donnees
        $request->validate([
            'sick_name' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|integer',
            'registration_number' => 'required|string',
            'service' => 'required|string',
            'fonction' => 'required|string',
        ]);

        // Enregistrer dans la base de données
        $imputation = $imputationService->create($request->all());

        // Notifier l'admin par mail
        Mail::to(User::first()->email)->send(new RequestImputation($imputation->last_name));
        // Notifier l'user par mail
        Mail::to($imputation->email)->send(new Acknowledgment());

        // Alert success message and return redirect to index of imputation
        return redirect()
                ->route('frontend.imputation.index')
                ->with(['flash_success' => 'Votre Demande a bien été transmise au service Ressources Humaines du MDCSNEST']);
    }
}
