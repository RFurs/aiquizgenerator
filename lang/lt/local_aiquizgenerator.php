<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version information for local_aiquizgenerator.
 *
 * @package    local_aiquizgenerator
 * @copyright  2026 Renat Furs <fursrenat@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['actions'] = 'Veiksmai';
$string['aigenerationerror'] = 'Nepavyko sugeneruoti viktorinos. Galimos priežastys:
<ul>
    <li>DI teikėjas arba veiksmas "Generuoti tekstą" yra išjungti.</li>
    <li>Neteisingas API raktas arba norektiška endpoint konfigūracija.</li>
    <li>Pasiektas API kvotos limitas.</li>
</ul>
Detalesnis klaidos aprašymas: {$a}';
$string['aiquizgenerator'] = 'DI viktorinų generatorius';
$string['aiquizgenerator:generate'] = 'Sugeneruoti viktoriną';
$string['analyze'] = 'Analizuoti';
$string['apply'] = 'Taikyti';
$string['c'] = 'C';
$string['category'] = 'Kategorija';
$string['cognitivedifficulty'] = 'Kognityv. sudėtingumas';
$string['confirm_delete_file'] = 'Ar tikrai norite pašalinti šį failą?';
$string['confirm_delete_all'] = 'Ar tikrai norite pašalinti šiuos failus?';
$string['comparch'] = 'Kompiuterių architektūra';
$string['choosejson'] = 'Pasirinkite JSON failą';
$string['cpp'] = 'C++';
$string['create'] = 'Kurti';
$string['delete'] = 'Pašalinti';
$string['delete_all'] = 'Pašalinti visus';
$string['dsa'] = 'Duomenų struktūros ir algoritmai';
$string['evaluate'] = 'Įvertinti';
$string['examplesname'] = 'Pavadinimas';
$string['examplesnamerequired'] = 'Pavadinimo įvedimas yra privalomas';
$string['examplesnameinvalid'] = 'Neteisingas pavadinimas. Pavadinimas negali prasidėti nuo nematomų simbolių';
$string['examples_deleted_all'] = 'Visi pavyzdžiai buvo sėkmingai pašalinti';
$string['examplesfiles'] = 'Pavyzdiniai JSON failai';
$string['examplesaved'] = 'Pavyzdžiai išsaugoti.';
$string['examplesprefix'] = 'Pavyzdys:';
$string['filedeleted'] = 'Failas buvo sėkmingai pašalintas';
$string['generatedsuccessfully'] = 'Moodle viktorina buvo sėkmingai sugeneruota';
$string['generatequiz'] = 'Generuoti viktoriną';
$string['importfailed'] = 'Nepavyko importuoti klausimų, galimai dėl neteisingos XML struktūros. Prašome pabandyti dar kartą. ';
$string['invalidfilename'] = 'Neteisingas failo pavadinimas. Leidžiami failo pavadinimai: [lvl1, lvl2, lvl3, lvl4, lvl5, lvl6]';
$string['invalidjsonuploaded'] = 'Neteisinga įkelto JSON failo struktūra';
$string['invalidjsonresponse'] = 'Nepavyko konvertuoti JSON į XML dėl neteisingos struktūros. Prašome pabandyti dar kartą.';
$string['invalidjsonstructure'] = 'Neteisinga JSON failo struktūra.';
$string['java'] = 'Java';
$string['jsonexamples'] = 'JSON pavyzdžiai';
$string['language'] = 'Kalba';
$string['numberofquestions'] = 'Klausimų skaičius';
$string['numofquestrestriction'] = 'Šis laukas leidžia įvesti nuo 1 iki 30 klausimų';
$string['numofquestrequired'] = 'Klausimų skaičiaus įvedimas yra privalomas';
$string['nofileuploaded'] = 'Failas nebuvo įkeltas';
$string['nouploadedexamples'] = 'Nebuvo rasta įkeltų pavyzdžių.';
$string['manageexamples'] = 'Tvarkyti pavyzdžius';
$string['nomodulecontext'] = 'Nerastas modulio kontekstas. Prašome patikrinti ar egzistuoja bent vienas klausimų bankas.';
$string['nodefaultcategory'] = 'Nepavyko rasti kategorijos pagal nutylėjimą. Prašome patikrinti ar egzistuoja bent viena kategorija';
$string['pluginname'] = 'AI Quiz Generator';
$string['prompt'] = 'Sukurk viktoriną iš dalyko {$a->subject}. Tema: {$a->topic}. Klausimų skaičius: {$a->count}. Blumo taksonomijos lygis: {$a->level}. Formatas: JSON. Sugeneruoti klausimai turi būti panašūs į klausimus esančius pavyzdžiuose sudėtingumo ir struktūros atžvilgiu.';
$string['questionbank'] = 'Klausimų bankas';
$string['quizgenerator'] = 'Viktorinų generatorius';
$string['quizsubject'] = 'Studijų dalykas';
$string['quiztopic'] = 'Viktorinos tema';
$string['remember'] = 'Atsiminti';
$string['savechanges'] = 'Išsaugoti';
$string['topic'] = 'Tema';
$string['topicisnotvalid'] = 'Leidžiamos tik raidės, skaitmenys ir nematomi simboliai. Temos pavadinimas taip pat negali prasidėti nuo nematomų simbolių';
$string['topicisrequired'] = 'Temos įvedimas yra privalomas';
$string['topicplaceholder'] = 'Rodyklės';
$string['understand'] = 'Suprasti';
$string['uploadedexamples'] = 'Įkelti pavyzdžiai';
$string['view'] = 'Žiūrėti';
