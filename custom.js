$(document).ready(function(){
    
    var stopAutohide;
    
    function showWindow(){
        $('#pop-up').show();
        //stop scroll
        $('html body') .css('overflow'.'hidden');

        //auto hide after 5s
        stopAutohide = setTimeout(hideWindow, 10000);


    }
    //showWindow()

    function hideWindow(){
        $('#pop-up').hide();
        //on scroll
        $('html body') .css('overflow'.'scroll');
    }
    //hideWindow()

    //call a function automatically after some time


    //auto open after 2s
    setTimeout(showWindow, 5000);

    //close after click
    $("#close-btn").click(function(){
        hideWindow();
        clearTimeout(stopAutohide);
})


<!--Pop-up-->

<style type="text/css">

#pop-up{
  text-align: center;
  width: 500px;
  height: 400px;
  background: #AE8094;
  box-sizing: border-box;
  padding: 20px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
}

</style>
<div id="pop-main">
    <div id="pop-up">
        <button id='close-btn'>X</button>
        <h1>Title</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Veniam error quae consequatur illo fuga 
            praesentium, provident repellendus est, maxime possimus explicabo exercitationem, molestias adipisci 
            mollitia facere temporibus nihil quia perferendis!</p>
        <h3>Footer</h3>
    </div>
</div>
<script src="custom.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
