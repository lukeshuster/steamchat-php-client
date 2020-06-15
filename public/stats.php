<?php
// Post to steam microservice and get user stats
$postRequest = array(
  'steamId' => $_POST['steamId']
);

$cURLConnection = curl_init('https://steamchat-ms.xyz/steam/my_stats');

curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

$apiResponse = curl_exec($cURLConnection);
curl_close($cURLConnection);

$parsed_json = json_decode($apiResponse, true);
if($parsed_json == "error"){
  header("Location: /");
}

require_once("tools.php");
topNav('Steam Chat - My Stats');
?>

<section id = myStats>
<div>
<?php
echo '<img style="display:inline-block;margin: 1px;" src='. $parsed_json['avatar_url'] . '><br>'; 
echo $parsed_json['name'];
?>
</div>
<div>
<table>
  <tr>
      <td>Time Wasted</td>
      <td>
      <?php
      echo $parsed_json['playtime'] . ' hours';
      ?>
      </td>
  </tr>
  <tr>
      <td>Owned Games</td>
      <td>
      <?php
      echo $parsed_json['total'] . ' games';
      ?>
      </td>
  </tr>
  <tr>
      <td>Unplayed Games (less than 10mins played)</td>
      <td>
      <?php
      echo $parsed_json['unplayed'] . ' games';
      ?>
      </td>
  </tr>
</table>
  <?php
    echo $parsed_json['unplayed_percent'] . '% of your library is unplayed!';
  ?>
</div>

<div>
  Top 10 time wasters
  <table>
    <?php
      foreach($parsed_json['top_played'] as $value)
      {
        echo '<tr>';
        echo '<td>' . $value['name'] . '</td>';
        echo '<td>' . $value['playtime'] . ' hours</td>';
        echo '</tr>';
      }
    ?>
  </table>
</div>

<div>
  <form class = steamIdForm action="/compare.php" method="post">
      <?php
        echo '<input type="hidden" id="steamId" name="steamId" value="' . $_POST['steamId'] . '" required><br>';
      ?>
      <input type="submit" class = "button" value="Compare Stats">
  </form>
</div>
</section>

<?php
bottomFooter();
?>
