<?php

return [
    'id' => 'ID',
    'actions' => 'Actions',
    'created_at' => 'Created At',

    'tables' => [
        'from_to_total' => 'Showing :from-:to of :total',
    ],

    'sexes' => [
        'male' => 'Male',
        'female' => 'Female',
    ],

    'number_of' => [
        'individual' => 'Individual',
        'couple' => 'Couple',
        'singing_male' => 'Singing male',
        'active_nest' => 'Active nest',
        'family_with_cubs' => 'Family with cubs',
    ],

    'transfer' => [
        'available' => 'Available',
        'chosen' => 'Chosen',
    ],

    'login' => [
        'email' => 'Email',
        'password' => 'Password',
        'forgot_password' => 'Forgot password?',
        'remember_me' => 'Remember me',
    ],

    'register' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'institution' => 'Institution',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Repeat Password',
        'verification_code' => 'Verification Code',
        'accept' => 'I agree with the <a href=":url" title="Privacy Policy" target="_blank">Privacy Policy</a>',
    ],

    'forgot_password' => [
        'email' => 'Email',
    ],

    'reset_password' => [
        'email' => 'E-Mail Address',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
    ],

    'users' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'institution' => 'Institution',
        'roles' => 'Roles',
        'curated_taxa' => 'Curated species',
        'email' => 'Email',
        'search' => 'Search',
    ],

    'taxa' => [
        'rank' => 'Rank',
        'name' => 'Species name',
        'parent' => 'Parent',
        'author' => 'Author',
        'native_name' => 'Native Name',
        'description' => 'Description',
        'fe_old_id' => '(old) FaunaEuropea ID',
        'fe_id' => 'FaunaEuropea ID',
        'restricted' => 'Species data is restricted',
        'allochthonous' => 'Species is allochthonous',
        'invasive' => 'Species is invasive',
        'stages' => 'Stages',
        'conservation_legislations' => 'Conservation Legislations',
        'conservation_documents' => 'Other Conservation Documents',
        'red_lists' => 'Red Lists',
        'add_red_list' => 'Add red list',
        'search_for_taxon' => 'Search for species...',
        'yes' => 'Yes',
        'no' => 'No',
        'rejected' => 'Rejected',
        'include_lower_taxa' => 'Include lower species',
        'atlas_codes' => 'Atlas Codes',
        'uses_atlas_codes' => 'Uses Atlas Codes',
        'spid' => 'SPID',
        'birdlife_seq' => 'BirdLife sequence',
        'birdlife_id' => 'BirdLife ID',
        'ebba_code' => 'EBBA code',
        'refer' => 'Referent list',
        'euring_code' => 'EURING code',
        'euring_sci_name' => 'EURING sci name',
        'eunis_n2000code' => 'EUNIS n2000 code',
        'eunis_sci_name' => 'EUNIS sci ime',
        'bioras_sci_name' => 'BioRaS sci name',
        'sg' => 'SG',
        'gn_status' => 'GN status',
        'prior' => 'Priority list',
        'strictly_protected' => 'Strictly protected',
        'strictly_note' => 'Note for s.p.s',
        'protected' => 'Protected',
        'protected_note' => 'Note for p.s',
        'type' => 'Type',
        'iucn_cat' => 'IUCN category',
        'sp' => 'SP',
        'full_sci_name' => 'Full scientific name',
        'synonyms' => 'List of synonyms',
        'addSynonym' => 'Add synonym',
        'annex' => 'Annex',
    ],

    'field_observations' => [
        'taxon' => 'Species name',
        'taxon_id' => 'Species ID',
        'original_identification' => 'Original Identification',
        'search_for_taxon' => 'Search for species...',
        'date' => 'Date',
        'year' => 'Year',
        'month' => 'Month',
        'day' => 'Day',
        'photos' => 'Photos',
        'upload' => 'Upload',
        'map' => 'Map',
        'latitude' => 'Latitude',
        'longitude' => 'Longitude',
        'accuracy_m' => 'Accuracy/Radius (m)',
        'accuracy' => 'Accuracy',
        'elevation_m' => 'Elevation (m)',
        'elevation' => 'Elevation',
        'location' => 'Location',
        'details' => 'Details',
        'more_details' => 'More Details',
        'less_details' => 'Less Details',
        'note' => 'Note',
        'number' => 'Number',
        'project' => 'Project',
        'project_tooltip' => 'If the data is gathered in the course of a project write the project name/number here.',
        'habitat' => 'Habitat',
        'found_on' => 'Found On',
        'found_on_tooltip' => 'You can fill this field if the species is observed on a host (i.e. latin name of the caterpillar host plant), dung (i.e. goat dung for scarabs), carrion (for carrion beetles), etc.',
        'sex' => 'Sex',
        'stage' => 'Stage',
        'time' => 'Time',
        'observer' => 'Observer',
        'observers' => 'Observers',
        'identifier' => 'Identifier',
        'data_license' => 'Data License',
        'image_license' => 'Image License',
        'default' => 'Default',
        'choose_a_stage' => 'Choose a stage',
        'choose_a_value' => 'Choose a value',
        'click_to_select' => 'Click to select...',
        'status' => 'Status',
        'types' => 'Observation Type',
        'types_placeholder' => 'Select Observation Type',
        'dataset' => 'Dataset',
        'mgrs10k' => 'MGRS 10K',
        'number_of' => 'Number of',
        'description' => 'Detailed description',
        'comment' => 'Comment',

        'statuses' => [
            'approved' => 'Approved',
            'unidentifiable' => 'Unidentifiable',
            'pending' => 'Pending',
        ],

        'save_tooltip' => 'Saves current observation and returns you to the list of your records. You can also use keyboard shortcut: Ctrl+Enter.',
        'save_more_tooltip' => 'Saves current observations, but allows you to enter more data from the same place. You can also use keyboard shortcut: Ctrl+Shift+Enter.',

        'include_lower_taxa' => 'Include lower species',
        'submitted_using' => 'Submitted Using',
    ],

    'observations' => [
        'observers' => 'Observers',
        'firstName' => 'First Name',
        'lastName' => 'Last Name',
        'fid' => 'Feature ID',
        'rid' => 'RID',
        'data_limit' => 'Data limit',
        'data_provider' => 'Data provider',
        'add_observer' => 'Add observer',
        'remove_observer_tooltip' => 'Remove observer',
        'id_tooltip' => 'Species name must be selected with autocomplete function, id will be automatically selected.',
        'atlas_code' => 'Atlas Code',
        'found_dead' => 'Found dead?',
        'found_dead_note' => 'Note on dead observation',
        'insert_first_name' => 'Insert first name',
        'insert_last_name' => 'Insert last name',

    ],

    'electrocution_observations' => [
        'time_of_departure' => 'Time of departure (h)',
        'time_of_arrival' => 'Time of arrival (h)',
        'duration' => 'Line tour duration (min)',
        'distance' => 'Traveled distance (km)',
        'transportation' => 'Transportation',
        'distance_from_pillar' => 'Distance from pillar (cm)',
        'number_of_pillars' => 'Number of pillars',
        'transmission_line' => 'Transmission line',
        'age' => 'Age',
        'position' => 'Corpse position',
        'state' => 'The condition of the dead individual',
        'annotation' => 'Annotation',
    ],

    'poaching_observations' => [
        'indigenous' => 'Indigenous',
        'dead_from_total' => 'Dead individuals from total number',
        'alive_from_total' => 'Alive individuals from total number',
        'total' => 'Ukupan broj jedinki',
        'exact_number' => 'Exact number',
        'offences' => 'Case belongs to these offences',
        'locality' => 'Locality',
        'place' => 'Place',
        'municipality' => 'Municipality',
        'data_id' => 'Data ID',
        'folder_id' => 'Folder ID',
        'file' => 'File',
        'in_report' => 'In report',
        'input_date' => 'Input date',
        'offence_details' => 'Offence in details',
        'case_reported' => 'Case reported',
        'case_reported_by' => 'Case reported by',
        'verdict' => 'Verdict',
        'verdict_date' => 'Verdict date',
        'proceeding' => 'Case recognized as following proceeding',
        'sanction_rsd' => 'Sanction (RSD)',
        'sanction_eur' => 'Sanction (EUR)',
        'community_sentence' => 'Community sentence (h)',
        'opportunity' => 'Opportunity',
        'annotation' => 'Annotation',
        'suspect_name' => 'Suspect',
        'suspect_place' => 'Suspect place',
        'suspect_profile' => 'Suspect profile',
        'suspects_number' => 'Suspects number',
        'sources' => 'Basic data source',
        'source' => 'Source type',
        'source_description' => 'Source description',
        'source_link' => 'Source link',
        'social_media' => 'Social media',
        'media' => 'Printed and electronic medias',
        'ads' => 'Advertisement',
        'institutions' => 'Institutions',
        'associates' => 'Associates',
        'cites' => 'CITES',
        'origin_of_individuals' => 'Origin of individuals',
        'rejected' => 'Rejected',
        'select_date' => 'Select date',
        'remove_source_tooltip' => 'Delete source',
        'add_source' => 'Add new source',
        'insert_source_description' => 'Insert sources description',
        'insert_source_link' => 'Insert sources link',
        'youtube' => 'YouTube',
        'facebook' => 'Facebook',
        'insert_source' => 'Insert new source...',
    ],

    'proceedings' => [
        'misdemeanor' => 'Misdemeanor',
        'criminal' => 'Criminal',
    ],

    'offence_cases' => [
        'killing' => 'Killing',
        'catching' => 'Catching',
        'poisoning' => 'Poisoning',
        'owning' => 'Owning',
        'trading' => 'Trading',
    ],

    'cites' => [
        'appendix_I' => 'Appendix I',
        'appendix_II' => 'Appendix II',
        'appendix_III' => 'Appendix III',
    ],

    'view_groups' => [
        'name' => 'Name',
        'parent' => 'Parent',
        'description' => 'Description',
        'taxa' => 'Species name',
        'image' => 'Image',
        'only_observed_taxa' => 'Only observed species',
    ],

    'exports' => [
        'title' => 'Export',
        'processing' => 'Exporting... This may take a while.',
        'only_checked' => 'Only export checked',
        'apply_filters' => 'Apply filters',
        'with_header' => 'With header',
        'finished' => 'Finished! You can now download you export.',
        'columns' => 'Columns',
        'types' => [
            'custom' => 'Custom',
            'darwin_core' => 'Darwin Core',
        ],
        'observers' => 'Observers',
    ],

    'imports' => [
        'choose_columns' => 'Choose Columns',
        'select_csv_file' => 'Select XLSX file',
        'available' => 'Available',
        'chosen' => 'Chosen',
        'import' => 'Import',
        'row_number' => 'Row Number',
        'error' => 'Error',
        'has_heading' => 'First row contains column titles',
        'columns' => 'Columns',
        'user' => 'For User',
        'approve_curated' => 'Approve Curated',
    ],

    'announcements' => [
        'title' => 'Title',
        'message' => 'Message',
        'private' => 'Private',
        'publish' => 'Publish',
    ],

    'publications' => [
        'type' => 'Type of Publication',
        'name' => 'Name',
        'symposium_name' => 'Symposium Name',
        'book_chapter_name' => 'Book Name',
        'paper_name' => 'Journal Title',
        'title' => 'Title',
        'year' => 'Year',
        'issue' => 'Issue',
        'publisher' => 'Publisher',
        'place' => 'Place',
        'page_count' => 'Page Count',
        'page_range' => 'Page Range',
        'authors' => 'Authors',
        'editors' => 'Editors',
        'attachment' => 'Attachment',
        'link' => 'Link',
        'doi' => 'DOI',
        'citation' => 'Citation',
        'citation_tooltip' => 'It will be auto-generated if left empty',
        'add_author' => 'Add Author',
        'add_editor' => 'Add Editor',
        'first_name' => 'First Name',
        'last_name' => 'Last Name',

        'search' => 'Search',
    ],

    'literature_observations' => [
        'publication' => 'Publication',
        'is_original_data' => 'Is Original Data?',
        'original_data' => 'Original Data',
        'citation' => 'Citation',
        'cited_publication' => 'Cited Publication',
        'search_for_publication' => 'Search for publication',
        'taxon' => 'Species name',
        'search_for_taxon' => 'Search for species',
        'date' => 'Date',
        'year' => 'Year',
        'month' => 'Month',
        'day' => 'Day',
        'elevation_m' => 'Elevation (m)',
        'elevation' => 'Elevation',
        'latitude' => 'Latitude',
        'longitude' => 'Longitude',
        'mgrs10k' => 'MGRS 10k',
        'accuracy' => 'Accuracy',
        'accuracy_m' => 'Accuracy (m)',
        'location' => 'Location',
        'minimum_elevation' => 'Minimum Elevation',
        'minimum_elevation_m' => 'Minimum Elevation (m)',
        'maximum_elevation' => 'Maximum Elevation',
        'maximum_elevation_m' => 'Maximum Elevation (m)',
        'stage' => 'Stage',
        'choose_a_stage' => 'Choose a stage',
        'sex' => 'Sex',
        'choose_a_value' => 'Choose a value',
        'number' => 'Number',
        'note' => 'Note',
        'habitat' => 'Habitat',
        'found_on' => 'Found On',
        'found_on_tooltip' => 'You can fill this field if the species is observed on a host (i.e. latin name of the caterpillar host plant), dung (i.e. goat dung for scarabs), carrion (for carrion beetles), etc.',
        'time' => 'Time',
        'click_to_select' => 'Click to select',
        'project' => 'Project',
        'project_tooltip' => 'If the data is gathered in the course of a project write the project name/number here.',
        'dataset' => 'Dataset',
        'observer' => 'Observer',
        'identifier' => 'Identifier',
        'original_date' => 'Original Date',
        'original_locality' => 'Original Locality',
        'original_coordinates' => 'Original Coordinates',
        'original_elevation' => 'Original Elevation',
        'original_elevation_placeholder' => 'f.e. 100-200m',
        'original_identification' => 'Original Identification',
        'original_identification_validity' => 'Original Identification Validity',
        'other_original_data' => 'Other Original Data',
        'collecting_start_year' => 'Collecting Start Year',
        'collecting_start_month' => 'Collecting Start Month',
        'collecting_end_year' => 'Collecting End Year',
        'collecting_end_month' => 'Collecting End Month',
        'place_where_referenced_in_publication' => 'Place of Reference in Publication',
        'place_where_referenced_in_publication_placeholder' => 'i.e. Page 45, Figure 4 or Table 3',
        'georeferenced_by' => 'Georeferenced By',
        'georeferenced_date' => 'Georeferenced on Date',

        'add_new_publication' => 'Add New Publication',

        'verbatim_data' => 'Verbatim Data',

        'validity' => [
            'invalid' => 'Invalid',
            'valid' => 'Valid',
            'synonym' => 'Synonym',
        ],

        'save_tooltip' => 'Saves current observation and returns you to the list of records. You can also use keyboard shortcut: Ctrl+Enter.',
        'save_more_tooltip' => 'Saves current observations, but allows you to enter more data from the same place. You can also use keyboard shortcut: Ctrl+Shift+Enter.',

        'save_more_same_taxon' => 'Save (more, same species)',
        'save_more_same_taxon_tooltip' => 'Saves current observations, but allows you to enter more data from the same place and for the same species.',

        'include_lower_taxa' => 'Include lower species',
    ],

    'iucn' => [
        'EX' => 'Extinct',
        'EW' => 'Extinct in the wild',
        'CR' => 'Critically endangered',
        'EN' => 'Endangered',
        'VU' => 'Vulnerable',
        'NT' => 'Near threatened',
        'LC' => 'Least concern',
        'DD' => 'Data deficient',
        'NE' => 'Not evaluated',
        'NR' => 'Not recognised',
    ],

    'preferences' => [
        'general' => [
            'locale' => 'Preferred locale',
        ],

        'account' => [
            'delete_account' => 'Delete Account',
            'delete_observations' => 'Delete observations as well',
        ],
        'notifications' => [
            'notification' => 'Notification',
            'inapp' => 'In App',
            'mail' => 'Mail',

            'field_observation_approved' => 'Observation has been approved',
            'field_observation_edited' => 'Observation has been edited',
            'field_observation_moved_to_pending' => 'Observation has been moved to pending',
            'field_observation_marked_unidentifiable' => 'Observation has been marked as unidentifiable',
            'field_observation_for_approval' => 'New observation for approval',
        ],
    ],
];
