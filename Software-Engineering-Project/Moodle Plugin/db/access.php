<?php

defined('MOODLE_INTERNAL') || die;

$capabilities = array(

    // This allows a user to add the slack block.

    'block/nop:addinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'guest' => CAP_ALLOW,       
            'user' => CAP_ALLOW,        
            'student' => CAP_ALLOW,     
            'teacher' => CAP_ALLOW,     
            'editingteacher' => CAP_ALLOW,// Allow Editingteacher user.
            'coursecreator' => CAP_ALLOW, // Allow Coursecreator user.
            'manager' => CAP_ALLOW        // Allow Manager user.
        ),
        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    ),

    // This allows a user to add slack block to their dashboard (My Moodle Page).

    'block/nop:myaddinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'guest' => CAP_ALLOW,       
            'user' => CAP_ALLOW,        
            'student' => CAP_ALLOW,     
            'teacher' => CAP_ALLOW,     
            'editingteacher' => CAP_ALLOW,// Allow Editingteacher user.
            'coursecreator' => CAP_ALLOW, // Allow Coursecreator user.
            'manager' => CAP_ALLOW        // Allow Manager user.
        ),
        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    )
);
