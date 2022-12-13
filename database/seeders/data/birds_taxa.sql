INSERT INTO `taxa`

(id, parent_id, name, rank, rank_level,
 author, strictly_protected, protected, refer, uses_atlas_codes, prior, type)

VALUES
    (1,	NULL,   'Animalia',	    'kingdom',	70, NULL,0,0,0,0,0, NULL),
    (2,	1,	    'Chordata',		'phylum',	60, NULL,0,0,0,0,0, NULL),
    (3,	2,	    'Vertebrata',	'subphylum',57, NULL,0,0,0,0,0, NULL),
    (4,	3,	    'Reptilia',		'class',	50, NULL,0,0,0,0,0, NULL),
    (5,	3,	    'Aves',			'class',	50, NULL,0,0,0,1,0, NULL)
;
