<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('Deve ser capaz de criar uma nova pergunta com mais de 255 caracteres', function (){

    //AAA

    // Arrange :: preparar

    $user = User::factory()->create();

    actingAs($user);

    // Act :: agir

    $request = post(route('pergunta.criar'), [
       'question' => str_repeat('*', 260) . '?',
    ]);

    // Asserr :: verificar

    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('perguntas', 1);
    assertDatabaseHas('perguntas', ['question' => str_repeat('*', 260) . '?']);

});

it('Deveria verificar se termina com ponto de interrogação ?', function (){


});

it('Deve ter pelo menos 10 caracteres', function (){

    // Arrange :: preparar

    $user = User::factory()->create();

    actingAs($user);

    // Act :: agir

    $request = \Pest\Laravel\post(route('pergunta.criar'), [
        'question' => str_repeat('*', 9) . '?',
    ]);

    // Asserr :: verificar

    $request->assertSessionHasErrors(['question']);

    \Pest\Laravel\assertDatabaseHas('questions', ['question' => 0]);
});
