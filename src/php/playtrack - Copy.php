<html>
<head>
<style>
body {
font-size:12px;font-family:verdana,Helvetica,sans-serif;
}
div#video_player_box{ width:700px; background:#000; margin:0px auto;}
div#video_controls_bar{ background: #333; padding:10px; color:#CCC;display:none;}
</style>
</head>
<body>

<?php
include 'connsrvr.php';

$phpCntxtVal = $_GET['cntxtVal'];

//$test = $_GET['test'];

//echo $phpCntxtVal ."<br><br>";

$tmpArr = explode($dlmtr1,$phpCntxtVal);

$trckArr = explode($dlmtr2,$tmpArr[0]);
$usrArr = explode($dlmtr2,$tmpArr[1]);
//$tranArr = explode($dlmtr2,$tmpArr[2]); //modified multiple tranID

$currTimeVal = "00:00";
$durTimeVal = "00:00";

/*
echo $tmpArr[0] ."<br><br>";
echo $tmpArr[1] ."<br><br>";
*/

//echo "hello world";

$arr = explode($dlmtr3,$trckArr[0]);
$TrackID = $arr[1];

$arr = explode($dlmtr3,$trckArr[1]);
$tmpval = $arr[1];
$TrackTitle = preg_replace('|_|',' ',$tmpval);

$arr = explode($dlmtr3,$trckArr[2]);
$TrackSrc = $arr[1];

$trckSrc = siteURL() .$TrackSrc;

/*
echo "<br><br>" .$TrackID ."<br><br>";

echo "<br><br>" .$TrackTitle ."<br><br>";

echo "<br><br>" .$TrackSrc ."<br><br>";

echo "<br><br>" .$trckSrc ."<br><br>";
*/

$arr = explode($dlmtr3,$usrArr[0]);
$UsrID = $arr[1];

$arr = explode($dlmtr3,$usrArr[1]);
$UsrName = $arr[1];

/*
echo "<br><br>" .$UsrID ."<br><br>";
echo "<br><br>" .$UsrName ."<br><br>";

echo "<br><br>" .$tranArr[0] ."<br><br>";
echo "<br><br>" .$tranArr[1] ."<br><br>";
*/

$tracktranArr = [];
//echo "testing<br>";

//$filename = '/path/to/foo.txt';

if (file_exists($tranlogfile)) {
    //echo "The file $tranlogfile exists";

    //Retrieve the serialized string from file.
   $fileContents = file_get_contents($tranlogfile);

   //Unserialize the string back into an array.
   $tracktranArr = unserialize($fileContents);

   //End result.
   //var_dump($tracktranArr);

   if (unlink($GLOBALS['tranlogfile'])) {
	//echo "delete file successful";
   } else {
  	//echo "delete file unsuccessful";
   }
} else {
    //echo "The file $tranlogfile does not exist";
}

$cnt = count($tracktranArr);
$tmpArr = "";
$arr = "";
$rowID = 0;

if ($cnt == 0) { 
	echo "";
} else {
    //echo var_dump($tracktranArr) . "<br>";

    echo "<table style='display:none;'>";

    for ($i=0;$i<$cnt;$i++) {
	$tmpArr = $tracktranArr[$i];

        $tranArr = explode($dlmtr2,$tmpArr);

        $arr = explode($dlmtr3,$tranArr[0]);
        $tranID = $arr[1];

        $arr = explode($dlmtr3,$tranArr[1]);
        $tranTrckID = $arr[1];

        $arr = explode($dlmtr3,$tranArr[2]);
        $tranCurrTime = $arr[1];

/*
        if ($TrackID == $tranTrckID) {
            $timeArr = explode("/",$tranCurrTime);
	    $currTimeVal = $timeArr[0];
	    $durTimeVal = $timeArr[1];
	} else {
	    //skip
	}
*/

	$rowID = $rowID+1;

	if ($TrackID == $tranTrckID) {
	    echo "<tr style='background:white;'>";

	    echo "<td>" .$rowID ."</td>";

            echo "<td>" .$TrackID ."</td>";

            echo "<td>" .$tranID ."</td>";

	    	echo "<td>" .$tranTrckID ."</td>";

            echo "<td>" .$tranCurrTime ."</td>";

            echo "</tr>";
            $timeArr = explode("/",$tranCurrTime);
            $currTimeVal = $timeArr[0];
            $durTimeVal = $timeArr[1];
	} else {
            echo "<tr>";

	    echo "<td>" .$rowID ."</td>";

	    echo "<td>" .$TrackID ."</td>";

            echo "<td>" .$tranID ."</td>";

	    echo "<td>" .$tranTrckID ."</td>";

            echo "<td>" .$tranCurrTime ."</td>";

	    echo "</tr>";
	}
    }
    echo "</table>";
}

