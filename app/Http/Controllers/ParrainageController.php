<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParrainageRequest;
use App\Http\Requests\UpdateParrainageRequest;
use App\Models\Archive;
use App\Models\Electeur;
use App\Models\Params;
use App\Models\Parrainage;
use App\Models\ParrainageFinal;
use App\Models\Parti;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ParrainageController extends Controller
{
    const jsonHeaders = ["Accept"=>"application/json",
        "Content-Type"=>"application/json"];
    const REGIONS_DIASPORA = [
        'DIASPORA',
        'AFRIQUE DU SUD',
        'ALLEMAGNE',
        'ARABIE SAOUDITE',
        'BELGIQUE',
        'BRESIL',
        'BURKINA FASO',
        'CAMEROUN',
        'CANADA',
        'CAP VERT',
        'CONGO',
        'COTE D\'IVOIRE',
        'EGYPTE',
        'EMIRATS ARABES UNIS',
        'ESPAGNE',
        'FRANCE',
        'GABON',
        'GAMBIE',
        'GHANA',
        'GRANDE BRETAGNE',
        'GUINEE',
        'GUINEE BISSAU',
        'ITALIE',
        'KOWEIT',
        'MALI',
        'MAROC',
        'MAURITANIE',
        'NIGER',
        'NIGERIA',
        'PAYS - BAS',
        'PORTUGAL',
        'SUISSE',
        'TOGO',
        'TUNISIE',
        'TURQUIE',
    ];
    const COMMUNES = [
        [
            "name" => "BISCUITERIE",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "CAMBERENE",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "DIEUPPEUL DERKLE",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "GOREE",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "GRAND DAKAR",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "GRAND YOFF",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "GUEULE TAPEE FASS CO",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "HANN BEL AIR",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "MEDINA",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "MERMOZ SACRE COEUR",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "NGOR",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "PARCELLES ASSAINIES",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "PATTE D OIE",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "PLATEAU",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "GOLF SUD",
            "departement" => "GUEDIAWAYE",
            "region" => "DAKAR"
        ],
        [
            "name" => "MEDINA GOUNASS",
            "departement" => "GUEDIAWAYE",
            "region" => "DAKAR"
        ],
        [
            "name" => "NDIAREME",
            "departement" => "GUEDIAWAYE",
            "region" => "DAKAR"
        ],
        [
            "name" => "SAM",
            "departement" => "GUEDIAWAYE",
            "region" => "DAKAR"
        ],
        [
            "name" => "WAKHINANE NIMZAT",
            "departement" => "GUEDIAWAYE",
            "region" => "DAKAR"
        ],
        [
            "name" => "DALIFORT",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "DIAMAGUENE SICAP MBAO",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "DJIDA THIAROYE KAO",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "GUINAW RAIL NORD",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "GUINAW RAIL SUD",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "MBAO",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "PIKINE EST",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "PIKINE NORD",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "PIKINE OUEST",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "THIAROYE GARE",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "THIAROYE SUR MER",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "TIVAOUANE DIAKSAO",
            "departement" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "JAXAAY-PARCELLES",
            "departement" => "KEUR MASSAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "KEUR MASSAR NORD",
            "departement" => "KEUR MASSAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "KEUR MASSAR SUD",
            "departement" => "KEUR MASSAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "MALIKA",
            "departement" => "KEUR MASSAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "YEUMBEUL NORD",
            "departement" => "KEUR MASSAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "YEUMBEUL SUD",
            "departement" => "KEUR MASSAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "BAMBYLOR",
            "departement" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "BARGNY",
            "departement" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "DIAMNIADIO",
            "departement" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "RUFISQUE EST",
            "departement" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "RUFISQUE NORD",
            "departement" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "RUFISQUE OUEST",
            "departement" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "SANGALKAM",
            "departement" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "SEBIKOTANE",
            "departement" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "SENDOU",
            "departement" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "TIVAOUANE PEULH - NIAGA",
            "departement" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "YENE",
            "departement" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "THIES EST",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "THIES NORD",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "THIES OUEST",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "TOUBA TOUL",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "DIENDER GUEDJI",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "FANDENE",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "KAYAR",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "KEUR MOUSSA",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "KHOMBOLE",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "NDIEYENE SIRAKH",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "NGOUNDIANE",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "NOTTO",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "POUT",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "TASSETTE",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "THIENABA",
            "departement" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "DIASS",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "FISSEL",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "JOAL FADIOUTH",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "MALICOUNDA",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "MBOUR",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "NDIAGANIAO",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "NGAPAROU",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "NGUEKHOKH",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "NGUENIENE",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "POPENGUINE",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "SALY PORTUDAL",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "SANDIARA",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "SESSENE",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "SINDIA",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "SOMONE",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "THIADIAYE",
            "departement" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "TOUBA MOSQUEE",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "CHERIF LO",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "DAROU KHOUDOSS",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "KOUL",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "MBAYENE",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "MBORO",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "MECKHE",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "MEOUANE",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "MERINA DAKHAR",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "MONT ROLLAND",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "NGANDIOUF",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "NIAKHENE",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "NOTTO GOUYE DIAMA",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "PAMBAL",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "THILMAKHA",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "TIVAOUANE",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "PIRE GOUREYE",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "PEKESSE",
            "departement" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "DALLA NGABOU",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "DANDEYE GOUYGUI",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "DAROU NAHIM",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "DAROU SALAM TYP",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "KAEL",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "MADINA",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "MBACKE",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "MISSIRAH (MBACKE)",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "NDIOUMANE",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "NGHAYE",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "SADIO",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "TAIBA THIEKENE",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "TAIF",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "TOUBA FALL",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "TOUBA MBOUL",
            "departement" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "YOFF",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "H L M",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "GADE ESCALE",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "KEUR NGALGOU",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "DANKH SENE",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "DIOURBEL",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "NDINDY",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "NDOULO",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "NGOHE",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "PATTAR",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "TAIBA MOUTOUPHA",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "TOCKY GARE",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "TOUBA LAPPE",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "TOURE MBONDE",
            "departement" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "BABA GARAGE",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "BAMBEY",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "DANGALMA",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "DINGUIRAYE  (BAMBEY)",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "GAWANE",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "KEUR SAMBA KANE",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "LAMBAYE",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "NDONDOL",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "NGOGOM",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "NGOYE",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "REFANE",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "THIAKHAR",
            "departement" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "DYA",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "GANDIAYE",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "KAHONE",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "KEUR BAKA",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "KEUR SOCE",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "LATMINGUE",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NDIAFFATE",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NDIEBEL",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NDIEDIENG",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NDOFFANE",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "SIBASSOR",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "THIARE",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "THIOMBY",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "KAOLACK",
            "departement" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "DABALY",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "DAROU SALAM",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "GAINTE KAYE",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "KAYEMOR",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "KEUR MABA DIAKHOU",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "KEUR MADIABEL",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "KEUR MADONGO",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "MEDINA SABAKH",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NDRAME ESCALE",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NGAYENE",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NIORO DU RIP",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "PAOSKOTO",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "POROKHANE",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "TAIBA NIASSENE",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "WACK NGOUNA",
            "departement" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "DARA MBOSS",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "FASS",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "GUINGUINEO",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "KHELCOM BIRAME",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "MBADAKHOUNE",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "MBOSS",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NDIAGO",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NGAGNICK",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NGATHIE NAOUDE",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NGELLOU",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "OUROUR",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "PANAL WOLOF",
            "departement" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "BASSOUL",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "COLOBANE",
            "departement" => "GOSSAS",
            "region" => "FATICK"
        ],
        [
            "name" => "DIAGANE BARKA",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "DIONEWAR",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "DIOSSONG",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "DJILASS",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "DJILOR",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "DJIRNDA",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "FATICK",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "FIMELA",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "FOUNDIOUGNE",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "GOSSAS",
            "departement" => "GOSSAS",
            "region" => "FATICK"
        ],
        [
            "name" => "KARANG POSTE",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "KEUR SALOUM DIANE",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "KEUR SAMBA GUEYE",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "LOUL SESSENE",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "MBAM",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "MBAR",
            "departement" => "GOSSAS",
            "region" => "FATICK"
        ],
        [
            "name" => "MBELLACADIAO",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "NDIENE LAGANE",
            "departement" => "GOSSAS",
            "region" => "FATICK"
        ],
        [
            "name" => "NDIOB",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "NGAYOKHEME",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "NIAKHAR",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "NIASSENE",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "NIORO ALASSANE TALL",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "OUADIOUR",
            "departement" => "GOSSAS",
            "region" => "FATICK"
        ],
        [
            "name" => "PALMARIN FACAO",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "PASSI",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "PATAR LIA",
            "departement" => "GOSSAS",
            "region" => "FATICK"
        ],
        [
            "name" => "PATAR",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "SOKONE",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "SOUM",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "TATTAGUINE",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "THIARE NDIALGUI",
            "departement" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "TOUBACOUTA",
            "departement" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "BIRKILANE",
            "departement" => "BIRKILANE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "BOULEL",
            "departement" => "KAFFRINE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "DAROU MINAM",
            "departement" => "MALEM HODAR",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "DIAMAGADIO",
            "departement" => "KAFFRINE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "DIAMAL",
            "departement" => "BIRKILANE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "DIOKOUL MBELBOUCK",
            "departement" => "KAFFRINE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "DJANKE SOUF",
            "departement" => "MALEM HODAR",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "FASS THIEKENE",
            "departement" => "KOUNGHEUL",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "GNIBY",
            "departement" => "KAFFRINE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "IDA MOURIDE",
            "departement" => "KOUNGHEUL",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "KAFFRINE",
            "departement" => "KAFFRINE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "KAHI",
            "departement" => "KAFFRINE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "KATHIOTE",
            "departement" => "KAFFRINE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "KEUR MBOUCKI",
            "departement" => "BIRKILANE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "KHELCOM",
            "departement" => "MALEM HODAR",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "KOUNGHEUL",
            "departement" => "KOUNGHEUL",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "LOUR ESCALE",
            "departement" => "KOUNGHEUL",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "MABO",
            "departement" => "BIRKILANE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "MAKA YOP",
            "departement" => "KOUNGHEUL",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "MALEM HODAR",
            "departement" => "MALEM HODAR",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "MBEULEUP",
            "departement" => "BIRKILANE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "MEDINATOUL SALAM 2",
            "departement" => "KAFFRINE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "MISSIRAH WADENE",
            "departement" => "KOUNGHEUL",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "NDIOBENE SAMBA LAMO",
            "departement" => "MALEM HODAR",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "NDIOGNICK",
            "departement" => "BIRKILANE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "NDIOUM NGAINTHE",
            "departement" => "MALEM HODAR",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "NGAINTHE PATE",
            "departement" => "KOUNGHEUL",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "NGANDA",
            "departement" => "KAFFRINE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "RIBOT ESCALE",
            "departement" => "KOUNGHEUL",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "SAGNA",
            "departement" => "MALEM HODAR",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "SALY ESCALE",
            "departement" => "KOUNGHEUL",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "SEGRE GATTA",
            "departement" => "BIRKILANE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "TOUBA MBELLA",
            "departement" => "BIRKILANE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "BADION",
            "departement" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "BAGADAJI",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "BIGNARABE",
            "departement" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "BONCONTO",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "BOUROUCO",
            "departement" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "COUMBACARA",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "DABO",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "DIALAMBERE",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "DIAOBE KABENDOU",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "DINGUIRAYE  (M.Y.F.)",
            "departement" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "DIOULACOLON",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "FAFACOUROU",
            "departement" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "GUIRO YERO BOCAR",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "KANDIA",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "KANDIAYE",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "KEREWANE",
            "departement" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "KOLDA",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "BANDAFASSI",
            "departement" => "KEDOUGOU",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "BEMBOU",
            "departement" => "SARAYA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "DAKATELY",
            "departement" => "SALEMATA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "DAR SALAM",
            "departement" => "SALEMATA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "DIMBOLI",
            "departement" => "KEDOUGOU",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "DINDEFELO",
            "departement" => "KEDOUGOU",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "ETHIOLO",
            "departement" => "SALEMATA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "FONGOLIMBI",
            "departement" => "KEDOUGOU",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "KEDOUGOU",
            "departement" => "KEDOUGOU",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "KOULINTO",
            "departement" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "KOUNKANE",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "KEVOYE",
            "departement" => "SALEMATA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "LINKERING",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "KHOSSANTO",
            "departement" => "SARAYA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "MEDINA BAFFE",
            "departement" => "SARAYA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "MAMPATIM",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "MISSIRAH SIRIMANA",
            "departement" => "SARAYA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "NINEFECHA",
            "departement" => "KEDOUGOU",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "MEDINA CHERIF",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "OUBADJI",
            "departement" => "SALEMATA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "SABODOLA",
            "departement" => "SARAYA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "SALEMATA",
            "departement" => "SALEMATA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "MEDINA EL HADJI",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "SARAYA",
            "departement" => "SARAYA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "MEDINA GOUNASSE",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "TOMBORONKOTO",
            "departement" => "KEDOUGOU",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "MEDINA YORO FOULAH",
            "departement" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "NDORNA",
            "departement" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "NEMATABA",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "NIAMING",
            "departement" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "OUASSADOU",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "PAKOUR",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "PAROUMBA",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "PATA",
            "departement" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "SALIKEGNE",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "SARE BIDJI",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "SARE COLI SALLE",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "SARE YOBA DIEGA",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "SINTHIANG KOUNDARA",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "TANKANTO ESCALE",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "THIETTY",
            "departement" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "VELINGARA",
            "departement" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "AFFE DJOLOF",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "BANDEGNE OUOLOF",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "BARKEDJI",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "BOULAL",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "DAHRA",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "DAROU MARNANE",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "DAROU MOUSTI",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "DEALY",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "DIOKOUL NDIAWRIGNE",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "DODJI",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "GANDE",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "GASSANE",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "GUEOUL",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "GUET ARDO",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "KAB GAYE",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "KAMBE",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "KANENE NDIOB",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "KEBEMER",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "KELLE GUEYE",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "KEUR MOMAR SARR",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "KOKI",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "LABGAR",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "LEONA",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "LINGUERE",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "LORO",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "LOUGA",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "MBACKE CAJOR",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "MBADIANE",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "MBEDIENE",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "MBEULEUKHE",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "MBOULA",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "NDANDE",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "NDIAGNE",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "NDOYENE",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "NGOURANE OUOLOF",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "NGUER MALAL",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "NGUEUNE SARR",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "NGUIDILE",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "NIOMRE",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "OUARKHOKH",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "PETE OUARACK",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "SAGATA GUETH",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "SAGATTA DJOLOF",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "SAKAL",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "SAM YABAL",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "SYER",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "TESSEKERE FORAGE",
            "departement" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "THIAMENE CAYOR",
            "departement" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "THIEP",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "THIOLOM FALL",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "TOUBA MERINA",
            "departement" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "ADEANE",
            "departement" => "ZIGUINCHOR",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "AERE LAO",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "AOURE",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "BAGHERE",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "BAKEL",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "BALA",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "BALINGORE",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "BALLOU",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "BAMBA THIALENE",
            "departement" => "KOUMPENTOUM",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "BAMBALI",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "BANI ISRAEL",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "BELE",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "BEMET BIDJINI",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "BIGNONA",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "BODE LAO",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "BOGHAL",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "BOKE DIALLOUBE",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "BOKHOL",
            "departement" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "BOKIDIAVE",
            "departement" => "MATAM",
            "region" => "MATAM"
        ],
        [
            "name" => "BOKILADJI",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "BONA",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "BOUNKILING",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "BOUTOUCOUFARA",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "BOUTOUPA CAMARACOUND",
            "departement" => "ZIGUINCHOR",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "BOYNGUEL BAMBA",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "COUBALAN",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "DABIA",
            "departement" => "MATAM",
            "region" => "MATAM"
        ],
        [
            "name" => "DAGANA",
            "departement" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "DEMBANCANE",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "DEMETTE",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "DES AGNAM (AGNAM CIVOL)",
            "departement" => "MATAM",
            "region" => "MATAM"
        ],
        [
            "name" => "DIACOUNDA",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DIALOKOTO",
            "departement" => "TAMBACOUNDA",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "DIAMA",
            "departement" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "DIAMBATY",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DIANAH MALARY",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DIANKE MAKHA",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "DIANNAH BA",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DIAROUME",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DIATTACOUNDA",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DIAWARA",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "DIEGOUNE",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "DIEMBERING",
            "departement" => "OUSSOUYE",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "DIENDE",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DIOUDOUBOU",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DIOULOULOU",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "DJIBABOUYA",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DJIBANAR",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DJIBIDIONE",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "DJINAKI",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "DJINANY",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DJIREDJI",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DODEL",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "DOUGUE",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "DOUMGA LAO",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "ENAMPOR",
            "departement" => "ZIGUINCHOR",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "FANAYE",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "FAOUNE",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "FASS NGOM",
            "departement" => "SAINT LOUIS",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "GABOU",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "GAE",
            "departement" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "GALOYA TOUCOULEUR",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "GAMADJI SARE",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "GANDON",
            "departement" => "SAINT LOUIS",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "GATHIARI",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "GNITH",
            "departement" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "GOLLERE",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "GOUDIRY",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "GOUDOMP",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "GOUMBAYEL",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "GUEDE CHANTIER",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "GUEDE VILLAGE",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "HAMADI HOUNARE",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "INOR",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "KAFOUNTINE",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "KAHENE",
            "departement" => "KOUMPENTOUM",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "KANDION MANGANA",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "KANEL",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "KAOUR",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "KARANTABA",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "KARTIACK",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "KATABA 1",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "KIDIRA",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "KOAR",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "KOLIBANTANG",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "KOMOTI",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "KOTHIARY",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "KOULOR",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "KOUMPENTOUM",
            "departement" => "KOUMPENTOUM",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "KOUSSAN",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "KOUSSANAR",
            "departement" => "TAMBACOUNDA",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "KOUSSY",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "KOUTHIA GAYDI",
            "departement" => "KOUMPENTOUM",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "KOUTHIABA WOLOF",
            "departement" => "KOUMPENTOUM",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "LOUGRE THIOLY",
            "departement" => "RANEROU FERLO",
            "region" => "MATAM"
        ],
        [
            "name" => "MADINA FOULBE",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "MADINA NDIATHBE",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "MADINA WANDIFA",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "MAKACOLIBANTANG",
            "departement" => "TAMBACOUNDA",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "MALEME NIANI",
            "departement" => "KOUMPENTOUM",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "MANGAGOULACK",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "MANGAROUNGOU SANTO",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "MARSSASSOUM",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "MATAM",
            "departement" => "MATAM",
            "region" => "MATAM"
        ],
        [
            "name" => "MBANE",
            "departement" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "MBOLO BIRANE",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "MBOUMBA",
            "departement" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "MERETO",
            "departement" => "KOUMPENTOUM",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "MISSIRAH (TAMBA)",
            "departement" => "TAMBACOUNDA",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "MLOMP (BIGNONA)",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "MLOMP (OUSSOUYE)",
            "departement" => "OUSSOUYE",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "MOUDERI",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "MPAL",
            "departement" => "SAINT LOUIS",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "NABADJI CIVOL",
            "departement" => "MATAM",
            "region" => "MATAM"
        ],
        [
            "name" => "NDAM",
            "departement" => "KOUMPENTOUM",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "NDENDORY",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "NDIAMACOUTA",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "NDIAMALATHIEL",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "NDIEBENE GANDIOLE",
            "departement" => "SAINT LOUIS",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "NDOGA BABACAR",
            "departement" => "TAMBACOUNDA",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "NDOMBO SANDJIRY",
            "departement" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "NETTEBOULOU",
            "departement" => "TAMBACOUNDA",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "NGUIDJILONE",
            "departement" => "MATAM",
            "region" => "MATAM"
        ],
        [
            "name" => "NIAGHA",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "NIAGUIS",
            "departement" => "ZIGUINCHOR",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "NIAMONE",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "NIANI TOUCOULEUR",
            "departement" => "TAMBACOUNDA",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "NIASSIA",
            "departement" => "ZIGUINCHOR",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "ODOBERE",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "OGO",
            "departement" => "MATAM",
            "region" => "MATAM"
        ],
        [
            "name" => "OREFONDE",
            "departement" => "MATAM",
            "region" => "MATAM"
        ],
        [
            "name" => "ORKADIERE",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "OUAOUNDE",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "OUDALAYE",
            "departement" => "RANEROU FERLO",
            "region" => "MATAM"
        ],
        [
            "name" => "OUDOUCAR",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "OUKOUT",
            "departement" => "OUSSOUYE",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "OULAMPANE",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "OUONCK",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "OUROSSOGUI",
            "departement" => "MATAM",
            "region" => "MATAM"
        ],
        [
            "name" => "OUSSOUYE",
            "departement" => "OUSSOUYE",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "PASS KOTO",
            "departement" => "KOUMPENTOUM",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "PAYAR",
            "departement" => "KOUMPENTOUM",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "RANEROU",
            "departement" => "RANEROU FERLO",
            "region" => "MATAM"
        ],
        [
            "name" => "RICHARD TOLL",
            "departement" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "RONKH",
            "departement" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "ROSS BETHIO",
            "departement" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "ROSSO SENEGAL",
            "departement" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "SADATOU",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "SAKAR",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "SAME KANTA PEULH",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "SAMINE",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "SANSAMBA",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "SANTHIABA MANJAQUE",
            "departement" => "OUSSOUYE",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "SEDHIOU",
            "departement" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "SEMME",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "SIMBANDI BALANTE",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "SIMBANDI BRASSOU",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "SINDIAN",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "SINTHIOU BAMAMBE BANADJI",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "SINTHIOU BOCAR ALY",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "SINTHIOU FISSA",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "SINTHIOU MALEME",
            "departement" => "TAMBACOUNDA",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "SINTHIOU MAMADOU BOUBOU",
            "departement" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "SUEL",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "TAMBACOUNDA",
            "departement" => "TAMBACOUNDA",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "TANAFF",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "TANKON",
            "departement" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "TENGHORI",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "THILOGNE",
            "departement" => "MATAM",
            "region" => "MATAM"
        ],
        [
            "name" => "THIONCK ESSYL",
            "departement" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "TOUMBOURA",
            "departement" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "VELINGARA  (RANEROU)",
            "departement" => "RANEROU FERLO",
            "region" => "MATAM"
        ],
        [
            "name" => "WOURO SIDY",
            "departement" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "YARANG BALANTE",
            "departement" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "ZIGUINCHOR",
            "departement" => "ZIGUINCHOR",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "FANN POINT E  AMITIE",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "SICAP LIBERTE",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "OUAKAM",
            "departement" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "SAINT LOUIS",
            "departement" => "SAINT LOUIS",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "ABENGOUROU",
            "departement" => "COTE D-IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "ABIDJAN",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "ABUJA",
            "departement" => "NIGERIA",
            "region" => "NIGERIA"
        ],
        [
            "name" => "ACCRA",
            "departement" => "GHANA",
            "region" => "GHANA"
        ],
        [
            "name" => "AGADIR",
            "departement" => "MAROC",
            "region" => "MAROC"
        ],
        [
            "name" => "AGBOVILLE",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "AGRIGENTO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "ALBACETE",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "ALGESIRAS",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "ALICANTE",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "ALMERIA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "AMSTERDAM",
            "departement" => "PAYS BAS",
            "region" => "PAYS - BAS"
        ],
        [
            "name" => "ANCONA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "ANKARA",
            "departement" => "TURQUIE",
            "region" => "TURQUIE"
        ],
        [
            "name" => "ANVERS",
            "departement" => "BELGIQUE",
            "region" => "BELGIQUE"
        ],
        [
            "name" => "ASTI",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "BAFATA",
            "departement" => "GUINEE BISSAU",
            "region" => "GUINEE BISSAU"
        ],
        [
            "name" => "BAKAU",
            "departement" => "GAMBIE",
            "region" => "GAMBIE"
        ],
        [
            "name" => "BALE",
            "departement" => "SUISSE",
            "region" => "SUISSE"
        ],
        [
            "name" => "BAMAKO",
            "departement" => "MALI",
            "region" => "MALI"
        ],
        [
            "name" => "BANJUL",
            "departement" => "GAMBIE",
            "region" => "GAMBIE"
        ],
        [
            "name" => "BARCELONA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "BARI",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "BASSANO DEL GRAPA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "BATA",
            "departement" => "GUINEE EQUATORIALE",
            "region" => "GABON"
        ],
        [
            "name" => "BEIRA",
            "departement" => "MOZAMBIQUE",
            "region" => "AFRIQUE DU SUD"
        ],
        [
            "name" => "BERGAMO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "BERLIN",
            "departement" => "ALLEMAGNE",
            "region" => "ALLEMAGNE"
        ],
        [
            "name" => "BEYROUTH",
            "departement" => "LIBAN",
            "region" => "EGYPTE"
        ],
        [
            "name" => "BILBAO",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "BIRMINGHAM",
            "departement" => "ANGLETERRE",
            "region" => "GRANDE BRETAGNE"
        ],
        [
            "name" => "BISSAU",
            "departement" => "GUINEE BISSAU",
            "region" => "GUINEE BISSAU"
        ],
        [
            "name" => "BISSORA",
            "departement" => "GUINEE BISSAU",
            "region" => "GUINEE BISSAU"
        ],
        [
            "name" => "BITAM",
            "departement" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "BOBODIOULASSO",
            "departement" => "BURKINA FASO",
            "region" => "BURKINA FASO"
        ],
        [
            "name" => "BOLOGNA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "BOLZANO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "BONDOUKOU",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "BORDEAUX",
            "departement" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "BOUAKE",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "BOUNDIALI",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "BRASILIA",
            "departement" => "BRESIL",
            "region" => "BRESIL"
        ],
        [
            "name" => "BRAZAVILLE",
            "departement" => "REPUBLIQUE DU CONGO",
            "region" => "CONGO"
        ],
        [
            "name" => "BRESCIA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "BRUXELLES",
            "departement" => "BELGIQUE",
            "region" => "BELGIQUE"
        ],
        [
            "name" => "BUENOS AIRES",
            "departement" => "ARGENTINE",
            "region" => "BRESIL"
        ],
        [
            "name" => "CADIZ",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "CAGLIARI",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "CAIRE",
            "departement" => "EGYPTE",
            "region" => "EGYPTE"
        ],
        [
            "name" => "CALPE (BENIDORM)",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "CANCHUNGO",
            "departement" => "GUINEE BISSAU",
            "region" => "GUINEE BISSAU"
        ],
        [
            "name" => "CANNES",
            "departement" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "CAP TOWN",
            "departement" => "AFRIQUE DU SUD",
            "region" => "AFRIQUE DU SUD"
        ],
        [
            "name" => "CASABLANCA",
            "departement" => "MAROC",
            "region" => "MAROC"
        ],
        [
            "name" => "CASERTA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "CATANIA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "CENTRAL RIVER DIVISION",
            "departement" => "GAMBIE",
            "region" => "GAMBIE"
        ],
        [
            "name" => "COMO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "CONAKRY",
            "departement" => "GUINEE",
            "region" => "GUINEE"
        ],
        [
            "name" => "COTONOU",
            "departement" => "BENIN",
            "region" => "TOGO"
        ],
        [
            "name" => "DAKHLA",
            "departement" => "MAROC",
            "region" => "MAROC"
        ],
        [
            "name" => "DALOA",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "DJEDDAH",
            "departement" => "ARABIE SAOUDITE",
            "region" => "ARABIE SAOUDITE"
        ],
        [
            "name" => "DOUALA",
            "departement" => "CAMEROUN",
            "region" => "CAMEROUN"
        ],
        [
            "name" => "ABU DHABI",
            "departement" => "EMIRATS ARABES UNIS",
            "region" => "EMIRATS ARABES UNIS"
        ],
        [
            "name" => "DUEKOUE",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "DURBAN",
            "departement" => "AFRIQUE DU SUD",
            "region" => "AFRIQUE DU SUD"
        ],
        [
            "name" => "DUSSELDORF",
            "departement" => "ALLEMAGNE",
            "region" => "ALLEMAGNE"
        ],
        [
            "name" => "EDMONTON",
            "departement" => "CANADA",
            "region" => "CANADA"
        ],
        [
            "name" => "ELCHE",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "FAENZA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "FANO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "FARIM",
            "departement" => "GUINEE BISSAU",
            "region" => "GUINEE BISSAU"
        ],
        [
            "name" => "FES",
            "departement" => "MAROC",
            "region" => "MAROC"
        ],
        [
            "name" => "FIGUERES",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "FIRENZI",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "FLORENCE",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "FOGGIA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "FRANCFORT",
            "departement" => "ALLEMAGNE",
            "region" => "ALLEMAGNE"
        ],
        [
            "name" => "FUERTEVENTURA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "GAGNOA",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "GAMBA",
            "departement" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "GANDIA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "GENES",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "GENEVE",
            "departement" => "SUISSE",
            "region" => "SUISSE"
        ],
        [
            "name" => "GIRONA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "GRANADA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "GRANOLLERS",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "GUISSONA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "HAMBOURG",
            "departement" => "ALLEMAGNE",
            "region" => "ALLEMAGNE"
        ],
        [
            "name" => "HELSINKI",
            "departement" => "FINLANDE",
            "region" => "PAYS - BAS"
        ],
        [
            "name" => "HUELVA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "IBADAN",
            "departement" => "NIGERIA",
            "region" => "NIGERIA"
        ],
        [
            "name" => "IBIZA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "INGORE",
            "departement" => "GUINEE BISSAU",
            "region" => "GUINEE BISSAU"
        ],
        [
            "name" => "ISCHIO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "ISTANBUL",
            "departement" => "TURQUIE",
            "region" => "TURQUIE"
        ],
        [
            "name" => "JOHANESBOURG",
            "departement" => "AFRIQUE DU SUD",
            "region" => "AFRIQUE DU SUD"
        ],
        [
            "name" => "KAMSAR",
            "departement" => "GUINEE",
            "region" => "GUINEE"
        ],
        [
            "name" => "KAYES",
            "departement" => "MALI",
            "region" => "MALI"
        ],
        [
            "name" => "KONIAKARY",
            "departement" => "MALI",
            "region" => "MALI"
        ],
        [
            "name" => "KORHOGO",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "KOWEIT CITY",
            "departement" => "KOWEIT",
            "region" => "KOWEIT"
        ],
        [
            "name" => "LA SPEZIA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "LABE",
            "departement" => "GUINEE",
            "region" => "GUINEE"
        ],
        [
            "name" => "LAGOS",
            "departement" => "NIGERIA",
            "region" => "NIGERIA"
        ],
        [
            "name" => "LANZAROTE",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "LAS PALMAS GRAND CANARIAS",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "LASTOURVILLE",
            "departement" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "LAUSANNE",
            "departement" => "SUISSE",
            "region" => "SUISSE"
        ],
        [
            "name" => "LAYOUNE",
            "departement" => "MAROC",
            "region" => "MAROC"
        ],
        [
            "name" => "LE HAVRE",
            "departement" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "LECCE",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "LECCO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "LEMEZIA TERME",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "LERIDA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "LIBREVILLE",
            "departement" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "LILLE",
            "departement" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "LISBONNE",
            "departement" => "PORTUGAL",
            "region" => "PORTUGAL"
        ],
        [
            "name" => "LIVORNE",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "LOGRONO",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "LOME",
            "departement" => "TOGO",
            "region" => "TOGO"
        ],
        [
            "name" => "LONDRES",
            "departement" => "ANGLETERRE",
            "region" => "GRANDE BRETAGNE"
        ],
        [
            "name" => "LOWER RIVER DIVISION",
            "departement" => "GAMBIE",
            "region" => "GAMBIE"
        ],
        [
            "name" => "LUXEMBOURG",
            "departement" => "LUXEMBOURG",
            "region" => "BELGIQUE"
        ],
        [
            "name" => "LYON",
            "departement" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "MACERATA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "MADRID",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "MAKOKOU",
            "departement" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "MALABO",
            "departement" => "GUINEE EQUATORIALE",
            "region" => "GABON"
        ],
        [
            "name" => "MALAGA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "MANCHESTER",
            "departement" => "ANGLETERRE",
            "region" => "GRANDE BRETAGNE"
        ],
        [
            "name" => "MANRESA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "MANTOVA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "MAPUTO",
            "departement" => "MOZAMBIQUE",
            "region" => "AFRIQUE DU SUD"
        ],
        [
            "name" => "MARBELLA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "MARRAKECH",
            "departement" => "MAROC",
            "region" => "MAROC"
        ],
        [
            "name" => "MARSEILLE",
            "departement" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "MASSA CARRARA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "MATARO",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "MENDOZA",
            "departement" => "ARGENTINE",
            "region" => "BRESIL"
        ],
        [
            "name" => "MILAN",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "MITZIC",
            "departement" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "MOANDA",
            "departement" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "MODENA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "MONGOMO",
            "departement" => "GUINEE EQUATORIALE",
            "region" => "GABON"
        ],
        [
            "name" => "MONTPELLIER",
            "departement" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "MONTREAL",
            "departement" => "CANADA",
            "region" => "CANADA"
        ],
        [
            "name" => "MONZA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "MOUILA",
            "departement" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "MUNICH",
            "departement" => "ALLEMAGNE",
            "region" => "ALLEMAGNE"
        ],
        [
            "name" => "MURCIA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "NAMPULA",
            "departement" => "MOZAMBIQUE",
            "region" => "AFRIQUE DU SUD"
        ],
        [
            "name" => "NAPLES",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "NDJAMENA",
            "departement" => "TCHAD",
            "region" => "CAMEROUN"
        ],
        [
            "name" => "NEUCHATEL",
            "departement" => "SUISSE",
            "region" => "SUISSE"
        ],
        [
            "name" => "NIAMEY",
            "departement" => "NIGER",
            "region" => "NIGER"
        ],
        [
            "name" => "NICE",
            "departement" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "NORTH BANK DIVISION",
            "departement" => "GAMBIE",
            "region" => "GAMBIE"
        ],
        [
            "name" => "NOUADIBOU",
            "departement" => "MAURITANIE",
            "region" => "MAURITANIE"
        ],
        [
            "name" => "NOUAKCHOTT",
            "departement" => "MAURITANIE",
            "region" => "MAURITANIE"
        ],
        [
            "name" => "NOVARA (BIERA VERCELLI)",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "NTOUM",
            "departement" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "OLBIA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "OTTAWA",
            "departement" => "CANADA",
            "region" => "CANADA"
        ],
        [
            "name" => "OVIEDO",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "PADOVA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "PALERME",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "PALMA DE MALLORCA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "PAMPLONA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "PARANA",
            "departement" => "BRESIL",
            "region" => "BRESIL"
        ],
        [
            "name" => "PARIS",
            "departement" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "PARMA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "PEMBA",
            "departement" => "MOZAMBIQUE",
            "region" => "AFRIQUE DU SUD"
        ],
        [
            "name" => "PESCARA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "PIACENZA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "PIOMBINO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "PISE",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "POINTE NOIRE",
            "departement" => "REPUBLIQUE DU CONGO",
            "region" => "CONGO"
        ],
        [
            "name" => "PORT ELISABETH",
            "departement" => "AFRIQUE DU SUD",
            "region" => "AFRIQUE DU SUD"
        ],
        [
            "name" => "PORT GENTIL",
            "departement" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "PORTIMAO",
            "departement" => "PORTUGAL",
            "region" => "PORTUGAL"
        ],
        [
            "name" => "PORTO",
            "departement" => "PORTUGAL",
            "region" => "PORTUGAL"
        ],
        [
            "name" => "PRAIA",
            "departement" => "CAP VERT",
            "region" => "CAP VERT"
        ],
        [
            "name" => "PRETORIA",
            "departement" => "AFRIQUE DU SUD",
            "region" => "AFRIQUE DU SUD"
        ],
        [
            "name" => "QUEBEC",
            "departement" => "CANADA",
            "region" => "CANADA"
        ],
        [
            "name" => "RABAT",
            "departement" => "MAROC",
            "region" => "MAROC"
        ],
        [
            "name" => "RAVENNA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "RECIFE",
            "departement" => "BRESIL",
            "region" => "BRESIL"
        ],
        [
            "name" => "REGGIO CALABRIA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "REGGIO EMILIA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "RIMINI",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "RIO DE JANEIRO",
            "departement" => "BRESIL",
            "region" => "BRESIL"
        ],
        [
            "name" => "RIO GRANDE SUL",
            "departement" => "BRESIL",
            "region" => "BRESIL"
        ],
        [
            "name" => "RIYAD",
            "departement" => "ARABIE SAOUDITE",
            "region" => "ARABIE SAOUDITE"
        ],
        [
            "name" => "ROME",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "ROQUETAS DE MAR",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "ROSSO MAURITANIE",
            "departement" => "MAURITANIE",
            "region" => "MAURITANIE"
        ],
        [
            "name" => "SAL",
            "departement" => "CAP VERT",
            "region" => "CAP VERT"
        ],
        [
            "name" => "SALAMANCA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "SALERNO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "SAN BENEDETTO DEL TRONTO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "SAN PEDRO",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "SANTA CROCE SULLZARNO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "SANTANDER",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "SAO DOMINGOS",
            "departement" => "GUINEE BISSAU",
            "region" => "GUINEE BISSAU"
        ],
        [
            "name" => "SAO PAULO",
            "departement" => "BRESIL",
            "region" => "BRESIL"
        ],
        [
            "name" => "SAO VICENTE",
            "departement" => "CAP VERT",
            "region" => "CAP VERT"
        ],
        [
            "name" => "SASSARI",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "SEGOU",
            "departement" => "MALI",
            "region" => "MALI"
        ],
        [
            "name" => "SEGUELA",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "SEREGNO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "SEREKUNDA",
            "departement" => "GAMBIE",
            "region" => "GAMBIE"
        ],
        [
            "name" => "SEVILLA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "SIENA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "STOCKHOLM",
            "departement" => "SUEDE",
            "region" => "PAYS - BAS"
        ],
        [
            "name" => "STUTTGART",
            "departement" => "ALLEMAGNE",
            "region" => "ALLEMAGNE"
        ],
        [
            "name" => "TANGER",
            "departement" => "MAROC",
            "region" => "MAROC"
        ],
        [
            "name" => "TARRAGONA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "TCHIBANGA",
            "departement" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "TENERIFE NORTE",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "TENERIFE",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "TERRASSA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "TIMBI MADINA",
            "departement" => "GUINEE",
            "region" => "GUINEE"
        ],
        [
            "name" => "TORINO VILLE",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "TORONTO",
            "departement" => "CANADA",
            "region" => "CANADA"
        ],
        [
            "name" => "TOULON",
            "departement" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "TOULOUSE",
            "departement" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "TRENTO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "TREVISO",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "TRIESTE",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "TUNIS",
            "departement" => "TUNISIE",
            "region" => "TUNISIE"
        ],
        [
            "name" => "UDINE",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "UPPER RIVER DIVISION",
            "departement" => "GAMBIE",
            "region" => "GAMBIE"
        ],
        [
            "name" => "VALENCIA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "VENEZIA MESTRE",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "VERONA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "VICENZA",
            "departement" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "VICTORIA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "VIGO",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "WINNIPEG",
            "departement" => "CANADA",
            "region" => "CANADA"
        ],
        [
            "name" => "YAMOUSSOUKRO",
            "departement" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "YAOUNDE",
            "departement" => "CAMEROUN",
            "region" => "CAMEROUN"
        ],
        [
            "name" => "ZARAGOZA",
            "departement" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "ZURICH",
            "departement" => "SUISSE",
            "region" => "SUISSE"
        ]
    ];
    const DEPARTEMENTS = [
        [
            "name" => "DAKAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "GUEDIAWAYE",
            "region" => "DAKAR"
        ],
        [
            "name" => "PIKINE",
            "region" => "DAKAR"
        ],
        [
            "name" => "KEUR MASSAR",
            "region" => "DAKAR"
        ],
        [
            "name" => "RUFISQUE",
            "region" => "DAKAR"
        ],
        [
            "name" => "THIES",
            "region" => "THIES"
        ],
        [
            "name" => "MBOUR",
            "region" => "THIES"
        ],
        [
            "name" => "MBACKE",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "TIVAOUANE",
            "region" => "THIES"
        ],
        [
            "name" => "DIOURBEL",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "BAMBEY",
            "region" => "DIOURBEL"
        ],
        [
            "name" => "KAOLACK",
            "region" => "KAOLACK"
        ],
        [
            "name" => "NIORO DU RIP",
            "region" => "KAOLACK"
        ],
        [
            "name" => "GUINGUINEO",
            "region" => "KAOLACK"
        ],
        [
            "name" => "FOUNDIOUGNE",
            "region" => "FATICK"
        ],
        [
            "name" => "GOSSAS",
            "region" => "FATICK"
        ],
        [
            "name" => "FATICK",
            "region" => "FATICK"
        ],
        [
            "name" => "BIRKILANE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "KAFFRINE",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "MALEM HODAR",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "KOUNGHEUL",
            "region" => "KAFFRINE"
        ],
        [
            "name" => "MEDINA YORO FOULAH",
            "region" => "KOLDA"
        ],
        [
            "name" => "KOLDA",
            "region" => "KOLDA"
        ],
        [
            "name" => "VELINGARA",
            "region" => "KOLDA"
        ],
        [
            "name" => "KEDOUGOU",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "SARAYA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "SALEMATA",
            "region" => "KEDOUGOU"
        ],
        [
            "name" => "LINGUERE",
            "region" => "LOUGA"
        ],
        [
            "name" => "KEBEMER",
            "region" => "LOUGA"
        ],
        [
            "name" => "LOUGA",
            "region" => "LOUGA"
        ],
        [
            "name" => "ZIGUINCHOR",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "PODOR",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "KANEL",
            "region" => "MATAM"
        ],
        [
            "name" => "GOUDOMP",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "BAKEL",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "GOUDIRY",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "BIGNONA",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "KOUMPENTOUM",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "SEDHIOU",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "BOUNKILING",
            "region" => "SEDHIOU"
        ],
        [
            "name" => "DAGANA",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "MATAM",
            "region" => "MATAM"
        ],
        [
            "name" => "TAMBACOUNDA",
            "region" => "TAMBACOUNDA"
        ],
        [
            "name" => "OUSSOUYE",
            "region" => "ZIGUINCHOR"
        ],
        [
            "name" => "SAINT LOUIS",
            "region" => "SAINT LOUIS"
        ],
        [
            "name" => "RANEROU FERLO",
            "region" => "MATAM"
        ],
        [
            "name" => "COTE D-IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "COTE D'IVOIRE",
            "region" => "COTE D'IVOIRE"
        ],
        [
            "name" => "NIGERIA",
            "region" => "NIGERIA"
        ],
        [
            "name" => "GHANA",
            "region" => "GHANA"
        ],
        [
            "name" => "MAROC",
            "region" => "MAROC"
        ],
        [
            "name" => "ITALIE",
            "region" => "ITALIE"
        ],
        [
            "name" => "ESPAGNE",
            "region" => "ESPAGNE"
        ],
        [
            "name" => "PAYS BAS",
            "region" => "PAYS - BAS"
        ],
        [
            "name" => "TURQUIE",
            "region" => "TURQUIE"
        ],
        [
            "name" => "BELGIQUE",
            "region" => "BELGIQUE"
        ],
        [
            "name" => "GUINEE BISSAU",
            "region" => "GUINEE BISSAU"
        ],
        [
            "name" => "GAMBIE",
            "region" => "GAMBIE"
        ],
        [
            "name" => "SUISSE",
            "region" => "SUISSE"
        ],
        [
            "name" => "MALI",
            "region" => "MALI"
        ],
        [
            "name" => "GUINEE EQUATORIALE",
            "region" => "GABON"
        ],
        [
            "name" => "MOZAMBIQUE",
            "region" => "AFRIQUE DU SUD"
        ],
        [
            "name" => "ALLEMAGNE",
            "region" => "ALLEMAGNE"
        ],
        [
            "name" => "LIBAN",
            "region" => "EGYPTE"
        ],
        [
            "name" => "ANGLETERRE",
            "region" => "GRANDE BRETAGNE"
        ],
        [
            "name" => "GABON",
            "region" => "GABON"
        ],
        [
            "name" => "BURKINA FASO",
            "region" => "BURKINA FASO"
        ],
        [
            "name" => "FRANCE",
            "region" => "FRANCE"
        ],
        [
            "name" => "BRESIL",
            "region" => "BRESIL"
        ],
        [
            "name" => "REPUBLIQUE DU CONGO",
            "region" => "CONGO"
        ],
        [
            "name" => "ARGENTINE",
            "region" => "BRESIL"
        ],
        [
            "name" => "EGYPTE",
            "region" => "EGYPTE"
        ],
        [
            "name" => "AFRIQUE DU SUD",
            "region" => "AFRIQUE DU SUD"
        ],
        [
            "name" => "GUINEE",
            "region" => "GUINEE"
        ],
        [
            "name" => "BENIN",
            "region" => "TOGO"
        ],
        [
            "name" => "ARABIE SAOUDITE",
            "region" => "ARABIE SAOUDITE"
        ],
        [
            "name" => "CAMEROUN",
            "region" => "CAMEROUN"
        ],
        [
            "name" => "EMIRATS ARABES UNIS",
            "region" => "EMIRATS ARABES UNIS"
        ],
        [
            "name" => "CANADA",
            "region" => "CANADA"
        ],
        [
            "name" => "FINLANDE",
            "region" => "PAYS - BAS"
        ],
        [
            "name" => "KOWEIT",
            "region" => "KOWEIT"
        ],
        [
            "name" => "PORTUGAL",
            "region" => "PORTUGAL"
        ],
        [
            "name" => "TOGO",
            "region" => "TOGO"
        ],
        [
            "name" => "LUXEMBOURG",
            "region" => "BELGIQUE"
        ],
        [
            "name" => "TCHAD",
            "region" => "CAMEROUN"
        ],
        [
            "name" => "NIGER",
            "region" => "NIGER"
        ],
        [
            "name" => "MAURITANIE",
            "region" => "MAURITANIE"
        ],
        [
            "name" => "CAP VERT",
            "region" => "CAP VERT"
        ],
        [
            "name" => "SUEDE",
            "region" => "PAYS - BAS"
        ],
        [
            "name" => "TUNISIE",
            "region" => "TUNISIE"
        ]
    ];
    const REGIONS = ["DAKAR","THIES","LOUGA","SAINT LOUIS","MATAM","TAMBACOUNDA","KEDOUGOU", "KOLDA","SEDHIOU","ZIGUINCHOR","KAOLACK","DIOURBEL","KAFFRINE","FATICK","DIASPORA"];


    public function index(): JsonResponse|array
    {


        if (!request()->user()->hasRole("owner")) {
            abort(403, "Accès aux rapports refusé !");
        }
        $params = Params::getParams();
        $rapports["max_count"] = $params->max_count;
        $rapports["min_count"] = $params->min_count;

        $parti = Parti::partiOfCurrentUser();

        try {
            $url = $parti->end_point . "parrainages";
            $response = Http::get($url);
            $response->throw();
            if ($response->successful()) {
                $dataFromApi = json_decode($response->body(), true);
                $rapports = array_merge($rapports, $dataFromApi);

                $rapports["users"] = array_map(function ($item) {
                    if ($item["user"] != null) {
                        $user = User::whereId($item["user"])->first();
                        $item["user"] = $user != null ? $user->name : "Inconnu";
                        return $item;
                    }
                    return $item;

                },
                    $rapports["users"]);
                /* $totalDiaspora = 0;
                 $rapports["regions"] = array_map(function ($item) use
                  (&$totalDiaspora) {
                     if ($item["nom"] != null) {
                         if (self::isDiasporaRegion($item["nom"])) {
                             $totalDiaspora += $item["nombre"];
                             $item['nom'] = "DIASPORA";
                         }
                         return $item;
                     }
                     return $item;

                 },
                     $rapports["regions"]);
                 $diasporaRegions = array_filter($rapports["regions"], function ($item) {
                     return $item["nom"] === "DIASPORA";
                 });

// Optionally, remove diaspora regions from the original array
                 $rapports["regions"] = array_filter($rapports["regions"], function ($item) {
                     return $item["nom"] !== "DIASPORA";
                 });*/
                $totalDiaspora = 0;
                $rapports["regions"] = array_reduce($rapports["regions"], function ($carry, $item) use (&$totalDiaspora) {
                    if ($item["nom"] != null) {
                        if (self::isDiasporaRegion($item["nom"])) {
                            $totalDiaspora += $item["nombre"];
                        } else {
                            // Add non-diaspora regions directly to the result
                            $carry[] = $item;
                        }
                    }

                    return $carry;
                }, []);

// Add a single item representing diaspora regions to the result
                if ($totalDiaspora > 0) {
                    $rapports["regions"][] = [
                        "nom" => "DIASPORA",
                        "nombre" => $totalDiaspora,
                        // Add other properties as needed
                    ];
                }
                $rapports["today_counts_per_user"] = array_map(function ($item) {
                    if ($item["user"] != null) {
                        $user = User::whereId($item["user"])->first();
                        $item["user"] = $user != null ? $user->name : "Inconnu";
                        return $item;
                    }
                    return $item;

                }, $rapports["today_counts_per_user"]);


            }
        } catch (RequestException $e) {
            Log::error($e->getMessage());
            return response()->json(["une erreur s'est produite " . $e->response->body()], 500);

        }

        $total_saisi = $rapports["total_saisi"];
        $rapports["manquant"] = $params->min_count - $total_saisi;
        $rapports["manquant_min"] = $params->min_count - $total_saisi;
        $rapports["manquant_max"] = $params->max_count - $total_saisi;
        $rapports["parti_users"] = $parti->users()->get();

        return $rapports;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreParrainageRequest $request
     * @return Parrainage|\Illuminate\Database\Eloquent\Model|JsonResponse
     * @throws RequestException
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            "prenom" => "required|min:2|max:50",
            "nom" => "required|min:2|max:20",
            "nin" => "required|string|min:13|max:14",
            "num_electeur" => "required|digits:9",
            "date_expir" => "required|date_format:d/m/Y",
            "region" => "required|string",
            "primo" => "bool",
            "commune" => "string"
        ]);
        $parti = Parti::partiOfCurrentUser();
        $haveAccessToProValidation = $parti->formule->has_pro_validation;
        $data["parti_id"] = $parti->id;
        if (!$parti->hasEndpoint()) {
            $request->validate([
                'nin' => [function ($attribute, $value, $fail) use ($data, $parti) {
                    $electeur = Parrainage::where("nin", $data["nin"])
                        ->wherePartiId($parti->id)
                        ->first();
                    if ($electeur != null) {
                        //no match
                        $fail('Un parrainage déjà enregistré avec la même cni ');
                    }
                }],
                'num_electeur' => [function ($attribute, $value, $fail) use ($data, $parti) {
                    $electeur =
                        Parrainage::where('num_electeur', $data['num_electeur'])
                            ->wherePartiId($parti->id)
                            ->first();
                    if ($electeur != null) {
                        //no match
                        $fail('Un parrainage déjà enregistré avec le même numéro électeur! ');
                    }
                }],
                'commune' => [function ($attribute, $value, $fail) use ($data, $parti) {
                    if (isset($data["primo"]) && $data["primo"]) {
                        if (!isset($data["commune"]) || $data["commune"] == null) {
                            $fail('Veuillez renseigner la commune car la case primo votant est cochée ');

                        }
                    }
                }],
            ]);
        }

        // Pro validation

        if ($haveAccessToProValidation) {
            $electeur = Electeur::where("nin", $data['nin'])
                ->orWhere('num_electeur', $data['num_electeur'])->first();
            if ($electeur != null) {
                $commune = $electeur->commune;
                $data["commune"] = $commune;
            }

            $validationResult = self::proValidation(new Parrainage($data), $electeur);
            if ($validationResult["all_fields_match"]) {

                $parti = Parti::partiOfCurrentUser();
                $has_endpoint = $parti->hasEndpoint();

                if ($has_endpoint) {
                    $url = $parti->end_point . "parrainages";
                    return $this->submitDataToPolexApi($data, $url);
                } else {
                    return Parrainage::create($data);
                }

            } else {
                $primoVotant = isset($data["primo"]) && $data["primo"];
                $url = $parti->end_point . "parrainages";

                if ($primoVotant) {
                    if (!request()->user()->hasRole("owner") && !request()->user()->hasRole("supervisor")) {
                        abort(403, "Seuls les admins ou superviseurs sont autorisés à enregistrer des données non validées comme les primo votants");
                    }
                    if (Parti::partiOfCurrentUser()->hasEndpoint()) {

                        return $this->submitDataToPolexApi($data, $url);
                    } else {
                        return Parrainage::create($data);
                    }
                }
                return new JsonResponse(["message" => "pro_validation_failed", "errors" => $validationResult], 422);
            }

        }


        return Parrainage::create($data);

    }

    /**
     * Display the specified resource.
     *
     * @param Parrainage $parrainage
     * @return Parrainage
     */
    public function show(Parrainage $parrainage): Parrainage
    {
        //
        return $parrainage;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateParrainageRequest $request
     * @return Parrainage|array|JsonResponse|object
     */
    public function update(UpdateParrainageRequest $request, $num_electeur)
    {
        //
        try {
            if (Parti::partiOfCurrentUser()->hasEndpoint()) {
                $url = Parti::partiOfCurrentUser()->end_point . "parrainages/update/" . $num_electeur;
                $response = Http::post($url, $request->input());
                $response->throw();
                if ($response->successful()) {
                    return $response->object();

                }
            } else {
                $parrainage = Parrainage::whereNumElecteur($num_electeur)->first();
                if ($parrainage != null) {
                    $parrainage->update($request->input());
                } else {
                    return \response()->json(["message" => "Parrainage introuvable ! "], 404);
                }
                return $parrainage;
            }
        } catch (RequestException $e) {

            if ($e->response->notFound()) {
                return \response()->json(["message" => "Electeur non trouvé"], 404);
            } else {
                Log::error("Une erreur s'est produite au niveau de l'api " . $e->getMessage());
                return \response()->json(["message" => "Une erreur s'est produite au niveau de l'api"], 404);

            }


        }

        return $request;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Parrainage $parrainage
     * @return Response
     */
    public function destroy(Parrainage $parrainage): Response
    {
        //
        $parrainage->delete();
        return new Response('deleted', 204);
    }

    public static function proValidation(Parrainage $parrainage, $electeur = null): array
    {
        $isDiasporaElecteur = strtolower($parrainage->region) == "diaspora" || self::isDiasporaRegion($parrainage->region);
        if ($electeur == null) {
            //no match
            return ["has_match" => false, "all_fields_match" => false, "fields" => []];
        } else {
            $result = [
                "has_match" => true,
                "all_fields_match" =>
                    strtolower(trim($parrainage->prenom)) == strtolower(trim($electeur->prenom))
                    && strtolower(trim($parrainage->nom)) == strtolower(trim($electeur->nom))
                    && ($electeur->nin == null || trim($parrainage->nin) == trim($electeur->nin))
                    && trim($parrainage->num_electeur) == trim($electeur->num_electeur)
                    && (strtolower(trim($parrainage->region)) == strtolower(trim($electeur->region)) || (self::isDiasporaRegion($electeur->region))),
                "fields" => [
                    ["label" => "PRENOM " . $parrainage->prenom, "matched" => strtolower(trim($parrainage->prenom)) == strtolower(trim($electeur->prenom))],
                    ["label" => "NOM " . $parrainage->nom, "matched" => strtolower(trim($parrainage->nom)) == strtolower(trim($electeur->nom))],
                    ["label" => "NIN " . $parrainage->nin, "matched" => strtolower(trim($parrainage->nin)) == strtolower(trim($electeur->nin))],
                    ["label" => "N° Electeur " . $parrainage->num_electeur, "matched" => intval($parrainage->num_electeur) == intval(trim($electeur->num_electeur))],
                    ["label" => "REGION " . $parrainage->region, "matched" => (strtolower($parrainage->region) == strtolower(trim($electeur->region)) || ($isDiasporaElecteur && self::isDiasporaRegion($electeur->region)))]
                ]

            ];

            return $result;
        }
    }

    public static function isDiasporaRegion($region): bool
    {

        return in_array($region, self::REGIONS_DIASPORA);
    }

    public function bulkInsertFromExcel()
    {

        $data = request()->json('data');
        $dataWithoutDiscriminantFieldName = array_map(function ($item) {
            $parti_id = Parti::partiOfCurrentUser()->id;
            $item["parti_id"] = $parti_id;
            $item["created_at"] = Carbon::now();
            $item["user_id"] = request()->user()->id;

            return $item;
        }, $data);

        $parti = Parti::partiOfCurrentUser();
        $has_endpoint = $parti->hasEndpoint();

        if ($has_endpoint) {
            $url = $parti->end_point . 'parrainages/excel';

            $response = Http::withHeaders([
                self::jsonHeaders
            ])->post($url, ["data" => $dataWithoutDiscriminantFieldName]);
            if ($response->successful()) {
                return response()->json(json_decode($response->body(), true));
            } else {
                return response()->json(["message" => "Une erreur", "detail" => $response->body()], 500);

            }

        } else {

            $total = Parrainage::insertOrIgnore($dataWithoutDiscriminantFieldName);
        }


        return response()->json(["total_inserted" => $total]);


    }

    public function bulkProValidation(): array|JsonResponse
    {
        $has_pro = Parti::partiOfCurrentUser()->formule->has_pro_validation;
        if (!$has_pro) {
            return response()->json(['Accès réservé aux clients Pro'], 403);
        }

        $data = request()->json('parrainages');
        $region = request()->json('region');
        $parrainagesValides = [];
        $parrainagesInvalides = [];
        foreach ($data as $parrainage) {
            $table_name = $region == "SAINT LOUIS" ? 'saint_louis' : strtolower($region);
            $electeur = DB::table($table_name)->select(["prenom", "nom", "nin", "num_electeur", "region", "commune"])
                ->where("nin", $parrainage["nin"])
                ->orWhere("num_electeur", $parrainage["num_electeur"])
                ->first();
            $validationResult = ParrainageController::proValidation(new Parrainage($parrainage), $electeur);
            if ($validationResult["has_match"] && $validationResult["all_fields_match"]) {
                $parrainage["commune"] = $electeur->commune;
                $parrainagesValides[] = $parrainage;
            } else {
                $errors = [];
                if ($validationResult["has_match"]) {
                    $fields = $validationResult["fields"];
                    foreach ($fields as $field) {
                        if (!$field['matched']) {
                            $message = $field["label"] . ' non conforme';
                            $errors[] = $message;
                        }
                    }
                } else {
                    $errors[] = "Introuvable dans la région de " . $region . " ou dans le fichier électoral";
                }
                $parrainage ["raison"] = implode(", ", $errors);
                $parrainagesInvalides[] = $parrainage;
            }
        }


        return ["parrainagesInvalides" => $parrainagesInvalides, "parrainagesValides" => $parrainagesValides];

    }

    public function bulkCorrection(): array|JsonResponse
    {
        $params = Params::getParams();
        $has_pro = Parti::partiOfCurrentUser()->formule->has_pro_validation;
        if (!$has_pro) {
            return response()->json(['Accès réservé aux clients Pro'], 403);
        }

        $data = request()->json('parrainages');
        $parrainagesCorriges = [];
        $parrainagesNonCorriges = [];
        foreach ($data as $parrainage) {
            $table_name = "electeurs";

            $query = DB::table($table_name)->select(["prenom", "nom", "nin", "num_electeur", "region", "commune"]);
            $electeur = $query
                ->where("nin", trim($parrainage["nin"]))
                ->orWhere("num_electeur", trim($parrainage["num_electeur"]))
                ->first();


            if ($electeur != null) {
                $corrected = [];
                $corrected["prenom"] = $electeur->prenom;
                $corrected["nom"] = $electeur->nom;
//                $corrected["nin"] = $electeur->nin ?? $parrainage["nin"];
                $corrected["nin"] = $electeur->nin;
                $corrected["num_electeur"] = $electeur->num_electeur;
                $corrected["date_expir"] = $parrainage["date_expir"];
                $corrected["region"] = $electeur->region;
                $corrected["commune"] = $electeur->commune;

                $parrainagesCorriges[] = $corrected;
            } else {
                $parrainagesNonCorriges [] = $parrainage;

            }
        }


        return ["parrainagesCorriges" => $parrainagesCorriges, "parrainagesNonCorriges" => $parrainagesNonCorriges];

    }

    public function findForAutocomplete($param)
    {

        $parti = Parti::partiOfCurrentUser();
        if ($parti->has_debt ){
            abort(403, "Souscription POLEX expirée ! Contactez le support");
        }
        $has_endpoint = $parti->hasEndpoint();

        if ($has_endpoint) {
            $url = $parti->end_point . "parrainages/find/" . $param;
            $response = Http::get($url);
            if ($response->successful()) {
                return ["already_exists" => true, "electeur" => $response->object()];

            } else {
                if ($response->notFound()) {
                    $electeur = DB::table("electeurs")->select(["prenom", "nom", "nin", "num_electeur", "region", "commune"])
                        ->where(DB::raw("TRIM(nin)"), $param)
                        ->orWhere(DB::raw("TRIM(num_electeur)"), $param)
                        ->first();
                    if ($electeur == null) {
                        return response()->json(['message' => 'not found'], 404);
                    }
                    $electeur->date_expir = null;

                    return ["already_exists" => false, "electeur" => $electeur];

                } else {

                    return response()->json([], 500);
                }
            }
        } else {
            $electeur = DB::table("electeurs")->select(["prenom", "nom", "nin", "num_electeur", "region", "commune"])
                ->where(DB::raw("TRIM(nin)"), $param)
                ->orWhere(DB::raw("TRIM(num_electeur)"), $param)
                ->first();
            $parrainage = Parrainage::where("nin", $param)
                ->orWhere(DB::raw("TRIM(num_electeur)"), $param)
                ->first();
            if ($electeur == null) {
                return response()->json(['message' => 'not found'], 404);
            }
            return ["already_exists" => $parrainage != null, "electeur" => $electeur];

        }


    }

    /**
     * @param array $data
     * @param string $url
     * @return JsonResponse
     */
    public function submitDataToPolexApi(array $data, string $url): JsonResponse
    {
        try {
            $data["user_id"] = request()->user()->id;
            unset($data["primo"]);
            $response = Http::withHeaders(self::jsonHeaders)
                ->post($url, $data);
            $response->throw();
            if ($response->successful()) {
                return response()->json(json_decode($response->body(), true));
            } else {
                return response()->json(["message" => "Une erreur", "detail" => json_decode($response->body(), true)], 500);

            }
        } catch (RequestException $e) {
            if ($e->response->unprocessableEntity()) {
                return response()->json(json_decode($e->response->body(), true), 422);

            } else
                return response()->json(["message" => "Une erreur from Polex api", "detail" => json_decode($e->response->body(), true)], 500);

        }
    }

    public function exportCriteria()
    {
        return \response()->json(["users" => Parti::partiOfCurrentUser()->user()->get()]);
    }

    public function searchParrainage(Request $request)
    {
        $parti = Parti::partiOfCurrentUser();
        if ($parti->has_debt ){
            return \response()->json(["message" => "Souscription POLEX expirée ! Contactez le support"], 422);

        }
        function rejectResponseForMissingQuery($message): JsonResponse
        {
            return \response()->json(["message" => $message], 422);

        }

        $searchCriteria = $request->query("criteria");
        $dateStart = $request->query("dateStart");
        $dateStart = $dateStart == "null" ? null : $dateStart;
        $dateEnd = $request->query("dateEnd");
        $dateEnd = $dateEnd == "null" ? null : $dateEnd;
        if ($searchCriteria == null) {
            return rejectResponseForMissingQuery("Aucun critère de recherche défini !");
        }
        $query = null;
        switch ($searchCriteria) {
            case "parrainages_single":
                $query = Parrainage::whereNumElecteur($request->query('param'))->orWhere('nin', $request->query('param'));
                break;
            case "parrainages_today":
                $query = Parrainage::whereDate("created_at", Carbon::today()->toDateString());
                break;
            case "parrainages_date_interval":
                if ($dateStart == null) {
                    return rejectResponseForMissingQuery("Vous avez choisi le critère <<Parrainages par intervalle>> sans précisé la date de début ! ");
                }
                if ($dateEnd == null) {
                    return rejectResponseForMissingQuery("Vous avez choisi le critère <<Parrainages par intervalle>> sans préciser la date de fin ! ");
                }
                $query = Parrainage::query();

                break;
            case "parrainages_region":
                $region = $request->query("region");
                if ($region == null) {
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Recherche par région" sans préciser la région ! ');

                }
                $query = ! self::isDiasporaRegion($region) ? Parrainage::whereRegion($region)
                : Parrainage::whereIn("region", self::REGIONS_DIASPORA)
                ;
                break;
            case "parrainages_departement":
                $departement = $request->query("departement");
                $communesDepartement = array_filter(self::COMMUNES, function ($item) use ($departement){
                    return $item['departement'] == $departement;
                });
                $communesDepartement = array_map(function ($item){ return $item['name']; }, $communesDepartement);
                $query = Parrainage::whereIn("commune", $communesDepartement);
                break;
            case "parrainages_commune":
                $commune = $request->query("commune");
                if ($commune == null) {
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Recherche par commune" sans préciser la commune ! ');

                }
                $query = Parrainage::whereCommune($commune);
                break;
            //http://localhost:8888/Polex/PolexBackend/public/api/parrainages/search?criteria=parrainages_by_user?user_id=1?region=null?departement=null?commune=null?dateStart=null?dateEnd=null
            case "parrainages_by_user":
                $user_id = $request->query("user_id");
                if ($user_id == null) {
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Recherche par opérateur de saisie" sans préciser l\'utilisateur ! ');

                }
                $query = Parrainage::whereUserId($user_id);
                break;
            case "parrainages_by_user_interval":
                $user_id = $request->query("user_id");
                if ($user_id == null) {
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Recherche par opérateur dans intervalle de date" sans préciser l\'utilisateur ! ');

                }
                if ($dateStart == null) {
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Parrainages par utilisateur dans une intervalle de date" sans préciser la date de début ! ');
                }
                if ($dateEnd == null) {
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Parrainages par utilisateur dans une intervalle de date" sans préciser la date de fin ! ');
                }

                break;
            default:
                return rejectResponseForMissingQuery("Critère de recherche inconnu ! ");

        }
        if ($query instanceof Builder) {
            if ($dateStart != null && $dateEnd != null) {
                $query->whereDate("created_at", '>=', $dateStart)
                    ->whereDate("created_at", '<=', $dateEnd);
            }
            $query->orderBy('created_at');
            if ($request->query("limit") != null && $request->query("limit") != "null" && $request->query("limit") >0){

                $query->limit($request->query("limit"));
            }
            if ($request->query("exclureDoublons") == "true"){
                $query->where(function ($subQuery){
                $subQuery->where('doublon', '!=',1)->orWhere('doublon', null);
                });

            }
            $sql = $query->toSql();

// Get the bindings
            $bindings = $query->getBindings();

// Replace placeholders with actual values
            foreach ($bindings as $binding) {
                $sql = preg_replace('/\?/', '"'.$binding.'"', $sql, 1);
            }
            try {
//                dd($sql);

                $url = Parti::partiOfCurrentUser()->end_point . "parrainages/search";
                $response = Http::withHeaders(ParrainageController::jsonHeaders)->post($url, ["secret" => $parti->code, "query" => $sql]);
                $response->throw();
                $results = $response->object();


                if (count($results) == 0) {
                    return \response()->json(["message" => "Aucun résultat trouvé !"], 404);
                }
                $results = array_map(function ($item) {
                    $user = User::whereId($item->user_id)->first();
                    $item->saisi_par = $user != null ? $user->name : 'Inconnu';
                    return $item;
                }, $results);
                return $results;
            } catch (RequestException $e) {
                return json_decode($e->response->body());

            }
        }
        return \response()->json(["message" => "Aucune recherche effectuée en fonction des critères"], 404);


    }

    /**
     * @throws RequestException
     */
    public function delete($parrainage_id)
    {
        try {
            if (!\request()->user()->hasRole('owner')) {
                abort(403, "Vous n'etes pas autorisé à supprimer un parrainage !");
            }
            $parti = Parti::partiOfCurrentUser();
            $response = Http::withHeaders(self::jsonHeaders)
                ->delete($parti->end_point . 'parrainages/delete/' . $parrainage_id, ["secret" => $parti->code]);
            $response->throw();
            if ($response->successful()) {
                return \response()->json(['message' => 'deleted'], 204);
            }
        } catch (RequestException $e) {
            return response()->json(['message' => $e->response->body()], 500);
        }

    }

    /**
     * @throws RequestException
     */
    public function bulkDelete(Request $request)
    {
        try {
            if (!\request()->user()->hasRole('owner')) {
                abort(403, "Vous n'etes pas autorisé à supprimer des parrainages !");
            }
            $parti = Parti::partiOfCurrentUser();
            $data = $request->getContent();
            $archive = new Archive();
            $archive->data = $data;
            $archive->parti()->associate($parti);
            $archive->save();
            $idsOfItemsToDelete = array_map(function ($item) {
                return $item['id'];

            }, $request->toArray());


            $query = Parrainage::whereIn('id', $idsOfItemsToDelete);
            $sql = str_replace('select * ', 'delete ', $query->toSql());
            $bindings = $query->getBindings();

// Replace placeholders with actual values
            foreach ($bindings as $binding) {
                $sql = preg_replace('/\?/', "'$binding'", $sql, 1);
            }
            try {

                $url = Parti::partiOfCurrentUser()->end_point . "parrainages/search";
                $response = Http::withHeaders(ParrainageController::jsonHeaders)->post($url, ["secret" => $parti->code, "query" => $sql]);
                $response->throw();
                $results = $response->object();


                return $results;
            } catch (RequestException $e) {
                return json_decode($e->response->body());

            }
            return new JsonResponse([$idsOfItemsToDelete], 204);
            /* $response = Http::withHeaders(self::jsonHeaders)
                 ->delete($parti->end_point .'parrainages/delete/bulk',["secret" => "2022"]);
             $response->throw();
             if ($response->successful()){
                 return \response()->json(['message'=>'deleted'],204);
             }*/
        } catch (RequestException $e) {
            return response()->json(['message' => $e->response->body()], 500);
        }

    }

    public function userReport(User $user)
    {
        $data = [];
        return $data;
    }

    public function bulkIdentify()
    {
        $data = request()->json('data');

        $parti = Parti::partiOfCurrentUser();

        $url = $parti->end_point . 'parrainages/search';

        try {
            $query = Parrainage::whereIn('num_electeur', $data);
            $sql = $query->toSql();
            $bindings = $query->getBindings();

// Replace placeholders with actual values
            foreach ($bindings as $binding) {
                $sql = preg_replace('/\?/', "'$binding'", $sql, 1);
            }
            $response = Http::withHeaders(ParrainageController::jsonHeaders)->post($url, ["secret" => $parti->code, "query" => $sql]);
            $response->throw();
            $results = $response->object();
            $results = array_map(function ($item) {
                $user = User::whereId($item->user_id)->first();
                $item->saisi_par = $user != null ? $user->name : 'Inconnu';
                return $item;
            }, $results);

        } catch (RequestException $e) {

        }


        return $results;
    }

    // ============================== SECTION OF FINAL METHODS ====================
    public function parrainagesFinalIndex()
    {
        $rapports = [];
        if (!request()->user()->hasRole("owner")) {
            abort(403, "Accès aux rapports refusé !");
        }

        $parti = Parti::partiOfCurrentUser();

        try {
            $url = $parti->end_point . "parrainages/final/index";
            $response = Http::get($url);
            $response->throw();
            if ($response->successful()) {
                $rapports = json_decode($response->body(), true);

                $rapports["users"] = array_map(function ($item) {
                    if ($item["user"] != null) {
                        $user = User::whereId($item["user"])->first();
                        $item["user"] = $user != null ? $user->name : "Inconnu";
                        return $item;
                    }
                    return $item;

                },
                    $rapports["users"]);
                $totalDiaspora = 0;
                $rapports["regions"] = array_reduce($rapports["regions"], function ($carry, $item) use (&$totalDiaspora) {
                    if ($item["nom"] != null) {
                        if (self::isDiasporaRegion($item["nom"])) {
                            $totalDiaspora += $item["nombre"];
                        } else {
                            // Add non-diaspora regions directly to the result
                            $carry[] = $item;
                        }
                    }

                    return $carry;
                }, []);

// Add a single item representing diaspora regions to the result
                if ($totalDiaspora > 0) {
                    $rapports["regions"][] = [
                        "nom" => "DIASPORA",
                        "nombre" => $totalDiaspora,
                        // Add other properties as needed
                    ];
                }



            }
        } catch (RequestException $e) {
            Log::error($e->getMessage());
            return response()->json(["une erreur s'est produite " . $e->response->body()], 500);

        }



        return $rapports;

    }
    public function bulkAddParrainagesToFinal()
    {


//        $data = json_decode(request()->getContent(), true);
        $data = \request()->json('data');
        $query = "INSERT IGNORE INTO parrainages_final ("; // start query
        $query .= implode(",",array_keys($data[0]));
        $query .= ") VALUES ";
        $parti = Parti::partiOfCurrentUser();

        $url = $parti->end_point . 'parrainages/search';

        try {

            $data = array_map(function ($item) {


// Extract values and escape special characters
                $escapedValues = array_map('addslashes', array_values($item));

// Implode into a string with each value quoted
                $implodedString = '"' . implode('", "', $escapedValues) . '"';

// Wrap with parentheses
                return "($implodedString)";
            }, $data);

            $query.=implode(",",$data);

            $response = Http::withHeaders(ParrainageController::jsonHeaders)->post($url, ["secret" => $parti->code, "query" => 'Select COUNT(*)  as total from parrainages_final']);
            $response->throw();
            $results = $response->object();
            $total = $results[0]->total;
            if ($total >= 58975){
                return response()->json(["message"=>"Vous avez atteint le nombre maximal de 58 975  parrainages autorisés  dans le fichier finale !"], 422);
            }
            $response = Http::withHeaders(ParrainageController::jsonHeaders)->post($url, ["secret" => $parti->code, "query" => $query]);
            $response->throw();
            $results = $response->object();


        } catch (RequestException $e) {
            Log::error($e->getMessage());
            return response($e->response, 500);
        }


        return $results;
    }
 public function saveDuplicates()
    {


//        $data = json_decode(request()->getContent(), true);
        $data = \request()->json('data');
        $query = "UPDATE parrainages SET doublon = 1 WHERE num_electeur IN ("; // start query
        $parti = Parti::partiOfCurrentUser();

        $url = $parti->end_point . 'parrainages/search';

        try {

            $data = array_map(function ($item) {
                return "'$item'";
            }, $data);

            $query.=implode(",",$data);

            $query.=")";


            $response = Http::withHeaders(ParrainageController::jsonHeaders)->post($url, ["secret" => $parti->code, "query" => $query]);
            $response->throw();
            $results = $response->object();


        } catch (RequestException $e) {
            Log::error($e->getMessage());
            return response($e->response, 500);
        }


        return $results;
    }
    public function deleteFinalBulk2()
    {


//        $data = json_decode(request()->getContent(), true);
        $data = \request()->json('data');
        $query = "DELETE FROM parrainages_final WHERE num_electeur IN ("; // start query
        $parti = Parti::partiOfCurrentUser();

        $url = $parti->end_point . 'parrainages/search';

        try {

            $data = array_map(function ($item) {
                return "'$item'";
            }, $data);

            $query.=implode(",",$data);

            $query.=")";


            $response = Http::withHeaders(ParrainageController::jsonHeaders)->post($url, ["secret" => $parti->code, "query" => $query]);
            $response->throw();
            $results = $response->object();


        } catch (RequestException $e) {
            Log::error($e->getMessage());
            return response($e->response, 500);
        }


        return $results;
    }
    public function deleteFinalBulk(Request $request)
    {
        try {
            if (!\request()->user()->hasRole('owner')) {
                abort(403, "Vous n'etes pas autorisé à supprimer des parrainages !");
            }
            $parti = Parti::partiOfCurrentUser();
            $data = $request->getContent();
            $archive = new Archive();
            $archive->data = $data;
            $archive->parti()->associate($parti);
            $archive->save();
            $idsOfItemsToDelete = $request->toArray();


            $query = ParrainageFinal::whereIn('num_electeur', $idsOfItemsToDelete);
            $sql = str_replace('select * ', 'delete ', $query->toSql());
            $bindings = $query->getBindings();

// Replace placeholders with actual values
            foreach ($bindings as $binding) {
                $sql = preg_replace('/\?/', "'$binding'", $sql, 1);
            }
            try {

                $url = Parti::partiOfCurrentUser()->end_point . "parrainages/search";
                $response = Http::withHeaders(ParrainageController::jsonHeaders)->post($url, ["secret" => $parti->code, "query" => $sql]);
                $response->throw();
                $results = $response->object();


                return $results;
            } catch (RequestException $e) {
                return json_decode($e->response->body());

            }
            return new JsonResponse([$idsOfItemsToDelete], 204);
            /* $response = Http::withHeaders(self::jsonHeaders)
                 ->delete($parti->end_point .'parrainages/delete/bulk',["secret" => "2022"]);
             $response->throw();
             if ($response->successful()){
                 return \response()->json(['message'=>'deleted'],204);
             }*/
        } catch (RequestException $e) {
            return response()->json(['message' => $e->response->body()], 500);
        }

    }


}
