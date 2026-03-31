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
 * JSON uploader form class.
 */
class examples_upload extends \moodleform {
    /**
     * Defining form structure
     */
    public function definition() {
        $mform = $this->_form;

        $options = ['en' => 'en', 'lt' => 'lt'];
        $mform->addElement('select', 'lang', get_string('language', 'local_aiquizgenerator'), $options);
        $mform->setDefault('lang', 'en');

        $subjects = [
            'C' => get_string('c', 'local_aiquizgenerator'),
            'C++' => get_string('cpp', 'local_aiquizgenerator'),
            'Java' => get_string('java', 'local_aiquizgenerator'),
            'Data structures and algorithms' => get_string('dsa', 'local_aiquizgenerator'),
            'Computer architecture' => get_string('comparch', 'local_aiquizgenerator'),
        ];
        $mform->addElement('select', 'subject', get_string('quizsubject', 'local_aiquizgenerator'), $subjects);

        $mform->addElement('text', 'examplesname', get_string('examplesname', 'local_aiquizgenerator'), ['size' => 50]);
        $mform->setType('examplesname', PARAM_TEXT);
        $mform->addRule('examplesname', get_string('examplesnamerequired', 'local_aiquizgenerator'), 'required', null, 'client');
        $mform->addRule(
            'examplesname',
            get_string('examplesnameinvalid', 'local_aiquizgenerator'),
            'regex',
            '/^(?!^default$)[\p{L}0-9]+([\s\p{L}0-9]+)?$/u',
            'client'
        );

        $fileoptions = [
            'subdirs' => 0,
            'maxbytes' => 0,
            'maxfiles' => 6,
            'accepted_types' => ['.json'],
        ];
        $mform->setType('examplesname', PARAM_TEXT);

        $mform->addElement(
            'filemanager',
            'examplesfiles',
            get_string('examplesfiles', 'local_aiquizgenerator'),
            null,
            $fileoptions
        );

        $mform->addRule('examplesfiles', get_string('required'), 'required', null, 'client');

        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons(true, get_string('savechanges'));
    }
}
