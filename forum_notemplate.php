<html>
<head>
    <link rel="shortcut icon" href="/wordpress/infophoto/intro/start.png" />
    <title>Forum | Health Up</title>
</head>
</html>
<?php
session_start();
?>
<h4 style="color: green;">Main Discussion:</h4>
<style>
    #header {
        background-color:darkred;
        color:white;
        text-align:center;
        padding:5px;
    }
    #nav {
        line-height:30px;
        background-color:#eeeeee;
        height:300px;
        width:100px;
        float:left;
        padding:5px;

    }
    #nava {
        line-height:30px;
        background-color:#eeeeee;
        height:100px;
        width:100px;
        float:left;
        padding:5px;
    }
    #section {

        float:left;
        padding:10px;
    }
    #footer {
        background-color:black;
        color:white;
        clear:both;
        text-align:center;
        padding:5px;
    }
</style>
<?php
//db connection
$dbLocalhost = mysql_connect("localhost", "root", "") or die("Could not connect: " . mysql_error());
mysql_select_db("healthquizup", $dbLocalhost) or die("Could not find database: " . mysql_error());
$dbQuestions = mysql_query("SELECT * FROM wp_forum_questions", $dbLocalhost) or die("Problem reading table: " . mysql_error());

$count = 1;
while ($arrQuestions = mysql_fetch_array($dbQuestions)) {

    echo '<div id="header"><h3 style="color:white;">Thread ' . $count . '</h3></div>';
    echo '<div id="nav">'. '<span style="color:MidnightBlue;">'.$arrQuestions['display_name'] .'</span>
    <br>'. $arrQuestions['question_postime'] . '</div>';

    if (!empty($arrQuestions['question_images'])) {
        echo '<div id="section"><p>' . $arrQuestions['questions'] .
             '</p><img  width="200" height="200"src="data:image;base64,'.$arrQuestions['question_images'].' ">'.
             '<Br>
    <a href="/wordpress/make-a-reply/">Make a reply</a></div>';
    } else {
        echo '<div id="section"><p>' . $arrQuestions['questions'] .
            '</p><Br><a href="/wordpress/make-a-reply/">Make a reply</a></div>';
    }

    echo '<div id="footer">Replies</div>';
    $_SESSION['replyno'] = $arrQuestions['question_id'];

    $dbAnswers = mysql_query
    ("SELECT * FROM wp_forum_answers Where question_id ='" . $_SESSION['replyno'] . "'", $dbLocalhost)
    or die("Problem reading table: " . mysql_error());

    while ($arrAnswers = mysql_fetch_array($dbAnswers)) {
        echo '<div id="nava">'. '<span style="color:MidnightBlue;">'.$arrAnswers['display_name'] .'</span><br>'
            . $arrAnswers['answer_postime'] . '</div>';
        if (!empty($arrAnswers['answer_images'])) {
            echo '<div id="section"><p>' . $arrAnswers['answers'] .
                '</p><img  width="200" height="200"src="data:image;base64,'.$arrAnswers['answer_images'].' "> '.'</div>';
        } else {
            echo '<div id="section"><p>' . $arrAnswers['answers'] . '</p></div>';
        }
        echo '<div id="footer"></div>';
    }
    $count ++;
    echo "<br><Br>";
    unset($_SESSION['replyno']);
}
?>

&nbsp;
&nbsp;
&nbsp;
<form action="/wordpress/discussion-2/" method="post"><input type="submit" value="POST A THREAD" /></form>