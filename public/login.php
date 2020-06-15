<?php
require_once("tools.php");
topNav('Steam Chat');

session_start();
$_SESSION = array();
session_destroy();

$cURLConnection = curl_init();
curl_setopt($cURLConnection, CURLOPT_URL, 'https://steamchat-api-b3xftqio3a-uc.a.run.app/get_popular_games');
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
$apiResponse = curl_exec($cURLConnection);
curl_setopt($cURLConnection, CURLOPT_URL, 'https://steamchat-api-b3xftqio3a-uc.a.run.app/get_total_users');
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
$apiResponse2 = curl_exec($cURLConnection);
curl_close($cURLConnection);

$parsed_json= json_decode($apiResponse, true);
$total_users= json_decode($apiResponse2, true);

?>

<section>
  <h1>Welcome to Steam Chat</h1>
  <div>
    <p>Enter your steam ID below. You must have your profile and games set to public to use this app.
    <br>If you just want to demo it try using my steam ID: 76561198038149325</p>
  </div>
</section>

<section>
  <div>
  <form class = steamIdForm action="/search.php" method="post">
        <h2 style="margin-bottom: -2px;">Enter Steam ID:</h2>
        <span>http://steamcommunity.com/profiles/</span>
        <input type="text" id="steamId" name="steamId" required><br>
      <input type="submit" class = "button" value="Chat About Games!">
      <input type="submit" class = "button"value="Wasted on Steam?" formaction="/stats.php">
    </form>
  </div>
</section>
<hr>
<section>
  <div id = mostPopularGame>
    
    <div>
      <table>
        <tr><td><h3 style="margin-bottom: -2px;">Most Popular Game</h3></td></tr>
        <tr>
          <td>
            <?php
              echo '<img src="' . $parsed_json['popular_games'][0]['img_logo_url'] . '" alt="' . $parsed_json['popular_game'][0]['name'] . '">';
            ?>
          </td>
          <td>
            <table>
              <tr><td>
                <?php
                  echo $parsed_json['popular_games'][0]['name'];
                ?>
              </td></tr>
              <tr><td>
                <?php
                  echo floor($parsed_json['popular_games'][0]['count']/$total_users['total_users']*100) . '% of users own this game';
                ?>
              </td></tr>
              <tr><td>
                <?php
                  echo $parsed_json['popular_games'][0]['playtime'] . ' hours have been played across all users';
                ?>
              </td></tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
  </div>
</section>

<?php
bottomFooter();
?>
