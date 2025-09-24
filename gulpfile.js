const concat = require('gulp-concat');
const deleteFile = require('del');
const fs = require('fs');
const gulp = require('gulp');
const minifyCss = require('gulp-minify-css');
const order = require('gulp-order');
const uglify = require('gulp-uglify');

const uniqid = () => (new Date().getTime()).toString(16);
const deletePreviousCompiledFile = path => {
	fs.readdirSync(path).forEach(filename => {
		if(filename.includes('all')) deleteFile([path + '/' + filename, path + '/' + filename + '.map']);
	});
};

gulp.task('default', ['deletePreviousCompiledFiles', 'styles', 'scripts', 'copy']);
gulp.task('watch', ['default'], function(){
	gulp.watch([
		'resources/assets/site/css/**/*',
		'resources/assets/site/js/**/*', 
		'resources/assets/site/fonts/**/*',
		'resources/assets/site/img/**/*',
		'resources/assets/admin/css/**/*',
		'resources/assets/admin/js/**/*', 
		'resources/assets/admin/fonts/**/*',
		'resources/assets/admin/img/**/*'
	], ['default']);
});

gulp.task('deletePreviousCompiledFiles', function() {
	deletePreviousCompiledFile('public/site/css');
	deletePreviousCompiledFile('public/site/js');
}); 
gulp.task('styles', function(){
	return gulp.src([
		'resources/assets/site/css/**/*.css'
	])
	.pipe(order([
        'lib/*',
    	'fonts.css',
    	'reset.css',
    	'classes.css',
		'layouts/main/index.css'
    ], {
    	base: 'resources/assets/site/css'
    }))
	.pipe(concat('all_' + uniqid() + '.css'))
	.pipe(minifyCss())
	.pipe(gulp.dest('public/site/css', {mode: 0777}));
});
gulp.task('scripts', function(){
	return gulp.src([
		'!resources/assets/site/js/lib/jquery.touchSwipe.min.js',
		'!resources/assets/site/js/lib/sortable.min.js',
		'resources/assets/site/js/**/*.js'
	])
	.pipe(order([
        'lib/*'
    ], {
    	base: 'resources/assets/site/js'
    }))
	.pipe(concat('all_' + uniqid() + '.js'))
	.pipe(uglify())
	.pipe(gulp.dest('public/site/js', {mode: 0777}));
});
gulp.task('copy', function() {
	gulp.src('resources/assets/site/fonts/**/*').pipe(gulp.dest('public/site/fonts', {mode: 0777}));
	gulp.src('resources/assets/site/img/**/*').pipe(gulp.dest('public/site/img', {mode: 0777}));
	
	gulp.src('resources/assets/admin/fonts/**/*').pipe(gulp.dest('public/admin/fonts', {mode: 0777}));
	gulp.src('resources/assets/admin/img/**/*').pipe(gulp.dest('public/admin/img', {mode: 0777}));
	gulp.src('resources/assets/admin/css/**/*').pipe(gulp.dest('public/admin/css', {mode: 0777}));
	gulp.src('resources/assets/admin/js/**/*').pipe(gulp.dest('public/admin/js', {mode: 0777}));
	
	gulp.src('resources/assets/site/js/lib/jquery.touchSwipe.min.js').pipe(gulp.dest('public/site/js', {mode: 0777}));
	gulp.src('resources/assets/site/js/lib/sortable.min.js').pipe(gulp.dest('public/site/js', {mode: 0777}));
});