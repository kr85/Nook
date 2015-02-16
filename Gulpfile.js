var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var concatCss = require('gulp-concat-css');
var uglify = require('gulp-uglify');
var minifyCss = require('gulp-minify-css');

gulp.task('css', function() {
    gulp.src('app/assets/sass/main.scss')
        .pipe(sass())
        .pipe(autoprefixer('last 10 version'))
        .pipe(gulp.dest('app/assets/css'));
    gulp.src([
        'app/assets/css/lib/bootstrap.css',
        'app/assets/css/lib/font-awesome.css',
        'app/assets/css/main.css'
    ])
        .pipe(concatCss('main.css'))
        .pipe(minifyCss({keepBreaks:false}))
        .pipe(gulp.dest('public/css'))
});

gulp.task('scripts', function() {
    gulp.src([
        'app/assets/javascript/lib/jquery.js',
        'app/assets/javascript/lib/bootstrap.min.js',
        'app/assets/javascript/lib/bootstrap-hover-dropdown.js',
        'app/assets/javascript/lib/jquery.placeholder.min.js',
        'app/assets/javascript/lib/jquery.jscroll.min.js',
        'app/assets/javascript/custom.js'
    ])
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/javascript'))
});

gulp.task('watch', function() {
    gulp.watch('app/assets/sass/**/*.scss', ['css'])
    gulp.watch('app/assets/javascript/**/*.js', ['scripts'])
});

gulp.task('default', ['watch']);