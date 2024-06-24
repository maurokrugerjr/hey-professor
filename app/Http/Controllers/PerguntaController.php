<?php

namespace App\Http\Controllers;

use App\Models\Pergunta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PerguntaController extends Controller
{
    public function store (): RedirectResponse
    {
        $attributes = \request()->validate([
            'pergunta' => ['required', 'min:10']
        ]);

        Pergunta::query()->create($attributes);

        return to_route('dashboard');
    }
}
