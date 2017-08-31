var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function(){
    return gulp.src('public_html/front/sass/main.scss')
        .pipe(sass())
        .pipe(gulp.dest('public_html/front/css'))
});

gulp.task('sass:watch', function () {
    gulp.watch('public_html/front/sass/**/*.scss', ['sass']);
});

gulp.task('default', [ 'sass:watch' ]);