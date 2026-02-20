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
namespace local_aiquizgenerator\form;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/formslib.php');

/**
 * Generator form class.
 */
class generator_form extends \moodleform {
    /**
     * Defining form structure
     *
     * @return void
     */
    public function definition() {
        $mform = $this->_form;
        $mform->addElement('header', 'general', get_string('aiquizgenerator', 'local_aiquizgenerator'));
        $subjects = [
            'C' => get_string('c', 'local_aiquizgenerator'),
            'C++' => get_string('cpp', 'local_aiquizgenerator'),
            'Java' => get_string('java', 'local_aiquizgenerator'),
            'Data Structures and Algorithms' => get_string('dsa', 'local_aiquizgenerator'),
            'Computer Architecture' => get_string('comparch', 'local_aiquizgenerator'),
        ];
        $mform->addElement('select', 'subject', get_string('quizsubject', 'local_aiquizgenerator'), $subjects);

        $mform->addElement('text', 'topic', get_string('quiztopic', 'local_aiquizgenerator'), ['size' => '50']);
        $mform->setType('topic', PARAM_TEXT);
        $mform->addRule('topic', get_string('topicisrequired', 'local_aiquizgenerator'), 'required', null, 'client');

        $mform->addElement('text', 'questioncount', get_string('numberofquestions', 'local_aiquizgenerator'));
        $mform->setType('questioncount', PARAM_INT);
        $mform->setDefault('questioncount', 5);
        $mform->addRule(
            'questioncount',
            get_string('numofquestrestriction', 'local_aiquizgenerator'),
            'regex',
            '/^([1-9]|[1-4][0-9]|50)$/',
            'client'
        );

        $bloomlevels = [
            'remember' => get_string('remember', 'local_aiquizgenerator'),
            'understand' => get_string('understand', 'local_aiquizgenerator'),
            'apply' => get_string('apply', 'local_aiquizgenerator'),
            'analyze' => get_string('analyze', 'local_aiquizgenerator'),
            'evaluate' => get_string('evaluate', 'local_aiquizgenerator'),
            'create' => get_string('create', 'local_aiquizgenerator'),
        ];
        $mform->addElement(
            'select',
            'cognitive_difficulty',
            get_string('cognitivedifficulty', 'local_aiquizgenerator'),
            $bloomlevels
        );

        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons(true, get_string('generatequiz', 'local_aiquizgenerator'));
    }
}
