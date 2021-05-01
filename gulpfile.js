const { series, parallel } = require('gulp');
const run = require('gulp-run');

const bs = require('browser-sync').create();

function feedDB(cb) {
	return run(`
		cd ./db; rm -f novels.db; 
		sqlite3 novels.db < schema.sql; 
		php dummy-data.php;
	`).exec()
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

exports.default = exports.serve;
