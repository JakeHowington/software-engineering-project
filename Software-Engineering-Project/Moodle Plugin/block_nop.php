<?php

class block_nop extends block_base {
    
    function init() {

        global $CFG;
        $this->title = get_string('nop', 'block_nop');
    }

    function has_config() {
        return true;
    }

    public function get_content() {
     
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text   .= html_writer::link(new moodle_url('/blocks/nop/surveyfiles/checksurveys.php'), get_string('blocklink', 'block_nop'));
        $this->content->footer = '';
        return $this->content;
    }

    public function instance_allow_multiple() {
        return true;
    }
}

