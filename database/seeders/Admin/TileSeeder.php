<?php

namespace Database\Seeders\Admin;

use Vng\DennisCore\Enums\TileEnum;
use Vng\DennisCore\Models\Tile;
use Exception;
use Illuminate\Database\Seeder;

/**
 * Dennis werklandschapstegel - DW
 */
class TileSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getData() as $tileData) {
            $tileKeys = TileEnum::keys();
            if (!in_array($tileData['key'], $tileKeys)) {
                throw new Exception('Invalid tile key found in key data');
            }

            Tile::withoutEvents(function () use ($tileData) {
                Tile::query()->updateOrCreate([
                    'key' => $tileData['key']
                ],[
                    'code' => $tileData['code'],
                    'name' => $tileData['name'],
                    'sub_title' => $tileData['sub_title'],
                    'description' => $this->cleanWhitespaces($tileData['description']),
                    'list' => $this->cleanWhitespaces($tileData['list']),
                    'position' => $tileData['position'],
                ]);
            });
        }
    }

    private function cleanWhitespaces($input) {
        // remove new lines
        $input = str_replace(PHP_EOL, ' ', $input);
        // multiple whitespaces reduced to one
        return preg_replace("/\s+/", ' ', $input);
    }

    private function getData() {
        return [
            [
                'code' => 'DW01',
                'name' => 'Voorzorg',
                'sub_title' => 'Voor behoud van werk',
                'description' => "
                    <p>
                        Door het belang van de werkgever centraal te stellen (gaat
                        vaak over goed personeel verkrijgen en behouden) en te
                        verbinden aan belangen van de overheid (werkzoekenden
                        op de arbeidsmarkt krijgen en houden), ontstaat
                        partnership.
                    </p>
                    <p>
                        Bij partnership ben je in goede en slechte tijden op elkaar
                        aan gewezen en ontstaat er good will van twee kanten om
                        te voorzien in ieders belang.
                    </p>
                    <p>
                        Zorg daarom dat werkgevers op de hoogte zijn van
                        ontwikkelingen, subsidies en inzet van instrumenten.
                        Heb oog voor de situatie waar de werkgever mee worstelt:
                        bv zijn er werknemers die ondersteuning nodig hebben om
                        beter te functioneren? Gemeenten hebben allerlei kennis,
                        contacten en instrumenten om hierin te ondersteunen.
                        Door hierin te ondersteunen kunnen werknemers zich
                        ontwikkelen, beter functioneren en kan uitval worden
                        voorkomen.
                    </p>
                    <p>
                        Zet de vier routes van duurzame Inzetbaarheid op de
                        agenda. Zorg voor vaste aanspreekpunten voor de
                        werkgever, bouw aan relaties.
                    </p>
                ",
                'list' => "
                    <ul>
                        <li>Relatiebeheer</li>
                        <li>Informeren over arbeidsmarktontwikkelingen</li>
                        <li>Vraagbaak voor (juridische) personeelsvraagstukken en duurzame inzetbaarheid</li>
                        <li>
                            Vier routes naar Duurzame Inzetbaarheid van personeel
                            <ul>
                                <li>Mobiliteit binnen en buiten bedrijf</li>
                                <li>Gezonde leefstijl bevorderen (op het werk)</li>
                                <li>Ontwikkelen door (om)scholing voor werknemers (stimuleer leven lang ontwikkelen)</li>
                                <li>Werkaanpassingen</li>
                            </ul>
                        </li>
                        <li>
                            Informeren over ondersteuning en inzet van instrumenten
                            <ul>
                                <li>Schuldhulpverlening t.b.v. werknemer</li>
                                <li>Ondersteuning werknemers bij rekenen en taal</li>
                                <li>Loonkostensubsidie</li>
                                <li>Jobcoaching</li>
                            </ul>
                        </li>
                        <li>Sectorplannen en subsidies om te ontwikkelen</li>
                    </ul>
                ",
                'key' => 'voorzorg',
                'position' => [
                    'x' => 4,
                    'y' => 0,
                ],
            ],
            [
                'code' => 'DW02',
                'name' => 'Werkgever Contact',
                'sub_title' => 'Vraag werkgever',
                'description' => "
                    <p>
                        Bekommer je om de werkgever.
                    </p>
                    <p>
                        De werkgever meldt zich bij de overheid of de overheid
                        contacteert de werkgever.
                    </p>
                    <p>
                        Bij een ‘nieuwe’ werkgever inventariseert de adviseur de
                        kenmerken, de producten, de missie van het bedrijf,
                        werkprocessen en kijkt op de werkvloer. Hij inventariseert de
                        vraag en verwijst door bij andere ondernemersvraagstukken. Bij
                        een bekende werkgever kent de adviseur de (economische)
                        ontwikkeling van de onderneming en welke vraagstukken de
                        werkgever heeft in het algemeen, maar met name op het gebied
                        van personeel.
                    </p>
                    <p>
                        De adviseur informeert de werkgever over de ontwikkelingen,
                        verschillende mogelijkheden en voordelen van de inzet van
                        mensen met een afstand tot de arbeidsmarkt en de verschillende
                        doelgroepen hierbinnen.
                    </p>
                    <p>
                        Maak een gezamenlijk marktbewerkingsplan voor de
                        arbeidsmarktregio, waarom je welke werkgevers in je netwerk
                        wilt hebben. Stem dit af met gemeenten, UWV en WSP. Betrek
                        economische zaken waar mogelijk. Fungeer zoveel mogelijk als
                        één overheid richting de werkgever.
                    </p>
                ",
                'list' => "
                    <ul>
                        <li>Opstellen profiel werkgever</li>
                        <li>Afstemmen verwachtingen t.a.v. WSP</li>
                        <li>
                            Voorbeeld verhalen van andere ondernemers bij vergelijkbare vraag
                            <ul>
                                <li>Social Return en Prestatieladder Sociaal Ondernemen (PSO-Nederland)</li>
                                <li>Functie creatie</li>
                            </ul>
                        </li>
                        <li>
                            Zoeken naar kansen op gedeeld belang
                            <ul>
                                <li>Bedrijf wil zich vestigen</li>
                                <li>Bedrijf wil groeien</li>
                                <li>Bedrijf zoekt personeel</li>
                                <li>Bedrijf wil innoveren</li>
                                <li>Strategisch HRM</li>
                            </ul>
                        </li>
                        <li>Advisering</li>
                        <li>Marktbewerkingsplan</li>
                        <li>Informeer en bevraag Economische Zaken</li>
                    </ul>
                ",
                'key' => 'werkgever_contact',
                'position' => [
                    'x' => 4,
                    'y' => 1,
                ],
            ],
            [
                'code' => 'DW03',
                'name' => 'Oriëntatie',
                'sub_title' => 'Op de arbeidsmarkt',
                'description' => "
                    <p>
                        De werkgever oriënteert zich op verschillende manieren om
                        inclusief te ondernemen en welke stappen daarvoor nodig zijn.
                    </p>
                    <p>
                        Dit kan door aansluiten bij het gemeentelijk SROI beleid of het
                        ontwikkelen van eigen beleid op maatschappelijk verantwoord
                        ondernemen. Andere manieren zijn stageplekken voor jongeren
                        (met beperkingen) creëren of open hiring.
                    </p>
                    <p>
                        Inclusief HR beleid opstellen betekent vooruit kijken naar de
                        verwachte veranderingen in het personeelsbestand (vergrijzing,
                        mogelijke groei van het bedrijf) en dit inclusief vormgeven.
                    </p>
                    <p>
                        De adviseur ondersteunt, legt uit, adviseert, biedt voorbeelden
                        van andere bedrijven om de werkgever te ondersteunen in de
                        oriëntatie op de mogelijkheden en creëert realistische
                        verwachtingen over de samenwerking en de kandidaten.
                    </p>
                    <p>
                        Brengen samen in kaart welke functies en welke veranderingen
                        nodig zijn om de kandidaten aan te nemen. Maakt hiervoor een
                        stappenplan met een haalbaar perspectief voor de werkgever. Zet
                        de werkgever centraal.
                    </p>
                ",
                'list' => "
                    <ul>
                        <li>Stage- en werkervaringsplekken</li>
                        <li>Prestatieladder Sociaal Ondernemen / SROI</li>
                        <li>Behalen van certificaat mantelzorgvriendelijke organisatie</li>
                        <li>Inclusief HR beleid opstellen</li>
                        <li>Missie statement van het bedrijf inclusief maken</li>
                        <li>Functies selecteren</li>
                    </ul>
                ",
                'key' => 'orientatie',
                'position' => [
                    'x' => 3,
                    'y' => 2,
                ],
            ],
            [
                'code' => 'DW04',
                'name' => 'Opleiden',
                'sub_title' => 'klaar voor werk',
                'description' => "
                    <p>
                        Het kan zijn dat het bedrijf onvoldoende vaardigheden heeft
                        om (kwetsbare) kandidaten met vertrouwen en succesvol een
                        baan aan te bieden. Door middel van opleiding kan een bedrijf
                        competenter worden in inclusief ondernemen.
                    </p>
                    <p>
                        Het kan gaan om beter leren omgaan met belemmeringen in
                        bedrijfsprocessen, het herkennen van en omgaan met
                        beperkingen van werknemers, alsook het aansturen van
                        werknemers.
                    </p>
                    <p>
                        Met name leidinggevend personeel kan hun kennis en
                        competenties vergroten door te investeren in bijvoorbeeld
                        ontwikkelingsgericht leidinggeven. Dit betekent dat het werk-
                        en de werkomstandigheden doorlopend zo worden ingericht,
                        dat de werknemer zo optimaal mogelijk kan functioneren en
                        waar mogelijk zichzelf kan ontwikkelen binnen het eigen
                        bedrijf of daarbuiten.
                    </p>
                    <p>
                        Met die kennis kunnen sectorplannen en andere bronnen die
                        behulpzaam kunnen zijn om werkgevers te ondersteunen bij
                        inclusief ondernemen, substantieel effectiever ingezet
                        worden.
                    </p>
                ",
                'list' => "
                    <ul>
                        <li>Aanleren vakkennis</li>
                        <li>Informeren collega’s over nieuwe medewerker met beperking</li>
                        <li>
                            Begeleiding tijdens werk
                            <ul>
                                <li>HARRIE Training</li>
                                <li>Mentorwijs</li>
                            </ul>
                        </li>
                        <li>Sector plannen</li>
                        <li>Inclusief HR beleid</li>
                        <li>Duurzaam Inzetbaarheidsstrategieen</li>
                    </ul>
                ",
                'key' => 'opleiden',
                'position' => [
                    'x' => 2,
                    'y' => 2,
                ],
            ],
            [
                'code' => 'DW05',
                'name' => 'Kandidaat fit',
                'sub_title' => 'Klaar voor kandidaat',
                'description' => "
                    <p>
                        In dit geval staat niet het werk, maar de kandidaat
                        centraal. Werkgever en kandidaat hebben een klik,
                        waardoor de werkgever bereid is om de kandidaat een
                        baan te bieden ondanks dat diegene niet alle benodigde
                        kennis en vaardigheden bezit.
                    </p>
                    <p>
                        De werkgever heeft de motivatie, het perspectief, de
                        mogelijkheden en de vaardigheden om mensen met een
                        afstand tot de arbeidsmarkt aan te nemen.
                    </p>
                    <p>
                        Directe plaatsing is mogelijk door de werkomstandigheden
                        zover nodig op de kandidaat aan te passen, mogelijkheden
                        tot ontwikkeling te bieden en intern de organisatie op orde
                        te hebben. In deze situatie werken werkgever en overheid
                        doorgaans nauwgezet samen om de plaatsing duurzaam te
                        maken.
                    </p>
                ",
                'list' => "
                    <ul>
                        <li>
                            Motivatie
                            <ul>
                                <li>Missie</li>
                                <li>Vertrouwen</li>
                                <li>Belang</li>
                            </ul>
                        </li>
                        <li>
                            Vaardigheden
                            <ul>
                                <li>Ontwikkelingsgericht leidinggeven</li>
                                <li>Team aansturing</li>
                                <li>Kent de doelgroep</li>
                            </ul>
                        </li>
                        <li>
                            Belemmeringen
                            <ul>
                                <li>Job-carving</li>
                                <li>Job coaching</li>
                                <li>Inclusieve arbeidsorganisatie</li>
                            </ul>
                        </li>
                        <li>Individuele Plaatsing en Steun (IPS)</li>
                        <li>Open hiring</li>
                        <li>Draagvlak onderzoek</li>
                    </ul>
                ",
                'key' => 'kandidaat_fit',
                'position' => [
                    'x' => 3,
                    'y' => 0,
                ],
            ],
            [
                'code' => 'DW06',
                'name' => 'Opstellen Werkprofiel',
                'sub_title' => 'Beoordelen vacature',
                'description' => "
                    <p>
                        Bij de verkenning van de vacature/taken, ondersteunt de
                        adviseur de werkgever dit te beschrijven in benodigde
                        competenties en kenmerken van het werk. Hierbij is ook
                        aandacht voor de zachte kenmerken van de werkgever,
                        waarop gematcht wordt.
                    </p>
                    <p>
                        De minimale eisen van de functie en de kandidaat wordt in
                        kaart gebracht. Jobcarving en andere functiecreatie
                        technieken kunnen hierbij effectief zijn. Vervolgens
                        beoordeelt de adviseur of het werkprofiel kan worden
                        ingevuld door de kandidaten of dat de werkgever hem
                        beter via reguliere kanalen kan uitzetten.
                    </p>
                    <p>
                        Het haalbaar perspectief betekent een
                        ontwikkelperspectief voor kandidaat én werkgever.
                    </p>
                    <p>
                        Het gaat niet alleen om actuele vacatures, maar juist en
                        vooral om toekomstige vacatures, door groei of verloop in
                        personeel. Dit biedt kansen (tijd en vertrouwen) om
                        kandidaten voor te bereiden op die werkplek.
                    </p>
                ",
                'list' => "
                    <ul>
                        <li>Opstellen samenwerkingsconvenant</li>
                        <li>Vacatures beschrijven in competenties ipv opleiding en ervaring</li>
                        <li>Passend werkprofiel opstellen</li>
                        <li>
                            Niet-passend werkprofiel
                            <ul>
                                <li>Verwijzing naar reguliere kanalen</li>
                                <li>Passend maken (jobcarving, advisering werkplekaanpassing, subsidieregelingen)</li>
                            </ul>
                        </li>
                    </ul>
                ",
                'key' => 'opstellen_werkprofiel',
                'position' => [
                    'x' => 3,
                    'y' => 1,
                ],
            ],
            [
                'code' => 'DW07',
                'name' => 'Werving en Selectie',
                'sub_title' => 'Vinden van kandidaten bij vacature',
                'description' => "
                    <p>
                        Werkgever en adviseur maken afspraken over hoe de
                        selectie wordt uitgevoerd en in welk tijdspad, op welke
                        wijze en het aantal kandidaten dat wordt voorgesteld.
                    </p>
                    <p>
                        Op basis van de harde eisen, benodigde competenties
                        en affiniteiten en de bedrijfscultuur, wordt gezocht in de
                        diagnostische informatie naar kandidaten die zich
                        kunnen en willen ontwikkelen in die richting.
                    </p>
                    <p>
                        De meest geschikte kandidaten worden vooraf
                        gesproken over de matching met de vraag van de
                        werkgever.
                    </p>
                ",
                'list' => "
                    <ul>
                        <li>Vacatures openstellen</li>
                        <li>Organiseren van ontmoetingen</li>
                        <li>
                            Matchen
                            <ul>
                                <li>Matchingsoverleg met ketenpartners</li>
                                <li>Digitaal selecteren</li>
                                <li>Persoonlijk matchen door professional</li>
                            </ul>
                        </li>
                        <li>Voorselectie kandidaten</li>
                    </ul>
                ",
                'key' => 'werving_en_selectie',
                'position' => [
                    'x' => 2,
                    'y' => 1,
                ],
            ],
            [
                'code' => 'DW08',
                'name' => 'Bemiddeling',
                'sub_title' => 'Kandidaten aan vacatures koppelen',
                'description' => "
                    <p>
                        Kandidaten, die matchen met het werkprofiel beschreven
                        in competenties, worden voorgedragen aan de werkgever.
                        Hierbij wordt ook besproken wat iemand nodig heeft om
                        goed te kunnen functioneren.
                    </p>
                    <p>
                        De werkgever beoordeelt op basis van leervermogen,
                        hard- en soft skills, welke kandidaat het beste past op de
                        openstaande vacature. Hierbij is de klik tussen
                        werkzoekende en werkgever een belangrijke factor.
                    </p>
                    <p>
                        Er is structureel overleg tussen de professional van de
                        werkzoekende en de adviseur van de werkgever. Zij
                        hebben contact over de voortgang en de eventuele inzet
                        van instrumenten om de kans op een succesvolle plaatsing
                        te vergroten.
                    </p>
                    <p>
                        Het besluit wie wel/niet wordt aangenomen ligt bij de
                        werkgever. De terugkoppeling van de werkgever met
                        motivatie voor aannemen/afwijzen op de vacature, is
                        relevante informatie voor de werkzoekende om beter te
                        leren solliciteren.
                    </p>
                ",
                'list' => "
                    <ul>
                        <li>Voordragen van kandidaten</li>
                        <li>
                            Sollicitatiegesprekken
                            <ul>
                                <li>Speeddates</li>
                            </ul>
                        </li>
                        <li>
                            Werkgevers Service Punt (WSP)
                            <ul>
                                <li>Wederzijdse aansluiting tussen coaching en activiteiten WSP</li>
                                <li>Relatie opbouw met private partijen</li>
                                <li>Vraaggericht werken door het aanbieden van passende kandidaten</li>
                                <li>Aanbodgericht werken obv goede relaties en nazorg aan werkgevers</li>
                            </ul>
                        </li>
                        <li>Inzet van ondersteunende voorzieningen bespreken</li>
                        <li>
                            Keuze van de werkgever
                            <ul>
                                <li>Terugkoppeling met motivatie bij afgewezen kandidaten</li>
                            </ul>
                        </li>
                    </ul>
                ",
                'key' => 'bemiddeling',
                'position' => [
                    'x' => 1,
                    'y' => 1,
                ],
            ],
            [
                'code' => 'DW09',
                'name' => 'Plaatsing',
                'sub_title' => 'Werkelijk aan de slag',
                'description' => "
                    <p>
                        In deze stap wordt op basis van de plaatsingsafspraken
                        met de werkgever en werknemer ondersteunende
                        voorzieningen aangevraagd voor een zo groot mogelijke
                        kans van slagen op een duurzame match.
                    </p>
                    <p>
                        De adviseur heeft hierin een informerende, adviserende
                        en bemiddelende rol.
                    </p>
                    <p>
                        De adviseur bespreekt de valkuilen en afbreekrisico’s met
                        de werkgever en de werknemer. Zij bespreken wat nodig
                        is om de plaatsing te laten slagen en maken afspraken
                        over de nazorg.
                    </p>
                    <p>
                        Belangrijk aandachtspunt is om de werknemer zoveel
                        mogelijk te betrekken bij de afspraken.
                    </p>
                    <p>
                        Voorkom dat de werkgever met iedere gemeente een
                        andere aanpak moet doorlopen, door instrumenten en
                        processen zoveel mogelijk af te stemmen met omliggende
                        gemeenten en de arbeidsmartkregio.
                    </p>
                ",
                'list' => "
                    <ul>
                        <li>
                            Een handzaam overzicht van instrumenten
                            <ul>
                                <li>Loonkostensubsidie (LKS)</li>
                                <li>LKV, LIV etc.</li>
                                <li>Proefplaatsing</li>
                                <li>Werkplekaanpassing</li>
                                <li>Jobcoaching</li>
                            </ul>
                        </li>
                        <li>Overzicht van valkuilen en risico’s en wat te doen in dat geval</li>
                        <li>Medewerkers worden voorbereid op de komst van de nieuwe collega</li>
                    </ul>
                ",
                'key' => 'plaatsing',
                'position' => [
                    'x' => 0,
                    'y' => 1,
                ],
            ],
            [
                'code' => 'DW10',
                'name' => 'Nazorg',
                'sub_title' => 'Voor duurzame plaatsing',
                'description' => "
                    <p>
                        Om de kans te vergroten dat de werknemer aan het werk
                        blijft, is het van belang dat er nazorg wordt geboden aan
                        de werkgever als dat nodig is. Regelmatig contact na
                        plaatsing is daarom belangrijk.
                    </p>
                    <p>
                        Het gaat hierbij zowel om persoonlijke ondersteuning als
                        om de inzet van instrumenten en subsidies. De duur,
                        intensiteit en inhoud van de nazorg zijn afhankelijk van de
                        behoefte. Dit kan variëren van nabellen tot intensieve
                        structurele begeleiding van werknemer en/of werkgever.
                    </p>
                    <p>
                        Monitor en evalueer daarom hoe de plaatsing verloopt,
                        pak voorliggende problemen op. Werk hierdoor aan een
                        duurzame relatie met de werkgever(s) in de
                        (arbeidsmarkt)regio.
                    </p>
                    <p>
                        Monitoring en evaluatie draagt tevens bij aan een lerende
                        organisatie.
                    </p>
                ",
                'list' => "
                    <ul>
                        <li>Ingezette instrumenten</li>
                        <li>
                            Begeleiding en de duur daarvan
                            <ul>
                                <li>Schuldhulpverlening (zie werknemerslandschap “maatschappelijk fit”)</li>
                            </ul>
                        </li>
                        <li>
                            Werkgever informeren over relevante wijzigingen in
                            <ul>
                                <li>Wetgeving</li>
                                <li>Fiscale voordelen</li>
                                <li>SROI</li>
                                <li>Duurzame inzetbaarheid</li>
                            </ul>
                        </li>
                        <li>Snelheid van reageren en acteren bij problemen is van belang</li>
                    </ul>
                ",
                'key' => 'nazorg',
                'position' => [
                    'x' => 1,
                    'y' => 2,
                ],
            ]
        ];
    }
}
