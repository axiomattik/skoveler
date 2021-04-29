const { series } = require('gulp');
const run = require('gulp-run');

function feedDB(cb) {
	return run(`
		cd ./db; rm -f novels.db; 
		sqlite3 novels.db < schema.sql; 
		php dummy-data.php;
	`).exec()
}

function defaultTask(cb) {

	cb();
}

exports.feedDB = feedDB;
exports.default = defaultTask;
