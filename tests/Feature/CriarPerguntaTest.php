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
       'pergunta' => str_repeat('*', 260) . '?',
    ]);

    // Asserr :: verificar

    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('perguntas', 1);
    assertDatabaseHas('perguntas', ['pergunta' => str_repeat('*', 260) . '?']);

});

it('Deveria verificar se termina com ponto de interrogação ?', function (){
    // Arrange :: preparar

    $user = User::factory()->create();

    actingAs($user);

    // Act :: agir

    $request = post(route('pergunta.criar'), [

        'pergunta' => str_repeat('*', 10),
        
    ]);

    // Asserr :: verificar

    $request->assertSessionHasErrors([

        'pergunta' => 'Tem certeza que isto é uma pergunta? Faltou o ponto de interrogação no final.'

    ]);

    assertDatabaseCount('perguntas', 0);
});

it('Deve ter pelo menos 10 caracteres', function (){

    // Arrange :: preparar

    $user = User::factory()->create();

    actingAs($user);

    // Act :: agir

    $request = post(route('pergunta.criar'), [
        'pergunta' => str_repeat('*', 8) . '?',
    ]);

    // Asserr :: verificar

    $request->assertSessionHasErrors(['pergunta' => __('validation.min.string', ['min' =>10, 'attribute' => 'pergunta'])]);

    assertDatabaseCount('perguntas', 0);
});
