const gulp = require('gulp');
const sass = require('gulp-dart-sass');
const autoprefixer = require('gulp-autoprefixer');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const babel = require('gulp-babel');
//notify = require('gulp-notify');
const cleanCSS = require('gulp-clean-css');
const sassGlob = require('gulp-sass-glob');

gulp.task('scripts', function() {
    return gulp.src(['assets/js/*.js', '!assets/js/_*.js'])
      .pipe(babel({
          presets: ['@babel/env'],
      }))
      //.pipe(concat('scripts.js'))
      .pipe(rename({suffix: '.min'}))
      .pipe(uglify())
      .pipe(gulp.dest('dist/'))
      //.pipe(notify({ message: 'Scripts task complete' }));
});

gulp.task('styles', function() {
    return gulp.src('assets/scss/*.scss')
      .pipe(sassGlob())
      .pipe(sass({silenceDeprecations: ['legacy-js-api', 'mixed-decls', 'color-functions', 'global-builtin', 'import'], outputStyle: 'compressed'}).on('error', sass.logError))
      .pipe(autoprefixer('last 2 versions'))
      .pipe(gulp.dest('assets/css'))
      .pipe(rename({suffix: '.min'}))
      .pipe(cleanCSS('level: 2'))
      .pipe(gulp.dest('dist/'))
      //.pipe(notify({ message: 'Styles task complete' }));
  });

gulp.task('watch', function() {
    gulp.watch(['assets/js/*.js', '!assets/js/scripts.js'], gulp.series('scripts'));    
    gulp.watch('assets/scss/*.scss', gulp.series('styles'));
    gulp.watch('assets/scss/*/*.scss', gulp.series('styles'));
    gulp.watch('assets/scss/*/*/*.scss', gulp.series('styles'));
    //gulp.watch('assets/css/*.css', gulp.series('process-styles'));
});


gulp.task('default', gulp.series('scripts', 'styles', 'watch'));