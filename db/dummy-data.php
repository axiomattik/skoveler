<?php

if ( php_sapi_name() != "cli" ) {
	echo "this is a utility intended to be executed from the command line\n";
	die;
}


require_once 'database.php';
require_once '../vendor/autoload.php';


$USER_COUNT = 3;
$NOVEL_COUNT = 10;
$CHAPTER_COUNT = 100;


$db = new NovelsDB();
$faker = Faker\Factory::create();


for ( $i = 0; $i < $USER_COUNT; $i++ ) {
	$db->add_user( 
		$faker->name(),		// name
		$faker->email(),	// email 
		$faker->uuid()		// passhash
	);
}


for ( $i = 0; $i < $NOVEL_COUNT; $i++ ) {
	$db->add_novel( 
		$faker->numberBetween(1, $USER_COUNT),	// userid
		$faker->sentence(4),										// title
		$faker->name(),													// author
		$faker->numberBetween(0, 1),						// is_public
	);
}


for ( $i = 0; $i < $CHAPTER_COUNT; $i++ ) {
	$db->add_chapter( 
		$faker->numberBetween(1, $NOVEL_COUNT), // novelid
		$faker->numberBetween(1, 30),						// numeral
		$faker->sentence(4),										// title
		$faker->iso8601(),											// time
		$faker->sentence(4),										// setting
		$faker->sentence(12),										// precis
		$faker->paragraph(8),										// synopsis
		$faker->paragraph(4),										// notes
		$faker->hexColor(),											// color
	);
}

