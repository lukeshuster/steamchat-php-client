<?php
header("Access-Control-Allow-Origin: *");
session_start();
// get user name and picture
$postRequest = array(
    'steamId' => $_SESSION['steamId']
  );
$cURLConnection = curl_init('https://steamchat-ms.xyz/steam/get_user_profile');
curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
$apiResponse = curl_exec($cURLConnection);
curl_close($cURLConnection);
$parsed_json = json_decode($apiResponse, true);

// Post to chat microservice and get chatRoom data
$_SESSION['appId'] = $_GET['appId'];
$_SESSION['gameName'] = $_GET['gameName'];
$_SESSION['name'] = $parsed_json['players'][0]['personaname'];
$_SESSION['avatar_url'] = $parsed_json['players'][0]['avatar'];

// pull values and print to the top cause why not
require_once("tools.php");
topNav('Steam Chat - Chat');
echo "App ID= " . $_GET['appId'] . "</br>";
echo "Steam ID= " . $_SESSION['steamId'] . "</br>";
echo "Name= " . $_SESSION['name']  . "</br>";
echo "Game Name= " . $_SESSION['gameName']. "</br>";

?>
<section id="chatForm">
    <div>
        Chat
        <table id="chatMessage">
        </table>
    </div>
    <form id="sendForm" class="form-group" style="position: fixed; bottom: 10%; width: 100%">
        <input type="text" name="message" placeholder="Enter Message">
        <input type="hidden" name="appId" value="<?php echo $_SESSION['appId']?>">
        <input type="hidden" name="steamId" value="<?php echo $_SESSION['steamId']?>">
        <input type="hidden" name="name" value="<?php echo $_SESSION['name']?>">
        <input type="hidden" name="avatar_url" value="<?php echo $_SESSION['avatar_url']?>">
        <button value="submit" type="submit">Send</button>
    </form>
</section>
<?php
// $messageCh = curl_init('http://localhost:5000/sendMessage');
// curl_setopt($messageCh, CURLOPT_POSTFIELDS, $messagePost);
// curl_exec($messageCh);
// curl_close($messageCh);
bottomFooter();
?>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>

<script type='text/javascript'>
    var displayedMessages = [];
     $(document).on('ready', function(e) {
         e.preventDefault();
         e.stopImmediatePropagation();
        $('#sendForm').on("submit", function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            $.ajax({
                headers: {'Access-Control-Allow-Origin' : '*'},
                url: "https://steamchat-ms.xyz/chat/sendMessage",
                data: $('form').serialize(),
                type : 'POST'
            })
            this.reset();
        })
         $.ajax({
             headers: {'Access-Control-Allow-Origin' : '*'},
             url: 'https://steamchat-ms.xyz/chat/add_chatRoom',
             data: $('form').serialize(),
             type: "POST",
             success: function (data){
                 $.each(data, function(i, item){
                     displayedMessages.push(item.timestamp)
                     var $tr = $('<tr>').append(
                         $('<td>').text(item.displayTime),
                         $('<td>').html('<img src="'+item.avatar_url+'">'),
                         $('<td>').text(item.name),
                         $('<td>').text(item.message)
                     ).appendTo('#chatMessage')
                 })
                 console.log(data)
             }
         })
         setTimeout(loadDelay, 2000)
         function loadDelay() {
             pollServer()
             function pollServer() {
                 var isActive = true;
                 if (isActive) {
                     $.ajax({
                         headers: {'Access-Control-Allow-Origin': '*'},
                         url: 'https://steamchat-ms.xyz/chat/updateChat',
                         data: $("form").serialize(),
                         type: "POST",
                         success: function (data) {
                             $.each(data, function (i, item) {
                                 if (displayedMessages.includes(item.timestamp) === false) {
                                     displayedMessages.push(item.timestamp)
                                     var $tr = $('<tr>').append(
                                         $('<td>').text(item.displayTime),
                                         $('<td>').html('<img src="'+item.avatar_url+'">'),
                                         $('<td>').text(item.name),
                                         $('<td>').text(item.message)
                                     ).appendTo('#chatMessage')
                                 }
                             })
                             console.log(data)
                             pollServer()
                         }
                     })
                 }
             }
         }
    })
</script>
