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
define([], function() {
    return {
        /**
         * Initialize the dynamic select logic.
         *
         * @param {Object} allTopics The JSON object containing subjects and their topics.
         */
        init: function(allTopics) {
            const subjectSelect = document.getElementById('id_subject');
            const topicSelect = document.getElementById('id_jsonexamples');

            /**
             * Populates the topic dropdown based on the selected subject.
             *
             * @param {string} subject
             */
            const populateTopics = (subject) => {
                const topics = allTopics[subject] || ['default'];

                topicSelect.innerHTML = '';

                topics.forEach(t => {
                    const option = new Option(t, t);
                    topicSelect.add(option);
                });

                topicSelect.value = 'default';

                topicSelect.dispatchEvent(new Event('change', { bubbles: true }));
            };

            if (subjectSelect && topicSelect) {
                populateTopics(subjectSelect.value);

                subjectSelect.addEventListener('change', (e) => {
                    populateTopics(e.target.value);
                });
            }
        }
    };
});