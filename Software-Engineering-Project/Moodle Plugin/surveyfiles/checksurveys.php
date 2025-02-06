<?php
require('../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once('./Functional PHP Files/NopDBCalls.php');

$path = optional_param('path', '', PARAM_PATH);
$pageparams = array();

if ($path) {
    $pageparams['path'] = $path;
}

global $CFG, $USER, $DB, $OUTPUT, $PAGE;

$PAGE->set_url('/blocks/nop/surveyfiles/checksurveys.php');

require_login();

$PAGE->set_pagelayout('base');
$context = context_system::instance();
$PAGE->set_context($context);

$header = "Numa Open Poll Survey System";
$PAGE->set_title(get_string('pluginname', 'block_nop'));
$PAGE->set_heading($header);


echo $OUTPUT->header();

readfile('./HTML Files/CheckSurveyHeader.html');

if (isloggedin() && !isguestuser()) {

    include('./Functional PHP Files/SelectSurveys.php');
    
}

echo $OUTPUT->footer();