<?php

return [
    'required' => 'Le champ :attribute est obligatoire.',
    'string' => 'Le champ :attribute doit être un texte.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'image' => 'Le champ :attribute doit être une image.',
    'mimes' => 'Le champ :attribute doit être un fichier de type : :values.',
    'exists' => 'La valeur choisie pour :attribute est invalide.',
    'unique' => 'La valeur de :attribute est déjà utilisée.',
    'in' => 'La valeur choisie pour :attribute est invalide.',
    'date' => 'Le champ :attribute n\'est pas une date valide.',
    'uploaded' => 'Le fichier du champ :attribute n\'a pas pu être téléversé (taille ou configuration PHP).',

    'max' => [
        'string' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
        'file' => 'Le fichier :attribute ne doit pas dépasser :max Ko.',
        'numeric' => 'Le champ :attribute ne doit pas dépasser :max.',
        'array' => 'Le champ :attribute ne doit pas contenir plus de :max éléments.',
    ],

    'attributes' => [
        'title' => 'titre',
        'slug' => 'slug',
        'excerpt' => 'extrait',
        'content' => 'contenu',
        'featured_image' => 'image de couverture',
        'category_id' => 'catégorie',
        'status' => 'statut',
        'published_at' => 'date de publication',
        'meta_title' => 'titre SEO',
        'meta_description' => 'description SEO',
        'name' => 'nom',
        'email' => 'adresse e-mail',
        'phone' => 'téléphone',
        'subject' => 'sujet',
        'message' => 'message',
        'password' => 'mot de passe',
    ],
];