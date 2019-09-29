<html>

<head>

<meta charset = "utf-8">

<title>mission3</title>

</head>

<body>

【入力フォーム】<br/>

<form method = "post" action = "mission_3-3.php">

<input type = "text" name = "name" placeholder = "名前"> <!名前入力テキスト>
<br/>
<input type = "text" name = "comment" placeholder = "コメント"> <!コメント入力テキスト>
<input type = "submit" value = "送信"> <!送信ボタン>
<br/>

</form>

【削除フォーム】<br/>

<form method = "post" action = "mission_3-3.php">

<input type = "text" name = "del" placeholder = "削除対象番号">
<input type = "submit" value = "削除">

</form>

<?php

$name = $_POST["name"] ;
$comment = $_POST["comment"] ;
$time = date ( "y年m月d日 H:i:s") ; //日時表示（フォーマット決まっているy,m,H,iなど）
$filename = "mission_3-3.txt" ; 



//入力フォーム
if ( !empty ( $_POST["name"] ) && !empty ( $_POST["comment"] ) ){ //条件二つとも真の時真

	$fp = fopen ( $filename , "a" ) ; 
//投稿番号取得	
	$arr = file ($filename) ; // 配列読み込み
	$end = end ( $arr ) ; //最後の行に焦点合わせる
	$arr_ex = explode ( '<>' , $end ) ; //最後の行を分解
	$num = $end[0] ; //投稿番号にあたる部分
//投稿日時など格納
	$toukou = $num+1 . "<>" . $name . "<>" . $comment ."<>" . $time ;  
//テキストファイルへ書き込み
	fwrite ( $fp , $toukou ."\n" ) ; 
	fclose ( $fp ) ; 
} 

//削除フォーム

//削除フォームの中身が空じゃないとき
if (!empty ($_POST["del"])){
//ファイルの中身を読み込み（配列）
	$file = file ( $filename ) ;
//書き込み準備および中身空に
	$fp2 = fopen ( $filename , "w") ;
//ループ開始
	foreach( $file as $str ) {
//配列を分解
		$ex = explode( '<>' , $str );
//投稿番号が削除番号と等しくないとき
		if( $ex[0] != $_POST["del"] ){
//一行ずつ書き込み
			fwrite( $fp2 , $str );
		}
	}
	fclose ( $fp2 );
}

//最終的な読み込みと表示↓↓

$file_output = file ( $filename ) ; 

foreach ( $file_output as $word ) { 

	$ex2 = explode ( '<>' , $word ) ; 
 
	echo "<br>" . $ex2[0] . " " . $ex2[1] . " " . $ex2[2] . " " . $ex2[3] ; 

} 

?>


</body>

</html>
