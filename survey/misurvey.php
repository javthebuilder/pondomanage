<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8"/>
  <title> MI Survey Board </title>

  <link href="css/bootstrap.css" rel="stylesheet"/>
  <link href="css/font-awesome.css" rel="stylesheet"/>
  <link href="css/rating.css" rel="stylesheet"/>
  <link href="css/bbox.css" rel="stylesheet"/>

</head>
<body>
<form action="send_survey.php" method="post">
  <div class="container" style="margin-top:35px">
    <div>
      <img src="img/misfheader.png" height="120" width="500">
    </div>
    <div>
      <img src="img/nameicon.png" height="25" width="30">
      <input type="text" name="name" placeholder="Name (Optional)"><br>

      <img src="img/cardicon.png" height="25" width="30">
      <input type="text" name="cardnumber" placeholder="Card Number" required="yes"><br>
    </div>

    <table border="0">
      <tr>
        <td width="250px">
          <label> Ambiance </label>
          <div class="ratings_ambiance">
            <input types="radio" name="star" id="rating" value="1"/>
            <input types="radio" name="star" id="rating" value="2"/>
            <input types="radio" name="star" id="rating" value="3"/>
            <input types="radio" name="star" id="rating" value="4"/>
            <input types="radio" name="star" id="rating" value="5"/>
          </div>
          <span class="info"></span>
          <input type="hidden" name="ab_score" id="ab_score">
        </td>
        <td width="250x">
          <label> Cleanliness </label>
          <div class="ratings_cleanliness">
            <input types="radio" name="star" id="rating" value="1"/>
            <input types="radio" name="star" id="rating" value="2"/>
            <input types="radio" name="star" id="rating" value="3"/>
            <input types="radio" name="star" id="rating" value="4"/>
            <input types="radio" name="star" id="rating" value="5"/>
          </div>
          <span class="info2"></span>
          <input type="hidden" name="cl_score" id="cl_score">
        </td>
      </tr>
      <tr>
        <td>
          <label> Peripherals </label>
          <div class="ratings_peripherals">
            <input types="radio" name="star" id="rating" value="1"/>
            <input types="radio" name="star" id="rating" value="2"/>
            <input types="radio" name="star" id="rating" value="3"/>
            <input types="radio" name="star" id="rating" value="4"/>
            <input types="radio" name="star" id="rating" value="5"/>
          </div>
          <span class="info3"></span>
          <input type="hidden" name="pr_score" id="pr_score">
          <input type="hidden" name="branch" id="branch" value="<?php echo $_GET['branch']; ?>">
        </td>
        <td>
          <label> Unit Performance</label>
          <div class="likelike">
            <!--
            <a class="like">
            <i class="fa fa-thumbs-o-up"></i>  Like
            <input class="qty1" name="qty1" readonly="readonly" type="text" value="0" />
              </a>
              <a class="dislike">
                  <i class="fa fa-thumbs-o-down"></i> Dislike
                  <input class="qty2"  name="qty2" readonly="readonly" type="text" value="0" />
              </a>
            -->
            <!--
              <br>
              <a class="like">Like</a> <br>
              <a class="dislike">Dislike</a>
              <input class="qty" name="qty" readonly="readonly" type="text" value="0" />
              <input type="button" id="button" value = "button" style= "color:white" onclick="setColor('button', '#101010')";/>

              <a href="#" class="btn btn-info btn-lg">
                <span class="glyphicon glyphicon-thumbs-up"></span> Like
              </a>
      -->       <button type="button" class="btn btn-labeled btn-success" id="like-btn" onclick="like()">
                    <span class="btn-label"><i class="glyphicon glyphicon-thumbs-up"></i></span> Like</button>
                <button type="button" class="btn btn-labeled btn-danger" id="dl-btn" onclick="dislike()">
                    <span class="btn-label"><i class="glyphicon glyphicon-thumbs-down"></i></span> Dislike</button>
                    <input type="hidden" name="up_score" id="up_score">

          </div>
          <div class="likelike2">

            <!--<input type="checkbox" class="likecat"/>
          -->


          </div>
        </td>
      </tr>
    </table>
    <br>
    <label>Game Request</label>
    <div>
      <img src="img/gameicon.png" height="25" width="30">
      <input type="text" name="gamerequest" placeholder=""><br>
    </div>
    <label>Others</label>
    <div class="others">
      <img src="img/nameicon.png" height="25" width="30">
      <input type="text" name="others" placeholder="Staff Name (Optional)"><br>
      <!--<label size="5"> Remarks </label><br>
      ​<textarea id="remarks" name="remarks" rows="10" cols="65"></textarea>-->
      <label for="comment">Remarks:</label> <br>
      <textarea id="comment" name="comment" rows="5" cols="65"></textarea>
    </div>
    <div align="">
      <br>
      <!--<input type="submit" value="Submit">-->
      <button type="submit"  value="Submit" class="btn btn-warning">SUBMIT</button>

      <!--<input type="submit" value="Submit"> -->
    </div>

  </div>
