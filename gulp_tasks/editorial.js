module.exports = function () {
    const theme = 'editorial',
        gulp = require('gulp'),
        sass = require('gulp-sass');

    gulp.task(theme + '-sass', function () {
        return gulp.src('public_html/front/' + theme + '/sass/main.scss')
            .pipe(sass())
            .pipe(gulp.dest('public_html/front/' + theme + '/css'))
    });

    gulp.task(theme + ':watch', function () {
        gulp.watch('public_html/front/' + theme + '/sass/**/*.scss', [theme + '-sass']);
    });
};