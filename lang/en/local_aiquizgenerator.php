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

$string['aigenerationerror'] = 'Quiz generation failed. This might be due to:
<ul>
    <li>The AI provider or "Generate text" action is disabled.</li>
    <li>Invalid AI API key or incorrect endpoint configuration.</li>
    <li>API quota limits reached.</li>
</ul>
Detailed error: {$a}';
$string['aiquizgenerator'] = 'AI Quiz Generator';
$string['analyze'] = 'Analyze';
$string['apply'] = 'Apply';
$string['c'] = 'C';
$string['category'] = 'Category';
$string['cognitivedifficulty'] = 'Cognitive Difficulty';
$string['comparch'] = 'Computer Architecture';
$string['cpp'] = 'C++';
$string['create'] = 'Create';
$string['dsa'] = 'Data Structures and Algorithms';
$string['evaluate'] = 'Evaluate';
$string['examplesprefix'] = 'Example:';
$string['generatedsuccessfully'] = 'Moodle quiz was generated successfully';
$string['generatequiz'] = 'Generate Quiz';
$string['importfailed'] = 'Quiz importing failed supposedly due to invalid XML structure. Please try again.';
$string['invalidjsonresponse'] = 'The model generated an invalid JSON. Please try again.';
$string['java'] = 'Java';
$string['numberofquestions'] = 'Number Of Questions';
$string['numofquestrestriction'] = 'This field allows numbers from 1 to 50';
$string['prompt'] = 'Create a quiz about {$a->subject}. Topic: {$a->topic}. Number of questions: {$a->count}. Bloom taxonomy level: {$a->level}. Format: JSON. Generated questions should be of similar complexity and structure to provided in example.';
$string['quizgenerator'] = 'Quiz Generator';
$string['quizsubject'] = 'Quiz Subject';
$string['quiztopic'] = 'Quiz Topic';
$string['remember'] = 'Remember';
$string['topic'] = 'Topic';
$string['topicisnotvalid'] = 'Topic can consist of letters and invisible characters only. The topic also cannot be default';
$string['topicisrequired'] = 'Topic is required';
$string['understand'] = 'Understand';
