<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training>
 */
class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    $turmas = [
        "Exercícios de coordenação motora com obstáculos e cones", 
        "Atividades lúdicas focadas em tomada de decisão rápida", 
        "Trabalhos de passe com diferentes distâncias e recepções", 
        "Mini-jogos para simular situações reais de jogo", 
        "Finalizações com ambos os pés em curta distância", 
        "Jogos reduzidos para desenvolver raciocínio e posicionamento", 
        "Condução da bola em slalom, com foco em controle", 
        "Situações de 1x1 ofensivas e defensivas com metas", 
        "Organização tática básica e noções de ocupação de espaço", 
        "Construção de jogadas desde a defesa até o ataque", 
        "Desafios técnicos cronometrados com avaliação de performance", 
        "Partidas amistosas internas para aplicar os conteúdos", 
        "Aquecimento tático com movimentações ofensivas programadas", 
        "Exercícios de triangulações em zonas ofensivas", 
        "Compactação defensiva com linha de quatro defensores", 
        "Cobertura em jogadas de ultrapassagem no setor lateral", 
        "Treino coletivo simulando situações reais de jogo oficial", 
        "Execução e marcação em bolas paradas ofensivas e defensivas"
    ];

        return [
            'planejamento' => $this->faker->randomElement($turmas),
            'date_training' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
        ];
    }
}