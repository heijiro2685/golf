<!--<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>seiseki.htmlのコピー</title>
</head>
<body>
	<p style="padding-left: 50px;">ファイルコピーを開始します</p>
    
</body>
</html> -->

<?php
    # フォームを読み込み、<main>まで出力用ファイルに書き込む
    $holder = "C:\\Users\\kjyos\\OneDrive\\Temporary\\";
    $fromstr = $holder."output.html";

    # seiseki.htmlをform.htmlとして、temporaryにコピー
    $holders = "C:\\Users\\kjyos\\OneDrive\\fcweb\html\\";
    $tostr = $holders."seiseki.html";
    copy($fromstr, $tostr);

    echo "<p style=\"padding-left: 50px;\">".$fromstr."を".$tostr."としてコピーしました";
?>

