<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width-device-width, initial-scale=1.0">

  <!-- css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/app.css">

  <!-- Javascript -->
  <script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery.js"></script>
  <!-- <script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery.min.js"></script> -->

  <!-- Snap JS -->
  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-_TTUffPMgSQxf_0K"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <title>E-Kado | Raffi - Nagita </title>
</head>

<body>

  <div class="donate">
    <div class="donate-black">
      <h2>Amerta E-Kado</h2>
      <p>Kirimkan angpau secara virtual dengan berbagai metode pembayaran melalui <a href="https://midtrans.com/id/features/payment-methods">midtrans</a></p>
    </div>
    <div class="donate-blue">
      <div class="denomination-email">
        <input type="text" name="email" id="email" placeholder="Masukkan email anda">
      </div>
      <div class="denomination-message">
        <input type="textarea" name="message" id="message" placeholder="Kirimkan pesan terbaikmu untuk kedua mempelai">
      </div>
      <h3>Jumlah E-Angpao*</h3>
      <div class="donate-amount-box">
        <div class="donate-amount">
          <div class="denomination selected">
            <input autocomplete="off" type="radio" name="amount" id="amount5" value="20000" checked="">
            <label for="amount5">Rp. 20.000,-</label>
          </div>
          <div class="denomination">
            <input autocomplete="off" type="radio" name="amount" id="amount10" value="50000">
            <label for="amount10">Rp. 50.000,-</label>
          </div>
          <div class="denomination">
            <input autocomplete="off" type="radio" name="amount" id="amount15" value="100000">
            <label for="amount15">Rp. 100.000,-</label>
          </div>
          <div class="denomination">
            <input autocomplete="off" type="radio" name="amount" id="amount25" value="200000">
            <label for="amount25">Rp. 200.000,-</label>
          </div>
          <div class="denomination">
            <input autocomplete="off" type="radio" name="amount" id="amount50" value="50000">
            <label for="amount50">Rp. 500.000,-</label>
          </div>
          <div class="denomination">
            <input autocomplete="off" type="radio" name="amount" id="amount100" value="1000000">
            <label for="amount100">Rp. 1.000.000,-</label>
          </div>
        </div>
        <div class="denomination-other">
          <input autocomplete="off" type="number" step="10000" name="amount" value="" placeholder="Masukkan Jumlah Lain">
        </div>
      </div>
    </div>
    <div class="donate-blue donate-payment">
      <div class="donate-submit">
        <button type="submit" id="pay-button" name="pay-button" autocomplete="off">Kirimkan Rp. 20000</button>
        <p><small>Anda akan dikenakan biaya admin sesuai dengan cara pembayaran yang anda pilih</small></p>
      
      <form id="payment-form" method="post" action="<?=site_url()?>/snap/finish">
      <input type="hidden" name="result_type" id="result-type" value=""></div>
      <input type="hidden" name="result_data" id="result-data" value=""></div>
      </form>
      </div>
    </div>
  </div>

    <!-- Ammount -->
    <script type="text/javascript">
      $(".denomination").click(function (event) {
        $(".denomination").removeClass("selected").prop("checked", false);
        $(".denomination-other input").removeClass("selected").val("");
        $(this).addClass("selected");
        $(this).children(":first").prop("checked", true);
        $("button").text("Kirimkan Rp. " + $(this).children(":first").val() + ",-");
      });
    
      $(".denomination-other input").on("keypress", function (event) {
        // allow only int values
        // TODO: remove leading 0
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
          event.preventDefault();
          return false;
        }
      
        $(".denomination").removeClass("selected").prop("checked", false);
        $(this).addClass("selected");
        $("button").text("Kirimkan Rp. " + $(this).val() + key + ",-");
      });
      </script>
  

    <script type="text/javascript">
      
      $('#pay-button').click(function (event) {
        event.preventDefault();
        $(this).attr("disabled", "disabled");
      
      var jumlah = $("#pay-button").val();
      var email = $("#email").val();
      var message = $("#message").val();
      $.ajax({
        type: "POST",
        url: '<?=site_url()?>/snap/token',
        data: {
          jumlah:jumlah,
          email:email,
          message:message
        },
        cache: false,

        success: function(data) {
          //location = data;

          console.log('token = '+data);
          
          var resultType = document.getElementById('result-type');
          var resultData = document.getElementById('result-data');

          function changeResult(type,data){
            $("#result-type").val(type);
            $("#result-data").val(JSON.stringify(data));
            //resultType.innerHTML = type;
            //resultData.innerHTML = JSON.stringify(data);
          }

          snap.pay(data, {
            
            onSuccess: function(result){
              changeResult('success', result);
              console.log(result.status_message);
              console.log(result);
              $("#payment-form").submit();
            },
            onPending: function(result){
              changeResult('pending', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            },
            onError: function(result){
              changeResult('error', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            }
          });
        }
      });
    });

    </script>
</body>

</html>