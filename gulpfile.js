import gulp from 'gulp';
import cssmin from 'gulp-cssmin';
import uglify from 'gulp-uglify';
import watch from 'gulp-watch';

// Caminhos dos arquivos CSS e JS do seu projeto Laravel
const paths = {
  css: 'resources/css/**/*.css',
  js: 'resources/js/**/*.js',
};

// Task para minificar o CSS
gulp.task('css', function () {
  return gulp.src(paths.css)
    .pipe(cssmin())
    .pipe(gulp.dest('public/css'));
});

// Task para minificar o JS
gulp.task('js', function () {
  return gulp.src(paths.js)
    .pipe(uglify())
    .pipe(gulp.dest('public/js'));
});

// Task padrão que executa as tarefas de minificação de CSS e JS
gulp.task('default', gulp.parallel('css', 'js'));

// Task para monitorar as alterações nos arquivos CSS e JS
gulp.task('watch', function () {
    gulp.watch(paths.css, gulp.series('css'));
    gulp.watch(paths.js, gulp.series('js'));
});
