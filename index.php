<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$city = $_GET['c1-t'];

if(!isset($city) || $city==NULL)
	$city='London,uk';
$url = 'http://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid=808268433b2e03a5e15354526a3e7712';
$r = file_get_contents($url);
$j = json_decode($r);

$context = Timber::get_context();
$context['posts'] = new Timber\PostQuery();
$context['foo'] = "bar";

$context['city'] = $city;
$context['main'] = $j->weather[0]->main;
$context['description'] = $j->weather[0]->description;
$context['temperature'] = $j->main->temp." °F";


$templates = array( 'index.twig' );
if ( is_home() ) {
	array_unshift( $templates, 'home.twig' );
}
Timber::render( $templates, $context );
