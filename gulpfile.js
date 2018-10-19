'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    cleanCSS = require('gulp-clean-css'),
    sourcemaps = require('gulp-sourcemaps'),
    livereload = require('gulp-livereload'),
    browserify = require('browserify'),
    source = require('vinyl-source-stream'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    buffer = require('vinyl-buffer'),
    filter = require('gulp-filter'),
    autoprefixer = require('gulp-autoprefixer'),
    moduleImporter = require('sass-module-importer'),
    imagemin = require('gulp-imagemin'),
    paths = {
        input_scss: [
            './wp-content/themes/erebus/assets/scss/style.scss',
            './wp-content/themes/erebus/assets/scss/editor-style.scss'
        ]
    };

gulp.task('scss', function () {
    gulp.src(paths.input_scss)
        .pipe(sass({importer: moduleImporter()}))
        .on('error', function (error) {
            console.log('Error: ' + error.message);
        })
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(autoprefixer({
            browsers: ['last 34 versions', 'IE 11'],
            remove: false
        }))
        .pipe(cleanCSS())
        .pipe(rename({
            dirname: './wp-content/themes/erebus/'
        }))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./'))
        .pipe(filter('**/*.css'))
        .pipe(livereload());
});

gulp.task('images', function () {
    gulp.src('./wp-content/themes/erebus/assets/images/*')
        .pipe(imagemin())
        .pipe(gulp.dest('./wp-content/themes/erebus/images/')
        );
});

gulp.task('js', function () {
    // set up the browserify instance on a task basis
    var b = browserify({
        entries: './wp-content/themes/erebus/assets/js/main.js',
        debug: true
    });

    return b.bundle()
        .pipe(source('main.js'))
        .pipe(buffer())
        .pipe(sourcemaps.init({loadMaps: true}))
        // Add transformation tasks to the pipeline here.
        .pipe(uglify())
        .pipe(rename({
            dirname: './wp-content/themes/erebus/'
        }))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./'));
});

//Watch task
gulp.task('default', ['scss', 'js'], function () {
    livereload.listen();
    gulp.watch('./wp-content/themes/erebus/assets/scss/**/*.scss', ['scss']);
    gulp.watch('./wp-content/themes/erebus/assets/js/**/*.js', ['js']);
});
