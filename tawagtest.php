<script>
$(function() {
  var source = new EventSource("testdawat.php");
  source.addEventListener("message", function(event) {
    var data = JSON.parse(event.data);
    var callerid = "7360";
    alert("Incoming call from " + callerid);
  });
});
</script>
Note that this is just a basic example and you may need to customize it to fit your specific requirements. Additionally, you should ensure that your web server and firewall are configured correctly to allow incoming connections from the Asterisk server.





