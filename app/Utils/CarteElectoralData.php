<?php

namespace App\Utils;

class CarteElectoralData
{
    const NOMBRE_INSCRITS = 6986826;
    const COMMUNES = [
            [
                "region" => "AFRIQUE DU SUD",
                "departement" => "AFRIQUE DU SUD",
                "commune" => "JOHANESBOURG",
                "total" => 1344
            ],
            [
                "region" => "AFRIQUE DU SUD",
                "departement" => "AFRIQUE DU SUD",
                "commune" => "CAP TOWN",
                "total" => 349
            ],
            [
                "region" => "AFRIQUE DU SUD",
                "departement" => "AFRIQUE DU SUD",
                "commune" => "DURBAN",
                "total" => 341
            ],
            [
                "region" => "AFRIQUE DU SUD",
                "departement" => "AFRIQUE DU SUD",
                "commune" => "PORT ELISABETH",
                "total" => 307
            ],
            [
                "region" => "AFRIQUE DU SUD",
                "departement" => "AFRIQUE DU SUD",
                "commune" => "PRETORIA",
                "total" => 129
            ],
            [
                "region" => "AFRIQUE DU SUD",
                "departement" => "MOZAMBIQUE",
                "commune" => "PEMBA",
                "total" => 169
            ],
            [
                "region" => "AFRIQUE DU SUD",
                "departement" => "MOZAMBIQUE",
                "commune" => "NAMPULA",
                "total" => 147
            ],
            [
                "region" => "AFRIQUE DU SUD",
                "departement" => "MOZAMBIQUE",
                "commune" => "MAPUTO",
                "total" => 123
            ],
            [
                "region" => "AFRIQUE DU SUD",
                "departement" => "MOZAMBIQUE",
                "commune" => "BEIRA",
                "total" => 54
            ],
            [
                "region" => "ALLEMAGNE",
                "departement" => "ALLEMAGNE",
                "commune" => "MUNICH",
                "total" => 405
            ],
            [
                "region" => "ALLEMAGNE",
                "departement" => "ALLEMAGNE",
                "commune" => "BERLIN",
                "total" => 291
            ],
            [
                "region" => "ALLEMAGNE",
                "departement" => "ALLEMAGNE",
                "commune" => "DUSSELDORF",
                "total" => 185
            ],
            [
                "region" => "ALLEMAGNE",
                "departement" => "ALLEMAGNE",
                "commune" => "HAMBOURG",
                "total" => 171
            ],
            [
                "region" => "ALLEMAGNE",
                "departement" => "ALLEMAGNE",
                "commune" => "FRANCFORT",
                "total" => 84
            ],
            [
                "region" => "ALLEMAGNE",
                "departement" => "ALLEMAGNE",
                "commune" => "STUTTGART",
                "total" => 61
            ],
            [
                "region" => "ARABIE SAOUDITE",
                "departement" => "ARABIE SAOUDITE",
                "commune" => "DJEDDAH",
                "total" => 1204
            ],
            [
                "region" => "ARABIE SAOUDITE",
                "departement" => "ARABIE SAOUDITE",
                "commune" => "RIYAD",
                "total" => 908
            ],
            [
                "region" => "BELGIQUE",
                "departement" => "BELGIQUE",
                "commune" => "BRUXELLES",
                "total" => 1750
            ],
            [
                "region" => "BELGIQUE",
                "departement" => "BELGIQUE",
                "commune" => "ANVERS",
                "total" => 539
            ],
            [
                "region" => "BELGIQUE",
                "departement" => "LUXEMBOURG",
                "commune" => "LUXEMBOURG",
                "total" => 159
            ],
            [
                "region" => "BRESIL",
                "departement" => "ARGENTINE",
                "commune" => "BUENOS AIRES",
                "total" => 1554
            ],
            [
                "region" => "BRESIL",
                "departement" => "ARGENTINE",
                "commune" => "MENDOZA",
                "total" => 111
            ],
            [
                "region" => "BRESIL",
                "departement" => "BRESIL",
                "commune" => "RIO GRANDE SUL",
                "total" => 1113
            ],
            [
                "region" => "BRESIL",
                "departement" => "BRESIL",
                "commune" => "SAO PAULO",
                "total" => 663
            ],
            [
                "region" => "BRESIL",
                "departement" => "BRESIL",
                "commune" => "RIO DE JANEIRO",
                "total" => 155
            ],
            [
                "region" => "BRESIL",
                "departement" => "BRESIL",
                "commune" => "RECIFE",
                "total" => 113
            ],
            [
                "region" => "BRESIL",
                "departement" => "BRESIL",
                "commune" => "BRASILIA",
                "total" => 60
            ],
            [
                "region" => "BRESIL",
                "departement" => "BRESIL",
                "commune" => "PARANA",
                "total" => 51
            ],
            [
                "region" => "BURKINA FASO",
                "departement" => "BURKINA FASO",
                "commune" => "BOBODIOULASSO",
                "total" => 177
            ],
            [
                "region" => "CAMEROUN",
                "departement" => "CAMEROUN",
                "commune" => "YAOUNDE",
                "total" => 1870
            ],
            [
                "region" => "CAMEROUN",
                "departement" => "CAMEROUN",
                "commune" => "DOUALA",
                "total" => 865
            ],
            [
                "region" => "CAMEROUN",
                "departement" => "TCHAD",
                "commune" => "NDJAMENA",
                "total" => 261
            ],
            [
                "region" => "CANADA",
                "departement" => "CANADA",
                "commune" => "MONTREAL",
                "total" => 2495
            ],
            [
                "region" => "CANADA",
                "departement" => "CANADA",
                "commune" => "QUEBEC",
                "total" => 525
            ],
            [
                "region" => "CANADA",
                "departement" => "CANADA",
                "commune" => "OTTAWA",
                "total" => 457
            ],
            [
                "region" => "CANADA",
                "departement" => "CANADA",
                "commune" => "EDMONTON",
                "total" => 193
            ],
            [
                "region" => "CANADA",
                "departement" => "CANADA",
                "commune" => "WINNIPEG",
                "total" => 169
            ],
            [
                "region" => "CANADA",
                "departement" => "CANADA",
                "commune" => "TORONTO",
                "total" => 147
            ],
            [
                "region" => "CAP VERT",
                "departement" => "CAP VERT",
                "commune" => "PRAIA",
                "total" => 1064
            ],
            [
                "region" => "CAP VERT",
                "departement" => "CAP VERT",
                "commune" => "SAL",
                "total" => 492
            ],
            [
                "region" => "CAP VERT",
                "departement" => "CAP VERT",
                "commune" => "SAO VICENTE",
                "total" => 113
            ],
            [
                "region" => "CONGO",
                "departement" => "REPUBLIQUE DU CONGO",
                "commune" => "POINTE NOIRE",
                "total" => 6704
            ],
            [
                "region" => "CONGO",
                "departement" => "REPUBLIQUE DU CONGO",
                "commune" => "BRAZAVILLE",
                "total" => 3106
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D-IVOIRE",
                "commune" => "ABENGOUROU",
                "total" => 188
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "ABIDJAN",
                "total" => 12794
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "YAMOUSSOUKRO",
                "total" => 1180
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "GAGNOA",
                "total" => 1029
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "BOUAKE",
                "total" => 1014
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "DALOA",
                "total" => 588
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "SEGUELA",
                "total" => 486
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "SAN PEDRO",
                "total" => 300
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "KORHOGO",
                "total" => 215
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "AGBOVILLE",
                "total" => 129
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "DUEKOUE",
                "total" => 122
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "BONDOUKOU",
                "total" => 78
            ],
            [
                "region" => "COTE D'IVOIRE",
                "departement" => "COTE D'IVOIRE",
                "commune" => "BOUNDIALI",
                "total" => 51
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "PARCELLES ASSAINIES",
                "total" => 95498
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "GRAND YOFF",
                "total" => 81184
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "YOFF",
                "total" => 53298
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "MEDINA",
                "total" => 49519
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "OUAKAM",
                "total" => 38879
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "GUEULE TAPEE FASS CO",
                "total" => 37409
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "PLATEAU",
                "total" => 36295
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "BISCUITERIE",
                "total" => 35267
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "HANN BEL AIR",
                "total" => 34118
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "GRAND DAKAR",
                "total" => 32379
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "SICAP LIBERTE",
                "total" => 30034
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "DIEUPPEUL DERKLE",
                "total" => 28091
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "H L M",
                "total" => 26001
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "CAMBERENE",
                "total" => 24668
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "PATTE D OIE",
                "total" => 24108
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "MERMOZ SACRE COEUR",
                "total" => 24010
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "FANN POINT E  AMITIE",
                "total" => 17458
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "NGOR",
                "total" => 10090
            ],
            [
                "region" => "DAKAR",
                "departement" => "DAKAR",
                "commune" => "GOREE",
                "total" => 2179
            ],
            [
                "region" => "DAKAR",
                "departement" => "GUEDIAWAYE",
                "commune" => "GOLF SUD",
                "total" => 53528
            ],
            [
                "region" => "DAKAR",
                "departement" => "GUEDIAWAYE",
                "commune" => "WAKHINANE NIMZAT",
                "total" => 49299
            ],
            [
                "region" => "DAKAR",
                "departement" => "GUEDIAWAYE",
                "commune" => "SAM",
                "total" => 44416
            ],
            [
                "region" => "DAKAR",
                "departement" => "GUEDIAWAYE",
                "commune" => "NDIAREME",
                "total" => 26191
            ],
            [
                "region" => "DAKAR",
                "departement" => "GUEDIAWAYE",
                "commune" => "MEDINA GOUNASS",
                "total" => 22106
            ],
            [
                "region" => "DAKAR",
                "departement" => "KEUR MASSAR",
                "commune" => "KEUR MASSAR NORD",
                "total" => 60053
            ],
            [
                "region" => "DAKAR",
                "departement" => "KEUR MASSAR",
                "commune" => "YEUMBEUL NORD",
                "total" => 58013
            ],
            [
                "region" => "DAKAR",
                "departement" => "KEUR MASSAR",
                "commune" => "YEUMBEUL SUD",
                "total" => 47710
            ],
            [
                "region" => "DAKAR",
                "departement" => "KEUR MASSAR",
                "commune" => "MALIKA",
                "total" => 28410
            ],
            [
                "region" => "DAKAR",
                "departement" => "KEUR MASSAR",
                "commune" => "KEUR MASSAR SUD",
                "total" => 27339
            ],
            [
                "region" => "DAKAR",
                "departement" => "KEUR MASSAR",
                "commune" => "JAXAAY-PARCELLES",
                "total" => 15139
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "DIAMAGUENE SICAP MBAO",
                "total" => 56536
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "MBAO",
                "total" => 50557
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "DJIDA THIAROYE KAO",
                "total" => 45818
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "PIKINE OUEST",
                "total" => 36617
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "PIKINE NORD",
                "total" => 28298
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "THIAROYE SUR MER",
                "total" => 26898
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "PIKINE EST",
                "total" => 25750
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "TIVAOUANE DIAKSAO",
                "total" => 25632
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "THIAROYE GARE",
                "total" => 23338
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "GUINAW RAIL SUD",
                "total" => 21676
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "DALIFORT",
                "total" => 19112
            ],
            [
                "region" => "DAKAR",
                "departement" => "PIKINE",
                "commune" => "GUINAW RAIL NORD",
                "total" => 16340
            ],
            [
                "region" => "DAKAR",
                "departement" => "RUFISQUE",
                "commune" => "RUFISQUE NORD",
                "total" => 42732
            ],
            [
                "region" => "DAKAR",
                "departement" => "RUFISQUE",
                "commune" => "RUFISQUE EST",
                "total" => 42486
            ],
            [
                "region" => "DAKAR",
                "departement" => "RUFISQUE",
                "commune" => "RUFISQUE OUEST",
                "total" => 32200
            ],
            [
                "region" => "DAKAR",
                "departement" => "RUFISQUE",
                "commune" => "BARGNY",
                "total" => 27598
            ],
            [
                "region" => "DAKAR",
                "departement" => "RUFISQUE",
                "commune" => "TIVAOUANE PEULH - NIAGA",
                "total" => 26217
            ],
            [
                "region" => "DAKAR",
                "departement" => "RUFISQUE",
                "commune" => "SANGALKAM",
                "total" => 23453
            ],
            [
                "region" => "DAKAR",
                "departement" => "RUFISQUE",
                "commune" => "BAMBYLOR",
                "total" => 18463
            ],
            [
                "region" => "DAKAR",
                "departement" => "RUFISQUE",
                "commune" => "SEBIKOTANE",
                "total" => 16186
            ],
            [
                "region" => "DAKAR",
                "departement" => "RUFISQUE",
                "commune" => "YENE",
                "total" => 14672
            ],
            [
                "region" => "DAKAR",
                "departement" => "RUFISQUE",
                "commune" => "DIAMNIADIO",
                "total" => 13839
            ],
            [
                "region" => "DAKAR",
                "departement" => "RUFISQUE",
                "commune" => "SENDOU",
                "total" => 1931
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "BAMBEY",
                "total" => 16874
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "NGOYE",
                "total" => 15433
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "DANGALMA",
                "total" => 14093
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "NGOGOM",
                "total" => 11750
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "REFANE",
                "total" => 11326
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "LAMBAYE",
                "total" => 11100
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "NDONDOL",
                "total" => 8136
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "THIAKHAR",
                "total" => 8017
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "KEUR SAMBA KANE",
                "total" => 7946
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "BABA GARAGE",
                "total" => 7824
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "GAWANE",
                "total" => 5013
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "BAMBEY",
                "commune" => "DINGUIRAYE  (BAMBEY)",
                "total" => 4809
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "DIOURBEL",
                "total" => 65840
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "NGOHE",
                "total" => 10459
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "PATTAR",
                "total" => 6945
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "TOCKY GARE",
                "total" => 6863
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "NDINDY",
                "total" => 6030
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "NDOULO",
                "total" => 5356
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "TOURE MBONDE",
                "total" => 4544
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "TAIBA MOUTOUPHA",
                "total" => 3980
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "DANKH SENE",
                "total" => 3862
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "KEUR NGALGOU",
                "total" => 2795
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "GADE ESCALE",
                "total" => 1642
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "DIOURBEL",
                "commune" => "TOUBA LAPPE",
                "total" => 1476
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "TOUBA MOSQUEE",
                "total" => 272500
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "MBACKE",
                "total" => 42590
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "SADIO",
                "total" => 9181
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "TAIF",
                "total" => 7652
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "MISSIRAH (MBACKE)",
                "total" => 4160
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "DALLA NGABOU",
                "total" => 3792
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "TOUBA MBOUL",
                "total" => 3737
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "TOUBA FALL",
                "total" => 3211
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "KAEL",
                "total" => 2890
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "NGHAYE",
                "total" => 2825
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "DANDEYE GOUYGUI",
                "total" => 2672
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "MADINA",
                "total" => 2541
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "DAROU SALAM TYP",
                "total" => 2480
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "NDIOUMANE",
                "total" => 2028
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "DAROU NAHIM",
                "total" => 1797
            ],
            [
                "region" => "DIOURBEL",
                "departement" => "MBACKE",
                "commune" => "TAIBA THIEKENE",
                "total" => 1660
            ],
            [
                "region" => "EGYPTE",
                "departement" => "EGYPTE",
                "commune" => "CAIRE",
                "total" => 509
            ],
            [
                "region" => "EGYPTE",
                "departement" => "LIBAN",
                "commune" => "BEYROUTH",
                "total" => 604
            ],
            [
                "region" => "EMIRATS ARABES UNIS",
                "departement" => "EMIRATS ARABES UNIS",
                "commune" => "ABU DHABI",
                "total" => 524
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "ROQUETAS DE MAR",
                "total" => 3417
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "MADRID",
                "total" => 2668
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "LERIDA",
                "total" => 2087
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "BILBAO",
                "total" => 1754
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "PALMA DE MALLORCA",
                "total" => 1683
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "ZARAGOZA",
                "total" => 1659
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "MURCIA",
                "total" => 1480
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "BARCELONA",
                "total" => 1434
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "GRANOLLERS",
                "total" => 1390
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "VALENCIA",
                "total" => 1348
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "ALMERIA",
                "total" => 1256
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "MATARO",
                "total" => 1191
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "TERRASSA",
                "total" => 1090
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "TARRAGONA",
                "total" => 1064
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "GIRONA",
                "total" => 950
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "GRANADA",
                "total" => 840
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "MALAGA",
                "total" => 623
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "FIGUERES",
                "total" => 597
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "TENERIFE",
                "total" => 557
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "ALICANTE",
                "total" => 497
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "OVIEDO",
                "total" => 491
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "VIGO",
                "total" => 487
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "GUISSONA",
                "total" => 439
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "LAS PALMAS GRAND CANARIAS",
                "total" => 410
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "HUELVA",
                "total" => 377
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "SEVILLA",
                "total" => 371
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "FUERTEVENTURA",
                "total" => 355
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "ALBACETE",
                "total" => 349
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "VICTORIA",
                "total" => 321
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "PAMPLONA",
                "total" => 299
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "GANDIA",
                "total" => 233
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "IBIZA",
                "total" => 221
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "MANRESA",
                "total" => 213
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "MARBELLA",
                "total" => 211
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "SANTANDER",
                "total" => 209
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "ELCHE",
                "total" => 193
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "LANZAROTE",
                "total" => 177
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "CALPE (BENIDORM)",
                "total" => 164
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "CADIZ",
                "total" => 153
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "SALAMANCA",
                "total" => 129
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "TENERIFE NORTE",
                "total" => 105
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "LOGRONO",
                "total" => 101
            ],
            [
                "region" => "ESPAGNE",
                "departement" => "ESPAGNE",
                "commune" => "ALGESIRAS",
                "total" => 66
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "FATICK",
                "total" => 21633
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "NIAKHAR",
                "total" => 13983
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "FIMELA",
                "total" => 13438
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "TATTAGUINE",
                "total" => 13073
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "DIARRERE",
                "total" => 12663
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "NGAYOKHEME",
                "total" => 11378
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "PATAR",
                "total" => 10735
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "DIOUROUP",
                "total" => 10596
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "LOUL SESSENE",
                "total" => 9193
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "THIARE NDIALGUI",
                "total" => 8769
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "DIOFIOR",
                "total" => 8025
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "NDIOB",
                "total" => 7832
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "MBELLACADIAO",
                "total" => 6823
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "DIAOULE",
                "total" => 6052
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "PALMARIN FACAO",
                "total" => 4831
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "DJILASS",
                "total" => 4721
            ],
            [
                "region" => "FATICK",
                "departement" => "FATICK",
                "commune" => "DIAKHAO",
                "total" => 3240
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "TOUBACOUTA",
                "total" => 14800
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "NIORO ALASSANE TALL",
                "total" => 11368
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "SOKONE",
                "total" => 10283
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "DIOSSONG",
                "total" => 8953
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "KEUR SAMBA GUEYE",
                "total" => 8945
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "DJILOR",
                "total" => 8829
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "KEUR SALOUM DIANE",
                "total" => 8186
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "DIONEWAR",
                "total" => 7594
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "BASSOUL",
                "total" => 6321
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "PASSI",
                "total" => 6301
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "KARANG POSTE",
                "total" => 6277
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "MBAM",
                "total" => 5913
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "NIASSENE",
                "total" => 5629
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "FOUNDIOUGNE",
                "total" => 5210
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "DJIRNDA",
                "total" => 5198
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "DIAGANE BARKA",
                "total" => 3606
            ],
            [
                "region" => "FATICK",
                "departement" => "FOUNDIOUGNE",
                "commune" => "SOUM",
                "total" => 2830
            ],
            [
                "region" => "FATICK",
                "departement" => "GOSSAS",
                "commune" => "MBAR",
                "total" => 10331
            ],
            [
                "region" => "FATICK",
                "departement" => "GOSSAS",
                "commune" => "COLOBANE",
                "total" => 9359
            ],
            [
                "region" => "FATICK",
                "departement" => "GOSSAS",
                "commune" => "GOSSAS",
                "total" => 8566
            ],
            [
                "region" => "FATICK",
                "departement" => "GOSSAS",
                "commune" => "PATAR LIA",
                "total" => 6707
            ],
            [
                "region" => "FATICK",
                "departement" => "GOSSAS",
                "commune" => "OUADIOUR",
                "total" => 5717
            ],
            [
                "region" => "FATICK",
                "departement" => "GOSSAS",
                "commune" => "NDIENE LAGANE",
                "total" => 4992
            ],
            [
                "region" => "FRANCE",
                "departement" => "FRANCE",
                "commune" => "PARIS",
                "total" => 41991
            ],
            [
                "region" => "FRANCE",
                "departement" => "FRANCE",
                "commune" => "LE HAVRE",
                "total" => 4223
            ],
            [
                "region" => "FRANCE",
                "departement" => "FRANCE",
                "commune" => "LYON",
                "total" => 3777
            ],
            [
                "region" => "FRANCE",
                "departement" => "FRANCE",
                "commune" => "MARSEILLE",
                "total" => 3238
            ],
            [
                "region" => "FRANCE",
                "departement" => "FRANCE",
                "commune" => "BORDEAUX",
                "total" => 2977
            ],
            [
                "region" => "FRANCE",
                "departement" => "FRANCE",
                "commune" => "LILLE",
                "total" => 1415
            ],
            [
                "region" => "FRANCE",
                "departement" => "FRANCE",
                "commune" => "TOULOUSE",
                "total" => 764
            ],
            [
                "region" => "FRANCE",
                "departement" => "FRANCE",
                "commune" => "NICE",
                "total" => 744
            ],
            [
                "region" => "FRANCE",
                "departement" => "FRANCE",
                "commune" => "MONTPELLIER",
                "total" => 719
            ],
            [
                "region" => "FRANCE",
                "departement" => "FRANCE",
                "commune" => "CANNES",
                "total" => 433
            ],
            [
                "region" => "FRANCE",
                "departement" => "FRANCE",
                "commune" => "TOULON",
                "total" => 245
            ],
            [
                "region" => "GABON",
                "departement" => "GABON",
                "commune" => "LIBREVILLE",
                "total" => 11450
            ],
            [
                "region" => "GABON",
                "departement" => "GABON",
                "commune" => "PORT GENTIL",
                "total" => 2470
            ],
            [
                "region" => "GABON",
                "departement" => "GABON",
                "commune" => "MAKOKOU",
                "total" => 177
            ],
            [
                "region" => "GABON",
                "departement" => "GABON",
                "commune" => "NTOUM",
                "total" => 164
            ],
            [
                "region" => "GABON",
                "departement" => "GABON",
                "commune" => "MOUILA",
                "total" => 163
            ],
            [
                "region" => "GABON",
                "departement" => "GABON",
                "commune" => "MOANDA",
                "total" => 161
            ],
            [
                "region" => "GABON",
                "departement" => "GABON",
                "commune" => "GAMBA",
                "total" => 159
            ],
            [
                "region" => "GABON",
                "departement" => "GABON",
                "commune" => "BITAM",
                "total" => 107
            ],
            [
                "region" => "GABON",
                "departement" => "GABON",
                "commune" => "TCHIBANGA",
                "total" => 76
            ],
            [
                "region" => "GABON",
                "departement" => "GABON",
                "commune" => "LASTOURVILLE",
                "total" => 75
            ],
            [
                "region" => "GABON",
                "departement" => "GABON",
                "commune" => "MITZIC",
                "total" => 58
            ],
            [
                "region" => "GABON",
                "departement" => "GUINEE EQUATORIALE",
                "commune" => "BATA",
                "total" => 728
            ],
            [
                "region" => "GABON",
                "departement" => "GUINEE EQUATORIALE",
                "commune" => "MALABO",
                "total" => 687
            ],
            [
                "region" => "GABON",
                "departement" => "GUINEE EQUATORIALE",
                "commune" => "MONGOMO",
                "total" => 227
            ],
            [
                "region" => "GAMBIE",
                "departement" => "GAMBIE",
                "commune" => "SEREKUNDA",
                "total" => 5215
            ],
            [
                "region" => "GAMBIE",
                "departement" => "GAMBIE",
                "commune" => "BANJUL",
                "total" => 3022
            ],
            [
                "region" => "GAMBIE",
                "departement" => "GAMBIE",
                "commune" => "NORTH BANK DIVISION",
                "total" => 1124
            ],
            [
                "region" => "GAMBIE",
                "departement" => "GAMBIE",
                "commune" => "UPPER RIVER DIVISION",
                "total" => 694
            ],
            [
                "region" => "GAMBIE",
                "departement" => "GAMBIE",
                "commune" => "BAKAU",
                "total" => 561
            ],
            [
                "region" => "GAMBIE",
                "departement" => "GAMBIE",
                "commune" => "CENTRAL RIVER DIVISION",
                "total" => 405
            ],
            [
                "region" => "GAMBIE",
                "departement" => "GAMBIE",
                "commune" => "LOWER RIVER DIVISION",
                "total" => 207
            ],
            [
                "region" => "GHANA",
                "departement" => "GHANA",
                "commune" => "ACCRA",
                "total" => 227
            ],
            [
                "region" => "GRANDE BRETAGNE",
                "departement" => "ANGLETERRE",
                "commune" => "LONDRES",
                "total" => 1045
            ],
            [
                "region" => "GRANDE BRETAGNE",
                "departement" => "ANGLETERRE",
                "commune" => "MANCHESTER",
                "total" => 263
            ],
            [
                "region" => "GRANDE BRETAGNE",
                "departement" => "ANGLETERRE",
                "commune" => "BIRMINGHAM",
                "total" => 131
            ],
            [
                "region" => "GUINEE",
                "departement" => "GUINEE",
                "commune" => "CONAKRY",
                "total" => 2460
            ],
            [
                "region" => "GUINEE",
                "departement" => "GUINEE",
                "commune" => "LABE",
                "total" => 145
            ],
            [
                "region" => "GUINEE",
                "departement" => "GUINEE",
                "commune" => "KAMSAR",
                "total" => 101
            ],
            [
                "region" => "GUINEE",
                "departement" => "GUINEE",
                "commune" => "TIMBI MADINA",
                "total" => 58
            ],
            [
                "region" => "GUINEE BISSAU",
                "departement" => "GUINEE BISSAU",
                "commune" => "BISSAU",
                "total" => 2892
            ],
            [
                "region" => "GUINEE BISSAU",
                "departement" => "GUINEE BISSAU",
                "commune" => "CANCHUNGO",
                "total" => 297
            ],
            [
                "region" => "GUINEE BISSAU",
                "departement" => "GUINEE BISSAU",
                "commune" => "INGORE",
                "total" => 204
            ],
            [
                "region" => "GUINEE BISSAU",
                "departement" => "GUINEE BISSAU",
                "commune" => "SAO DOMINGOS",
                "total" => 169
            ],
            [
                "region" => "GUINEE BISSAU",
                "departement" => "GUINEE BISSAU",
                "commune" => "BAFATA",
                "total" => 101
            ],
            [
                "region" => "GUINEE BISSAU",
                "departement" => "GUINEE BISSAU",
                "commune" => "FARIM",
                "total" => 82
            ],
            [
                "region" => "GUINEE BISSAU",
                "departement" => "GUINEE BISSAU",
                "commune" => "BISSORA",
                "total" => 73
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "MILAN",
                "total" => 6727
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "BERGAMO",
                "total" => 3643
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "BRESCIA",
                "total" => 3400
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "ROME",
                "total" => 2846
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "PISE",
                "total" => 1942
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "NAPLES",
                "total" => 1697
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "GENES",
                "total" => 1278
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "TREVISO",
                "total" => 1146
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "TORINO VILLE",
                "total" => 1122
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "RIMINI",
                "total" => 1102
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "PARMA",
                "total" => 1013
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "NOVARA (BIERA VERCELLI)",
                "total" => 1007
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "LECCO",
                "total" => 979
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "FAENZA",
                "total" => 873
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "CAGLIARI",
                "total" => 861
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "LIVORNE",
                "total" => 821
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "PESCARA",
                "total" => 806
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "CATANIA",
                "total" => 798
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "BARI",
                "total" => 721
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "VICENZA",
                "total" => 719
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "FLORENCE",
                "total" => 709
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "VERONA",
                "total" => 669
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "LECCE",
                "total" => 567
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "PIACENZA",
                "total" => 567
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "COMO",
                "total" => 541
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "FIRENZI",
                "total" => 537
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "PADOVA",
                "total" => 525
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "SASSARI",
                "total" => 525
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "REGGIO EMILIA",
                "total" => 521
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "RAVENNA",
                "total" => 511
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "MACERATA",
                "total" => 481
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "BOLOGNA",
                "total" => 469
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "CASERTA",
                "total" => 427
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "VENEZIA MESTRE",
                "total" => 409
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "AGRIGENTO",
                "total" => 393
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "MONZA",
                "total" => 375
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "MANTOVA",
                "total" => 357
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "SIENA",
                "total" => 349
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "BASSANO DEL GRAPA",
                "total" => 327
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "SALERNO",
                "total" => 321
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "OLBIA",
                "total" => 311
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "TRIESTE",
                "total" => 305
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "ASTI",
                "total" => 269
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "BOLZANO",
                "total" => 267
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "ISCHIO",
                "total" => 259
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "FANO",
                "total" => 245
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "SANTA CROCE SULLZARNO",
                "total" => 243
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "PALERME",
                "total" => 227
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "LEMEZIA TERME",
                "total" => 225
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "MODENA",
                "total" => 187
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "TRENTO",
                "total" => 187
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "UDINE",
                "total" => 173
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "SEREGNO",
                "total" => 161
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "FOGGIA",
                "total" => 151
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "PIOMBINO",
                "total" => 133
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "LA SPEZIA",
                "total" => 113
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "SAN BENEDETTO DEL TRONTO",
                "total" => 94
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "ANCONA",
                "total" => 88
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "MASSA CARRARA",
                "total" => 84
            ],
            [
                "region" => "ITALIE",
                "departement" => "ITALIE",
                "commune" => "REGGIO CALABRIA",
                "total" => 84
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "BIRKILANE",
                "commune" => "NDIOGNICK",
                "total" => 13927
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "BIRKILANE",
                "commune" => "MABO",
                "total" => 10395
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "BIRKILANE",
                "commune" => "BIRKILANE",
                "total" => 5309
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "BIRKILANE",
                "commune" => "DIAMAL",
                "total" => 4897
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "BIRKILANE",
                "commune" => "TOUBA MBELLA",
                "total" => 4627
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "BIRKILANE",
                "commune" => "KEUR MBOUCKI",
                "total" => 4358
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "BIRKILANE",
                "commune" => "SEGRE GATTA",
                "total" => 2662
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "BIRKILANE",
                "commune" => "MBEULEUP",
                "total" => 2603
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KAFFRINE",
                "commune" => "KAFFRINE",
                "total" => 24720
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KAFFRINE",
                "commune" => "KATHIOTE",
                "total" => 12375
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KAFFRINE",
                "commune" => "BOULEL",
                "total" => 9444
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KAFFRINE",
                "commune" => "DIOKOUL MBELBOUCK",
                "total" => 8762
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KAFFRINE",
                "commune" => "KAHI",
                "total" => 8230
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KAFFRINE",
                "commune" => "MEDINATOUL SALAM 2",
                "total" => 7462
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KAFFRINE",
                "commune" => "DIAMAGADIO",
                "total" => 7084
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KAFFRINE",
                "commune" => "GNIBY",
                "total" => 6652
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KAFFRINE",
                "commune" => "NGANDA",
                "total" => 5497
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KOUNGHEUL",
                "commune" => "KOUNGHEUL",
                "total" => 13334
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KOUNGHEUL",
                "commune" => "LOUR ESCALE",
                "total" => 9323
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KOUNGHEUL",
                "commune" => "FASS THIEKENE",
                "total" => 7905
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KOUNGHEUL",
                "commune" => "MISSIRAH WADENE",
                "total" => 7848
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KOUNGHEUL",
                "commune" => "SALY ESCALE",
                "total" => 7616
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KOUNGHEUL",
                "commune" => "IDA MOURIDE",
                "total" => 7587
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KOUNGHEUL",
                "commune" => "NGAINTHE PATE",
                "total" => 6482
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KOUNGHEUL",
                "commune" => "RIBOT ESCALE",
                "total" => 6285
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "KOUNGHEUL",
                "commune" => "MAKA YOP",
                "total" => 5427
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "MALEM HODAR",
                "commune" => "SAGNA",
                "total" => 13519
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "MALEM HODAR",
                "commune" => "DJANKE SOUF",
                "total" => 6990
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "MALEM HODAR",
                "commune" => "DAROU MINAM",
                "total" => 6032
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "MALEM HODAR",
                "commune" => "NDIOUM NGAINTHE",
                "total" => 4764
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "MALEM HODAR",
                "commune" => "MALEM HODAR",
                "total" => 4197
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "MALEM HODAR",
                "commune" => "NDIOBENE SAMBA LAMO",
                "total" => 2827
            ],
            [
                "region" => "KAFFRINE",
                "departement" => "MALEM HODAR",
                "commune" => "KHELCOM",
                "total" => 403
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "GUINGUINEO",
                "total" => 10830
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "MBADAKHOUNE",
                "total" => 6881
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "NGATHIE NAOUDE",
                "total" => 5478
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "KHELCOM BIRAME",
                "total" => 5283
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "NDIAGO",
                "total" => 4537
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "OUROUR",
                "total" => 4313
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "NGAGNICK",
                "total" => 3777
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "NGELLOU",
                "total" => 3718
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "PANAL WOLOF",
                "total" => 2756
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "FASS",
                "total" => 2576
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "MBOSS",
                "total" => 2523
            ],
            [
                "region" => "KAOLACK",
                "departement" => "GUINGUINEO",
                "commune" => "DARA MBOSS",
                "total" => 2509
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "KAOLACK",
                "total" => 129870
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "NDIAFFATE",
                "total" => 14065
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "LATMINGUE",
                "total" => 11900
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "NDIEDIENG",
                "total" => 10512
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "KEUR SOCE",
                "total" => 9456
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "KEUR BAKA",
                "total" => 9265
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "THIARE",
                "total" => 8627
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "NDOFFANE",
                "total" => 8610
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "KAHONE",
                "total" => 8496
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "GANDIAYE",
                "total" => 8173
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "THIOMBY",
                "total" => 7009
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "DYA",
                "total" => 6810
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "NDIEBEL",
                "total" => 5485
            ],
            [
                "region" => "KAOLACK",
                "departement" => "KAOLACK",
                "commune" => "SIBASSOR",
                "total" => 4987
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "MEDINA SABAKH",
                "total" => 17927
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "WACK NGOUNA",
                "total" => 14511
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "NIORO DU RIP",
                "total" => 13252
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "POROKHANE",
                "total" => 12095
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "TAIBA NIASSENE",
                "total" => 10800
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "DAROU SALAM",
                "total" => 10161
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "KEUR MABA DIAKHOU",
                "total" => 9669
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "GAINTE KAYE",
                "total" => 9008
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "NGAYENE",
                "total" => 8687
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "KAYEMOR",
                "total" => 8463
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "PAOSKOTO",
                "total" => 7522
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "NDRAME ESCALE",
                "total" => 7057
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "KEUR MADIABEL",
                "total" => 6222
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "DABALY",
                "total" => 4722
            ],
            [
                "region" => "KAOLACK",
                "departement" => "NIORO DU RIP",
                "commune" => "KEUR MADONGO",
                "total" => 3836
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "KEDOUGOU",
                "commune" => "KEDOUGOU",
                "total" => 16691
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "KEDOUGOU",
                "commune" => "BANDAFASSI",
                "total" => 6160
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "KEDOUGOU",
                "commune" => "TOMBORONKOTO",
                "total" => 4958
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "KEDOUGOU",
                "commune" => "DIMBOLI",
                "total" => 2972
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "KEDOUGOU",
                "commune" => "FONGOLIMBI",
                "total" => 2951
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "KEDOUGOU",
                "commune" => "NINEFECHA",
                "total" => 2811
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "KEDOUGOU",
                "commune" => "DINDEFELO",
                "total" => 2797
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SALEMATA",
                "commune" => "SALEMATA",
                "total" => 2634
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SALEMATA",
                "commune" => "DAKATELY",
                "total" => 2263
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SALEMATA",
                "commune" => "DAR SALAM",
                "total" => 1867
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SALEMATA",
                "commune" => "ETHIOLO",
                "total" => 1792
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SALEMATA",
                "commune" => "KEVOYE",
                "total" => 1538
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SALEMATA",
                "commune" => "OUBADJI",
                "total" => 1019
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SARAYA",
                "commune" => "BEMBOU",
                "total" => 4877
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SARAYA",
                "commune" => "SABODOLA",
                "total" => 3828
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SARAYA",
                "commune" => "MISSIRAH SIRIMANA",
                "total" => 3363
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SARAYA",
                "commune" => "MEDINA BAFFE",
                "total" => 2629
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SARAYA",
                "commune" => "KHOSSANTO",
                "total" => 2302
            ],
            [
                "region" => "KEDOUGOU",
                "departement" => "SARAYA",
                "commune" => "SARAYA",
                "total" => 1928
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "KOLDA",
                "total" => 38724
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "DIOULACOLON",
                "total" => 6665
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "MAMPATIM",
                "total" => 6505
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "SARE BIDJI",
                "total" => 6428
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "BAGADAJI",
                "total" => 5346
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "GUIRO YERO BOCAR",
                "total" => 5096
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "MEDINA CHERIF",
                "total" => 4984
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "TANKANTO ESCALE",
                "total" => 4850
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "DIALAMBERE",
                "total" => 4476
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "MEDINA EL HADJI",
                "total" => 4372
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "COUMBACARA",
                "total" => 4134
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "DABO",
                "total" => 3198
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "SALIKEGNE",
                "total" => 1828
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "THIETTY",
                "total" => 1819
            ],
            [
                "region" => "KOLDA",
                "departement" => "KOLDA",
                "commune" => "SARE YOBA DIEGA",
                "total" => 1495
            ],
            [
                "region" => "KOLDA",
                "departement" => "MEDINA YORO FOULAH",
                "commune" => "BOUROUCO",
                "total" => 7741
            ],
            [
                "region" => "KOLDA",
                "departement" => "MEDINA YORO FOULAH",
                "commune" => "KEREWANE",
                "total" => 7363
            ],
            [
                "region" => "KOLDA",
                "departement" => "MEDINA YORO FOULAH",
                "commune" => "DINGUIRAYE  (M.Y.F.)",
                "total" => 4652
            ],
            [
                "region" => "KOLDA",
                "departement" => "MEDINA YORO FOULAH",
                "commune" => "NIAMING",
                "total" => 4557
            ],
            [
                "region" => "KOLDA",
                "departement" => "MEDINA YORO FOULAH",
                "commune" => "BADION",
                "total" => 4169
            ],
            [
                "region" => "KOLDA",
                "departement" => "MEDINA YORO FOULAH",
                "commune" => "NDORNA",
                "total" => 3905
            ],
            [
                "region" => "KOLDA",
                "departement" => "MEDINA YORO FOULAH",
                "commune" => "BIGNARABE",
                "total" => 2643
            ],
            [
                "region" => "KOLDA",
                "departement" => "MEDINA YORO FOULAH",
                "commune" => "FAFACOUROU",
                "total" => 2612
            ],
            [
                "region" => "KOLDA",
                "departement" => "MEDINA YORO FOULAH",
                "commune" => "KOULINTO",
                "total" => 2611
            ],
            [
                "region" => "KOLDA",
                "departement" => "MEDINA YORO FOULAH",
                "commune" => "MEDINA YORO FOULAH",
                "total" => 1909
            ],
            [
                "region" => "KOLDA",
                "departement" => "MEDINA YORO FOULAH",
                "commune" => "PATA",
                "total" => 1632
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "MEDINA GOUNASSE",
                "total" => 19546
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "VELINGARA",
                "total" => 14934
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "DIAOBE KABENDOU",
                "total" => 9073
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "KANDIA",
                "total" => 7839
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "SARE COLI SALLE",
                "total" => 7521
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "SINTHIANG KOUNDARA",
                "total" => 6908
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "LINKERING",
                "total" => 6141
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "KOUNKANE",
                "total" => 5849
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "OUASSADOU",
                "total" => 5720
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "PAROUMBA",
                "total" => 5307
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "PAKOUR",
                "total" => 5119
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "BONCONTO",
                "total" => 4457
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "KANDIAYE",
                "total" => 4221
            ],
            [
                "region" => "KOLDA",
                "departement" => "VELINGARA",
                "commune" => "NEMATABA",
                "total" => 3990
            ],
            [
                "region" => "KOWEIT",
                "departement" => "KOWEIT",
                "commune" => "KOWEIT CITY",
                "total" => 68
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "DAROU MOUSTI",
                "total" => 20566
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "KEBEMER",
                "total" => 15948
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "NDANDE",
                "total" => 12684
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "THIOLOM FALL",
                "total" => 9357
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "DIOKOUL NDIAWRIGNE",
                "total" => 7102
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "SAGATA GUETH",
                "total" => 6940
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "BANDEGNE OUOLOF",
                "total" => 6328
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "THIEP",
                "total" => 5329
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "LORO",
                "total" => 5110
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "GUEOUL",
                "total" => 4946
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "KANENE NDIOB",
                "total" => 4892
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "NGOURANE OUOLOF",
                "total" => 4699
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "KAB GAYE",
                "total" => 4686
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "DAROU MARNANE",
                "total" => 4427
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "SAM YABAL",
                "total" => 3513
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "MBADIANE",
                "total" => 3323
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "TOUBA MERINA",
                "total" => 3015
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "NDOYENE",
                "total" => 2972
            ],
            [
                "region" => "LOUGA",
                "departement" => "KEBEMER",
                "commune" => "MBACKE CAJOR",
                "total" => 2349
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "DAHRA",
                "total" => 18201
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "LINGUERE",
                "total" => 11883
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "BARKEDJI",
                "total" => 9542
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "OUARKHOKH",
                "total" => 8638
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "THIAMENE PASSE",
                "total" => 7865
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "DEALY",
                "total" => 7765
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "BOULAL",
                "total" => 6519
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "DODJI",
                "total" => 6212
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "GASSANE",
                "total" => 6099
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "SAGATTA DJOLOF",
                "total" => 6054
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "THIEL",
                "total" => 5723
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "TESSEKERE FORAGE",
                "total" => 5564
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "MBOULA",
                "total" => 5426
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "KAMBE",
                "total" => 5001
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "LABGAR",
                "total" => 4864
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "THIARGNY",
                "total" => 4586
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "YANG YANG",
                "total" => 3391
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "AFFE DJOLOF",
                "total" => 2905
            ],
            [
                "region" => "LOUGA",
                "departement" => "LINGUERE",
                "commune" => "MBEULEUKHE",
                "total" => 1720
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "LOUGA",
                "total" => 55563
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "KEUR MOMAR SARR",
                "total" => 13940
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "LEONA",
                "total" => 13498
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "SAKAL",
                "total" => 12548
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "NGUER MALAL",
                "total" => 12073
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "NGUIDILE",
                "total" => 11144
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "KOKI",
                "total" => 10680
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "NIOMRE",
                "total" => 7781
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "THIAMENE CAYOR",
                "total" => 7714
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "NGUEUNE SARR",
                "total" => 7557
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "GANDE",
                "total" => 6235
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "MBEDIENE",
                "total" => 5275
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "KELLE GUEYE",
                "total" => 5189
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "SYER",
                "total" => 4980
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "NDIAGNE",
                "total" => 4497
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "GUET ARDO",
                "total" => 3907
            ],
            [
                "region" => "LOUGA",
                "departement" => "LOUGA",
                "commune" => "PETE OUARACK",
                "total" => 2639
            ],
            [
                "region" => "MALI",
                "departement" => "MALI",
                "commune" => "BAMAKO",
                "total" => 7786
            ],
            [
                "region" => "MALI",
                "departement" => "MALI",
                "commune" => "KAYES",
                "total" => 984
            ],
            [
                "region" => "MALI",
                "departement" => "MALI",
                "commune" => "KONIAKARY",
                "total" => 317
            ],
            [
                "region" => "MALI",
                "departement" => "MALI",
                "commune" => "SEGOU",
                "total" => 88
            ],
            [
                "region" => "MAROC",
                "departement" => "MAROC",
                "commune" => "CASABLANCA",
                "total" => 5954
            ],
            [
                "region" => "MAROC",
                "departement" => "MAROC",
                "commune" => "RABAT",
                "total" => 986
            ],
            [
                "region" => "MAROC",
                "departement" => "MAROC",
                "commune" => "MARRAKECH",
                "total" => 701
            ],
            [
                "region" => "MAROC",
                "departement" => "MAROC",
                "commune" => "AGADIR",
                "total" => 620
            ],
            [
                "region" => "MAROC",
                "departement" => "MAROC",
                "commune" => "FES",
                "total" => 431
            ],
            [
                "region" => "MAROC",
                "departement" => "MAROC",
                "commune" => "DAKHLA",
                "total" => 321
            ],
            [
                "region" => "MAROC",
                "departement" => "MAROC",
                "commune" => "TANGER",
                "total" => 277
            ],
            [
                "region" => "MAROC",
                "departement" => "MAROC",
                "commune" => "LAYOUNE",
                "total" => 123
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "ORKADIERE",
                "total" => 19987
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "WOURO SIDY",
                "total" => 15243
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "NDENDORY",
                "total" => 14585
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "BOKILADJI",
                "total" => 13676
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "AOURE",
                "total" => 13575
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "KANEL",
                "total" => 7818
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "SINTHIOU BAMAMBE BANADJI",
                "total" => 7749
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "HAMADI HOUNARE",
                "total" => 6214
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "OUAOUNDE",
                "total" => 4660
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "SEMME",
                "total" => 4198
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "ODOBERE",
                "total" => 3427
            ],
            [
                "region" => "MATAM",
                "departement" => "KANEL",
                "commune" => "DEMBANCANE",
                "total" => 3218
            ],
            [
                "region" => "MATAM",
                "departement" => "MATAM",
                "commune" => "NABADJI CIVOL",
                "total" => 27032
            ],
            [
                "region" => "MATAM",
                "departement" => "MATAM",
                "commune" => "BOKIDIAVE",
                "total" => 24143
            ],
            [
                "region" => "MATAM",
                "departement" => "MATAM",
                "commune" => "OGO",
                "total" => 21102
            ],
            [
                "region" => "MATAM",
                "departement" => "MATAM",
                "commune" => "DES AGNAM (AGNAM CIVOL)",
                "total" => 18635
            ],
            [
                "region" => "MATAM",
                "departement" => "MATAM",
                "commune" => "MATAM",
                "total" => 12380
            ],
            [
                "region" => "MATAM",
                "departement" => "MATAM",
                "commune" => "DABIA",
                "total" => 12363
            ],
            [
                "region" => "MATAM",
                "departement" => "MATAM",
                "commune" => "OREFONDE",
                "total" => 12007
            ],
            [
                "region" => "MATAM",
                "departement" => "MATAM",
                "commune" => "OUROSSOGUI",
                "total" => 10853
            ],
            [
                "region" => "MATAM",
                "departement" => "MATAM",
                "commune" => "THILOGNE",
                "total" => 6663
            ],
            [
                "region" => "MATAM",
                "departement" => "MATAM",
                "commune" => "NGUIDJILONE",
                "total" => 6584
            ],
            [
                "region" => "MATAM",
                "departement" => "RANEROU FERLO",
                "commune" => "OUDALAYE",
                "total" => 11421
            ],
            [
                "region" => "MATAM",
                "departement" => "RANEROU FERLO",
                "commune" => "VELINGARA  (RANEROU)",
                "total" => 9010
            ],
            [
                "region" => "MATAM",
                "departement" => "RANEROU FERLO",
                "commune" => "LOUGRE THIOLY",
                "total" => 3606
            ],
            [
                "region" => "MATAM",
                "departement" => "RANEROU FERLO",
                "commune" => "RANEROU",
                "total" => 2851
            ],
            [
                "region" => "MAURITANIE",
                "departement" => "MAURITANIE",
                "commune" => "NOUAKCHOTT",
                "total" => 23026
            ],
            [
                "region" => "MAURITANIE",
                "departement" => "MAURITANIE",
                "commune" => "NOUADIBOU",
                "total" => 3303
            ],
            [
                "region" => "MAURITANIE",
                "departement" => "MAURITANIE",
                "commune" => "ROSSO MAURITANIE",
                "total" => 299
            ],
            [
                "region" => "NIGER",
                "departement" => "NIGER",
                "commune" => "NIAMEY",
                "total" => 1062
            ],
            [
                "region" => "NIGERIA",
                "departement" => "NIGERIA",
                "commune" => "ABUJA",
                "total" => 335
            ],
            [
                "region" => "NIGERIA",
                "departement" => "NIGERIA",
                "commune" => "LAGOS",
                "total" => 163
            ],
            [
                "region" => "NIGERIA",
                "departement" => "NIGERIA",
                "commune" => "IBADAN",
                "total" => 81
            ],
            [
                "region" => "PAYS - BAS",
                "departement" => "FINLANDE",
                "commune" => "HELSINKI",
                "total" => 63
            ],
            [
                "region" => "PAYS - BAS",
                "departement" => "PAYS BAS",
                "commune" => "AMSTERDAM",
                "total" => 425
            ],
            [
                "region" => "PAYS - BAS",
                "departement" => "SUEDE",
                "commune" => "STOCKHOLM",
                "total" => 183
            ],
            [
                "region" => "PORTUGAL",
                "departement" => "PORTUGAL",
                "commune" => "LISBONNE",
                "total" => 827
            ],
            [
                "region" => "PORTUGAL",
                "departement" => "PORTUGAL",
                "commune" => "PORTIMAO",
                "total" => 99
            ],
            [
                "region" => "PORTUGAL",
                "departement" => "PORTUGAL",
                "commune" => "PORTO",
                "total" => 94
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "DAGANA",
                "commune" => "RICHARD TOLL",
                "total" => 31386
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "DAGANA",
                "commune" => "DIAMA",
                "total" => 19571
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "DAGANA",
                "commune" => "DAGANA",
                "total" => 17488
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "DAGANA",
                "commune" => "MBANE",
                "total" => 15175
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "DAGANA",
                "commune" => "RONKH",
                "total" => 11304
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "DAGANA",
                "commune" => "BOKHOL",
                "total" => 10525
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "DAGANA",
                "commune" => "GNITH",
                "total" => 9851
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "DAGANA",
                "commune" => "ROSSO SENEGAL",
                "total" => 9383
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "DAGANA",
                "commune" => "ROSS BETHIO",
                "total" => 7844
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "DAGANA",
                "commune" => "GAE",
                "total" => 7109
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "DAGANA",
                "commune" => "NDOMBO SANDJIRY",
                "total" => 3395
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "GUEDE VILLAGE",
                "total" => 23700
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "BOKE DIALLOUBE",
                "total" => 20179
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "DODEL",
                "total" => 18767
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "FANAYE",
                "total" => 18691
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "NDIAYENE PEINDAO",
                "total" => 16198
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "MADINA NDIATHBE",
                "total" => 15749
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "DOUMGA LAO",
                "total" => 13411
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "MBOLO BIRANE",
                "total" => 13028
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "GAMADJI SARE",
                "total" => 12074
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "MERI",
                "total" => 11298
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "NDIOUM",
                "total" => 11101
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "AERE LAO",
                "total" => 8465
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "GALOYA TOUCOULEUR",
                "total" => 4665
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "NIANDANE",
                "total" => 4124
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "GOLLERE",
                "total" => 4051
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "MBOUMBA",
                "total" => 3304
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "GUEDE CHANTIER",
                "total" => 3160
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "DEMETTE",
                "total" => 2782
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "PETE",
                "total" => 2626
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "PODOR",
                "commune" => "BODE LAO",
                "total" => 1952
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "SAINT LOUIS",
                "commune" => "SAINT LOUIS",
                "total" => 121635
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "SAINT LOUIS",
                "commune" => "GANDON",
                "total" => 23147
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "SAINT LOUIS",
                "commune" => "NDIEBENE GANDIOLE",
                "total" => 10983
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "SAINT LOUIS",
                "commune" => "FASS NGOM",
                "total" => 8231
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "SAINT LOUIS",
                "commune" => "MPAL",
                "total" => 5327
            ],
            [
                "region" => "SAINT LOUIS",
                "departement" => "X",
                "commune" => "PODOR",
                "total" => 9411
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "DIAROUME",
                "total" => 7634
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "MADINA WANDIFA",
                "total" => 6949
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "TANKON",
                "total" => 6046
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "BOGHAL",
                "total" => 5792
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "FAOUNE",
                "total" => 5381
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "NDIAMALATHIEL",
                "total" => 4971
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "INOR",
                "total" => 4459
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "BONA",
                "total" => 4111
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "NDIAMACOUTA",
                "total" => 4051
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "DIAMBATY",
                "total" => 3535
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "BOUNKILING",
                "total" => 3504
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "DIACOUNDA",
                "total" => 3158
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "DJINANY",
                "total" => 1663
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "BOUNKILING",
                "commune" => "KANDION MANGANA",
                "total" => 931
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "SIMBANDI BALANTE",
                "total" => 8765
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "GOUDOMP",
                "total" => 7825
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "KARANTABA",
                "total" => 5966
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "SIMBANDI BRASSOU",
                "total" => 5894
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "DJIBANAR",
                "total" => 5771
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "YARANG BALANTE",
                "total" => 5666
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "NIAGHA",
                "total" => 5190
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "BAGHERE",
                "total" => 4665
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "MANGAROUNGOU SANTO",
                "total" => 4474
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "KOLIBANTANG",
                "total" => 3949
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "TANAFF",
                "total" => 3374
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "SAMINE",
                "total" => 2860
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "KAOUR",
                "total" => 2543
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "DIATTACOUNDA",
                "total" => 2477
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "GOUDOMP",
                "commune" => "DIOUDOUBOU",
                "total" => 2291
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "SEDHIOU",
                "total" => 15130
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "DJIREDJI",
                "total" => 7497
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "BAMBALI",
                "total" => 7027
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "SANSAMBA",
                "total" => 5975
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "DIENDE",
                "total" => 5435
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "MARSSASSOUM",
                "total" => 4781
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "BEMET BIDJINI",
                "total" => 4601
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "OUDOUCAR",
                "total" => 3975
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "KOUSSY",
                "total" => 3615
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "SAKAR",
                "total" => 3372
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "DIANNAH BA",
                "total" => 2856
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "DJIBABOUYA",
                "total" => 2719
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "SAME KANTA PEULH",
                "total" => 1846
            ],
            [
                "region" => "SEDHIOU",
                "departement" => "SEDHIOU",
                "commune" => "DIANAH MALARY",
                "total" => 1552
            ],
            [
                "region" => "SUISSE",
                "departement" => "SUISSE",
                "commune" => "GENEVE",
                "total" => 612
            ],
            [
                "region" => "SUISSE",
                "departement" => "SUISSE",
                "commune" => "NEUCHATEL",
                "total" => 147
            ],
            [
                "region" => "SUISSE",
                "departement" => "SUISSE",
                "commune" => "LAUSANNE",
                "total" => 135
            ],
            [
                "region" => "SUISSE",
                "departement" => "SUISSE",
                "commune" => "ZURICH",
                "total" => 79
            ],
            [
                "region" => "SUISSE",
                "departement" => "SUISSE",
                "commune" => "BALE",
                "total" => 69
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "MOUDERI",
                "total" => 9518
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "BALLOU",
                "total" => 9412
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "BAKEL",
                "total" => 9360
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "GABOU",
                "total" => 8423
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "BELE",
                "total" => 7611
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "KIDIRA",
                "total" => 5751
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "DIAWARA",
                "total" => 4731
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "SINTHIOU FISSA",
                "total" => 3920
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "SADATOU",
                "total" => 2800
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "TOUMBOURA",
                "total" => 1389
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "GATHIARI",
                "total" => 1142
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "BAKEL",
                "commune" => "MADINA FOULBE",
                "total" => 793
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "BOYNGUEL BAMBA",
                "total" => 5084
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "SINTHIOU MAMADOU BOUBOU",
                "total" => 4767
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "GOUDIRY",
                "total" => 4435
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "KOULOR",
                "total" => 4196
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "KOUSSAN",
                "total" => 3438
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "KOAR",
                "total" => 3275
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "BALA",
                "total" => 3239
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "DIANKE MAKHA",
                "total" => 2940
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "DOUGUE",
                "total" => 2848
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "KOMOTI",
                "total" => 2635
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "GOUMBAYEL",
                "total" => 2609
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "KOTHIARY",
                "total" => 2228
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "BANI ISRAEL",
                "total" => 1950
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "SINTHIOU BOCAR ALY",
                "total" => 1907
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "GOUDIRY",
                "commune" => "BOUTOUCOUFARA",
                "total" => 1796
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "KOUMPENTOUM",
                "commune" => "PAYAR",
                "total" => 6300
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "KOUMPENTOUM",
                "commune" => "KOUTHIABA WOLOF",
                "total" => 6234
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "KOUMPENTOUM",
                "commune" => "KOUMPENTOUM",
                "total" => 6081
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "KOUMPENTOUM",
                "commune" => "BAMBA THIALENE",
                "total" => 5981
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "KOUMPENTOUM",
                "commune" => "KAHENE",
                "total" => 4558
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "KOUMPENTOUM",
                "commune" => "MERETO",
                "total" => 4465
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "KOUMPENTOUM",
                "commune" => "NDAM",
                "total" => 3981
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "KOUMPENTOUM",
                "commune" => "PASS KOTO",
                "total" => 3885
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "KOUMPENTOUM",
                "commune" => "KOUTHIA GAYDI",
                "total" => 3161
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "KOUMPENTOUM",
                "commune" => "MALEME NIANI",
                "total" => 1788
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "TAMBACOUNDA",
                "commune" => "TAMBACOUNDA",
                "total" => 53050
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "TAMBACOUNDA",
                "commune" => "MISSIRAH (TAMBA)",
                "total" => 12451
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "TAMBACOUNDA",
                "commune" => "MAKACOLIBANTANG",
                "total" => 10038
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "TAMBACOUNDA",
                "commune" => "KOUSSANAR",
                "total" => 9116
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "TAMBACOUNDA",
                "commune" => "SINTHIOU MALEME",
                "total" => 7190
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "TAMBACOUNDA",
                "commune" => "NDOGA BABACAR",
                "total" => 5898
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "TAMBACOUNDA",
                "commune" => "NETTEBOULOU",
                "total" => 5878
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "TAMBACOUNDA",
                "commune" => "DIALOKOTO",
                "total" => 4997
            ],
            [
                "region" => "TAMBACOUNDA",
                "departement" => "TAMBACOUNDA",
                "commune" => "NIANI TOUCOULEUR",
                "total" => 3681
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "MBOUR",
                "total" => 108471
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "MALICOUNDA",
                "total" => 29951
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "JOAL FADIOUTH",
                "total" => 22484
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "DIASS",
                "total" => 18991
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "SINDIA",
                "total" => 18925
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "SALY PORTUDAL",
                "total" => 18607
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "NDIAGANIAO",
                "total" => 18246
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "NGUEKHOKH",
                "total" => 16880
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "NGUENIENE",
                "total" => 15174
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "FISSEL",
                "total" => 14522
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "SANDIARA",
                "total" => 11805
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "THIADIAYE",
                "total" => 9672
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "SESSENE",
                "total" => 9557
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "POPENGUINE",
                "total" => 6829
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "NGAPAROU",
                "total" => 6403
            ],
            [
                "region" => "THIES",
                "departement" => "MBOUR",
                "commune" => "SOMONE",
                "total" => 5464
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "THIES EST",
                "total" => 80328
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "THIES NORD",
                "total" => 60723
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "THIES OUEST",
                "total" => 52347
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "NOTTO",
                "total" => 22849
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "KEUR MOUSSA",
                "total" => 22524
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "TOUBA TOUL",
                "total" => 20444
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "DIENDER GUEDJI",
                "total" => 16189
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "FANDENE",
                "total" => 15587
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "POUT",
                "total" => 14599
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "NGOUNDIANE",
                "total" => 13835
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "NDIEYENE SIRAKH",
                "total" => 12903
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "KAYAR",
                "total" => 12520
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "THIENABA",
                "total" => 12411
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "KHOMBOLE",
                "total" => 11188
            ],
            [
                "region" => "THIES",
                "departement" => "THIES",
                "commune" => "TASSETTE",
                "total" => 11070
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "TIVAOUANE",
                "total" => 41182
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "DAROU KHOUDOSS",
                "total" => 26012
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "MEOUANE",
                "total" => 16984
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "MERINA DAKHAR",
                "total" => 16341
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "MBORO",
                "total" => 16300
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "NOTTO GOUYE DIAMA",
                "total" => 12991
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "MECKHE",
                "total" => 12848
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "PIRE GOUREYE",
                "total" => 12199
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "KOUL",
                "total" => 12177
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "CHERIF LO",
                "total" => 10512
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "THILMAKHA",
                "total" => 10272
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "PEKESSE",
                "total" => 9678
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "NGANDIOUF",
                "total" => 9657
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "MONT ROLLAND",
                "total" => 9319
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "PAMBAL",
                "total" => 5885
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "NIAKHENE",
                "total" => 5864
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAOUANE",
                "commune" => "MBAYENE",
                "total" => 3888
            ],
            [
                "region" => "THIES",
                "departement" => "TIVAUONE",
                "commune" => "TAIBA NDIAYE",
                "total" => 14266
            ],
            [
                "region" => "TOGO",
                "departement" => "BENIN",
                "commune" => "COTONOU",
                "total" => 991
            ],
            [
                "region" => "TOGO",
                "departement" => "TOGO",
                "commune" => "LOME",
                "total" => 687
            ],
            [
                "region" => "TUNISIE",
                "departement" => "TUNISIE",
                "commune" => "TUNIS",
                "total" => 409
            ],
            [
                "region" => "TURQUIE",
                "departement" => "TURQUIE",
                "commune" => "ISTANBUL",
                "total" => 1245
            ],
            [
                "region" => "TURQUIE",
                "departement" => "TURQUIE",
                "commune" => "ANKARA",
                "total" => 129
            ],
            [
                "region" => "X",
                "departement" => "X",
                "commune" => "WALALDE",
                "total" => 3592
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "BIGNONA",
                "total" => 23764
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "KAFOUNTINE",
                "total" => 13843
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "TENGHORI",
                "total" => 11819
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "KATABA 1",
                "total" => 9829
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "DJINAKI",
                "total" => 8055
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "THIONCK ESSYL",
                "total" => 7373
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "SINDIAN",
                "total" => 6097
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "COUBALAN",
                "total" => 6013
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "OULAMPANE",
                "total" => 5585
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "SUEL",
                "total" => 5220
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "MANGAGOULACK",
                "total" => 5108
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "KARTIACK",
                "total" => 4927
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "DIEGOUNE",
                "total" => 4871
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "OUONCK",
                "total" => 4686
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "NIAMONE",
                "total" => 4009
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "DIOULOULOU",
                "total" => 3795
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "DJIBIDIONE",
                "total" => 3578
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "BALINGORE",
                "total" => 3263
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "BIGNONA",
                "commune" => "MLOMP (BIGNONA)",
                "total" => 2387
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "OUSSOUYE",
                "commune" => "DIEMBERING",
                "total" => 12101
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "OUSSOUYE",
                "commune" => "MLOMP (OUSSOUYE)",
                "total" => 7293
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "OUSSOUYE",
                "commune" => "OUKOUT",
                "total" => 5998
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "OUSSOUYE",
                "commune" => "OUSSOUYE",
                "total" => 3777
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "OUSSOUYE",
                "commune" => "SANTHIABA MANJAQUE",
                "total" => 3101
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "ZIGUINCHOR",
                "commune" => "ZIGUINCHOR",
                "total" => 99746
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "ZIGUINCHOR",
                "commune" => "NIAGUIS",
                "total" => 8485
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "ZIGUINCHOR",
                "commune" => "ADEANE",
                "total" => 8351
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "ZIGUINCHOR",
                "commune" => "NIASSIA",
                "total" => 5412
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "ZIGUINCHOR",
                "commune" => "BOUTOUPA CAMARACOUND",
                "total" => 3976
            ],
            [
                "region" => "ZIGUINCHOR",
                "departement" => "ZIGUINCHOR",
                "commune" => "ENAMPOR",
                "total" => 3474
            ]
        ];
    const REGIONS =  [
        [
            "region"=> "DAKAR",
            "total"=> 1749038
        ],
        [
            "region"=> "THIES",
            "total"=> 957873
        ],
        [
            "region"=> "DIOURBEL",
            "total"=> 607829
        ],
        [
            "region"=> "SAINT LOUIS",
            "total"=> 531090
        ],
        [
            "region"=> "KAOLACK",
            "total"=> 442378
        ],
        [
            "region"=> "LOUGA",
            "total"=> 441364
        ],
        [
            "region"=> "FATICK",
            "total"=> 338900
        ],
        [
            "region"=> "ZIGUINCHOR",
            "total"=> 295936
        ],
        [
            "region"=> "MATAM",
            "total"=> 293000
        ],
        [
            "region"=> "TAMBACOUNDA",
            "total"=> 270930
        ],
        [
            "region"=> "KOLDA",
            "total"=> 250339
        ],
        [
            "region"=> "KAFFRINE",
            "total"=> 249543
        ],
        [
            "region"=> "SEDHIOU",
            "total"=> 204276
        ],
        [
            "region"=> "KEDOUGOU",
            "total"=> 69380
        ],
        [
            "region"=> "FRANCE",
            "total"=> 60526
        ],
        [
            "region"=> "ITALIE",
            "total"=> 46887
        ],
        [
            "region"=> "ESPAGNE",
            "total"=> 33659
        ],
        [
            "region"=> "MAURITANIE",
            "total"=> 26628
        ],
        [
            "region"=> "COTE D'IVOIRE",
            "total"=> 18174
        ],
        [
            "region"=> "GABON",
            "total"=> 16702
        ],
        [
            "region"=> "GAMBIE",
            "total"=> 11228
        ],
        [
            "region"=> "CONGO",
            "total"=> 9810
        ],
        [
            "region"=> "MAROC",
            "total"=> 9413
        ],
        [
            "region"=> "MALI",
            "total"=> 9175
        ],
        [
            "region"=> "CANADA",
            "total"=> 3986
        ],
        [
            "region"=> "BRESIL",
            "total"=> 3820
        ],
        [
            "region"=> "GUINEE BISSAU",
            "total"=> 3818
        ],
        [
            "region"=> "X",
            "total"=> 3592
        ],
        [
            "region"=> "CAMEROUN",
            "total"=> 2996
        ],
        [
            "region"=> "AFRIQUE DU SUD",
            "total"=> 2963
        ],
        [
            "region"=> "GUINEE",
            "total"=> 2764
        ],
        [
            "region"=> "BELGIQUE",
            "total"=> 2448
        ],
        [
            "region"=> "ARABIE SAOUDITE",
            "total"=> 2112
        ],
        [
            "region"=> "TOGO",
            "total"=> 1678
        ],
        [
            "region"=> "CAP VERT",
            "total"=> 1669
        ],
        [
            "region"=> "GRANDE BRETAGNE",
            "total"=> 1439
        ],
        [
            "region"=> "TURQUIE",
            "total"=> 1374
        ],
        [
            "region"=> "ALLEMAGNE",
            "total"=> 1197
        ],
        [
            "region"=> "EGYPTE",
            "total"=> 1113
        ],
        [
            "region"=> "NIGER",
            "total"=> 1062
        ],
        [
            "region"=> "SUISSE",
            "total"=> 1042
        ],
        [
            "region"=> "PORTUGAL",
            "total"=> 1020
        ],
        [
            "region"=> "PAYS - BAS",
            "total"=> 671
        ],
        [
            "region"=> "NIGERIA",
            "total"=> 579
        ],
        [
            "region"=> "EMIRATS ARABES UNIS",
            "total"=> 524
        ],
        [
            "region"=> "TUNISIE",
            "total"=> 409
        ],
        [
            "region"=> "GHANA",
            "total"=> 227
        ],
        [
            "region"=> "BURKINA FASO",
            "total"=> 177
        ],
        [
            "region"=> "KOWEIT",
            "total"=> 68
        ]
    ];
    const DEPARTEMENTS = [
        [
            "departement" => "DAKAR",
            "total" => 680485
        ],
        [
            "departement" => "THIES",
            "total" => 379517
        ],
        [
            "departement" => "PIKINE",
            "total" => 376572
        ],
        [
            "departement" => "MBACKE",
            "total" => 365716
        ],
        [
            "departement" => "MBOUR",
            "total" => 331981
        ],
        [
            "departement" => "RUFISQUE",
            "total" => 259777
        ],
        [
            "departement" => "KAOLACK",
            "total" => 243265
        ],
        [
            "departement" => "KEUR MASSAR",
            "total" => 236664
        ],
        [
            "departement" => "TIVAOUANE",
            "total" => 232109
        ],
        [
            "departement" => "PODOR",
            "total" => 209325
        ],
        [
            "departement" => "GUEDIAWAYE",
            "total" => 195540
        ],
        [
            "departement" => "LOUGA",
            "total" => 185220
        ],
        [
            "departement" => "SAINT LOUIS",
            "total" => 169323
        ],
        [
            "departement" => "FATICK",
            "total" => 166985
        ],
        [
            "departement" => "MATAM",
            "total" => 151762
        ],
        [
            "departement" => "NIORO DU RIP",
            "total" => 143932
        ],
        [
            "departement" => "DAGANA",
            "total" => 143031
        ],
        [
            "departement" => "BIGNONA",
            "total" => 134222
        ],
        [
            "departement" => "ZIGUINCHOR",
            "total" => 129444
        ],
        [
            "departement" => "KEBEMER",
            "total" => 128186
        ],
        [
            "departement" => "LINGUERE",
            "total" => 127958
        ],
        [
            "departement" => "FOUNDIOUGNE",
            "total" => 126243
        ],
        [
            "departement" => "BAMBEY",
            "total" => 122321
        ],
        [
            "departement" => "DIOURBEL",
            "total" => 119792
        ],
        [
            "departement" => "KANEL",
            "total" => 114350
        ],
        [
            "departement" => "TAMBACOUNDA",
            "total" => 112299
        ],
        [
            "departement" => "VELINGARA",
            "total" => 106625
        ],
        [
            "departement" => "KOLDA",
            "total" => 99920
        ],
        [
            "departement" => "KAFFRINE",
            "total" => 90226
        ],
        [
            "departement" => "KOUNGHEUL",
            "total" => 71807
        ],
        [
            "departement" => "GOUDOMP",
            "total" => 71710
        ],
        [
            "departement" => "SEDHIOU",
            "total" => 70381
        ],
        [
            "departement" => "BAKEL",
            "total" => 64850
        ],
        [
            "departement" => "BOUNKILING",
            "total" => 62185
        ],
        [
            "departement" => "FRANCE",
            "total" => 60526
        ],
        [
            "departement" => "GUINGUINEO",
            "total" => 55181
        ],
        [
            "departement" => "BIRKILANE",
            "total" => 48778
        ],
        [
            "departement" => "GOUDIRY",
            "total" => 47347
        ],
        [
            "departement" => "ITALIE",
            "total" => 46887
        ],
        [
            "departement" => "KOUMPENTOUM",
            "total" => 46434
        ],
        [
            "departement" => "GOSSAS",
            "total" => 45672
        ],
        [
            "departement" => "MEDINA YORO FOULAH",
            "total" => 43794
        ],
        [
            "departement" => "KEDOUGOU",
            "total" => 39340
        ],
        [
            "departement" => "MALEM HODAR",
            "total" => 38732
        ],
        [
            "departement" => "ESPAGNE",
            "total" => 33659
        ],
        [
            "departement" => "OUSSOUYE",
            "total" => 32270
        ],
        [
            "departement" => "RANEROU FERLO",
            "total" => 26888
        ],
        [
            "departement" => "MAURITANIE",
            "total" => 26628
        ],
        [
            "departement" => "SARAYA",
            "total" => 18927
        ],
        [
            "departement" => "COTE D'IVOIRE",
            "total" => 17986
        ],
        [
            "departement" => "GABON",
            "total" => 15060
        ],
        [
            "departement" => "TIVAUONE",
            "total" => 14266
        ],
        [
            "departement" => "X",
            "total" => 13003
        ],
        [
            "departement" => "GAMBIE",
            "total" => 11228
        ],
        [
            "departement" => "SALEMATA",
            "total" => 11113
        ],
        [
            "departement" => "REPUBLIQUE DU CONGO",
            "total" => 9810
        ],
        [
            "departement" => "MAROC",
            "total" => 9413
        ],
        [
            "departement" => "MALI",
            "total" => 9175
        ],
        [
            "departement" => "CANADA",
            "total" => 3986
        ],
        [
            "departement" => "GUINEE BISSAU",
            "total" => 3818
        ],
        [
            "departement" => "GUINEE",
            "total" => 2764
        ],
        [
            "departement" => "CAMEROUN",
            "total" => 2735
        ],
        [
            "departement" => "AFRIQUE DU SUD",
            "total" => 2470
        ],
        [
            "departement" => "BELGIQUE",
            "total" => 2289
        ],
        [
            "departement" => "BRESIL",
            "total" => 2155
        ],
        [
            "departement" => "ARABIE SAOUDITE",
            "total" => 2112
        ],
        [
            "departement" => "CAP VERT",
            "total" => 1669
        ],
        [
            "departement" => "ARGENTINE",
            "total" => 1665
        ],
        [
            "departement" => "GUINEE EQUATORIALE",
            "total" => 1642
        ],
        [
            "departement" => "ANGLETERRE",
            "total" => 1439
        ],
        [
            "departement" => "TURQUIE",
            "total" => 1374
        ],
        [
            "departement" => "ALLEMAGNE",
            "total" => 1197
        ],
        [
            "departement" => "NIGER",
            "total" => 1062
        ],
        [
            "departement" => "SUISSE",
            "total" => 1042
        ],
        [
            "departement" => "PORTUGAL",
            "total" => 1020
        ],
        [
            "departement" => "BENIN",
            "total" => 991
        ],
        [
            "departement" => "TOGO",
            "total" => 687
        ],
        [
            "departement" => "LIBAN",
            "total" => 604
        ],
        [
            "departement" => "NIGERIA",
            "total" => 579
        ],
        [
            "departement" => "EMIRATS ARABES UNIS",
            "total" => 524
        ],
        [
            "departement" => "EGYPTE",
            "total" => 509
        ],
        [
            "departement" => "MOZAMBIQUE",
            "total" => 493
        ],
        [
            "departement" => "PAYS BAS",
            "total" => 425
        ],
        [
            "departement" => "TUNISIE",
            "total" => 409
        ],
        [
            "departement" => "TCHAD",
            "total" => 261
        ],
        [
            "departement" => "GHANA",
            "total" => 227
        ],
        [
            "departement" => "COTE D-IVOIRE",
            "total" => 188
        ],
        [
            "departement" => "SUEDE",
            "total" => 183
        ],
        [
            "departement" => "BURKINA FASO",
            "total" => 177
        ],
        [
            "departement" => "LUXEMBOURG",
            "total" => 159
        ],
        [
            "departement" => "KOWEIT",
            "total" => 68
        ],
        [
            "departement" => "FINLANDE",
            "total" => 63
        ]
    ];

}
