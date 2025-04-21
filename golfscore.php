<?php
# 2022.8.13 function yymmdd()追加
# birdiegenerate, generate2, gennewfileを統合
# 作業用のホルダはE:\hobbyとする
# 2024.11.11～html5対応に修正開始

# プレー結果アップロード
$holders = "E:\\hobby\\server\\";
$holderc = "C:\\Users\\kjyos\\OneDrive\\Temporary\\";

if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
#    var_dump($_FILES);
    if (move_uploaded_file($_FILES["upfile"]["tmp_name"], $holders. "playdate.csv")) {
        echo $_FILES["upfile"]["name"] . "をアップロードしました<br>";
    } else {
        echo "ファイルをアップロードできません";
    }
} else {
    echo "ファイルが選択されていません";
}

try {
    # csv全データ読み込み
    $inputptr = fopen($holders."playdate.csv", "r");
    $row = 0;
    while($linedata = fgetcsv($inputptr)){
        $alldata[$row] = $linedata;

    #    echo '<br>';
    #    var_dump($row, $alldata[$row]);
            $row++;
    }
    fclose($inputptr);

    # データ数から順位あり、なしを判断
    $columnss = count($alldata[1]);
    if ($columnss == 29){
        $compe = TRUE;
    }
    else
        $compe = FALSE;
    #var_dump($compe);   echo "<br>";

    $holdero = "E:\\temporary\\";
    $outptr = fopen($holdero."mid.html", "w");

    # 1行目～コンペ、通常ラウンド共通
    $str = "<table class=\"normal\">".PHP_EOL;
    fputs($outptr, $str);
    $str = "\t<tbody>".PHP_EOL;
    fputs($outptr, $str);

    $str = "\t\t<tr><td colspan=\"{$columnss}\">".$alldata[0][0]."</td></tr>".PHP_EOL;
    #var_dump($str); echo "<br>";
    fputs($outptr, $str);

    # 2行目
    $str = "\t\t<tr>";
    $column = 0;
    if ($compe){
        $str = $str."<td>".$alldata[1][$column]."</td>";    # 順位
        $column++;
    
        $str = $str."<td rowspan=\"3\">".$alldata[1][$column]."</td>";  # out
        $column++;
        $str = $str."<td>".$alldata[1][$column]."</td>";    # Hole
        $column++;
    
        # 9ホールと前半トータル
        for($ii = 0;$ii < 10; $ii++){
            $str = $str."<td>".$alldata[1][$column]."</td>";
            $column++;
        }

        $str = $str."<td rowspan=\"3\">".$alldata[1][$column]."</td>";  # in
        $column++;
        $str = $str."<td>".$alldata[1][$column]."</td>";     # Hole
        $column++;

        # 後半9ホール、後半トータル、グロス
        for($jj = 0;$jj < 11; $jj++){
            $str = $str."<td>".$alldata[1][$column]."</td>";
            $column++;
        }

        $str = $str."<td>".$alldata[1][$column]."</td>";    # HDCP
        $column++;
        $str = $str."<td>".$alldata[1][$column]."</td>";    # NET
        #$column++;
        #$str = $str."<td>".$alldata[1][$column]."</td>";    # 記事
    }
    else {
        $str = $str."<td rowspan=\"3\">".$alldata[1][$column]."</td>";  # out
        $column++;
        $str = $str."<td>".$alldata[1][$column]."</td>";    # Hole
        $column++;

        for($ii = 0;$ii < 10; $ii++){
            $str = $str."<td>".$alldata[1][$column]."</td>";
            $column++;
        }

        $str = $str."<td rowspan=\"3\">".$alldata[1][$column]."</td>";  # in
        $column++;
        $str = $str."<td>".$alldata[1][$column]."</td>";     # Hole
        $column++;
        
        for($jj = 0;$jj < 11; $jj++){
            $str = $str."<td>".$alldata[1][$column]."</td>";
            $column++;
        }
    }
    $str = $str."</tr>".PHP_EOL;
    #var_dump($str); echo "<br>";
    fputs($outptr,$str);
    
    #3行目
    $str = "\t\t<tr>";

    $column = 0;
    if ($compe){
        if($alldata[2][$column] == 1){
            $str = $str."<td rowspan=\"2\" class=\"eagle\">".$alldata[2][$column]."</td>";
        }
        else {
            $str = $str."<td rowspan=\"2\">".$alldata[2][$column]."</td>";
        }    
        $column++;

        $column++;  # 飛ばす(outの下)
        $str = $str."<td>".$alldata[2][$column]."</td>";    # Par
        $column++;
    
        for($kk = 0;$kk < 10; $kk++){
            $str = $str."<td>".$alldata[2][$column]."</td>";
            $column++;
        }
        $column++;  # 飛ばす(inの下)
    
        $str = $str."<td>".$alldata[2][$column]."</td>";    # Par
        $column++;    

        for ($mm = 0; $mm  < 11; $mm++){
            $str = $str."<td>".$alldata[2][$column]."</td>";
            $column++;       
        }
    
        $str = $str."<td rowspan=\"2\">".$alldata[2][$column]."</td>";  # HDCP
        $column++;
        $str = $str."<td rowspan=\"2\">".$alldata[2][$column]."</td>";  # NET
        #$column++;
        #$str = $str."<td rowspan=\"2\">".$alldata[2][$column]."</td>";  # 記事
    }
    else {
        $column++;  # 飛ばす(outの下)
        $str = $str."<td>".$alldata[2][$column]."</td>";    # Par
        $column++;
    
        for($kk = 0;$kk < 10; $kk++){
            $str = $str."<td>".$alldata[2][$column]."</td>";
            $column++;
        }
        $column++;  # 飛ばす(inの下)
    
        $str = $str."<td>".$alldata[2][$column]."</td>";    # Par
        $column++;    

        for ($mm = 0; $mm  < 11; $mm++){
            $str = $str."<td>".$alldata[2][$column]."</td>";
            $column++;       
        }
    }
    $str = $str."</tr>".PHP_EOL;
    #var_dump($str); echo "<br>";
    fputs($outptr,$str);

    #4行目
    $str = "\t\t<tr>";
    $column = 0;

    if ($compe){
        $column++;    
        $column++;
        # Score
        $str = $str."<td>".$alldata[3][$column]."</td>";
        $column++;

        for($nn = 0; $nn < 9;$nn++){        # 前半9ホールスコア
            if ($alldata[3][$column] <> ""){
                $subb = (int)$alldata[2][$column] - (int)$alldata[3][$column];
                if ($subb <= 0){
                    $str = $str."<td>".$alldata[3][$column]."</td>";
                }
                else if($subb == 1){
                    $str = $str."<tdclass=\"birdie\">".$alldata[3][$column]."</td>";
                }
                else {
                    $str = $str."<td class=\"eagle\">".$alldata[3][$column]."</td>".PHP_EOL;
                }    
            }
            else {
                $str = $str."<td></td>";
            }
            $column++;
        }
    
        if ($alldata[3][$column] <> ""){
            if ($alldata[3][$column] < 40){
                $str = $str."<td class=\"eagle\">".$alldata[3][$column]."</td>";
            }
            else {
                $str = $str."<td>".$alldata[3][$column]."</td>";
            }
        }
        else {
            $str = $str."<td></td>";
        }
        $column++;
        $column++;  # 一つ飛ばす(inの下)

        # Score
        $str = $str."<td>".$alldata[3][$column]."</td>";
        $column++;

        for($pp = 0; $pp < 9;$pp++){        # 後半成績
            If ($alldata[3][$column] <> ""){
                $subb = (int)$alldata[2][$column] - (int)$alldata[3][$column];
                if ($subb <= 0){
                    $str = $str."<td>".$alldata[3][$column]."</td>";
                }
                else if($subb == 1){
                    $str = $str."<td class=\"birdie\">".$alldata[3][$column]."</td>";
                }
                else {
                    $str = $str."<td class=\"eagle\">".$alldata[3][$column]."</td>";
                }
            }
            else {
                $str = $str."<td></td>";
            }
            $column++;
        }

        if ($alldata[3][$column] <> ""){
            if ($alldata[3][$column] < 40){
                $str = $str."<td class=\"eagle\">".$alldata[3][$column]."</td>";
            }
            else {
                $str = $str."<td>".$alldata[3][$column]."</td>";
            }    
        }
        else {
            $str = $str."<td></td>";
        }
        $column++;

        if ($alldata[3][$column] <> ""){
            if ($alldata[3][$column] < 80){
                $str = $str."<td class=\"eagle\">".$alldata[3][$column]."</td>";
            }
            else {
                $str = $str."<td>".$alldata[3][$column]."</td>";
            }
        }
        else {
            $str = $str."<td></td>";
        }
    }
    else {
        $column++;
        # Score
        $str = $str."<td>".$alldata[3][$column]."</td>";
        $column++;

        for($nn = 0; $nn < 9;$nn++){        # 前半9ホールスコア
            if ($alldata[3][$column] <> ""){
                $subb = (int)$alldata[2][$column] - (int)$alldata[3][$column];
                if ($subb <= 0){
                    $str = $str."<td>".$alldata[3][$column]."</td>";
                }
                else if($subb == 1){
                    $str = $str."<tdclass=\"birdie\">".$alldata[3][$column]."</td>";
                }
                else {
                    $str = $str."<td class=\"eagle\">".$alldata[3][$column]."</td>".PHP_EOL;
                }    
            }
            else {
                $str = $str."<td></td>";
            }
            $column++;
        }
    
        if ($alldata[3][$column] <> ""){
            if ($alldata[3][$column] < 40){
                $str = $str."<td class=\"eagle\">".$alldata[3][$column]."</td>";
            }
            else {
                $str = $str."<td>".$alldata[3][$column]."</td>";
            }
        }
        else {
            $str = $str."<td></td>";
        }
        $column++;
        # Score
        $column++;  # 一つ飛ばす(inの下)
        $str = $str."<td>".$alldata[3][$column]."</td>";
        $column++;
        for($pp = 0; $pp < 9;$pp++){        # 後半成績
            If ($alldata[3][$column] <> ""){
                $subb = (int)$alldata[2][$column] - (int)$alldata[3][$column];
                if ($subb <= 0){
                    $str = $str."<td>".$alldata[3][$column]."</td>";
                }
                else if($subb == 1){
                    $str = $str."<td class=\"birdie\">".$alldata[3][$column]."</td>";
                }
                else {
                    $str = $str."<td class=\"eagle\">".$alldata[3][$column]."</font></td>";
                }
            }
            else {
                $str = $str."<td></td>";
            }
            $column++;
        }

        if ($alldata[3][$column] <> ""){
            if ($alldata[3][$column] < 40){
                $str = $str."<td class=\"eagle\">".$alldata[3][$column]."</td>";
            }
            else {
                $str = $str."<td>".$alldata[3][$column]."</td>";
            }    
        }
        else {
            $str = $str."<td></td>";
        }
        $column++;

        if ($alldata[3][$column] <> ""){
            if ($alldata[3][$column] < 80){
                $str = $str."<td class=\"eagle\">".$alldata[3][$column]."</td>";
            }
            else {
                $str = $str."<td>".$alldata[3][$column]."</td>";
            }
        }
        else {
            $str = $str."<td></td>";
        }
        #$column++;
        #$str = $str."<td>".$alldata[3][$column]."</td>";
    }    
    $str = $str."</tr>".PHP_EOL;
    #var_dump($str); echo "<br>";

    fputs($outptr,$str);
    $str = "\t</tbody>".PHP_EOL;
    fputs($outptr,$str);
    $str = "</table>".PHP_EOL;
    fputs($outptr,$str);

    fclose($outptr);
    # ファイルマージ
    # 挿入位置
    
    copy("C:\\Users\\kjyos\\OneDrive\\fcweb\\html\\seiseki.html", $holdero."infile.html");

    $inptr = fopen($holdero."infile.html","r");
    $outputptr = fopen($holderc."output.html","w");
    $midptr = fopen($holdero."mid.html","r");
    
    while($line = fgets($inptr)){
        if(str_contains($line, "<main>") !== FALSE){

            fputs($outputptr, $line);
            while($insert = fgets($midptr)){
                fputs($outputptr, $insert);
            }
        }
        else{
            fputs($outputptr, $line);
        }
    }    

    fclose($inptr);
    fclose($outputptr);
    fclose($midptr);
}
catch(Exception $excn){
    echo '<p>',"エラー発生==>".$exn->getMessage(),'</p>';    
    exit;
}

echo "<p>処理を終了しました。作成されたファイル {$holderc}output.html を確認。<br>問題なければcopyseiseki.html実行</p>";

