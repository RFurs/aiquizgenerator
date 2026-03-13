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

require('../../config.php');

use local_aiquizgenerator\form\examples_upload;

require_once($CFG->libdir . '/tablelib.php');

$courseid = required_param('courseid', PARAM_INT);
$course = get_course($courseid);
require_login($course);
$context = context_course::instance($courseid);
require_capability('moodle/course:manageactivities', $context);

$PAGE->set_url(new moodle_url('/local/aiquizgenerator/examples.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_title(get_string('manageexamples', 'local_aiquizgenerator'));
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');

$mform = new examples_upload(null, ['courseid' => $courseid]);
$mform->set_data(['courseid' => $courseid]);

$langfilter = optional_param('langfilter', '', PARAM_ALPHA);
$subjectfilter = optional_param('subjectfilter', '', PARAM_TEXT);

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/local/aiquizgenerator/index.php', ['courseid' => $courseid]));
}

if ($data = $mform->get_data()) {
    $draftitemid = $data->examplesfiles;
    $fs = get_file_storage();
    $usercontext = context_user::instance($USER->id);

    $lang = $data->lang;
    $subject = $data->subject;
    $examplesname = clean_param($data->examplesname, PARAM_FILE);
    $filepath = "/{$lang}/{$subject}/{$examplesname}/";

    $draftfiles = $fs->get_area_files($usercontext->id, 'user', 'draft', $draftitemid, 'id', false);

    if (empty($draftfiles)) {
        \core\notification::error(get_string('nofileuploaded', 'local_aiquizgenerator'));
    } else {
        $allowednames = ['lvl1.json', 'lvl2.json', 'lvl3.json', 'lvl4.json', 'lvl5.json', 'lvl6.json'];

        foreach ($draftfiles as $draftfile) {
            $filename = $draftfile->get_filename();
            if (!in_array($filename, $allowednames)) {
                \core\notification::error(get_string('invalidfilename', 'local_aiquizgenerator'));
                redirect(new moodle_url('/local/aiquizgenerator/examples.php', ['courseid' => $courseid]));
            }

            $existing = $fs->get_file($context->id, 'local_aiquizgenerator', 'examples', 0, $filepath, $filename);
            if ($existing) {
                $existing->delete();
            }

            $filerecord = [
                'contextid' => $context->id,
                'component' => 'local_aiquizgenerator',
                'filearea'  => 'examples',
                'itemid'    => 0,
                'filepath'  => $filepath,
                'filename'  => $filename,
            ];
            $fs->create_file_from_storedfile($filerecord, $draftfile);
        }
        \core\notification::success(get_string('examplesaved', 'local_aiquizgenerator'));
        redirect(new moodle_url('/local/aiquizgenerator/examples.php', ['courseid' => $courseid]));
    }
}

echo $OUTPUT->header();
$mform->display();

echo html_writer::tag('h3', get_string('uploadedexamples', 'local_aiquizgenerator'), ['class' => 'mt-4']);

$fs = get_file_storage();
$files = $fs->get_area_files($context->id, 'local_aiquizgenerator', 'examples', 0, 'filepath, filename', false);

$flatdata = [];
$languages = [];
$subjectslist = [];

foreach ($files as $file) {
    $fp = trim($file->get_filepath(), '/');
    $parts = explode('/', $fp);
    if (count($parts) < 3) {
        continue;
    }

    $l = $parts[0];
    $s = $parts[1];
    $t = $parts[2];
    $lvl = preg_replace('/\.json$/i', '', $file->get_filename());

    $languages[$l] = $l;
    $subjectslist[$s] = $s;

    if (!empty($langfilter) && $l !== $langfilter) {
        continue;
    }
    if (!empty($subjectfilter) && $s !== $subjectfilter) {
        continue;
    }

    $key = "$l|$s|$t";
    if (!isset($flatdata[$key])) {
        $flatdata[$key] = [
            'lang' => $l,
            'subject' => $s,
            'examplesname' => $t,
            'levels' => [],
        ];
    }
    $flatdata[$key]['levels'][$lvl] = $file;
}

$filterurl = new moodle_url(
    '/local/aiquizgenerator/examples.php',
    ['courseid' => $courseid]
);

echo html_writer::start_tag(
    'div',
    ['class' => 'box p-3 mb-3 bg-light']
);

echo html_writer::start_tag(
    'form',
    ['method' => 'get', 'action' => $filterurl, 'class' => 'form-inline']
);

echo html_writer::empty_tag(
    'input',
    ['type' => 'hidden', 'name' => 'courseid', 'value' => $courseid]
);

echo html_writer::tag(
    'label',
    get_string('language', 'local_aiquizgenerator') . ': ',
    ['class' => 'mr-2']
);

echo html_writer::select(
    ['' => get_string('all')] + $languages,
    'langfilter',
    $langfilter,
    false,
    ['class' => 'form-control mr-3']
);

echo html_writer::tag(
    'label',
    get_string('quizsubject', 'local_aiquizgenerator') . ': ',
    ['class' => 'mr-2']
);

echo html_writer::select(
    ['' => get_string('all')] + $subjectslist,
    'subjectfilter',
    $subjectfilter,
    false,
    ['class' => 'form-control mr-3']
);

echo html_writer::empty_tag(
    'input',
    ['type' => 'submit', 'value' => get_string('filter'), 'class' => 'btn btn-primary']
);

echo html_writer::end_tag('form');
echo html_writer::end_tag('div');

$table = new flexible_table('local_aiquiz_examples');
$table->define_baseurl($PAGE->url);
$columns = ['lang', 'subject', 'examplesname', 'lvl1', 'lvl2', 'lvl3', 'lvl4', 'lvl5', 'lvl6', 'actions'];
$headers = [
    get_string('language', 'local_aiquizgenerator'),
    get_string('quizsubject', 'local_aiquizgenerator'),
    get_string('examplesname', 'local_aiquizgenerator'),
    'Lvl 1', 'Lvl 2', 'Lvl 3', 'Lvl 4', 'Lvl 5', 'Lvl 6',
    get_string('actions', 'local_aiquizgenerator'),
];

$table->define_columns($columns);
$table->define_headers($headers);

$table->sortable(true, 'examplesname', SORT_ASC);
$table->no_sorting('lvl1');
$table->no_sorting('lvl2');
$table->no_sorting('lvl3');
$table->no_sorting('lvl4');
$table->no_sorting('lvl5');
$table->no_sorting('lvl6');
$table->no_sorting('actions');

$table->setup();

$sortcolumns = $table->get_sort_columns();
if (!empty($sortcolumns)) {
    usort($flatdata, function ($a, $b) use ($sortcolumns) {
        foreach ($sortcolumns as $column => $order) {
            $res = strnatcasecmp($a[$column], $b[$column]);
            if ($res !== 0) {
                return ($order === SORT_DESC) ? -$res : $res;
            }
        }
        return 0;
    });
}

foreach ($flatdata as $rowdata) {
    $row = [
        s($rowdata['lang']),
        s($rowdata['subject']),
        s($rowdata['examplesname']),
    ];

    for ($i = 1; $i <= 6; $i++) {
        $lvlkey = 'lvl' . $i;
        if (isset($rowdata['levels'][$lvlkey])) {
            $file = $rowdata['levels'][$lvlkey];

            $viewurl = new moodle_url('/local/aiquizgenerator/view_example.php', [
                'courseid' => $courseid, 'filepath' => $file->get_filepath(), 'filename' => $file->get_filename(),
            ]);
            $deleteurl = new moodle_url(
                '/local/aiquizgenerator/delete_example.php',
                ['courseid' => $courseid,
                 'filepath' => $file->get_filepath(),
                 'filename' => $file->get_filename(),
                 'sesskey' => sesskey(), ]
            );

            $links = html_writer::link($viewurl, get_string('view', 'local_aiquizgenerator')) . '  ' .
                     html_writer::link($deleteurl, get_string('delete'), [
                         'class' => 'text-danger',
                         'onclick' => "return confirm('" . get_string('confirm_delete_file', 'local_aiquizgenerator') . "');",
                     ]);
            $row[] = html_writer::tag('small', $links);
        } else {
            $row[] = html_writer::tag('span', '-', ['class' => 'text-muted']);
        }
    }

    $deleteallurl = new moodle_url(
        '/local/aiquizgenerator/delete_all_examples.php',
        ['courseid' => $courseid,
        'lang' => $rowdata['lang'],
        'subject' => $rowdata['subject'],
        'examplesname' => $rowdata['examplesname'],
        'sesskey' => sesskey(), ]
    );
    $row[] = html_writer::link($deleteallurl, get_string('delete_all', 'local_aiquizgenerator'), [
        'class' => 'btn btn-outline-danger btn-sm',
        'onclick' => "return confirm('" . get_string('confirm_delete_all', 'local_aiquizgenerator') . "');",
    ]);

    $table->add_data($row);
}

$table->finish_output();
echo $OUTPUT->footer();
