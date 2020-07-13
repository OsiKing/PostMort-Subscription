<?php 
include('templates/header.php');
?>
<section class="showcase">
  <div class="container">
    <div class="pb-2 mt-4 mb-2 ">
      <h2 style="visibility:hidden">Build a Newsletter Email Subscription with PHP and MySQL</h2>
    </div>
    <div class="row">
        <div class="col-sm-12"><span id="success-msg"></span></div>
    </div>
    
    <form  id="newsletter-frm" class="newsletter-frm">
    <input type="hidden" name="action" value="create">
    <div class="row align-items-center">
      <div class="col-sm-6 offset-md-3 sub-form">
        <div>
              <h2 style="text-align: center;" class="text-muted sub-head">SUBSCRIBE NOW</h2>
            </div>
       <div class="form-group">
          <div class="col-sm-12">          
            <input type="text" class="form-control newsletter-name autofocus" id="newsletter-name" placeholder="Enter Name" name="name">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">          
            <input type="text" class="form-control newsletter-email" id="newsletter-email" placeholder="Enter Email" name="email" >
          </div>
        </div> 
        <div class="form-group">        
          <div class="col-sm-offset-2 col-sm-12">
            <button type="button" class="btn btn-info text-center" id="subscribe-newsletter">Subscribe</button>
          </div>
        </div>
    </div>
  </div>
 </form>
</div>
</section>
<?php include('templates/footer.php');?>
<script type="text/javascript">
jQuery(document).on('click', 'button#subscribe-newsletter', function() {
    jQuery.ajax({
        type:'POST',
        url:'action.php',
        data:jQuery("form#newsletter-frm").serialize(),
        dataType:'json',    
        beforeSend: function () {
            jQuery('button#subscribe-newsletter').button('Loding..');
        },  

        complete: function () {
            jQuery('button#subscribe-newsletter').button('reset');
            setTimeout(function () {
                jQuery("form#newsletter-frm")[0].reset();
            }, 2000);
            
        },

        success: function (json) {
            $('.text-danger').remove();
            if (json['error']) {
              jQuery('span#success-msg').html('');            
                for (i in json['error']) {
                    var element = $('.newsletter-' + i.replace('_', '-'));
                    if ($(element).parent().hasClass('input-group')) {                       
                        $(element).parent().after('<div class="text-danger" style="font-size: 14px;">' + json['error'][i] + '</div>');
                    } else {
                        $(element).after('<div class="text-danger" style="font-size: 14px;">' + json['error'][i] + '</div>');
                    }
                }
            } else {
              jQuery('span#success-msg').html('<div class="alert alert-success">You have successfully subscribed to the newsletter</div>');
                
            }                       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });
});
</script>