<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="main">
        <div class="main-wordinput">
            <form action="index.php" method="post">
                <div class="main-wordinput-eng">
                    <div class="main-wordinput-eng-text">
                        WORD
                    </div>
                    <div class="main-wordinput-eng-input">
                        <input type="text" name="word-eng">
                    </div>
                </div>

                <div class="main-wordinput-breakline"> <!--
                    LITERALLY JUST A SPACE BETWEEN TWO BLOCKS -->
                </div>
                
                <div class="main-wordinput-transl">
                    <div class="main-wordinput-transl-text">
                        TRANSLATION
                    </div>
                    <div class="main-wordinput-transl-input">
                        <input type="text" name="word-transl"/>
                    </div>
                </div>

                <div class="main-wordinput-breakline"></div>

                <div class="main-wordinput-lower">
                    <div class="main-wordinput-lower-submit">
                        <!-- <button>SUBMIT</button> -->
                        <input type="submit" name="word-submit" value="SUBMIT">
                    </div>

                    <div class="main-wordinput-lower-console">
                        <div class="main-wordinput-lower-console-bg">
                            <p>CONSOLE</p>
                        </div>
                        <div class="main-wordinput-lower-console-text">
                            <p>
                                <?php
                                    if (isset($_POST["word-submit"])) {
                                        if ($_POST["word-eng"] != "" && $_POST["word-transl"] != "") {
                                            $filename = "./words.txt";
                                            $file = file($filename);
                                            $new_text = "";
                                            $words = [];
                                            foreach ($file as $line) {
                                                $new_text = $new_text . $line;
                                                
                                                $splitted = explode("@", $line);
                                                array_push($words, [$splitted[0], $splitted[1]]);
                                            }

                                            if (!in_array([$_POST["word-eng"], $_POST["word-transl"]], $words)) {
                                                $new_text = $new_text . $_POST["word-eng"] . "@" .
                                                            $_POST["word-transl"] . "@" . 0 . "@\n";
                                            } else {
                                                echo $_POST["word-eng"] . " " . $_POST["word-transl"] . " EXISTS";
                                            }

                                            file_put_contents($filename, $new_text);
                                            $filename_n2 = "./allwords/words-copy.txt";
                                            file_put_contents($filename_n2, $new_text);
                                        }
                                    }
                                ?>
                            </p>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>

        <!-- <div class="main-breakline"></div> -->

        <!-- <div class="main-nextpage">
            <div class="main-nextpage-checker">
                <a href="./checker/checker.php"><button>KNOWLEDGE CHECK</button></a>
            </div>
        </div> -->
        
        <div class="main-links">
            <a href="./index.php">
                <div class="main-links-someotheridkwhat nomarginbottom">
                    <p>RELOAD PAGE</p>
                </div>
            </a>

            <a href="./checker/checker.php">
                <div class="main-links-addwords nomargintop">
                    <p>KNOWLEDGE CHECK</p>
                </div>
            </a>

            <a href="./allwords/allwords.php">
                <div class="main-links-seeallwords">
                    <p>CHECK ALL WORDS</p>
                </div>
            </a>
        </div>
    </div>

    <!-- <form action="index.php" method="post">
        <input type="text" name="text" id="text1">
        <input type="submit" value="SUBMIT!!!" name="submit">
    </form>
    <?php
        // if (isset($_POST["submit"])) {
        //     echo "oifgasdiofasdgofiasdhfuighasdio";
        // }
    ?> -->
</body>
</html>