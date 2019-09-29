<html>

<head>

<meta charset = "utf-8">

<title>mission3</title>

</head>

<body>


<?php

ini_set('display_errors', 0);

$name = $_POST["name"] ;
$comment = $_POST["comment"] ;
$time = date ( "y年m月d日 H:i:s") ; //日時表示（フォーマット決まっているy,m,H,iなど）
$filename = "mission_3-4.txt" ; 



//入力フォーム

if ( !empty ( $_POST["name"] ) && !empty ( $_POST["comment"] ) && empty( $_POST["editnum"] ) ){ //条件二つとも真の時真

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

//編集選択

//編集フォームの中身が空じゃないとき
if(!empty ($_POST["edit"])){
//ファイルの中身を読み込み（配列）
	$file_edit = file( $filename ) ;
//ループ開始
	foreach( $file_edit as $str_edit ){
//配列を分解
		$ex_edit = explode( '<>' , $str_edit ) ;
//投稿番号と編集対象番号が等しい時
		if( $ex_edit[0] == $_POST["edit"] ){
//その投稿の名前とコメントを取得
			$num_edit = $ex_edit[0];
			$name_edit = $ex_edit[1];
			$comment_edit = $ex_edit[2];
		}
	}
}

//編集機能 3-4-7

//hiddenのところ空じゃないとき
if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty ($_POST["editnum"])){
//ファイルの中身を読み込み
	$file_edit2 = file( $filename );
//書き込み準備
	$fp3 = fopen( $filename , "w" );
//読み込んだ配列を1行ずつ走査（ループ）	
	foreach( $file_edit2 as $str_edit2 ){
//分解		
		$ex_edit2 = explode( '<>' , $str_edit2 );
//hiddenの番号と投稿番号を比較
		if($_POST["editnum"] == $ex_edit2[0]){//同じとき
//差し替え
			$ex_edit2[1] = $name; //分解した名前の部分差し替え
			$ex_edit2[2] = $comment; //分解したコメント部分差し替え
			$str_edit2 = implode( '<>' , $ex_edit2 );//分解したものを結合
		
		}
		fwrite($fp3,$str_edit2); //ループ配列を書き込み
	}
	fclose($fp3);
}

?>

【入力フォーム】
<form method = "post" action = "mission_3-4.php">

<input type = "text" name = "name" placeholder = "名前" value = "<?php echo $name_edit ; ?>" ><br> <!名前入力テキスト>
<input type = "text" name = "comment" placeholder = "コメント" value = "<?php echo $comment_edit ; ?>" ><!コメント入力テキスト>
<input type = "hidden" name = "editnum" value = "<?php echo $num_edit[0]; ?>" > <!hiddenで隠すやつ>
<input type = "submit" value = "送信"> <!送信ボタン>
<br>
</form>

【削除フォーム】
<form method = "post" action = "mission_3-4.php">

<input type = "text" name = "del" placeholder = "削除対象番号">
<input type = "submit" value = "削除">
<br>
</form>

【編集番号指定フォーム】
<form method = "post" action = "mission_3-4.php">

<input type = "text" name = "edit" placeholder = "編集対象番号">
<input type = "submit" value = "編集">

</form>


<?php
//最終的な読み込みと表示↓↓

$file_output = file ( $filename ) ; 

foreach ( $file_output as $word ) { 

	$ex2 = explode ( '<>' , $word ) ; 
 
	echo "<br>" . $ex2[0] . " " . $ex2[1] . " " . $ex2[2] . " " . $ex2[3] ; 

} 

?>


</body>

</html>
