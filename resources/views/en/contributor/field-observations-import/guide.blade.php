@extends('layouts.dashboard', ['title' => __('navigation.field_observations_import')])

@section('content')
    <div class="box content">
        <h1>Field observations import guide</h1>

        <div class="message mt-8">
            <div class="message-body">
                Importing data into Birdloger from a table is complex process.
                Some errors that are not easy to handle could appear during this task.
                Entering observations this way is justified if you have a large set of data,
                which is not easy to type into Birdloger web interface. However, before
                you choose to import data from the table, think about all other options
                and study this manual in details, so we can avoid unnecessary complications.
            </div>
        </div>

        <h2>Table format</h2>

        <p>
            Birdloger works with tables saved in „.XLSX“ format.
        </p>

        <h2>Table content</h2>

        <p>
            Before importing the data from a table, you must correctly format the
            fields so that Birdloger can recognise the data. During the data import,
            Birdloger is reading values from table rows and columns, preforming a
            basic check of the data and putting the data into appropriate fields
            within the database. If you don’t format the field correctly, Birdloger
            will report an error and show the row within the table where this error
            occurred. In the worst case, Birdloger will not report the error and will
            put the imported data on a wrong place, which means that the Project
            team must react in order to correct this mistake.
        </p>

        <p>These are several things you should check before importing the data:</p>

        <ol>
            <li>
                Scientific name of the taxa in the table needs harmonisation in
                order to match the names of the taxa within the Birdloger database.
                If certain taxon doesn’t exist in the database, you must ask the
                Editor of the taxonomic group to add this taxa first.
            </li>

            <li>
                <b>One of the most common mistakes is made by switching the coordinates
                for longitude and latitude, thus a large number of data can end up
                in the wrong side of the planet Earth.</b> Latitude (y axis) represents
                the distance from the Equator, while the longitude (x axis) represents
                the distance from the Greenwich. In Eastern Europe the numbers for
                latitude are always higher then those for longitude, which can be helpful.
                The coordinates for latitude and longitude are always given in decimal degrees
                (e.g. 43.1111). Coordinates given in degrees, minutes and seconds
                (e.g. 43°10'10" or 43°10.81') needs to be transformed into decimal degrees.
                The same is true for other coordinates given in coordinate system other that WGS84.
            </li>

            <li>
                All variables given along the record needs to be written using the English
                phrases from Birdloger. For example, in column where you type the sex of the
                individual you may write only two values: "male" and "female".
                The same is true for values within the columns defining data licenses or
                developmental stage of a certain individual.
            </li>

            <li>
                Altitude and coordinate precision is always given in meters,
                thus make sure to transform any measures given in miles of kilometres into meters.
            </li>

            <li>
                Every observer must have first and last name. If there are more than one observer, they must be
                separated by comma <b>,</b> and white space <b>&#9251;</b> example: "Anthropoides virgo,
                Grus virgo" and "1, 2b, 3a".
            </li>
        </ol>

        <p>Simple table serving as an example</p>

        <table>
            <thead>
                <tr>
                    <th>Species</th>
                    <th>X</th>
                    <th>Y</th>
                    <th>Year</th>
                    <th>Observers</th>
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
                    <td>Ivan Ivić, Miša Mišić</td>
                </tr>

                <tr>
                    <td>ASIOTUS</td>
                    <td>20,210</td>
                    <td>45,400</td>
                    <td>2015</td>
                    <td>Miša Mišić, Rade Radić</td>
                </tr>
            </tbody>
        </table>

        <h2>Required fields</h2>

        <p>
            During the import, software will ask User for minimal set of data:
            Species ID, geographic coordinates and year of the record.
        </p>

        <h2>From spreadsheet to database</h2>

        <p>
            No mater how we try to unify our tables, not a single data table will ever be the same.
            For this purpose it is required to tell Birdloger how every table looks like!
            This is done by simply choosing the columns and their order within the table.
        </p>

        <p>
            To start, click on a button "Select XLSX file" and choose already prepared
            table from your computer. If the first line of a table contain names of the columns,
            as in our example, you also need to check the field "First row contain column titles".
            After this, click on a button "Choose columns". You will notice that the list of
            columns in Birdloger is somewhat longer than the list of columns in your table
            and that four of them are already selected as required columns.
        </p>

        <p>
            If we would like to import the data from a table given in this example,
            we must select one additional column: Observers. Simply
            check this column from the list and it will be selected for import.
            Since Birdloger can not guess the order of your columns in the table (from left to right),
            we will have to sort the columns in Birdloger list (from top to bottom) so
            that this order matches the table. You can do this simply by dragging the
            column names. In our example the right order of columns will be: SPID,
            Longitude, Latitude, Year, Observers.
        </p>

        <p>
            When you are sure that everything is OK (and when you checked everything
            for at least 10 times!), you may proceed to data import by pressing the Import button.
            The software will parse your table and, if everything is right, the records
            from the table will appear under your field observations.
        </p>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li><a href="{{ route('contributor.field-observations.index') }}">{{ __('navigation.my_field_observations') }}</a></li>
            <li><a href="{{ route('contributor.field-observations-import.index') }}">{{ __('navigation.field_observations_import') }}</a></li>
            <li class="is-active"><a>Import Guide</a></li>
        </ul>
    </div>
@endsection
