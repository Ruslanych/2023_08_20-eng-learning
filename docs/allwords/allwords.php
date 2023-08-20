<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="allwords.css">
</head>
<body>
    <div class="main">
        <div class="main-words">
            <form action="allwords.php" method="post">
                <div class="main-words-cont">
                    <?php
                        
                        if (isset($_POST["save-changes"])) {
                            $filename = "./words-copy.txt";
                            $filename_n2 = "../words.txt";
                            $text = "";
                            for ($i = 0; $i < count(file($filename)); $i++) {
                                if ($_POST["word-eng-$i"] != "" && $_POST["word-transl-$i"] != "") {
                                    if ($_POST["word-coeff-$i"] == "") {
                                        $text = $text .
                                                $_POST["word-eng-$i"] . "@" .
                                                $_POST["word-transl-$i"] . "@" .
                                                0 . "@\n";
                                    } else {
                                        $text = $text .
                                                $_POST["word-eng-$i"] . "@" .
                                                $_POST["word-transl-$i"] . "@" .
                                                $_POST["word-coeff-$i"] . "@\n";
                                    }
                                }
                            }
                            file_put_contents($filename, $text);
                            file_put_contents($filename_n2, $text);
                            
                            // $file = "../words.txt";
                            // $file_copy = "words-copy.txt";
                            // $text = "";
                            // foreach (file($file_copy) as $line) {
                            //     $text = $text . $line;
                            // }
                            // file_put_contents($file, $text);
                        } elseif (isset($_POST["undo-changes"])) {
                            $file = "../words.txt";
                            $file_copy = "words-copy.txt";
                            $text = "";
                            foreach (file($file) as $line) {
                                $text = $text . $line;
                            }
                            file_put_contents($file_copy, $text);
                        } elseif (isset($_POST["local-save"])) {
                            $filename = "./words-copy.txt";
                            $text = "";
                            for ($i = 0; $i < count(file($filename)); $i++) {
                                if ($_POST["word-eng-$i"] != "" && $_POST["word-transl-$i"] != "") {
                                    if ($_POST["word-coeff-$i"] == "") {
                                        $text = $text .
                                                $_POST["word-eng-$i"] . "@" .
                                                $_POST["word-transl-$i"] . "@" .
                                                0 . "@\n";
                                    } else {
                                        $text = $text .
                                                $_POST["word-eng-$i"] . "@" .
                                                $_POST["word-transl-$i"] . "@" .
                                                $_POST["word-coeff-$i"] . "@\n";
                                    }
                                }
                            }
                            file_put_contents($filename, $text);
                        }
                        
                        $filename = "./words-copy.txt";
                        $file = file($filename);
                        $echo_txt = "";
                        for ($i = 0; $i < count($file); $i++) {
                            $line = $file[$i];
                            $exploded = explode("@", $line);
                            $added_txt = "";
                            $added_txt = $added_txt . "<div class='main-words-cont-word'>\n";
                            $added_txt = $added_txt . "    <div class='main-words-cont-word-eng'>\n";
                            $added_txt = $added_txt . "        <input type='text' name='word-eng-$i' value='$exploded[0]'>\n";
                            $added_txt = $added_txt . "    </div>\n";
                            $added_txt = $added_txt . "    <div class='main-words-cont-word-transl'>\n";
                            $added_txt = $added_txt . "        <input type='text' name='word-transl-$i' value='$exploded[1]'>\n";
                            $added_txt = $added_txt . "    </div>\n";
                            $added_txt = $added_txt . "    <div class='main-words-cont-word-coeff'>\n";
                            $added_txt = $added_txt . "        <input type='text' name='word-coeff-$i' value='$exploded[2]'>\n";
                            $added_txt = $added_txt . "    </div>\n";
                            $added_txt = $added_txt . "</div>\n";
                            $echo_txt = $added_txt. $echo_txt;
                        }
                        echo $echo_txt;
                    ?>
                    <div class="main-words-cont-save">
                        <input type="submit" value="LOCAL SAVE CHANGES" name="local-save">
                    </div>
                </div>
                <div class="main-words-savebutton">
                    <input type="submit" value="UNDO ALL CHANGES" name="undo-changes">
                    <input type="submit" value="SAVE CHANGES" name="save-changes" class="red_bg">
                </form>
            </div>
        </div>
        <div class="main-links">
            <a href="../index.php">
                <div class="main-links-addwords nomargintop">
                    <p>ADD MORE WORDS</p>
                </div>
            </a>

            <a href="../checker/checker.php">
                <div class="main-links-checker">
                    <p>KNOWLEDGE CHECK</p>
                </div>
            </a>
            
            <a href="./allwords.php">
                <div class="main-links-someotheridkwhat nomarginbottom">
                    <p>RELOAD PAGE</p>
                </div>
            </a>
        </div>
    </div>
</body>
</html>