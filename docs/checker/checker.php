<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./checker.css">
</head>
<body>
    <?php
        $filename = "../words.txt";
        $file = file($filename);
        $words = [];
        $tmp_arr = [];
        $max_num = 1;
        foreach ($file as $line) {
            $exploded = explode("@", $line);
            $max_num = max($max_num, $exploded[2]);
            array_push($tmp_arr,
                        [$exploded[0], $exploded[1]]);
        }
        for ($i = 0; $i < count($tmp_arr); $i++) { 
            for ($j = $tmp_arr[$i]; $j < $max_num; $j++) {
                array_push($words, $tmp_arr[$i]);
            }
        }
    ?>
    <div class="main">
        <div class="main-checker">
            <?php
                $state_started = false;
                $state_changeword = 0;

                $state_lang = explode("@", file("tmp.txt")[0])[3]; // 0-eng | 1-ru | 2-both
                // $state_lang = 0;

                $words_tmp = [];
                $words = [];

                if (isset($_POST["checker-button-eng"])) {
                    $state_started = true;
                    $state_transl_shown = false;
                    $state_word_chosen = false;
                    $state_lang = 0;
                    $state_changeword = 0;
                } elseif (isset($_POST["checker-button-ru"])) {
                    $state_started = true;
                    $state_transl_shown = false;
                    $state_word_chosen = false;
                    $state_lang = 1;
                    $state_changeword = 0;
                } elseif (isset($_POST["checker-button-both"])) {
                    $state_started = true;
                    $state_transl_shown = false;
                    $state_word_chosen = false;
                    $state_lang = 2;
                    $state_changeword = 0;
                }
                if (isset($_POST["main-checher-showanotherword"])) {
                    $state_started = true;
                    $state_transl_shown = true;
                    $state_word_chosen = true;
                    $state_changeword = 0;
                }
                if (isset($_POST["main-checker-showbuttons-n1"]) || isset($_POST["main-checker-showbuttons-n2"])) {
                    $state_started = true;
                    $state_transl_shown = false;
                    $state_word_chosen = false;

                    if (isset($_POST["main-checker-showbuttons-n1"])) {
                        $state_changeword = 1;
                    } elseif (isset($_POST["main-checker-showbuttons-n2"])) {
                        $state_changeword = -1;
                    }
                    
                }


                if ($state_started) {
                    if (!$state_word_chosen) {
                        $filename = "../words.txt";
                        $file_main = file($filename);
                        $words_tmp = [];
                        $words = [];
                        $max_num = -9999;
                        foreach ($file_main as $line) {
                            $exploded = explode("@", $line);
                            array_push($words_tmp,
                                        $exploded);
                            $max_num = max($max_num, $exploded[2]);
                        }
                        for ($i = 0; $i < count($words_tmp); $i++) {
                            $exploded_line = $words_tmp[$i];

                            for ($j = $exploded_line[2]; $j <= $max_num; $j++) {
                                // echo $i . " ";
                               array_push($words, $i);
                            }
                            echo "\n";
                        }

                        // print_r($words);
                        // print_r($words_tmp);
                        $rand_num = random_int(0, count($words) - 1);
                        $rand_index = $words[$rand_num];
                        $text_tmp = $words_tmp[$rand_index][0] . "@" .
                                    $words_tmp[$rand_index][1] . "@" .
                                    $words_tmp[$rand_index][2] . "@" .
                                    $state_lang;
                        $file_tmp = file("tmp.txt");
                        $num_old = explode("@", $file_tmp[0])[2];
                        // echo $num_old;

                        if ($state_changeword != 0) {
                            $new_text = "";
                            for ($i = 0; $i < count($words_tmp); $i++) {
                                if ($i != $num_old) {
                                    $new_text = $new_text .
                                            $words_tmp[$i][0] . "@" .
                                            $words_tmp[$i][1] . "@" .
                                            $words_tmp[$i][2] . "@\n";
                                } else {
                                    $new_text = $new_text .
                                            $words_tmp[$i][0] . "@" .
                                            $words_tmp[$i][1] . "@" .
                                            ($words_tmp[$i][2] + $state_changeword) . "@\n";
                                }
                            }
                            // echo $new_text;
                            file_put_contents($filename, $new_text);
                            $filename_n2 = "../allwords/words-copy.txt";
                            file_put_contents($filename_n2, $new_text);
                        }

                        file_put_contents("tmp.txt", $text_tmp);
                    }

            ?>
                <div class="main-checker-wordchecker">
                    <?php
                        $file = file("tmp.txt");
                        foreach ($file as $line) {
                            $exploded = explode("@", $line); break;
                        }
                        echo $exploded[0];
                    ?>
                </div>
                <div class="main-checker-translation">
                    <?php
                        if ($state_transl_shown) {
                            echo $exploded[1];
                        } else {
                    ?>
                        <form action='checker.php' method='post'>
                            <input type='submit' value='Show the word' name='main-checher-showanotherword'>
                        </form>
                    <?php
                        }
                    ?>
                    <!-- <form action="checker.php" method="post">
                        <input type='submit' value='Show the word' name='main-checher-showanotherword'>
                    </form> -->
                </div>
                <?php
                    if ($state_transl_shown) {
                ?>
                    <div class="main-checker-showbuttons">
                        <!-- <div class="main-checker-showbuttons-n1">
                            SUCCESS
                        </div>
                        <div class="main-checker-showbuttons-n2">
                            FAIL
                        </div> -->
                        <form action="checker.php" method="post">
                            <input type="submit"
                                   value="SUCCESS"
                                   class="main-checker-showbuttons-n1"
                                   name="main-checker-showbuttons-n1">
                            <input type="submit"
                                   value="FAIL"
                                   class="main-checker-showbuttons-n2"
                                   name="main-checker-showbuttons-n2">
                        </form>
                    </div>
                <?php
                    }
                ?>
            <?php
                } else {
            ?>
                <form action="checker.php" method="post">
                    <div class="main-checker-startbutton">
                        <input type="submit" value="START ENG" name="checker-button-eng">
                    </div>
                    <div class="main-checker-startbutton">
                        <input type="submit" value="START RU" name="checker-button-ru">
                    </div>
                    <div class="main-checker-startbutton">
                        <input type="submit" value="START BOTH" name="checker-button-both">
                    </div>
                </form>
            <?php
                }
            ?>
        </div>
        <div class="main-splitline"></div>
        <div class="main-links">
            <a href="./checker.php">
                <div class="main-links-someotheridkwhat nomarginbottom">
                    <p>RESTART</p>
                </div>
            </a>

            <a href="../index.php">
                <div class="main-links-addwords nomargintop">
                    <p>ADD MORE WORDS</p>
                </div>
            </a>

            <a href="../allwords/allwords.php">
                <div class="main-links-seeallwords">
                    <p>CHECK ALL WORDS</p>
                </div>
            </a>
        </div>
    </div>
</body>
</html>