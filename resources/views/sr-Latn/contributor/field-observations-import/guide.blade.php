@extends('layouts.dashboard', ['title' => __('navigation.field_observations_import')])

@section('content')
    <div class="box content">
        <h1>Uputstvo za uvoz terenskih podataka</h1>

        <div class="message mt-8">
            <div class="message-body">
                Uvoz podataka iz tablice u Birdloger je kompleksan proces. Tom prilikom
                mogu da se potkradu greške koje nije jednostavno ispraviti. Unos podataka
                na ovaj način je opravdan ukoliko se radi o velikom setu podataka, koji nije
                jednostavno prekucati unutar veb okruženja Birdloger. Ipak, pre nego što se
                odlučite za uvoz podataka iz tabele razmislite o drugim mogućnostima i dobro
                proučite ovo uputstvo kako bi izbegli neželjene komplikacije.
            </div>
        </div>

        <h2>Format tabele</h2>

        <p>
            Birdloger radi sa excel tabelama koje su sačuvane u „.XLSX“ formatu.
        </p>

        <h2>Sadržaj tabele</h2>

        <p>
            Pre nego što uvezete podatke iz tabele morate pravilno formatirati njena
            polja kako bi Birdloger prepoznao podatke. Prilikom uvoza podataka Birdloger
            čita vrednosti iz redova i kolona tabele, sprovodi osnovnu proveru podataka
            i smešta podatke u odgovarajuća polja unutar baze podataka. Ukoliko ne formatirate
            polje kako treba, Birdloger će vam prijaviti grešku i ukazati u kom redu tablice
            se greška nalazi. U najgorem slučaju Birdloger neće prepoznati grešku već će
            podatak iz tablice smestiti na pogrešno mesto, nakon čega će biti neophodna
            intervencija našeg Projektnog tima.
        </p>

        <p>Evo nekoliko stvari koje najčešće morate uskladiti pre uvoza podataka:</p>

        <ol>
            <li>
                Naziv vrste je potrebno uskladiti tako da odgovara nazivima
                vrsta u Birdloger bazi podataka. Ukoliko vrsta ne postoji u bazi podataka,
                morate najpre zatražiti od Urednika vrste da ga doda.
            </li>

            <li>
                <b>Jedna od najčešćih greški je zamena koordinata geografske širine i
                geografske dužine, zbog čega veliki broj nalaza može da završi na
                pogrešnoj strani Zemljine kugle.</b> Geografska širina (y osa) predstavlja
                rastojanje od Ekvatora, dok je geografska dužina (x osa) rastojanje od Griniča.
                Na području Istočne Evrope brojčane vrednosti geografske širine su uvek
                veće od vrednosti geografske dužine, što vam može biti od pomoći.
                Koordinate geografske širine i dužine se uvek daju u stepenima (npr. 43,1111).
                Koordinate koje su date u stepenima, minutima i sekundama (npr. 43°10'10" ili 43°10,81')
                je potrebno pretvoriti u decimalni zapis. Isto važi i za koordinate koje su date
                u koordinatnom sistemu različitom od WGS84.
            </li>

            <li>
                Nadmorska visina i preciznost koordinate se uvek daju u metrima,
                pa je brojčane vrednosti u kilometrima potrebno pretvoriti u metre.
            </li>

            <li>
                Svaki posmatrač mora imati upisano ime i prezime. Ukoliko postoji više posmatrača neophodno je da
                budu odvojeni znakom <b>;</b> i praznim razmakom <b>&#9251;</b> npr. "Ivan Ivić; Miša Mišić".
            </li>

            <li>
                Vrednosti za polje Broj čega moraju biti sledeće: Jedinka, Par, Pevajući mužjak, Aktivno gnezdo ili
                Porodica sa mladuncima
            </li>
        </ol>

        <p>Primer jedne proste tabele</p>

        <table>
            <thead>
                <tr>
                    <th>SPID Vrste</th>
                    <th>X</th>
                    <th>Y</th>
                    <th>Godina</th>
                    <th>Posmatrač/i</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>ANAPLAT</td>
                    <td>20,210</td>
                    <td>45,400</td>
                    <td>2014</td>
                    <td>Ivan Ivić</td>
                </tr>

                <tr>
                    <td>MARSTRE</td>
                    <td>20,210</td>
                    <td>45,400</td>
                    <td>2000</td>
                    <td>Ivan Ivić; Miša Mišić</td>
                </tr>

                <tr>
                    <td>ASIOTUS</td>
                    <td>20,210</td>
                    <td>45,400</td>
                    <td>2015</td>
                    <td>Miša Mišić; Rade Radić</td>
                </tr>
            </tbody>
        </table>

        <h2>Obavezna polja</h2>

        <p>
            Prilikom uvoza podataka, od korisnika se traži minimalan set podataka:
            SPID vrste, geografske koordinate i godina nalaza.
        </p>

        <h2>Od tabele do baze</h2>

        <p>
            Ma koliko se trudili da ujednačimo naše tablice, ni jedna tablica sa
            podacima nikada neće biti ista. Zbog toga je neophodno reći Birdlogeru
            kako izgleda svaka tabela ponaosob! To se vrši jednostavnim izborom
            kolona i njihovog redosleda.
        </p>

        <p>
            Kliknite na dugme „Odaberi XLSX datoteku“ i odaberite ranije pripremljenu
            tabelu sa vašeg računara. Ukoliko prvi red tablele sadrži nazive kolona,
            kao u našem primeru, potrebno je da čekirate polje „Prvi red sadrži nazive kolona“.
            Nakon toga kliknite na dugme „Odaberi kolone“. Primetićete da je spisak kolona
            nešto duži od onog koji sadrži vaša tablica, te da je pet kolona automatski
            označeno kao obavezne kolone.
        </p>

        <p>
            Ukoliko želimo da uvezemo podatke iz tabele koju smo dali kao primer,
            moraćemo da označimo još jednu kolonu: Posmatrač/i. Jednostavno
            čekirajte još ovu kolonu sa spiska i ona će biti označena za uvoz iz tabele.
            Pošto Birdloger ne može da zna redosled kolona u vašoj tablici (s leva na desno),
            moraćemo još da premestimo kolone u Birdlogeru (odozgo na dole) tako da odgovaraju tabeli.
            To možete uraditi jednostavnim prevlačenjem naziva kolona. U našem primeru moramo rasporediti
            kolone sledećim redosledom: SPID vrste, Geografska dužina, Geografska širina, Godina, Posmatrač/i.
        </p>

        <p>
            Kada ste se uverili da je sve kako treba (i to 10 puta proverili!),
            možete kliknuti na dugme Uvezi. Program će obraditi vašu tablicu i,
            ako je sve kako treba, nalazi iz tablice će biti pridodati vašim terenskim nalazima.
        </p>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li><a href="{{ route('contributor.field-observations.index') }}">{{ __('navigation.my_field_observations') }}</a></li>
            <li><a href="{{ route('contributor.field-observations-import.index') }}">{{ __('navigation.field_observations_import') }}</a></li>
            <li class="is-active"><a>Uputstvo za uvoz</a></li>
        </ul>
    </div>
@endsection
