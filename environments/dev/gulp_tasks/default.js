module.exports = function () {
    const gulp = require('gulp');

    gulp.task('default', ['editorial:watch', 'admin:watch']);
    gulp.task('b', ['editorial']);
};