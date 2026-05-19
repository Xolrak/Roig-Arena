<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = [
            [
                'nombre' => 'CUARTO AZUL TOUR - Aitana',
                'descripcion_corta' => 'La gira más esperada del año llega al Roig Arena.',
                'descripcion_larga' => 'No te pierdas el espectacular concierto de Aitana, presentando sus últimos éxitos en un show único lleno de energía.',
                'poster_url' => 'https://image.europafm.com/clipping/cmsimages01/2025/05/10/6CF32283-8EC7-4FD7-B2AC-58940488A7D1/aitana-portada-album-cuarto-azul_103.jpg?crop=2048,1536,x0,y114&width=800&height=600&optimize=low&format=webply',
                'fecha' => '2026-06-15',
                'hora' => '21:00',
            ],
            [
                'nombre' => 'FINAL FOUR EUROLIGA - Exclusivo Amic Taronja',
                'descripcion_corta' => 'Emisión exclusiva para Amic Taronja.',
                'descripcion_larga' => 'Vive la gran final de la Final Four de la Euroliga en directo a través de nuestras pantallas gigantes. Acceso exclusivo para la familia Amic Taronja.',
                'poster_url' => 'https://img2.rtve.es/n/17067986?w=800&h=600',
                'fecha' => '2026-05-24',
                'hora' => '20:00',
            ],
            [
                'nombre' => 'SOY TU SUPERHEROE TOUR - Melendi',
                'descripcion_corta' => 'Melendi vuelve a Valencia con su nueva gira.',
                'descripcion_larga' => 'Disfruta de los grandes clásicos y las nuevas canciones de Melendi en un ambiente inmejorable.',
                'poster_url' => 'https://image.europafm.com/clipping/cmsimages01/2016/10/29/FD5F970C-F009-4983-A342-008BAC4FE65B/104.jpg?crop=1500,1500,x0,y0&width=800&height=600&optimize=low&format=webply',
                'fecha' => '2026-09-10',
                'hora' => '21:30',
            ],
            [
                'nombre' => 'BELLODRAMA TOUR - Ana Mena',
                'descripcion_corta' => 'El gran show de Ana Mena.',
                'descripcion_larga' => 'Baila sin parar con Ana Mena en su paso por el Roig Arena. ¡Un espectáculo imperdible!',
                'poster_url' => 'https://image.europafm.com/clipping/cmsimages01/2023/02/09/23AF9756-F8C5-4E7D-AAFA-39E999450173/ana-mena-publica-tracklist-bellodrama-desvela-portada-disco_103.jpg?crop=887,665,x0,y0&width=800&height=600&optimize=low&format=webply',
                'fecha' => '2026-10-05',
                'hora' => '20:30',
            ],
        ];

        foreach ($eventos as $evento) {
            Evento::create($evento);
        }

        $this->command->info('✅ Eventos creados: ' . count($eventos));
    }
}