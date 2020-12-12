<!DOCTYPE html>
<html> <!-- Watch Later page after sign in/ sign up -->
    <head>
        <title>Watch later - Youtube</title>
        <meta charset="UTF-8">
        <link href="later.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="horizNav">
            <div id="youtubelogo">
                <img src="images/youtube logo.png" alt="youtube logo" id="logo">
            </div>
            <div id="searchBox">
                <form>
                    <input type="text" id="searchText" placeholder="Search">
                    <button id="searchBtn">
                        <img src="images/search logo.png" alt="Search">
                    </button>
                </form>
                
            </div>
            <div id="buttons">

                <?php
				
					$fname = $_REQUEST["fname"];
					$lname = $_REQUEST["lname"];
                    $email = $_REQUEST["email"];
                    $playlist = $_REQUEST["playlist"];
				
                ?>
                
                <input type="button" id="vidImage" onclick="window.location.href = 'upload_vid.php?fname=<?php echo $fname?> &lname=<?php echo $lname?> &email=<?php echo $email?>'">
                <input type="button" id="gridImage">
                <input type="button" id="bellImage">
                <button id="profileImage">

				<?php
					print $fname[0];
					print $lname[0];
				?>

				</button>
            </div>
        </div>

        <?php
            $db = new PDO("mysql:dbname=278project", "root","");
            $rows = $db->query("SELECT *, DATE_FORMAT(upload_date , '%m-%d-%Y') AS upload_date FROM Video WHERE private=0");
            $rows0 = $db->query("SELECT * FROM Channel WHERE owner='$email'");
            $rows01 = $db->query("SELECT * FROM Channel WHERE owner='$email'");
            $rows02 = $db->query("SELECT * FROM Channel WHERE owner='$email'");
        ?>

        <div class="vertNav">
            <ul>
                <li id="homeBtn" onclick="window.location.href = 'homeAfter.php?fname=<?php echo $fname?> &lname=<?php echo $lname?> &email=<?php echo $email?>'">
                    <img src="images/home.png" alt="Home Image">
                    <p>Home</p>
                </li>
                <li id="subBtn" onclick="window.location.href = 'subAfter.php?fname=<?php echo $fname?> &lname=<?php echo $lname?> &email=<?php echo $email?>'">
                    <img src="images/sub.png" alt="Sub Image">
                    <p>Subscriptions</p>
                </li>
                <li id="libBtn" onclick="window.location.href = 'lib_after.php?fname=<?php echo $fname?> &lname=<?php echo $lname?> &email=<?php echo $email?>'">
                    <img src="images/lib.png" alt="Library Image">
                    <p>Library</p>
                </li>
                <li id="historyBtn" onclick="window.location.href = 'History.html?fname=<?php echo $fname?> &lname=<?php echo $lname?> &email=<?php echo $email?>'">
                    <img src="images/hist.png" alt="History Image">
                    <p>History</p>
                </li>
                <li id="urvidBtn" onclick="window.location.href = 'upload_vid.php?fname=<?php echo $fname?> &lname=<?php echo $lname?> &email=<?php echo $email?>'">
                    <img src="images/ur vid.png" alt="Your Vid Image">
                    <p>Your Videos</p>
                </li>
                <li id="laterBtn" onclick="window.location.href = 'later.php?fname=<?php echo $fname?> &lname=<?php echo $lname?> &email=<?php echo $email?>'">
                    <img src="images/later.png" alt="Later Image">
                    <p>Watch Later</p>
                </li>
            </ul>
        </div>

        <div id="prev">
            <div id="name">
                <?php
                    $playlistVids = $db->query("SELECT * FROM PlaylistVideos WHERE playlist=$playlist");
                    foreach($playlistVids as $playlistVid)
                    {
                        $vid = $playlistVid["video"];
                        $videos = $db->query("SELECT * FROM Video WHERE id=$vid");
                        foreach($videos as $video)
                        {
                        ?>
                            <video width="300px">
                                <source src="test_uploads/<?php echo $video["fileName"] ?>" type="video/mp4">
                            </video>
                        <?php
                        break;
                        }
                    break;
                    }
                    $playlists = $db->query("SELECT * FROM Playlist WHERE id=$playlist");
                    foreach($playlists as $playlst)
                    {
                        ?>
                        <p><?= $playlst["title"]?></p>
                        <?php
                    }
                ?>
                
                
            </div>
            <div id="details">
                <span id="vidNbr">
                    <span><?= $db->query("SELECT * FROM PlaylistVideos WHERE playlist=$playlist")->rowCount();?></span>
                    <span> videos • </span>
                </span>
                <span id="lastUpdate">
                    <span>Updated on </span>
                    <?php

                        $playlistVids = $db->query("SELECT *, DATE_FORMAT(playlist_datetime , '%m-%d-%Y') AS playlist_datetime FROM PlaylistVideos WHERE playlist=$playlist ORDER BY playlist_datetime DESC");
                        foreach($playlistVids as $playlistVid)
                        {
                            ?>
                            <span><?= $playlistVid['playlist_datetime']?></span>
                            <?php
                            break;
                        }
                    ?>
                </span>
            </div>
            <?php
            $playlists = $db->query("SELECT * FROM Playlist WHERE id=$playlist");
            foreach($playlists as $playlist)
            {
                if($playlist["private"]==1)
                {
                    ?>
                    <div id="type">
                        <img src="images/lock.png" alt="Lock Image">
                        <span>Private</span>
                    </div>
                    <?php
                }
            }
            ?>
            <div id="actions">
                <input type="button" id="shufflePlay">
                <input type="button" id="moreInfo">
            </div><hr>
            <div id="accountInfo">
            <button id="pImage">

            <?php
                print $fname[0];
                print $lname[0];
            ?>

            </button>
                <span><?= $fname?> <?= $lname?> </span>
            </div>
        </div>

        <div id="laterVids">
            <div id="wrapLater">
            <?php
            foreach($rows01 as $row)
            {
                $pid = $row["id"];
                $rows1 = $db->query("SELECT * FROM WatchLater WHERE viewer=$pid ORDER BY later_datetime DESC");
                foreach($rows1 as $row1)
                {
                    $videoId = $row1["video"];
                    $rows2 = $db->query("SELECT *, DATE_FORMAT(upload_date , '%m-%d-%Y') AS upload_date FROM Video WHERE id='$videoId'");
                    foreach($rows2 as $row2)
                    {
                        $vid = $row2["id"];
                        $chan = $row2["channel"];
                        $channels = $db->query("SELECT * FROM Channel WHERE id=$chan");
                        foreach($channels as $channel)
                        {
                            ?>
                            <button id="videoBtn" onclick="window.location.href = `watchvideo.php?fname=<?php echo $fname?>&lname=<?php echo $lname?>&email=<?php echo $email?>&id=<?php echo $vid?>&playlist=<?= $pid?>`">
                                <video id="watchVideo" width="150px" style="float:left;">
                                    <source src="test_uploads/<?php echo $row2["fileName"] ?>" type="video/mp4">
                                </video>
                                <div id="vidDetails" style="float:left;">
                                
                                <h4><?php echo $row2["title"] ?></h4>
                                <p><?php echo $channel["name"] ?></p>
                                <p>
                                    <?php 
                                        $views = $db->query("SELECT * FROM Views WHERE video=$vid")->rowCount();
                                    ?>
                                    <span><?php echo $views ?> views • </span>
                                    <span><?php echo $row2['upload_date'] ?></span>
                                </p>
                                </div>
                            </button>
                            <?php
                        }
                    }
                }
            }
            ?>
            </div>
        </div>

    </body>
</html>