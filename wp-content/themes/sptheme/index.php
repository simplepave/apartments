<?php

/**
 * Index page
 */

echo 'Index page';
echo '<br>';
var_dump('Front page', is_front_page());
echo '<br>';
var_dump('Home page', is_home());
echo '<br>';
echo '<pre>';
var_dump(get_post());