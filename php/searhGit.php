<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 04.09.2018
 * Time: 10:44
// */

if (!empty($_GET["quereArraySend"])) {
    $quereReceived = $_GET["quereArraySend"];
    $reseivedItems = explode(",", $quereReceived);
    $j=0;
    foreach ($reseivedItems as $reseivedItem){
        echo"
        <!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <link rel=\"stylesheet\" href=\"../css/style.css\">
    <title>PHP+JS+HTML test Andreychenko Victor</title>
</head>
<body>
    <div class=\"answer\">
        ";
        echo "<div class='requestTitle'>";
        echo "<h1> request # ".$j." : ".$reseivedItem."</h1>";
        echo "</div>";
        echo "<div class='keys'>
            <h2>#</h2><h2 class='nameH2'>Name</h2><h2 class='urlH2'>URL</h2><h2>Size</h2><h2>Forks</h2><h2>Stars</h2>
        </div>";
$j++;

$url = "https://api.github.com/search/repositories?q=".$reseivedItem;

$context = stream_context_create(
    array(
        "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        )
    )
);

$resp = file_get_contents($url, FALSE, $context);
$data = json_decode($resp);
$i=0;
foreach ($data->items as $item){

    $name = $item->name;
    $html_url = '<a href="'.$item->html_url.'">'.$item->html_url.'</a>';
    $size = $item->size;
    $forks = $item->forks;
    $followers = $item->subscribers_count;
    $stars = $item->watchers;
    echo "<div class='answerLine'>";
    echo '<h2>'.$i.'</h2><h2 class="nameH2">'.$name.'</h2><h2 class="urlH2">'.$html_url.'</h2><h2>'.$size.'</h2><h2>'.$forks.'</h2><h2>'.$stars.'</h2>';
    echo "</div>";

    $i++;
}
    }
    echo "
        </body>
</html>
    ";
}
else { echo "<script>alert('Переменные не дошли. Проверьте все еще раз.');</script>";
    // так получаем URL, с которого пришёл посетитель
    $back = $_SERVER['HTTP_REFERER']; // для справки, не обязательно создавать переменную

// Теперь создаём страницу, пересылающую
// в meta теге на предыдущую
    echo "
    </div>
<html>
  <head>
   <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
  </head>
</html>";
}

/*
**************************** my letter to github *****************
How i can call request for 2 or more params in the one line?

something like this:

https://api.github.com/search/repositories?q=followers:600 and size:500 and stars:400
is there a difference betveen
followers and stars quantity?
I found it is equal, am i wrong?
*************************** github answer *************************
Hey Victor,
You can include multiple parameters using URL formatting, however we do not support colon formatting:

https://api.github.com/search/repositories?q=followers=600&size=500

The stargazers_count and watchers_count fields both refer to the same data point: the number of users who have starred a repository. The number of users who have watched a repository is instead reported in a different field: subscribers_count.

The functionality we refer to today as "starring" was previously known as "watching", before we ever introduced the feature that now goes by that name.

We updated our Web UI to use the new terminology of "starring", but preserved the old terminology alongside the new in our API to avoid breaking existing applications. There's a blog post here that provides some further historical context:

https://developer.github.com/changes/2012-09-05-watcher-api/

I hope this helps!

Best,
Shawna

/***********************************************************************/