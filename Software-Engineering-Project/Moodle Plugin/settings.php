<?php
$settings->add(new admin_setting_heading('block_nop_heading', 
                                          get_string('settings_heading', 'block_nop'),
                                          get_string('settings_content', 'block_nop')));

$settings->add(new admin_setting_configtext('block_nop/Label',
                                             get_string('label', 'block_nop'),
                                             get_string('label_desc', 'block_nop'), '', PARAM_TEXT));
