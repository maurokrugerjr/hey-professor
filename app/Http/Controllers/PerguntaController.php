<?php

namespace App\Http\Controllers;

use App\Models\Pergunta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PerguntaController extends Controller
{
    public function criar (): RedirectResponse
    {
        $attributes = \request()->validate([
            'question' => ['required']
        ]);

        Pergunta::query()->create($attributes);

        return to_route('dashboard');
    }
}