</form>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/rating.js"></script>




  <script>
    var like_score = 0;
    $('.ratings_ambiance').rating(function(vote,event){
      $.ajax({
        method: 'POST',
        url: 'insrating.php',
        data: {vote:vote}
      }).done(function(info){
        $('.info').html("Your vote : <b>"+info+"</b>")
        var s = document.getElementById('ab_score');
        s.value = ""+info+"";

      })
    })
    $('.ratings_cleanliness').rating(function(vote,event){
      $.ajax({
        method: 'POST',
        url: 'insrating.php',
        data: {vote:vote}
      }).done(function(info){
        $('.info2').html("Your vote : <b>"+info+"</b>")
        var s = document.getElementById('cl_score');
        s.value = ""+info+"";

      })
    })
    $('.ratings_peripherals').rating(function(vote,event){
      $.ajax({
        method: 'POST',
        url: 'insrating.php',
        data: {vote:vote}
      }).done(function(info){
        $('.info3').html("Your vote : <b>"+info+"</b>")
        //$('.pr_score').html(info)
        var s = document.getElementById('pr_score');
        s.value = ""+info+"";
        //console.log( s.value);
      })
    })


    $(function(){
      $(".like-btn").click(function(){
          console.log('1');
          //var input = $(this).siblings('.qty');
          //input.val(parseFloat(input.val()) + 1);

      });
      $(".dl-btn").click(function(){
          console.log('0');
          //var input = $(this).siblings('.qty');
          //input.val(parseFloat(input.val()) - 1);
      });

      $(".likecat").click(function(){
          var input = $(this).siblings('.qty');
          input.val(parseFloat(input.val()) - 1);
      });
    });

    // var count = 1;
    // function setColor(btn, color) {
    //     var property = document.getElementById(btn);
    //     if (count == 0) {
    //         property.style.backgroundColor = "#FFFFFF"
    //         count = 1;
    //         console.log(count);
    //     }
    //     else {
    //         property.style.backgroundColor = "#7FFF00"
    //         count = 0;
    //         console.log(count);
    //     }
    // }
    function like() {
        like_score = 1;
      //console.log(like_score);
        var s = document.getElementById('up_score');
        s.value = ""+like_score+"";
    }
    function dislike() {
        like_score = -1;
      //console.log(like_score);
      var s = document.getElementById('up_score');
      s.value = ""+like_score+"";
    }

    function saveData(){
      //console.log('save under');
        var card = $('#card').val()
        var name = $('#nm').val()
        var ambiance = $('#ab').val()
        var cleanliness = $('#cl').val()
        var peripherals = $('#pr').val()
        var ls = like_score
        // var gamerequest = $('#gr').val()
        // var ostaff = $('#osn').val()
        // var oremarks = $('#oremarks').val()
        $.post('server.php?p=add', {id:card, nm:name, cl:cleanliness, pr:peripherals, ls:ls}, function(data){
            //viewData()
            // $('#id').val(' ')
            // $('#nm').val(' ')
            // $('#em').val(' ')
            // $('#hp').val(' ')
            // $('#ad').val(' ')
        })
    }

  </script>
</body>

</html>
