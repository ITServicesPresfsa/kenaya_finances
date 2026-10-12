<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'MoneyGram',
                'slug' => 'moneygram',
                'short_description' => 'Envoyez et recevez de l\'argent en quelques minutes, partout dans le monde.',
                'description' => '<p>Avec MoneyGram, envoyez et recevez de l\'argent en quelques minutes, partout dans le monde. Ce service est idéal pour soutenir vos proches à l\'international en toute sécurité, avec un réseau étendu de partenaires à travers le globe.</p><p>Notre équipe vous accompagne à chaque étape de votre transfert, du remplissage du formulaire jusqu\'à la confirmation de la transaction.</p>',
                'icon' => 'bi-globe-americas',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'RIA',
                'slug' => 'ria',
                'short_description' => 'Des transferts d\'argent rapides, abordables et fiables pour tous vos besoins.',
                'description' => '<p>Ria facilite les transferts d\'argent rapides et abordables. Que ce soit pour des besoins familiaux ou professionnels, bénéficiez d\'un service fiable et simple d\'utilisation.</p><p>Grâce à notre réseau Ria, vos proches reçoivent les fonds rapidement, où qu\'ils se trouvent.</p>',
                'icon' => 'bi-currency-exchange',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'MTN Mobile Money',
                'slug' => 'mtn-mobile-money',
                'short_description' => 'Effectuez vos dépôts et retraits MTN Mobile Money directement en agence.',
                'description' => '<p>Effectuez vos dépôts et retraits au sein de nos agences. Pratique, sécurisé et toujours à portée de main, c\'est la solution mobile pour gérer vos finances au quotidien.</p><p>Le service MTN Mobile Money vous permet de garder le contrôle de vos transactions en toute simplicité.</p>',
                'icon' => 'bi-phone',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Airtel Money',
                'slug' => 'airtel-money',
                'short_description' => 'Gérez vos transactions courantes facilement avec Airtel Money.',
                'description' => '<p>Airtel Money vous permet de gérer vos transactions courantes facilement : transferts d\'argent ou encore achats de crédit. Profitez d\'un service rapide et accessible où que vous soyez.</p><p>Disponible dans nos agences, le service Airtel Money simplifie votre quotidien financier.</p>',
                'icon' => 'bi-wallet2',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Cartes et recharges Visa',
                'slug' => 'cartes-recharges-visa',
                'short_description' => 'Rechargez vos cartes Visa prépayées en partenariat avec UBA et ECOBANK.',
                'description' => '<p>Rechargez vos cartes Visa prépayées en toute sécurité pour vos paiements en ligne ou vos voyages. Grâce à nos partenariats avec <strong>UBA</strong> et <strong>ECOBANK</strong>, nous vous offrons un service rapide, fiable et accessible pour gérer vos recharges à tout moment.</p><p>Idéal pour les achats en ligne, les abonnements numériques et les voyages à l\'international.</p>',
                'icon' => 'bi-credit-card',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        $this->command->info('✅ Services Kenaya Finances créés (5 services).');
    }
}
