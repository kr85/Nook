var gulp         = require('gulp'),
    sass         = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    concat       = require('gulp-concat'),
    concatCss    = require('gulp-concat-css'),
    uglify       = require('gulp-uglify'),
    minifyCss    = require('gulp-minify-css'),
    jshint       = require('gulp-jshint'),
    imagemin     = require('gulp-imagemin'),
    rename       = require('gulp-rename'),
    notify       = require('gulp-notify'),
    cache        = require('gulp-cache'),
    livereload   = require('gulp-livereload'),
    del          = require('del'),
    modernizr    = require('gulp-modernizr');

// Styles task
gulp.task('css', function() {
  gulp.src('app/assets/sass/main.scss')
    .pipe(sass({ style : 'expanded' })).on('error', errorHandler)
    .pipe(autoprefixer({
      browsers : ['last 40 versions'],
      cascade  : false
    }))
    .pipe(gulp.dest('app/assets/css'));
  return gulp.src([
    'app/assets/css/lib/jquery-ui.css',
    'app/assets/css/lib/bootstrap.css',
    'app/assets/css/lib/font-awesome.css',
    'app/assets/css/main.css'
  ])
    .pipe(concatCss('all.css')).on('error', errorHandler)
    .pipe(gulp.dest('public/css'))
    .pipe(rename({ suffix : '.min' }))
    .pipe(minifyCss({
      keepBreaks          : false,
      keepSpecialComments : 0
    }))
    .pipe(gulp.dest('public/css'))
    .pipe(notify({ message : 'CSS task complete.' }));
});

// Scripts task
gulp.task('scripts', function() {
  return gulp.src([
    'app/assets/js/lib/jquery.js',
    'app/assets/js/lib/jquery-ui.js',
    'app/assets/js/lib/bootstrap.min.js',
    'app/assets/js/lib/bootstrap-hover-dropdown.js',
    'app/assets/js/lib/jquery.placeholder.min.js',
    'app/assets/js/placeholder.js',
    'app/assets/js/infinitescroll.js',
    'app/assets/js/custom.js'
  ])
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('default'))
    .pipe(concat('all.js'))
    .pipe(gulp.dest('public/js'))
    .pipe(rename({ suffix : '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest('public/js'))
    .pipe(notify({ message : 'Scripts task complete.' }));
});

// Custom modernizr tast
gulp.task('modernizr', function() {
  gulp.src('public/js/*.js')
    .pipe(modernizr())
    .pipe(gulp.dest("public/js/"))
    .pipe(rename({ suffix : '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest("public/js/"))
    .pipe(notify({ message : 'Custom modernizr task complete.' }));
});

// Images task
gulp.task('images', function () {
  return gulp.src('app/assets/images/**/*')
    .pipe(cache(imagemin({
      optimizationLevel : 3,
      progressive       : true,
      interlaced        : true
    })))
    .pipe(gulp.dest('public/images'))
    .pipe(notify({ message : 'Images task complete.' }));
});

// Clean task
gulp.task('clean', function (callback) {
  del(['public/css', 'public/js', 'public/images'], callback);
});

// Watch task
gulp.task('watch', function() {
  // Watch .scss files
  gulp.watch('app/assets/sass/**/*.scss', ['css']);
  // Watch .js files
  gulp.watch('app/assets/js/**/*.js', ['scripts']);
  // Watch images files
  gulp.watch('app/assets/images/**/*', ['images']);
  // Create a LiveReload server
  livereload.listen();
  // Watch any files in public/, reload on change
  gulp.watch(['public/**']).on('change', livereload.changed);
});

// Default tast
gulp.task('default', ['clean'], function () {
  gulp.start('css', 'scripts', 'images');
  setTimeout(function () {
    gulp.start('modernizr');
  }, 6000);
});

function errorHandler (error) {
  console.log(error.toString());
  this.emit('end');
}