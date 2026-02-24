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

$string['aigenerationerror'] = 'Nepavyko sugeneruoti viktorinos. Galimos priežastys:
<ul>
    <li>DI teikėjas arba veiksmas "Generuoti tekstą" yra išjungti.</li>
    <li>Neteisingas API raktas arba norektiška endpoint konfigūracija.</li>
    <li>Pasiektas API kvotos limitas.</li>
</ul>
Detalesnis klaidos aprašymas: {$a}';
$string['aiquizgenerator'] = 'DI viktorinų generatorius';
$string['analyze'] = 'Analizuoti';
$string['apply'] = 'Taikyti';
$string['c'] = 'C';
$string['category'] = 'Kategorija';
$string['cognitivedifficulty'] = 'Kognityv. sudėtingumas';
$string['comparch'] = 'Kompiuterių architektūra';
$string['cpp'] = 'C++';
$string['create'] = 'Kurti';
$string['dsa'] = 'Duomenų struktūros ir algoritmai';
$string['evaluate'] = 'Įvertinti';
$string['generatedsuccessfully'] = 'Moodle viktorina buvo sėkmingai sugeneruota';
$string['generatequiz'] = 'Generuoti viktoriną';
$string['importfailed'] = 'Nepavyko importuoti klausimų, galimai dėl neteisingos XML struktūros. Prašome pabandyti dar kartą. ';
$string['java'] = 'Java';
$string['numberofquestions'] = 'Klausimų skaičius';
$string['numofquestrestriction'] = 'Šis laukas leidžia įvesti nuo 1 iki 50 klausimų';
$string['prompt'] = 'Sukurk viktoriną iš dalyko {$a->subject}. Tema: {$a->topic}. Klausimų skaičius: {$a->count}. Blumo taksonomijos lygis: {$a->level}. Formatas: JSON. Tavo išvestis turi atitikti tokią struktūrą:
{
	"questions": [
		{
			"name": "Funkcijos grąžinamos reikšmės tipas",
			"questiontext": "Pagal nutylėjimą kokio duomenų tipo reikšmę grąžina funkcija",
			"questiontype": "multichoice",
			"code": "",
			"answers": [
				{
					"text": "int",
					"fraction": 100
				},
				{
					"text": "void",
					"fraction": 0
				},
				{
					"text": "bool",
					"fraction": 0
				},
				{
					"text": "Pagal nutylėjimą funkcijos C programavimo kalboje nieko negrąžina",
					"fraction": 0
				}
			]
		},
		{
			"name": "Didžiausio elemento masyve radimas",
			"questiontext": "Parašykite funkciją kuri randa didžiausio elemento indeksą sveikųjų skaičių masyve. Pavyzdys:",
			"questiontype": "essay",
			"code": "int arr[] = {-5, 10, 3, 10, 2};\\n int idx = max(arr, 5);\\n // Result: idx = 1",
			"answers": []
		},
		{
			"name": "Parametrų perdavimas pagal reikšmę",
			"questiontext": "Išanalizuokite žemiau pateiktus kodo fragmentus ir nurodykite programos išvestį",
			"questiontype": "shortanswer",
			"code": "#include <stdio.h>\\n void swap(int a, int b) {\\n int t = a; a = b; b = t;\\n}\\n int main(void) {\\n int x = 3, y = 7;\\n swap(x, y);\\n printf(\"%d %d\\n\", x, y);\\n return 0;\\n}",
			"answers": [
				{
					"text": "3 7",
					"fraction": 100
				}
			]
		}
	]
}';
$string['quizgenerator'] = 'Viktorinų generatorius';
$string['quizsubject'] = 'Studijų dalykas';
$string['quiztopic'] = 'Viktorinos tema';
$string['remember'] = 'Atsiminti';
$string['topic'] = 'Tema';
$string['topicisrequired'] = 'Temos įvedimas yra privalomas';
$string['topiclettersonly'] = 'Įvesti galima tik raides';
$string['understand'] = 'Suprasti';
