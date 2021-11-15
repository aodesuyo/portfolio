//起動コマンド
//$ npx gulp --domain "サイトのドメイン"

//---------------------------------------------------------
//  モード
//---------------------------------------------------------
'use strict'; //厳格モード

//---------------------------------------------------------
//  本体読み込み
//---------------------------------------------------------
const gulp = require( 'gulp' );
const { src, dest, watch, series, parallel } = require( 'gulp' );
/*
src      =>  参照先指定
dest     =>  出力先指定
watch    =>  ファイル監視
series   =>  直列処理
parallel =>  並列処理
*/

//---------------------------------------------------------
//  入出力パス設定
//---------------------------------------------------------
//参照元パス
const srcPath = {
  'scss': './production/sass/**/*.scss',
  'php' : './production/php/**/*.php',
  'js'  : './production/js/**/*.js'
}
//出力先パス
const destPath = {
  'css' : '../css/',
  'php' : '../',
  'js'  : '../js/'
}

//---------------------------------------------------------
//  プラグイン読み込み
//---------------------------------------------------------
//scss
const sass = require( 'gulp-sass' )( require('sass') );  //cssコンパイル
const plumber = require( 'gulp-plumber' );               //エラーが発生しても強制終了させない
const notify = require( 'gulp-notify' );                 //エラー発生時のアラート出力
const autoprefixer = require( 'gulp-autoprefixer' );     //ベンダープレフィックス自動付与(条件はpackage.jsonに記載)
const postcss = require( 'gulp-postcss' );               //Node.js製、CSS操作プラグインのフレームワーク
const mqpacker = require( 'css-mqpacker' );              //メディアクエリの整理
const browserSync = require( 'browser-sync' );           //ブラウザシンク
const minimist = require( 'minimist' );                  //コマンドラインパーサー

//---------------------------------------------------------
//  関数定義
//---------------------------------------------------------
//scssコンパイル
const scssCompile = () => {
  return src( srcPath.scss, {
    sourcemaps: true, //init
    })
    //エラーが出ても処理継続
    .pipe( plumber( {
      errorHandler: notify.onError( 'Error:<%= error.message %>' )
    }))
    //CSS形式 => expanded：一般的なCSS形式　compressed：空白、改行取り除く(本番環境用)
    .pipe( sass({ outputStyle: 'expanded' }))
    //メディアクエリの整理
    .pipe( postcss([mqpacker()]))
    //ベンダープレフィックス自動付与
    .pipe( autoprefixer())
    //出力設定
    .pipe( dest( destPath.css, {
      sourcemaps: '/'  //write
    }))
    //修正部分だけ反映
    .pipe( browserSync.stream())
}

//minimist設定
const options = minimist( process.argv.slice( 2 ),{ //process.argv=>コマンドラインの引数取得
  string: 'domain',
  default: {
    domain: 'sitedomain.local' //引数初期値
  }
});
//ブラウザ設定
const browserSyncFunc = () => {
  browserSync.init( browserSyncOption );
}
const browserSyncOption = {
  proxy: {
    target: options.domain
  },
}
//リロードタスク
const browserSyncReload = ( done ) => {
  browserSync.reload();
  done();
}

//PHPファイル監視・出力
const phpWatch = () => {
  return src( srcPath.php )
    .pipe( gulp.dest( destPath.php ))
}
//Jsファイル監視・出力
const jsWatch = () => {
  return src( srcPath.js )
    .pipe( gulp.dest( destPath.js ))
}

//watchタスク
const watchFiles = () => {
  watch( srcPath.scss, series( scssCompile ))
  watch( srcPath.php, series( phpWatch, browserSyncReload ))
  watch( srcPath.js, series( jsWatch, browserSyncReload ))
}

//---------------------------------------------------------
//  モジュール作成
//---------------------------------------------------------
exports.default = series(
  parallel( phpWatch, jsWatch, scssCompile ),
  parallel( watchFiles , browserSyncFunc )
);