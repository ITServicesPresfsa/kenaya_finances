<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name',           'label' => 'Nom du site',            'value' => 'Kenaya Finances'],
            ['key' => 'site_slogan',          'label' => 'Slogan',                 'value' => 'Vos solutions de transfert et de paiement en toute confiance'],
            ['key' => 'contact_phone',        'label' => 'Téléphone',              'value' => '+242 06 497 33 49'],
            ['key' => 'contact_email',        'label' => 'Email',                  'value' => 'contact@kenayafinances.com'],
            ['key' => 'contact_address',      'label' => 'Adresse',                'value' => '219 Avenue Nelson Mandela, Brazzaville, République du Congo'],
            ['key' => 'social_facebook',      'label' => 'Facebook',               'value' => 'https://www.facebook.com/kenayacg/'],
            ['key' => 'social_instagram',     'label' => 'Instagram',              'value' => 'https://www.instagram.com/kenayafinances'],
            ['key' => 'social_tiktok',        'label' => 'TikTok',                 'value' => 'https://www.tiktok.com/@kenaya_finances'],
            ['key' => 'social_linkedin',      'label' => 'LinkedIn',               'value' => 'https://cg.linkedin.com/company/kenaya-finances'],
            ['key' => 'social_youtube',       'label' => 'YouTube',                'value' => 'https://www.youtube.com/@kenayafinances'],
            ['key' => 'about_intro',          'label' => 'Intro À propos',         'value' => 'Kenaya Finances est une entreprise de services financiers basée à Brazzaville, en République du Congo. Nous accompagnons nos clients dans leurs besoins de transfert d\'argent et de paiement, avec un engagement constant envers la sécurité, la transparence et la proximité.'],
            ['key' => 'meta_description',     'label' => 'Méta description globale', 'value' => 'Kenaya Finances — Vos solutions de transfert et de paiement à Brazzaville, République du Congo. MoneyGram, RIA, MTN Mobile Money, Airtel Money, recharges Visa.'],
            ['key' => 'notification_email',   'label' => 'Email de notification',   'value' => 'contact@kenayafinances.com'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'label' => $setting['label']]
            );
        }

        $this->command->info('✅ Paramètres initialisés.');
    }
}