/*
echo "<br><br>" .$TrackID ."<br><br>";

echo "<br><br>" .$tranTrckID ."<br><br>";

echo "<br><br>" .$currTimeVal ."<br><br>";

echo "<br><br>" .$durTimeVal ."<br><br>";
*/
if ($currTimeVal == $durTimeVal) {
$currTimeVal = "00:00";
} 

?>
<center>
<form id="frmTrack" name="frmTrack" method=post action="posttrack.php">
<table id="tblPlay">
<tr id="trckrw1">
<td id="trckrw1cl1" style="width:100%;padding:5px;text-align:center;" colspan="3"> 
<label id="lbl" style='font-size:24px;'> <?php echo $TrackTitle ?> </label>
<input type=hidden readonly id="trckTitle" name="trckTitle" value='<?php echo $TrackTitle ?>'></input>
<input type=hidden readonly id="trckSrc" name="trckSrc" value='<?php echo $TrackSrc ?>'></input>
<input type=hidden readonly id="trckID" name="trckID" value='<?php echo $TrackID ?>'></input> 
<input type=hidden readonly id="usrID" name="usrID" value='<?php echo $UsrID ?>'> </input> 
<input type=hidden readonly id="usrName" name="usrName" value='<?php echo $UsrName ?>'> </input> 
</td>
</tr>
<tr id="trckrw2">
<td id="trckrw2cl1" style="width:100%;padding:5px;text-align:left;"> 
<div id="video_player_box">
  <video id="myplayer" width="700" height="400" controls>
     <source src="<?php echo $trckSrc ?>" type="video/mp4">
  </video>
  <div id="video_controls_bar">
     <input type=text id="usrAction" name="usrAction" style="width:70px;border:none;outline:none;" readonly> 
     <input type=text id="trckCurrTime" name="trckCurrTime" style="width:70px;border:none;outline:none;" readonly> </input> 
	<i> / </i>
     <input type=text id="trckDurTime" name="trckDurTime" style="width:70px;border:none;outline:none;" readonly> </input>     
  </div>
</div>
</td>
</tr>
<td>
<input type=text id="tranTrckInfo" name="tranTrckInfo" style="width:700px;height:40px;display:none;"; readonly> </input>
</td>
</table>
</form>
</center>
<script>

var playCounter = 0;
var trckStatus = "";
var trckInfo = "";

var currTimeVal = formatTimeToSeconds('<?php echo $currTimeVal ?>');
var durTimeVal = formatTimeToSeconds('<?php echo $durTimeVal ?>');

var vid, txtcurtime, txtdurtime, usrtran;

intializePlayer();

function intializePlayer() {
	// Set object references
	vid = document.getElementById("myplayer");
	txtcurtime = document.getElementById("trckCurrTime");
	txtdurtime = document.getElementById("trckDurTime");
	usrtran = document.getElementById("usrAction");

	// Add event listeners
	vid.addEventListener("timeupdate",seektimeupdate,false);
	vid.addEventListener("click",playPause,false);
	vid.addEventListener("play",playPause,false);
	vid.addEventListener("pause",playPause,false);

	vid.currentTime = currTimeVal;

	txtcurtime.value = formatTime(vid.currentTime);
        if (isNaN(vid.duration) == true) {
	    txtdurtime.value = formatTime(durTimeVal);
	} else {
	    txtdurtime.value = formatTime(vid.duration);
        }
	
	//alert("current time : " + txtcurtime.value);
	//alert("Duration time : " + txtdurtime.value);
	
	if (txtcurtime.value == txtdurtime.value) {
	   vid.currentTime = 0;
	}
        trckStatus = "Play";
	usrtran.value = trckStatus;
	//alert("Action: " + trckStatus);
}
//window.onload = intializePlayer;

