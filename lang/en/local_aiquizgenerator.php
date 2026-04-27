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

$string['actions'] = 'Actions';
$string['aigenerationerror'] = 'Quiz generation failed. This might be due to:
<ul>
    <li>The AI provider or "Generate text" action is disabled.</li>
    <li>Invalid AI API key or incorrect endpoint configuration.</li>
    <li>API quota limits reached.</li>
</ul>
Detailed error: {$a}';
$string['aiquizgenerator'] = 'AI Quiz Generator';
$string['aiquizgenerator:generate'] = 'Generate a Quiz';
$string['analyze'] = 'Analyze';
$string['apply'] = 'Apply';
$string['c'] = 'C';
$string['category'] = 'Category';
$string['choosejson'] = 'Choose JSON file';
$string['cognitivedifficulty'] = 'Cognitive Difficulty';
$string['comparch'] = 'Computer Architecture';
$string['confirm_delete_all'] = 'Are you sure you want to delete all levels of examples that are under this name?';
$string['confirm_delete_file'] = 'Are you sure you want to delete this example file?';
$string['cpp'] = 'C++';
$string['create'] = 'Create';
$string['delete'] = 'Delete';
$string['delete_all'] = 'Delete all';
$string['dsa'] = 'Data Structures and Algorithms';
$string['evaluate'] = 'Evaluate';
$string['examples_deleted_all'] = 'All examples were deleted sucessfully';
$string['examplesaved'] = 'Examples are saved sucessfully.';
$string['examplesfiles'] = 'Example JSON files';
$string['examplesname'] = 'Name';
$string['examplesnameinvalid'] = 'Name is invalid. It cannot begin from invisible characters';
$string['examplesnamerequired'] = 'Name is required';
$string['examplesnotfound'] = 'Custom examples were not found.<br>Default examples were used instead.';
$string['examplesprefix'] = 'Example:';
$string['filedeleted'] = 'File was deleted sucessfully';
$string['generatedsuccessfully'] = 'Moodle quiz was generated successfully';
$string['generatequiz'] = 'Generate Quiz';
$string['importfailed'] = 'Quiz importing failed supposedly due to invalid XML structure. Please try again.';
$string['invalidfilename'] = 'Invalid filename. Allowed names are: [lvl1, lvl2, lvl3, lvl4, lvl5, lvl6]';
$string['invalidjsonresponse'] = 'Unable to convert JSON to XML due to invalid structure. Please try again.';
$string['invalidjsonstructure'] = 'JSON file structure is wrong.';
$string['invalidjsonuploaded'] = 'Uploaded file does not contain valid JSON.';
$string['java'] = 'Java';
$string['jsonexamples'] = 'JSON Examples';
$string['language'] = 'Language';
$string['manageexamples'] = 'Manage Examples';
$string['nodefaultcategory'] = 'No default category found. Perhaps you have not created it yet. Please ensure at least one category exists';
$string['nofileuploaded'] = 'No file uploaded';
$string['nomodulecontext'] = 'No module context found. Perhaps you have not created a question bank yet. Please ensure that at least one question bank is created';
$string['nouploadedexamples'] = 'No uploaded example files found.';
$string['numberofquestions'] = 'Number Of Questions';
$string['numofquestrequired'] = 'Number of questions is required';
$string['numofquestrestriction'] = 'This field allows numbers from 1 to 30';
$string['pluginname'] = 'AI Quiz Generator';
$string['prompt'] = 'You are an educology expert. Create a quiz about {$a->subject}. Topic: {$a->topic}. Number of questions: {$a->count}. Bloom taxonomy level: {$a->level}. Format: JSON. Make sure that the answers to the questions or code have plausible distractors. Generated questions should be of similar complexity and structure to provided ones in the example.';
$string['questionbank'] = 'Question Bank';
$string['quizgenerator'] = 'Quiz Generator';
$string['quizsubject'] = 'Quiz Subject';
$string['quiztopic'] = 'Quiz Topic';
$string['remember'] = 'Remember';
$string['savechanges'] = 'Save';
$string['topic'] = 'Topic';
$string['topicisnotvalid'] = 'Topic can consist of letters, digits and invisible characters only. Topic cannot begin with invisible characters';
$string['topicisrequired'] = 'Topic is required';
$string['topicplaceholder'] = 'Pointers';
$string['understand'] = 'Understand';
$string['uploadedexamples'] = 'Uploaded examples';
$string['view'] = 'View';
