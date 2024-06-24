<?php

namespace App\Http\Controllers;

use App\Models\Pergunta;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PerguntaController extends Controller
{
    public function store (): RedirectResponse
    {
        $attributes = \request()->validate([
            'pergunta' => [
                'required',
                'min:10',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value[strlen($value) - 1] != '?') {
                        $fail("Tem certeza que isto é uma pergunta? Faltou o ponto de interrogação no final.");
                    }
                }
            ]
        ]);

        Pergunta::query()->create($attributes);

        return to_route('dashboard');
    }
}
