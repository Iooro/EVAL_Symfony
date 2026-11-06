<?php

namespace App\DataFixtures;

use App\Entity\{Artiste, Benevole, Lieu, Oeuvre, Photo, Technique};
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // Instantané du catalogue local. Aucun ancien mot de passe n’est exporté.
        $data = json_decode(<<<'JSON'

{
    "benevoles": [
        {
            "id": 1,
            "email": "mail.test@gmail.com",
            "roles": [],
            "nom": "Test",
            "prenom": "Testeur"
        },
        {
            "id": 2,
            "email": "mail.test2@gmail.com",
            "roles": [],
            "nom": "Test2",
            "prenom": "Testeur2"
        }
    ],
    "artistes": [
        {
            "id": 3,
            "pseudonyme": "Nacre",
            "nomReel": null,
            "bio": "Artiste fictif du jeu de démonstration ; aucune attribution réelle des œuvres photographiées.",
            "nationalite": "Fictive"
        },
        {
            "id": 4,
            "pseudonyme": "Sillage",
            "nomReel": null,
            "bio": "Artiste fictif du jeu de démonstration ; aucune attribution réelle des œuvres photographiées.",
            "nationalite": "Fictive"
        },
        {
            "id": 5,
            "pseudonyme": "Kroma",
            "nomReel": null,
            "bio": "Artiste fictif du jeu de démonstration ; aucune attribution réelle des œuvres photographiées.",
            "nationalite": "Fictive"
        },
        {
            "id": 6,
            "pseudonyme": "Ligne Libre",
            "nomReel": null,
            "bio": "Artiste fictif du jeu de démonstration ; aucune attribution réelle des œuvres photographiées.",
            "nationalite": "Fictive"
        },
        {
            "id": 7,
            "pseudonyme": "Brume",
            "nomReel": null,
            "bio": "Artiste fictif du jeu de démonstration ; aucune attribution réelle des œuvres photographiées.",
            "nationalite": "Fictive"
        }
    ],
    "techniques": [
        {
            "id": 2,
            "nom": "Aérosol"
        },
        {
            "id": 3,
            "nom": "Peinture murale"
        },
        {
            "id": 4,
            "nom": "Pochoir"
        },
        {
            "id": 5,
            "nom": "Pinceau"
        },
        {
            "id": 6,
            "nom": "Rouleau"
        },
        {
            "id": 7,
            "nom": "Lettrage"
        },
        {
            "id": 8,
            "nom": "Aplats géométriques"
        },
        {
            "id": 9,
            "nom": "Techniques mixtes"
        }
    ],
    "lieux": [
        {
            "id": 2,
            "nom": "Passage des Ateliers",
            "adresse": "1 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 1",
            "latitude": "48.85",
            "longitude": "2.34"
        },
        {
            "id": 3,
            "nom": "Cour des Couleurs",
            "adresse": "2 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 2",
            "latitude": "48.851",
            "longitude": "2.341"
        },
        {
            "id": 4,
            "nom": "Square des Fresques",
            "adresse": "3 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 3",
            "latitude": "48.852",
            "longitude": "2.342"
        },
        {
            "id": 5,
            "nom": "Allée du Canal",
            "adresse": "4 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 4",
            "latitude": "48.853",
            "longitude": "2.343"
        },
        {
            "id": 6,
            "nom": "Mur des Rencontres",
            "adresse": "5 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 5",
            "latitude": "48.854",
            "longitude": "2.344"
        },
        {
            "id": 7,
            "nom": "Parvis des Arts",
            "adresse": "6 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 1",
            "latitude": "48.855",
            "longitude": "2.345"
        },
        {
            "id": 8,
            "nom": "Passage des Plumes",
            "adresse": "7 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 2",
            "latitude": "48.856",
            "longitude": "2.346"
        },
        {
            "id": 9,
            "nom": "Cour des Briques",
            "adresse": "8 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 3",
            "latitude": "48.857",
            "longitude": "2.347"
        },
        {
            "id": 10,
            "nom": "Rue des Graphismes",
            "adresse": "9 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 4",
            "latitude": "48.858",
            "longitude": "2.348"
        },
        {
            "id": 11,
            "nom": "Jardin des Murs",
            "adresse": "10 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 5",
            "latitude": "48.859",
            "longitude": "2.349"
        },
        {
            "id": 12,
            "nom": "Place des Créateurs",
            "adresse": "11 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 1",
            "latitude": "48.86",
            "longitude": "2.35"
        },
        {
            "id": 13,
            "nom": "Traverse des Lumières",
            "adresse": "12 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 2",
            "latitude": "48.861",
            "longitude": "2.351"
        },
        {
            "id": 14,
            "nom": "Quai des Pigments",
            "adresse": "13 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 3",
            "latitude": "48.862",
            "longitude": "2.352"
        },
        {
            "id": 15,
            "nom": "Impasse des Regards",
            "adresse": "14 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 4",
            "latitude": "48.863",
            "longitude": "2.353"
        },
        {
            "id": 16,
            "nom": "Promenade des Nuances",
            "adresse": "15 voie fictive — localisation de démonstration",
            "quartier": "Secteur fictif 5",
            "latitude": "48.864",
            "longitude": "2.354"
        }
    ],
    "oeuvres": [
        {
            "id": 2,
            "titre": "Le Baiser — deux regards",
            "date_creation": "2009-01-01",
            "description": "Deux photographies distinctes du Baiser de Dmitri Vrubel à l’East Side Gallery de Berlin : une vue frontale et une vue oblique. Les associations aux artistes et au lieu du catalogue restent fictives.",
            "est_detruite": false,
            "lieu": 2,
            "recouverte": null,
            "artistes": [
                3,
                4
            ],
            "techniques": [
                2,
                5
            ]
        },
        {
            "id": 3,
            "titre": "Les enfants à bicyclette — deux regards",
            "date_creation": "2012-01-01",
            "description": "Deux photographies distinctes de Little Children on a Bicycle d’Ernest Zacharevic à George Town : la fresque intègre un véritable vélo. Les associations aux artistes et au lieu du catalogue restent fictives.",
            "est_detruite": false,
            "lieu": 3,
            "recouverte": null,
            "artistes": [
                4
            ],
            "techniques": [
                3,
                6
            ]
        },
        {
            "id": 4,
            "titre": "Traces de passage",
            "date_creation": "2025-01-25",
            "description": "Des marques et compositions de graffiti occupent la surface d’un mur urbain. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 4,
            "recouverte": null,
            "artistes": [
                5,
                6
            ],
            "techniques": [
                4,
                7
            ]
        },
        {
            "id": 5,
            "titre": "Briques en rythme",
            "date_creation": "2025-02-06",
            "description": "Des formes géométriques colorées animent une façade de briques. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 5,
            "recouverte": null,
            "artistes": [
                6
            ],
            "techniques": [
                5,
                8
            ]
        },
        {
            "id": 6,
            "titre": "Visages entrelacés",
            "date_creation": "2025-02-18",
            "description": "Des visages abstraits et des motifs colorés se mêlent sur un mur de briques. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 6,
            "recouverte": null,
            "artistes": [
                3,
                7
            ],
            "techniques": [
                6,
                9
            ]
        },
        {
            "id": 7,
            "titre": "Traversée animale",
            "date_creation": "2025-03-02",
            "description": "Une fresque animalière accompagne le passage d’un cycliste dans la ville. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 7,
            "recouverte": null,
            "artistes": [
                3
            ],
            "techniques": [
                2,
                7
            ]
        },
        {
            "id": 8,
            "titre": "Éclats primaires",
            "date_creation": "2025-03-14",
            "description": "Une composition abstraite joue avec les couleurs franches et les formes géométriques. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 8,
            "recouverte": null,
            "artistes": [
                4,
                5
            ],
            "techniques": [
                3,
                8
            ]
        },
        {
            "id": 9,
            "titre": "Marbrures urbaines",
            "date_creation": "2025-03-26",
            "description": "Des textures tourbillonnantes évoquent le marbre sur une paroi de béton. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 9,
            "recouverte": null,
            "artistes": [
                5
            ],
            "techniques": [
                4,
                9
            ]
        },
        {
            "id": 10,
            "titre": "L’envol des marches",
            "date_creation": "2025-04-07",
            "description": "Une grande composition d’oiseau coloré dialogue avec un escalier et ses visiteurs. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 10,
            "recouverte": null,
            "artistes": [
                6,
                7
            ],
            "techniques": [
                2,
                5
            ]
        },
        {
            "id": 11,
            "titre": "Oiseau de façade",
            "date_creation": "2025-04-19",
            "description": "Un oiseau multicolore occupe le mur extérieur d’un bâtiment. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 11,
            "recouverte": null,
            "artistes": [
                7
            ],
            "techniques": [
                3,
                6
            ]
        },
        {
            "id": 12,
            "titre": "Jardin de plumes",
            "date_creation": "2025-05-01",
            "description": "Des oiseaux et des fleurs recouvrent une façade dans une composition végétale. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 12,
            "recouverte": null,
            "artistes": [
                3,
                4
            ],
            "techniques": [
                4,
                7
            ]
        },
        {
            "id": 13,
            "titre": "La fleur de la porte bleue",
            "date_creation": "2025-05-13",
            "description": "Une fleur souriante peinte anime une porte bleue dans un mur de béton. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 13,
            "recouverte": null,
            "artistes": [
                4
            ],
            "techniques": [
                5,
                8
            ]
        },
        {
            "id": 14,
            "titre": "Géométrie sur briques",
            "date_creation": "2025-05-25",
            "description": "Des motifs géométriques et des couleurs contrastées structurent un mur texturé. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 14,
            "recouverte": null,
            "artistes": [
                5,
                6
            ],
            "techniques": [
                6,
                9
            ]
        },
        {
            "id": 15,
            "titre": "Fragments chromatiques",
            "date_creation": "2025-06-06",
            "description": "Un cadrage rapproché révèle des motifs de graffiti et la texture du mur. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 15,
            "recouverte": null,
            "artistes": [
                6
            ],
            "techniques": [
                2,
                7
            ]
        },
        {
            "id": 16,
            "titre": "Façade imaginaire",
            "date_creation": "2025-06-18",
            "description": "Des motifs abstraits colorés occupent le mur extérieur d’un immeuble. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 16,
            "recouverte": null,
            "artistes": [
                3,
                7
            ],
            "techniques": [
                3,
                8
            ]
        },
        {
            "id": 17,
            "titre": "Love letters only",
            "date_creation": "2025-06-30",
            "description": "Un message peint LOVE LETTERS ONLY transforme un mur en déclaration urbaine. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 2,
            "recouverte": null,
            "artistes": [
                3
            ],
            "techniques": [
                4,
                9
            ]
        },
        {
            "id": 18,
            "titre": "Le regard de l’enfance",
            "date_creation": "2025-07-12",
            "description": "Un visage d’enfant en noir et blanc est représenté sur un mur urbain. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 3,
            "recouverte": null,
            "artistes": [
                4,
                5
            ],
            "techniques": [
                2,
                5
            ]
        },
        {
            "id": 19,
            "titre": "Les lettres du trottoir",
            "date_creation": "2025-07-24",
            "description": "Des lettres multicolores et des lignes ondulantes couvrent un ancien mur de ciment. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 4,
            "recouverte": null,
            "artistes": [
                5
            ],
            "techniques": [
                3,
                6
            ]
        },
        {
            "id": 20,
            "titre": "Le chat des montagnes",
            "date_creation": "2025-08-05",
            "description": "Une fresque de chat apparaît sur un bâtiment dans un village enneigé. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 5,
            "recouverte": null,
            "artistes": [
                6,
                7
            ],
            "techniques": [
                4,
                7
            ]
        },
        {
            "id": 21,
            "titre": "Écritures nocturnes",
            "date_creation": "2025-08-17",
            "description": "Des inscriptions sur béton accompagnent un portrait urbain dans une lumière sombre. Jeu de démonstration : titre, artistes, techniques, date et lieu fictifs ; photographie illustrative sous licence Pexels.",
            "est_detruite": false,
            "lieu": 6,
            "recouverte": null,
            "artistes": [
                7
            ],
            "techniques": [
                5,
                8
            ]
        }
    ],
    "photos": [
        {
            "id": 6,
            "date_prise_vue": "2020-03-12",
            "nom_fichier": "Photos/demo/berlin-baiser-2020.jpg",
            "etat_oeuvre": "Vue frontale du Baiser de Dmitri Vrubel. Inscriptions et portraits visibles. Photo Gzen92, 12 mars 2020, CC BY-SA 4.0 ; source et licence dans les crédits.",
            "oeuvre": 2
        },
        {
            "id": 7,
            "date_prise_vue": "2024-06-15",
            "nom_fichier": "Photos/demo/berlin-baiser-autre-vue.jpg",
            "etat_oeuvre": "Vue oblique de la même fresque, avec ciel et pied du mur visibles. Date de suivi fictive ; photographie distincte, source Pexels 29049323.",
            "oeuvre": 2
        },
        {
            "id": 8,
            "date_prise_vue": "2013-03-03",
            "nom_fichier": "Photos/demo/penang-velo-2013.jpg",
            "etat_oeuvre": "Vue du mur et du vélo sans visiteur au premier plan. Photo Azreey, 3 mars 2013, CC BY-SA 3.0 ; source et licence dans les crédits.",
            "oeuvre": 3
        },
        {
            "id": 9,
            "date_prise_vue": "2025-01-15",
            "nom_fichier": "Photos/demo/penang-velo-autre-vue.jpg",
            "etat_oeuvre": "Autre vue de la même fresque : un visiteur pose près du vélo ; les marques sur le mur et le vélo diffèrent. Date de suivi fictive ; source Pexels 30867351.",
            "oeuvre": 3
        },
        {
            "id": 10,
            "date_prise_vue": "2026-10-03",
            "nom_fichier": "Photos/demo/oeuvre-5464093-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 4
        },
        {
            "id": 12,
            "date_prise_vue": "2026-10-04",
            "nom_fichier": "Photos/demo/oeuvre-3964508-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 5
        },
        {
            "id": 14,
            "date_prise_vue": "2026-10-05",
            "nom_fichier": "Photos/demo/oeuvre-7951583-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 6
        },
        {
            "id": 16,
            "date_prise_vue": "2026-10-06",
            "nom_fichier": "Photos/demo/oeuvre-32831370-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 7
        },
        {
            "id": 18,
            "date_prise_vue": "2026-10-07",
            "nom_fichier": "Photos/demo/oeuvre-4165343-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 8
        },
        {
            "id": 20,
            "date_prise_vue": "2026-10-08",
            "nom_fichier": "Photos/demo/oeuvre-11646477-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 9
        },
        {
            "id": 22,
            "date_prise_vue": "2026-10-09",
            "nom_fichier": "Photos/demo/oeuvre-40615268-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 10
        },
        {
            "id": 24,
            "date_prise_vue": "2026-10-10",
            "nom_fichier": "Photos/demo/oeuvre-11216911-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 11
        },
        {
            "id": 26,
            "date_prise_vue": "2026-10-11",
            "nom_fichier": "Photos/demo/oeuvre-31588972-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 12
        },
        {
            "id": 27,
            "date_prise_vue": "2026-10-12",
            "nom_fichier": "Photos/demo/oeuvre-33323196-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 13
        },
        {
            "id": 28,
            "date_prise_vue": "2026-10-13",
            "nom_fichier": "Photos/demo/oeuvre-40729733-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 14
        },
        {
            "id": 29,
            "date_prise_vue": "2026-10-14",
            "nom_fichier": "Photos/demo/oeuvre-4165349-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 15
        },
        {
            "id": 30,
            "date_prise_vue": "2026-10-15",
            "nom_fichier": "Photos/demo/oeuvre-15145789-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 16
        },
        {
            "id": 31,
            "date_prise_vue": "2026-10-16",
            "nom_fichier": "Photos/demo/oeuvre-35030844-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 17
        },
        {
            "id": 32,
            "date_prise_vue": "2026-10-17",
            "nom_fichier": "Photos/demo/oeuvre-2053-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 18
        },
        {
            "id": 33,
            "date_prise_vue": "2026-10-18",
            "nom_fichier": "Photos/demo/oeuvre-4133752-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 19
        },
        {
            "id": 34,
            "date_prise_vue": "2026-10-19",
            "nom_fichier": "Photos/demo/oeuvre-35399039-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 20
        },
        {
            "id": 35,
            "date_prise_vue": "2026-10-20",
            "nom_fichier": "Photos/demo/oeuvre-30047305-vue.jpg",
            "etat_oeuvre": "Vue illustrative de l’œuvre ; suivi fictif de démonstration.",
            "oeuvre": 21
        }
    ]
}
JSON, true, 512, JSON_THROW_ON_ERROR);

        foreach ($data['photos'] as $row) {
            if (!is_file($this->projectDir.'/public/'.$row['nom_fichier'])) {
                throw new \RuntimeException('Image absente : '.$row['nom_fichier']);
            }
        }

        $owner = null;
        foreach ($data['benevoles'] as $row) {
            $benevole = (new Benevole())->setEmail($row['email'])
                ->setNom($row['nom'])->setPrenom($row['prenom'])->setRoles($row['roles']);
            $benevole->setPassword($this->passwordHasher->hashPassword($benevole, '123'));
            $manager->persist($benevole);
            if ($row['email'] === 'mail.test@gmail.com') {
                $owner = $benevole;
            }
        }
        if ($owner === null) {
            throw new \RuntimeException('Le compte propriétaire est absent du catalogue.');
        }

        $artistes = [];
        foreach ($data['artistes'] as $row) {
            $artiste = (new Artiste())->setPseudonyme($row['pseudonyme'])
                ->setNomReel($row['nomReel'])->setBio($row['bio'])->setNationalite($row['nationalite']);
            $manager->persist($artiste);
            $artistes[$row['id']] = $artiste;
        }
        $techniques = [];
        foreach ($data['techniques'] as $row) {
            $technique = (new Technique())->setNom($row['nom']);
            $manager->persist($technique);
            $techniques[$row['id']] = $technique;
        }
        $lieux = [];
        foreach ($data['lieux'] as $row) {
            $lieu = (new Lieu())->setNom($row['nom'])->setAdresse($row['adresse'])
                ->setQuartier($row['quartier'])->setLatitude($row['latitude'])->setLongitude($row['longitude']);
            $manager->persist($lieu);
            $lieux[$row['id']] = $lieu;
        }
        $oeuvres = [];
        foreach ($data['oeuvres'] as $row) {
            $oeuvre = (new Oeuvre())->setTitre($row['titre'])->setDescription($row['description'])
                ->setDateCreation(new \DateTime($row['date_creation']))->setEstDetruite($row['est_detruite'])
                ->setIdLieu($row['lieu'] === null ? null : $lieux[$row['lieu']]);
            foreach ($row['artistes'] as $id) {
                $oeuvre->addIdArtiste($artistes[$id]);
            }
            foreach ($row['techniques'] as $id) {
                $oeuvre->addIdTechnique($techniques[$id]);
            }
            $manager->persist($oeuvre);
            $oeuvres[$row['id']] = $oeuvre;
        }
        foreach ($data['oeuvres'] as $row) {
            if ($row['recouverte'] !== null) {
                $oeuvres[$row['id']]->setIdOeuvreRecouverte($oeuvres[$row['recouverte']]);
            }
        }
        foreach ($data['photos'] as $row) {
            $photo = (new Photo())->setNomFichier($row['nom_fichier'])
                ->setDatePriseVue(new \DateTime($row['date_prise_vue']))->setEtatOeuvre($row['etat_oeuvre'])
                ->setIdBenevole($owner);
            $oeuvres[$row['oeuvre']]->addPhoto($photo);
            $manager->persist($photo);
        }
        $manager->flush();
    }
}
