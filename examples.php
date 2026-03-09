<?php
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
    $topic = clean_param($data->topic, PARAM_FILE);
    $filepath = "/{$lang}/{$subject}/{$topic}/";

    $draftfiles = $fs->get_area_files($usercontext->id, 'user', 'draft', $draftitemid, 'id', false);

    if (empty($draftfiles)) {
        \core\notification::error(get_string('nofileuploaded', 'local_aiquizgenerator'));
    } else {
        $allowed_names = ['lvl1.json', 'lvl2.json', 'lvl3.json', 'lvl4.json', 'lvl5.json', 'lvl6.json'];

        foreach ($draftfiles as $draftfile) {
            $filename = $draftfile->get_filename();
            if (!in_array($filename, $allowed_names)) {
                continue;
            }

            $existing = $fs->get_file($context->id, 'local_aiquizgenerator', 'examples', 0, $filepath, $filename);
            if ($existing) {
                $existing->delete();
            }

            $file_record = [
                'contextid' => $context->id,
                'component' => 'local_aiquizgenerator',
                'filearea'  => 'examples',
                'itemid'    => 0,
                'filepath'  => $filepath,
                'filename'  => $filename,
            ];
            $fs->create_file_from_storedfile($file_record, $draftfile);
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

$flat_data = [];
$languages = [];
$subjects_list = [];

foreach ($files as $file) {
    $fp = trim($file->get_filepath(), '/');
    $parts = explode('/', $fp);
    if (count($parts) < 3) continue;

    $l = $parts[0];
    $s = $parts[1];
    $t = $parts[2];
    $lvl = preg_replace('/\.json$/i', '', $file->get_filename());

    $languages[$l] = $l;
    $subjects_list[$s] = $s;

    if (!empty($langfilter) && $l !== $langfilter) continue;
    if (!empty($subjectfilter) && $s !== $subjectfilter) continue;

    $key = "$l|$s|$t";
    if (!isset($flat_data[$key])) {
        $flat_data[$key] = [
            'lang' => $l,
            'subject' => $s,
            'topic' => $t,
            'levels' => []
        ];
    }
    $flat_data[$key]['levels'][$lvl] = $file;
}

$filterurl = new moodle_url('/local/aiquizgenerator/examples.php', ['courseid' => $courseid]);
echo html_writer::start_tag('div', ['class' => 'box p-3 mb-3 bg-light']);
echo html_writer::start_tag('form', ['method' => 'get', 'action' => $filterurl, 'class' => 'form-inline']);
echo html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'courseid', 'value' => $courseid]);

echo html_writer::tag('label', get_string('language', 'local_aiquizgenerator') . ': ', ['class' => 'mr-2']);
echo html_writer::select(['' => get_string('all')] + $languages, 'langfilter', $langfilter, false, ['class' => 'form-control mr-3']);

echo html_writer::tag('label', get_string('quizsubject', 'local_aiquizgenerator') . ': ', ['class' => 'mr-2']);
echo html_writer::select(['' => get_string('all')] + $subjects_list, 'subjectfilter', $subjectfilter, false, ['class' => 'form-control mr-3']);

echo html_writer::empty_tag('input', ['type' => 'submit', 'value' => get_string('filter'), 'class' => 'btn btn-primary']);
echo html_writer::end_tag('form');
echo html_writer::end_tag('div');

$table = new flexible_table('local_aiquiz_examples');
$table->define_baseurl($PAGE->url);
$columns = ['lang', 'subject', 'topic', 'lvl1', 'lvl2', 'lvl3', 'lvl4', 'lvl5', 'lvl6', 'actions'];
$headers = [
    get_string('language', 'local_aiquizgenerator'),
    get_string('quizsubject', 'local_aiquizgenerator'),
    get_string('topic', 'local_aiquizgenerator'),
    'Lvl 1', 'Lvl 2', 'Lvl 3', 'Lvl 4', 'Lvl 5', 'Lvl 6',
    get_string('actions', 'local_aiquizgenerator')
];

$table->define_columns($columns);
$table->define_headers($headers);

$table->sortable(true, 'topic', SORT_ASC);
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
    usort($flat_data, function($a, $b) use ($sortcolumns) {
        foreach ($sortcolumns as $column => $order) {
            $res = strnatcasecmp($a[$column], $b[$column]);
            if ($res !== 0) {
                return ($order === SORT_DESC) ? -$res : $res;
            }
        }
        return 0;
    });
}

foreach ($flat_data as $row_data) {
    $row = [
        s($row_data['lang']),
        s($row_data['subject']),
        s($row_data['topic'])
    ];

    for ($i = 1; $i <= 6; $i++) {
        $lvl_key = 'lvl' . $i;
        if (isset($row_data['levels'][$lvl_key])) {
            $file = $row_data['levels'][$lvl_key];
            
            $viewurl = new moodle_url('/local/aiquizgenerator/view_example.php', [
                'courseid' => $courseid, 'filepath' => $file->get_filepath(), 'filename' => $file->get_filename()
            ]);
            $deleteurl = new moodle_url('/local/aiquizgenerator/delete_example.php', [
                'courseid' => $courseid, 'filepath' => $file->get_filepath(), 'filename' => $file->get_filename(), 'sesskey' => sesskey()
            ]);

            $links = html_writer::link($viewurl, get_string('view')) . '  ' .
                     html_writer::link($deleteurl, get_string('delete'), [
                         'class' => 'text-danger',
                         'onclick' => "return confirm('".get_string('confirm_delete_file', 'local_aiquizgenerator')."');"
                     ]);
            $row[] = html_writer::tag('small', $links);
        } else {
            $row[] = html_writer::tag('span', '-', ['class' => 'text-muted']);
        }
    }

    $deleteallurl = new moodle_url('/local/aiquizgenerator/delete_all_examples.php', [
        'courseid' => $courseid, 'lang' => $row_data['lang'], 'subject' => $row_data['subject'], 'topic' => $row_data['topic'], 'sesskey' => sesskey()
    ]);
    $row[] = html_writer::link($deleteallurl, get_string('delete_all', 'local_aiquizgenerator'), [
        'class' => 'btn btn-outline-danger btn-sm',
        'onclick' => "return confirm('".get_string('confirm_delete_all', 'local_aiquizgenerator')."');"
    ]);

    $table->add_data($row);
}

$table->finish_output();
echo $OUTPUT->footer();