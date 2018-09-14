const gulp         = require('gulp'),
      rename       = require('gulp-rename'),
      plumber      = require('gulp-plumber'),
      uglify       = require('gulp-uglify'),
      sourcemaps   = require('gulp-sourcemaps'),
      autoprefixer = require('gulp-autoprefixer'),
      sass         = require('gulp-sass'),
      csso         = require('gulp-csso'),
      browserify   = require('browserify'),
      babelify     = require('babelify'),
      source       = require('vinyl-source-stream'),
      buffer       = require('vinyl-buffer');

const jsSrc   = 'main.js',
      jsFolder   = 'src/js/',
      jsDist  = './dist/js',
      jsWatch = 'src/js/**/*.js',
      jsFiles = [jsSrc];

const cssSrc   = ['src/css/**/*.css', '!src/css/**/*.min.css'],
      cssWatch = 'src/scss/**/*.scss',
      cssDist  = './dist/css';

const scssSrc   = ['src/scss/*.scss'],
      scssWatch = 'src/scss/**/*.scss';

gulp.task('css', () => {
    return gulp.src(cssSrc)
        .pipe(plumber())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(csso())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(cssDist));
});

gulp.task('scss', function(){
    return gulp.src(scssSrc)
        .pipe(sass({
            includePaths: ['node_modules/bootstrap-4-grid/scss'],
        }).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(csso())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(cssDist));
});

gulp.task('js', () => {
    jsFiles.map(entry => {
        return browserify({
            entries: [jsFolder + entry]
        })
        .transform(babelify, {presets: ['env']})
        .bundle()
        .pipe(plumber())
        .pipe(source(entry))
        .pipe(rename({extname: '.min.js'}))
        .pipe(buffer())
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(jsDist))
    });
});

gulp.task('default', ['js', 'scss', 'css']);

gulp.task('watch', ['default'], () => {
    gulp.watch(jsWatch, ['js']);
    gulp.watch(scssWatch, ['scss']);
    gulp.watch(cssWatch, ['css']);
});