function playPause() {
trckStatus = "";
txtcurtime.value = formatTime(vid.currentTime);
txtdurtime.value = formatTime(vid.duration);

if (vid.paused) {
trckStatus = "Pause"
} else {
trckStatus = "Play";
}

if (txtcurtime.value == txtdurtime.value) {
trckStatus = "Stop";
}
usrtran.value = trckStatus;
 
//alert(vid.duration);

var myform = document.getElementById("frmTrack");
if (trckInfo == "") {
trckInfo = "Action~" + usrtran.value + "|" + "TranCurrTime~" + formatTime(vid.currentTime) + "/" + formatTime(vid.duration);
} else {
trckInfo = trckInfo + "||" + "Action~" + usrtran.value + "|" + "TranCurrTime~" + formatTime(vid.currentTime) + "/" + formatTime(vid.duration);
}
//alert(trckInfo);
var tempX = document.getElementById("tranTrckInfo");
tempX.value = trckInfo;


if (playCounter == 0) {
//skip
} else {
myform.submit();
}
playCounter = playCounter + 1;
}

function formatTimeToSeconds(strTime) {
var arr = strTime.split(":");
if (arr.length == 2) {
var hrs = "00";
var mins = arr[0];
var secs = arr[1];
} else {
var hrs = arr[0];
var mins = arr[1];
var secs = arr[2];
}

var secsVal = (parseInt(hrs)*3600) + (parseInt(mins)*60) + (parseInt(secs));
return secsVal;
}

function formatTime(timeVal) {
if (Number.isNaN(timeVal)) {
tmpTimeVal = "00:00";
} else {
var tmphrs = Math.floor(timeVal / 3600);
var tmpmins = Math.floor(timeVal / 60);
var tmpsecs = Math.floor(timeVal - tmpmins * 60);
var tmpTimeVal = "0";

if(tmphrs < 10){ tmphrs = "0"+tmphrs; }
if(tmpmins < 10){ tmpmins = "0"+tmpmins; }
if(tmpsecs < 10){ tmpsecs = "0"+tmpsecs; }

if (tmphrs == "00") {
tmpTimeVal = tmpmins + ":" + tmpsecs;
} else {
tmpTimeVal = tmphrs + ":" + tmpmins + ":" + tmpsecs;
}
}
return tmpTimeVal;
}

function vidSeek() {
	var seekto = vid.duration * (seekslider.value / 100);
	vid.currentTime = seekto;
}

function seektimeupdate() {
	//var nt = vid.currentTime * (100 / vid.duration);
	//seekslider.value = nt;
        var curhr = Math.floor(vid.currentTime / 3600);
	var curmins = Math.floor(vid.currentTime / 60);
	var cursecs = Math.floor(vid.currentTime - curmins * 60);

        var durhr = Math.floor(vid.duration / 3600);
	var durmins = Math.floor(vid.duration / 60);
	var dursecs = Math.floor(vid.duration - durmins * 60);

	if(cursecs < 10){ cursecs = "0"+cursecs; }
	if(dursecs < 10){ dursecs = "0"+dursecs; }
	if(curmins < 10){ curmins = "0"+curmins; }
	if(durmins < 10){ durmins = "0"+durmins; }
	if(curhr < 10){ curhr = "0"+curhr; }
	if(durhr < 10){ durhr = "0"+durhr; }

	if (curhr == "00" && durhr == "00") {
	    txtcurtime.value = curmins+":"+cursecs;
	    txtdurtime.value = durmins+":"+dursecs;
	} else {
	      txtcurtime.value = curhr+":"+curmins+":"+cursecs;
	      txtdurtime.value = durhr+":"+durmins+":"+dursecs;
	}

	if (txtcurtime.value == txtdurtime.value) {
	    usrtran.value = "Pause";
	}
}

</script>

</body>
</html>