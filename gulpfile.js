const { src, dest, series, parallel, watch } = require('gulp');
const path = require('path');
const concat = require('gulp-concat');
const minify = require('gulp-minify');
const run = require('gulp-run');
const sass = require('gulp-sass');

const bs = require('browser-sync').create();


function feedDB(cb) {
	return run(`
		cd ./db; rm -f novels.db; 
		sqlite3 novels.db < schema.sql; 
		php dummy-data.php;
	`).exec()
}


function compileSCSS() {
	return src(
			'assets/css/style.scss', 
			{ 'allowEmpty': true } 
		).pipe(sass({ outputStyle: 'compressed' })
		.on('error', sass.logError))
		.pipe(dest('assets/css/'));
}


function compilePrintSCSS() {
	return src(
			'assets/css/print.scss', 
			{ 'allowEmpty': true } 
		).pipe(sass({ outputStyle: 'compressed' })
		.on('error', sass.logError))
		.pipe(dest('assets/css/'));
}


function minifyCustomJS() {
	return src(
			'assets/js/custom/**/*.js',
			{ 'allowEmpty': true }
		).pipe(concat('skoveler.js'))
		.pipe(minify())
		.pipe(dest('assets/js/.'));
}


function minifyVendorJS() {
	return src(
			'assets/js/vendor/**/*.js',
			{ 'allowEmpty': true }
		).pipe(concat('vendor.js'))
		.pipe(minify())
		.pipe(dest('assets/js/.'));
}


function watchFiles(cb) {

	cb();
}

function browsersync(cb) {
	bs.init({proxy: 'localhost:8000'});
	cb();
}

exports.feedDB = feedDB;

exports.watch = watchFiles;

exports.serve = parallel(exports.watch, browsersync);

exports.css = series(compileSCSS, compilePrintSCSS);

exports.js = series(minifyCustomJS, minifyVendorJS);


exports.default = series(
	exports.css,
	exports.js,
	exports.serve
);
