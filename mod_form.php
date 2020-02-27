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

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}
 
require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/evaluationforum/lib.php');
 
class mod_evaluationforum_mod_form extends moodleform_mod {
 
    function definition() {
        global $CFG, $DB, $OUTPUT;
 
        $mform =& $this->_form;
        
        // ----------------------------Activity name and description ------------------------------------//
        $mform->addElement('text', 'name', get_string('activityname', 'evaluationforum'), array('size'=>'64'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
 
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        
        $this->standard_intro_elements(get_string('forumintro', 'evaluationforum')); //Review this line again

        
        //----------------Availability ----------------------------------------------------//

        $mform->addElement('header', 'availability', get_string('availability', 'forum'));

        $name = get_string('duedate', 'forum');
        $mform->addElement('date_time_selector', 'duedate', $name, array('optional' => true));
        $mform->addHelpButton('duedate', 'duedate', 'forum');

        $name = get_string('cutoffdate', 'forum');
        $mform->addElement('date_time_selector', 'cutoffdate', $name, array('optional' => true));
        $mform->addHelpButton('cutoffdate', 'cutoffdate', 'forum');

        // Attachments and word count.
        $mform->addElement('header', 'attachmentswordcounthdr', get_string('attachmentswordcount', 'forum'));

        $choices = get_max_upload_sizes($CFG->maxbytes, $COURSE->maxbytes, 0, $CFG->forum_maxbytes);
        $choices[1] = get_string('uploadnotallowed');
        $mform->addElement('select', 'maxbytes', get_string('maxattachmentsize', 'forum'), $choices);
        $mform->addHelpButton('maxbytes', 'maxattachmentsize', 'forum');
        $mform->setDefault('maxbytes', $CFG->forum_maxbytes);

        $choices = array(
            0 => 0,
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
            20 => 20,
            50 => 50,
            100 => 100
        );
        $mform->addElement('select', 'maxattachments', get_string('maxattachments', 'forum'), $choices);
        $mform->addHelpButton('maxattachments', 'maxattachments', 'forum');
        $mform->setDefault('maxattachments', $CFG->forum_maxattachments);

        $mform->addElement('selectyesno', 'displaywordcount', get_string('displaywordcount', 'forum'));
        $mform->addHelpButton('displaywordcount', 'displaywordcount', 'forum');
        $mform->setDefault('displaywordcount', 0);
        
        
    
        $this->standard_coursemodule_elements();
 
        $this->add_action_buttons();
    }
}