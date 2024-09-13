<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

it('Should be able to create a new question bigger than 255 characters', function () {
    // Ao desenvolver teste você sempre precisa lembrar dos AAA

    // Arrange = Preparar
    $user = User::factory()->create(); //Criar usuário

    actingAs($user); //Logar com o usuário

    // Act = Agir
    post(route('question.store'), [
        'question' => str_repeat('*', 260) . '?', //Cria a pergunta
    ]);

    //Assert = Verificar
    $request = post(route('dashboard'));

    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);

});

it('Should check if ends with question mark ?', function () {
    $user = User::factory()->create();
    actingAs($user);

    $request = post(route('question.store'), [
        'question' => str_repeat('*', 10),
    ]);

    $request->assertSessionHasErrors([
        'question' => 'Are you sure that is a question? It is missing the question mark in the end.',
    ]);
    assertDatabaseCount('questions', 0);
});

it('Should have at least 10 charascters', function () {
    $user = User::factory()->create();
    actingAs($user);

    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseCount('questions', 0);
});
