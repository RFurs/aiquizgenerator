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

require(__DIR__ . '/../../config.php');

$courseid = required_param('courseid', PARAM_INT);

$course = get_course($courseid);

require_login($course);

$context = context_course::instance($courseid);
require_capability('local/aiquizgenerator:generate', $context);

global $SESSION;
$sessionkey = 'aiquiz_form_data_' . $courseid;

$PAGE->set_url(new moodle_url('/local/aiquizgenerator/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('quizgenerator', 'local_aiquizgenerator'));
$PAGE->set_heading($course->fullname);

$mform = new \local_aiquizgenerator\form\edit(null, ['courseid' => $courseid]);

if (isset($SESSION->$sessionkey)) {
    $mform->set_data($SESSION->$sessionkey);
} else {
    $mform->set_data(['courseid' => $courseid]);
}

if ($mform->is_cancelled()) {
    unset($SESSION->$sessionkey);
    redirect(new moodle_url('/course/view.php', ['id' => $courseid]));
}

$quizcontent = null;

if ($data = $mform->get_data()) {
    try {
        $SESSION->$sessionkey = $data;

        $generator = new \local_aiquizgenerator\generator();
        $formatconverter = new \local_aiquizgenerator\format_converter();
        $importer = new \local_aiquizgenerator\xml_importer();

        $result = $generator->generate_quiz($data, $context->id);
        $jsoncontent = $result['content'];
        $examplesnotfound = $result['examplesnotfound'];

        $xmlcontent = $formatconverter->convert_json_to_xml($jsoncontent);
        $importer->import_to_question_bank($xmlcontent, $courseid, $data->category);

        $message = get_string('generatedsuccessfully', 'local_aiquizgenerator');

        if ($examplesnotfound) {
            \core\notification::add(
                get_string('examplesnotfound', 'local_aiquizgenerator'),
                \core\output\notification::NOTIFY_INFO,
            );
        }
        $selfurl = new moodle_url('/local/aiquizgenerator/index.php', ['courseid' => $courseid]);
        redirect($selfurl, $message, null, \core\output\notification::NOTIFY_SUCCESS);
    } catch (\Exception $e) {
        \core\notification::error($e->getMessage());
    }
}
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
