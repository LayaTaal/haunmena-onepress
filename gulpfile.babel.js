import { src, dest, watch, series, parallel } from 'gulp';
import yargs from 'yargs';
import sass from 'gulp-sass';
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'autoprefixer';
import imagemin from 'gulp-imagemin';
import del from 'del';
import webpack from 'webpack-stream';
import named from 'vinyl-named';
import browserSync from 'browser-sync';
import wpPot from 'gulp-wp-pot';
import info from './package.json';

const PRODUCTION = yargs.argv.prod;

/**
 * Browser sync
 */
const server = browserSync.create();
export const serve = done => {
    server.init({
        proxy: 'https://haunmenaprod.local', // put your local website link here
    });
    done();
};
export const reload = done => {
    server.reload();
    done();
};

/**
 * Process CSS
 */
export const styles = done => {
    src('src/scss/core.scss')
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulpif(PRODUCTION, postcss([autoprefixer])))
        .pipe(gulpif(PRODUCTION, cleanCss({ compatibility: 'ie8' })))
        .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
        .pipe(dest('dist/css'))
        .pipe(server.stream());
    done();
};

/**
 * Bundle JavaScript
 */
export const scripts = done => {
    src('src/js/core.js')
        .pipe(named())
        .pipe(
            webpack({
                module: {
                    rules: [
                        {
                            test: /\.js$/,
                            use: {
                                loader: 'babel-loader',
                                options: {
                                    presets: [],
                                },
                            },
                        },
                    ],
                },
                mode: PRODUCTION ? 'production' : 'development',
                devtool: !PRODUCTION ? 'inline-source-map' : false,
                output: {
                    filename: '[name].js',
                },
                externals: {
                    jquery: 'jQuery',
                },
            })
        )
        .pipe(dest('dist/js'));
    done();
};

/**
 * Process images
 */
export const images = done => {
    src('src/img/**/*.{jpg,jpeg,png,svg,gif}')
        .pipe(gulpif(PRODUCTION, imagemin()))
        .pipe(dest('dist/img'));
    done();
};

/**
 * Copy theme files to dist folder
 */
export const copy = done => {
    src(['src/**/*', '!src/{img,js,scss}', '!src/{img,js,scss}/**/*']).pipe(
        dest('dist')
    );
    done();
};

/**
 * Delete our dist folder
 */
export const clean = () => del(['dist']);

/**
 * Watch for changes and process
 */
export const watchForChanges = () => {
    watch('src/scss/**/*.scss', styles);
    watch('src/img/**/*.{jpg,jpeg,png,svg,gif}', series(images, reload));
    watch(
        ['src/**/*', '!src/{img,js,scss}', '!src/{img,js,scss}/**/*'],
        series(copy, reload)
    );
    watch('src/js/**/*.js', series(scripts, reload));
    watch('**/*.php', reload);
};

/**
 * Translate our theme
 */
export const pot = done => {
    src('**/*.php')
        .pipe(
            wpPot({
                domain: 'haunmena',
                package: info.name,
            })
        )
        .pipe(dest(`languages/${info.name}.pot`));
    done();
};

/**
 * Compose our tasks together
 */
export const dev = series(
    clean,
    parallel(styles, images, copy, scripts),
    serve,
    watchForChanges
);
export const build = series(
    clean,
    parallel(styles, images, copy, scripts),
    pot,
);
export default dev;
