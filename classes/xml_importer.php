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
namespace local_aiquizgenerator;

/**
 * Class responsible for importing XML content into question bank
 */
class xml_importer {
    /**
     * Imports XML content into a question bank.
     *
     * @param string $xmlcontent Cleaned up xml content.
     * @param int $courseid Course ID.
     * @param mixed $categoryid Category Id (can be int or string).
     * @throws \moodle_exception
     */
    public function import_to_question_bank(string $xmlcontent, int $courseid, $categoryid = 0): void {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/question/format/xml/format.php');
        require_once($CFG->libdir . '/questionlib.php');

        if ($categoryid === 0) {
            $contexts = new \core_question\local\bank\question_edit_contexts(\context_course::instance($courseid));
            $category = question_get_default_category($contexts->lowest()->id);
            $categoryid = $category->id;
        }

        $filename = tempnam($CFG->tempdir, 'ai_import');
        file_put_contents($filename, $xmlcontent);

        try {
            $qformat = new \qformat_xml();
            $qformat->setCategory($DB->get_record('question_categories', ['id' => $categoryid]));
            $qformat->setCourse($DB->get_record('course', ['id' => $courseid]));
            $qformat->setFilename($filename);
            ob_start();
            $status = $qformat->importprocess();
            ob_end_clean();
        } finally {
            if (file_exists($filename)) {
                unlink($filename);
            }
        }

        if (!$status) {
            throw new \moodle_exception('importfailed', 'local_aiquizgenerator');
        }
    }
}
