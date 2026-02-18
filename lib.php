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

/**
 * Extend course navigation to add AI Quiz Generator link.
 *
 * @param navigation_node $navigation
 * @param stdClass $course
 * @param context_course $context
 */
function local_aiquizgenerator_extend_navigation_course(
    navigation_node $navigation,
    stdClass $course,
    context_course $context
) {

    if (!has_capability('local/aiquizgenerator:generate', $context)) {
        return;
    }

    $url = new moodle_url(
        '/local/aiquizgenerator/index.php',
        ['courseid' => $course->id]
    );

    $navigation->add(
        get_string('pluginname', 'local_aiquizgenerator'),
        $url,
        navigation_node::TYPE_CUSTOM,
        null,
        'local_aiquizgenerator'
    );
}
