module.exports = function () {
    const theme = 'editorial',
        gulp = require('gulp'),
        sass = require('gulp-sass');

    gulp.task(theme + '-sass', function () {
        return gulp.src('public_html/front/editorial/sass/main.scss')
            .pipe(sass())
            .pipe(gulp.dest('public_html/front/editorial/css'))
    });

    gulp.task(theme + '-sass:watch', function () {
        gulp.watch('public_html/front/editorial/sass/**/*.scss', [theme + '-sass']);
    });
};