<?php
// Post to steam microservice and get global stats
$postRequest = array(
    'steamId' => $_POST['steamId']
);


$cURLConnection = curl_init('https://steamchat-ms.xyz/steam/global_stats');

curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

$apiResponse = curl_exec($cURLConnection);
curl_close($cURLConnection);

$parsed_json = json_decode($apiResponse, true);
if($parsed_json == "error"){
    header("Location: /");
}

require_once("tools.php");
topNav('Steam Chat - Compare Stats');
?>

<section class = globalStats>
    <h1 style="width:100%;margin:auto;text-align:center;">Top 10 User Stats</h1>
    <table>
        <tr>
            <th class = cell>Games Owned</th>
            <th class = cell>Hours Wasted</th>
            <th class = cell>% Library Played</th>
        </tr>
        <tr>
            <td class = cell>
                <?php
                    foreach($parsed_json['global_game_count'] as $value)
                    {
                    echo '<div>';
                    echo '<table><tr>';
                    echo '<td><img style="display:inline-block;margin: 1px;" src='. $value['avatar_url'] . '></td>'; 
                    echo '<td><table>';
                    echo '<tr><td>' . $value['steamId'] . '</td></tr>';
                    echo '<tr><td>' . $value['game_count'] . ' games owned</td></tr>';
                    echo '</table></td>';
                    echo '</tr></table>';
                    echo '</div>';
                    }
                ?>
            </td>
            <td class = cell>
                <?php
                    foreach($parsed_json['global_playtime'] as $value)
                    {
                    echo '<div>';
                    echo '<table><tr>';
                    echo '<td><img style="display:inline-block;margin: 1px;" src='. $value['avatar_url'] . '></td>'; 
                    echo '<td><table>';
                    echo '<tr><td>' . $value['steamId'] . '</td></tr>';
                    echo '<tr><td>' . $value['playtime'] . ' hours wasted</td></tr>';
                    echo '</table></td>';
                    echo '</tr></table>';
                    echo '</div>';
                    }
                ?>
            </td>
            <td class = cell>
                <?php
                    foreach($parsed_json['global_play_percent'] as $value)
                    {
                    echo '<div>';
                    echo '<table><tr>';
                    echo '<td><img style="display:inline-block;margin: 1px;" src='. $value['avatar_url'] . '></td>'; 
                    echo '<td><table>';
                    echo '<tr><td>' . $value['steamId'] . '</td></tr>';
                    echo '<tr><td>' . $value['played_percent'] . '% played library</td></tr>';
                    echo '</table></td>';
                    echo '</tr></table>';
                    echo '</div>';
                    }
                ?>
            </td>
        </tr>
    </table>
</section>

<hr>

<section class = globalStats>
    <h2 style="width:30%;margin:auto;text-align:center;">Your Rankings</h2>
    <table>
        <tr>
            <th class = cell>
                Games Owned
            </th>
            <th class = cell>
                Hours Wasted
            </th>
            <th class = cell>
                % Library Played
            </th>
        </tr> 
        <tr>
            <td class = cell>
                <table><tr>
                    <?php
                        echo '<td><img style="display:inline-block;margin: 1px;" src='. $parsed_json['user_stats']['avatar_url'] . '></td>'; 
                        echo '<td><table>';
                        echo '<tr><td>' . $parsed_json['user_stats']['name'] . '</td></tr>';
                        echo '<tr><td>Rank ' . $parsed_json['user_stats']['game_count_rank'][0]['rank'] . '</td></tr>';
                        echo '<tr><td>' . $parsed_json['user_stats']['game_count_rank'][0]['game_count'] . ' games owned</td></tr>';
                        echo '</table></td>';
                    ?>
                </tr></table>
            </td>
            <td class = cell>
                <table><tr>
                    <?php
                        echo '<td><img style="display:inline-block;margin: 1px;" src='. $parsed_json['user_stats']['avatar_url'] . '></td>'; 
                        echo '<td><table>';
                        echo '<tr><td>' . $parsed_json['user_stats']['name'] . '</td></tr>';
                        echo '<tr><td>Rank ' . $parsed_json['user_stats']['playtime_rank'][0]['rank'] . '</td></tr>';
                        echo '<tr><td>' . $parsed_json['user_stats']['playtime_rank'][0]['playtime'] . ' hours wasted</td></tr>';
                        echo '</table></td>';
                    ?>
                </tr></table>
            </td>
            <td class = cell>
                <table><tr>
                    <?php
                        echo '<td><img style="display:inline-block;margin: 1px;" src='. $parsed_json['user_stats']['avatar_url'] . '></td>'; 
                        echo '<td><table>';
                        echo '<tr><td>' . $parsed_json['user_stats']['name'] . '</td></tr>';
                        echo '<tr><td>Rank ' . $parsed_json['user_stats']['play_percent_rank'][0]['rank'] . '</td></tr>';
                        echo '<tr><td>' . $parsed_json['user_stats']['play_percent_rank'][0]['play_percent'] . '% played library</td></tr>';
                        echo '</table></td>';
                    ?>
                </tr></table>
            </td>
        </tr>   
    </table>
</section>
<?php
bottomFooter();
?>
