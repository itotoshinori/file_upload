  <? require 'subpac.php'; ?>
<html>
<title>画像アップロード</title>
<head>
<meta name="Content-Style-Type" content="text/css">
<style>
.btn-square-pop {
  position: relative;
  display: inline-block;
  padding: 0.25em 0.5em;
  text-decoration: none;
  color: #FFF;
  background: #fd9535;/*背景色*/
  border-bottom: solid 2px #d27d00;/*少し濃い目の色に*/
  border-radius: 4px;/*角の丸み*/
  box-shadow: inset 0 2px 0 rgba(255,255,255,0.2), 0 2px 2px rgba(0, 0, 0, 0.19);
  font-weight: bold;
  font-size: 12px;
  width:80px;
  height:25px;
}

.btn-square-pop:active {
  border-bottom: solid 2px #fd9535;
  box-shadow: 0 0 2px rgba(0, 0, 0, 0.30);
}
</style>
<script>
   function copyText(){
       var ta = document.createElement("textarea")
       ta.value = document.getElementById("hoge").innerText;
       document.body.appendChild(ta)
       ta.select()
       document.execCommand("copy")
       ta.parentElement.removeChild(ta)
   }
   </script>
	<head>
<meta charset="utf-8">
<title>画像アップロード、タグ作成システム</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<header>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarEexample1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
        </button>
		</div>
		
		<div class="collapse navbar-collapse" id="navbarEexample1">
                
			<ul class="nav navbar-nav">
				<li><a href="https://guarded-spire-64417.herokuapp.com/">HP</a></li>
				<li><a href="http://titonet384.sakura.ne.jp/imagelink/">画像リンク</a></li>
        <li><a href="http://titonet384.sakura.ne.jp/uploads/">画像up</a></li>
        <li><a href="http://titonet384.sakura.ne.jp/linkmake/">リンクタグ</a></li>
        <li><a href="http://titonet384.sakura.ne.jp/mail/mail.html">メール</a></li>

			</ul>
		</div>
	</div>
</nav>
</header>
<?php
$pass="123456";
if (!empty($_POST["pwd"])) {
  $password=$_POST["pwd"];
  if ($password==$pass){
    setcookie(‘passwd1’,OK,time()+1200);
    #setcookie(‘passwd’,OK,time()+31536000);
    $passok="OK";
  }
}
if($_COOKIE[‘passwd1’]=='OK'){
    $passok="OK";
}

if ($passok<>"OK") {
  header ( 'Location: pwd.php' );
  exit ();
}
ini_set('display_errors', 1);
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
$nomal=true;
$seiko=false;
$msg = null;
if (!empty($_POST["scale"])) {
$scale=$_POST["scale"];
}


if (isset ($_FILES ['upfile'] ) && is_uploaded_file ( $_FILES ['upfile'] ['tmp_name'] )) {
    $old_name = $_FILES ['upfile'] ['tmp_name'];
    #$new_name = date ( "YmdHis" );
    function insertStr1($text, $insert, $num){
      return substr_replace($text, $insert, $num, 0);
    }
    $insert_text = array('&','+','7E','!','A','B');
		$num = mt_rand(20, 30);
    $newfile = randomstr($num);
    for($count = 0; $count < 3; $count++) {
      $insert_t = $insert_text[mt_rand(0, 5)];
      $newfile = insertStr1($newfile, $insert_t, mt_rand(0, 20));
    }
    #$new_name = insertStr1($newfile, $insert_t, mt_rand(0, 20));
    $new_name =  $newfile.date ( "YmdHis" );
    $old_file= $_FILES ['upfile'] ['tmp_name'];
    $imagelink = $_POST["imagelink"];
    $nonpublic = $_POST["nonpublic"];
    (int)$old_file_size=0;
    $filename = $_FILES ['upfile']['name'];
    $file_type = substr($filename, -3);
    #$filename = pathinfo( $filename, PATHINFO_EXTENSION);
    $old_file_size=filesize($old_file);
    if($file_type =="peg" || $file_type =="jpg") {
      $new_name .= '.jpg';
      $normal=true;
    }else if($file_type =="gif"){
      $new_name .= '.gif';
      $normal=true;
    }else if($file_type =="png"){
      $normal=true;
      $new_name .= '.png';
    }else if($file_type =="pdf"){
      $normal=true;
      $new_name .= '.pdf';
    }else{
      $nomal=false;
    }
    if($old_file_size>50000000){
      $nomal=false;
    }
    if($nomal==true){
      $gazou = basename ( $_FILES ['upfile'] ['name'] );
      if($nonpublic=="1"){
        $folder = 'internal_images/';
      } else {
        $folder = 'images/';
      }
      if (move_uploaded_file ( $old_name, $folder.$new_name )) {
        $msg = $gazou . 'のアップロードに成功しました';
        $seiko=true;
      }else {
        $norml=false;
        $msg = 'アップロードに失敗しました。サーバーに問題があります。';
      }
    }else{
        $msg = 'アップロードに失敗しました。'.'<br>'.'画像タイプのファイルなのかサイズが１MB以下であることを確認してください';
    }

}
if (!empty($_POST["newfilename"])) {
  $new_name=$_POST["newfilename"];
  $scale=$_POST["scale"];
  $msg = 'サイズ変更しました';
    $seiko=true;
}
?>
<center>
  <h2>画像のアップロード</h2>
  <h3>画像ファイルを選択して読み込みボタンをクリックして下さい</h3>
  <h4>画像ファイルでサイズを１MB未満とします</h4>
  <h3><a href="index.php">リセット</a></h3>

<?php echo '<p>' . $msg . '</p>'; ?>
<p>
<?php if (empty($_POST["scale"])) {
echo <<<END
<form action="index.php" method="post"
    enctype="multipart/form-data">
    <input type="file" name="upfile">
    画像の大きさ：<select name="scale">
      <option value="100">100%</option>
      <option value="70">70%</option>
      <option value="50" selected>50%</option>
      <option value="20">20%</option>
    </select></p>
     <input type="checkbox"  name="imagelink" value="1">イメージリンクをつける<br>
     <input type="checkbox" name="nonpublic" value="1">公開しない
    <input type="submit" value="読み込み"
        name="yomikomi" class="btn-square-pop">
</p>
END;
}
if ( $seiko==true) {
    #echo '<p>' . $msg . '</p>';
    if($nonpublic=="1"){
      $url="http://titonet384.sakura.ne.jp/uploads/internal_images/".$new_name;
    } else {
      $url="http://titonet384.sakura.ne.jp/uploads/images/".$new_name;
    }
    if($file_type == "pdf"){
      $tag = htmlentities("<a href=\"{$url}\">PDFリンク</a>");
    }
    else if($imagelink=="1"){
      $tag=htmlentities("<a href=\"{$url}\"><img src=\"{$url}\" width=\"{$scale}%\" ></a>");
      echo "<img src=\"${url}\" width={$scale}%><br><br>";
    } else {
      echo "<img src=\"${url}\" width={$scale}%><br><br>";
      $tag=htmlentities("<img src=\"{$url}\" width=\"{$scale}%\" >");
    }
    echo "<div id='hoge'>".$tag."</div>";
    echo "<p><button onclick='copyText()'>タグをコピー</button></p>";
    echo  "画像比率{$scale}%"."<br />";

echo <<<END
<A HREF="javascript:history.back()">再設定</A>
<br>
</table>
END;
}

?>

</td></tr></table>
</html>
