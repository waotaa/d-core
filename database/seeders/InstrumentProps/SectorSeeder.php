<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\Sector;
use Illuminate\Database\Seeder;

/**
 * Sectoren
 *
 * For sbi (Standaard bedrijfsindeling) groups see:
 * https://sbi.cbs.nl/cbs.typeermodule.typeerservicewebapi/content/angular/app/#/tree
 *
 * A - Landbouw, bosbouw, visserij
 * B - Winning van delfstoffen
 * C - Industrie
 * D - Productie en distributie van en handel in elektriciteit, aardgas, stoom en gekoelde lucht
 * E - Winning en distributie van water; afval- en afvalwaterbeheer en sanering
 * F - Bouwnijverheid
 * G - Groot- en detailhandel; reparatie van auto's
 * H - Vervoer en opslag
 * I - Logies-, maaltijd- en drankverstrekking
 * J - Informatie en communicatie
 * K - Financiële instellingen
 * L - Verhuur van en handel in onroerend goed
 * M - Advisering, onderzoek en overige specialistische zakelijke dienstverlening
 * N - Verhuur van roerende goederen en overige zakelijke dienstverlening
 * O - Openbaar bestuur, overheidsdiensten en verplichte sociale verzekeringen
 * P - Onderwijs
 * Q - Gezondheid- en welzijnszorg
 * R - Cultuur, sport en recreatie
 * S - Overige dienstverlening
 * T - Huishoudens als werkgever; niet-gedifferentieerde productie van goederen en diensten door huishoudens voor eigen gebruik
 * U - Extraterritoriale organisaties en lichamen
 *
 */
class SectorSeeder extends Seeder
{
    public function run(): void
    {
        Sector::query()->updateOrCreate([
            'description' => 'Landbouw, Natuur, Milieu',
        ],[
            'sbi_group' => 'A'
            // A - Landbouw, bosbouw, visserij
        ]);
        Sector::query()->updateOrCreate([
            'description' => 'Bouw',
        ],[
            'sbi_group' => 'F'
            // F - Bouwnijverheid
        ]);
        Sector::query()->updateOrCreate([
            'description' => 'Detailhandel',
        ],[
            'sbi_group' => 'G'
            // G - Groot- en detailhandel; reparatie van auto's
        ]);
        Sector::query()->updateOrCreate([
            'description' => 'Administratie, Automatisering, ICT',
        ],[
            'sbi_group' => 'J'
            // J - Informatie en communicatie
        ]);
        Sector::query()->updateOrCreate([
            'description' => 'Horeca en Toerisme',
        ],[
            'sbi_group' => 'I'
            // I - Logies-, maaltijd- en drankverstrekking
            // R - Cultuur, sport en recreatie
        ]);
        Sector::query()->updateOrCreate([
            'description' => 'Techniek',
        ],[
            'sbi_group' => 'C'
            // C - Industrie
        ]);
        Sector::query()->updateOrCreate([
            'description' => 'Overheid',
        ],[
            'sbi_group' => 'O'
            // O - Openbaar bestuur, overheidsdiensten en verplichte sociale verzekeringen
        ]);
        Sector::query()->updateOrCreate([
            'description' => 'Onderwijs',
        ],[
            'sbi_group' => 'P'
            // P - Onderwijs
        ]);
        Sector::query()->updateOrCreate([
            'description' => 'Transport en Logistiek',
        ],[
            'sbi_group' => 'H'
            // H - Vervoer en opslag
        ]);
        Sector::query()->updateOrCreate([
            'description' => 'Zorg en Welzijn',
        ],[
            'sbi_group' => 'Q'
            // Q - Gezondheid- en welzijnszorg
        ]);
    }
}
