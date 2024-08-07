<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Helpers\Codelijsten;
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
        Sector::withoutEvents(function () {
            $sectoren = Codelijsten::get('Sectoren');
            foreach ($sectoren as $codeSector => $naamSector) {
                Sector::query()->updateOrCreate(
                    ['sbi_group' => $codeSector],
                    ['description' => $naamSector]
                );
            }
        });
    }
}
