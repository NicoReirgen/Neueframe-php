const gulp        = require('gulp');
const browserSync = require('browser-sync').create();
const phpConnect  = require('gulp-connect-php');
const sourcemaps  = require('gulp-sourcemaps');
const concat      = require('gulp-concat');
const rename      = require('gulp-rename');
const notify      = require('gulp-notify');

// required modules for styles
const sass        = require('gulp-sass');
const cleancss    = require('gulp-clean-css');

// required modules for scripts
const uglify      = require('gulp-uglify');

// required modules for images
const imagemin    = require('gulp-imagemin')

const paths = {
    styles: {
        assets: ['app/assets/styles/**/*.scss'],
        dist  : 'app/dist/styles'
    },
    scripts: {
        assets: ['app/assets/scripts/**/*.js'],
        dist  : 'app/dist/scripts'
    },
    images: {
        assets: ['app/assets/images/**/*'],
        dist  : 'app/dist/images'
    },
    php: {
        src   : ['app/**/*.php']
    }
}

//compile scss into css
function styles() {    
    return gulp.src(paths.styles.assets)
    .pipe(sourcemaps.init({
        loadMaps: true
    }))
    .pipe(sass().on('error', sass.logError))
    .pipe(cleancss())
    .pipe(concat('main.css'))
    .pipe(rename({
        suffix: ".min"
    }))
    .pipe(sourcemaps.write('/'))
    .pipe(gulp.dest(paths.styles.dist))
    .pipe(browserSync.stream())
    .pipe(notify(
        {
            message: "[STYLES] Compiled files and sourcemap file created !",
            onLast: true
        }
    ));
}

function scripts() {
    return gulp.src(paths.scripts.assets)
    .pipe(sourcemaps.init({
        loadMaps: true
    }))
    .pipe(uglify())
    .pipe(concat('main.js'))
    .pipe(rename({
        suffix: ".min"
    }))
    .pipe(sourcemaps.write('/'))
    .pipe(gulp.dest(paths.scripts.dist))
    .pipe(browserSync.stream())
    .pipe(notify(
        {
            message: "[SCRIPTS] Compiled files and sourcemap file created !",
            onLast: true
        }
    ));
}

function images() {
    return gulp.src(paths.images.assets, {
        since: gulp.lastRun(images)
    })
    .pipe(imagemin())
    .pipe(gulp.dest(paths.images.dist))
    .pipe(notify("[IMAGES] Images are minified !"))
}

function watch() {
    phpConnect.server({
        port: 8000,
        keepalive: true,
        base: "./"
    }, function (){
        browserSync.init({
            proxy: '127.0.0.1:8000'
        });
    });
    
    gulp.watch(paths.styles.assets,  styles);
    gulp.watch(paths.scripts.assets, scripts);
    gulp.watch(paths.images.assets,  images)
    
    gulp.watch(paths.php.src).on('change',browserSync.reload);

}

exports.styles  = styles;
exports.scripts = scripts;
exports.images  = images;
exports.default = watch;