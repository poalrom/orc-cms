module.exports = function () {
    const gulp = require('gulp'),
        sass = require('gulp-sass');

    gulp.task('admin-sass', function () {
        return gulp.src('public_html/admin/sass/main.sass')
            .pipe(sass())
            .pipe(gulp.dest('public_html/admin/css'))
    });

    gulp.task('admin:watch', function () {
        gulp.watch('public_html/admin/sass/**/*.sass', ['admin-sass']);
    });
};