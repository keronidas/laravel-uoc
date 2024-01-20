<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EventoCulturalSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) { // Generar 20 eventos ficticios
            $nombreEvento = $faker->sentence;
            $fecha = $faker->date('Y-m-d', '+1 year'); // Fecha aleatoria dentro del próximo año
            $ubicacion = $faker->address; // Ubicación ficticia generada por Faker
            $descripcion = $faker->paragraph;
            $autor = $faker->name; // Nombre ficticio del autor u organizador
            $imagen = $faker->imageUrl(); // URL de imagen ficticia

            \App\Models\EventoCultural::create([
                'nombre_evento' => $nombreEvento,
                'fecha' => $fecha,
                'ubicacion' => $ubicacion,
                'descripcion' => $descripcion,
                'autor' => $autor,
                'imagen' => $imagen
            ]);
        }
    }
}
