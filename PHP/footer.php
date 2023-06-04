<style>
  <?php include '../../CSS/footer.css'; ?>
</style>
<style>
  .modal-dialog.large {
    width: 80% !important;
    max-width: unset;
  }

  .modal-dialog.mid-large {
    width: 50% !important;
    max-width: unset;
  }
</style>


<script>
  // $('.datepicker').datepicker({
  // 	format:"yyyy-mm-dd"
  // })
  window.start_load = function() {
    $('body').prepend('<div id="preloader2"></div>')
  }
  window.end_load = function() {
    $('#preloader2').fadeOut('fast', function() {
      $(this).remove();
    })
  }
  $(document).ready(function() {
    $('#uni_modal').on('show.bs.modal', function() {
      $(document).on('click', function(e) {
        if (!$(e.target).closest('.modal-content').length && $('.modal-content').is(':visible')) {
          $('#uni_modal').modal('hide');
        }
      });
    });
  });
  window.uni_modal = function($title = '', $url = '', $size = '') {
    start_load()
    jQuery.ajax({
      url: $url,
      error: err => {
        console.log()
        alert("An error occured")
      },
      success: function(resp) {
        if (resp) {
          $('#uni_modal .modal-title').html($title)
          $('#uni_modal .modal-body').html(resp)
          if ($size != '') {
            $('#uni_modal .modal-dialog').addClass($size)
          } else {
            $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md")
          }
          $('#uni_modal').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
            focus: true
          })
          end_load()
        }
      }
    })
  }
  // window.uni_modal_right = function($title = '' , $url=''){
  //     start_load()
  //     $.ajax({
  //         url:$url,
  //         error:err=>{
  //             console.log()
  //             alert("An error occured")
  //         },
  //         success:function(resp){
  //             if(resp){
  //                 $('#uni_modal_right .modal-title').html($title)
  //                 $('#uni_modal_right .modal-body').html(resp)

  //                 $('#uni_modal_right').modal('show')
  //                 end_load()
  //             }
  //         }
  //     })
  // }
  window.viewer_modal = function($src = '') {
    start_load()
    var t = $src.split('.')
    t = t[1]
    if (t == 'mp4') {
      var view = $("<video src='" + $src + "' controls autoplay></video>")
    } else {
      var view = $("<img src='" + $src + "' />")
    }
    $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
    $('#viewer_modal .modal-content').append(view)
    $('#viewer_modal').modal({
      show: true,
      focus: true
    })
    end_load()

  }
  window.alert_toast = function($msg = 'TEST', $bg = 'success') {
    $('#alert_toast').removeClass('bg-success')
    $('#alert_toast').removeClass('bg-danger')
    $('#alert_toast').removeClass('bg-info')
    $('#alert_toast').removeClass('bg-warning')

    if ($bg == 'success')
      $('#alert_toast').addClass('bg-success')
    if ($bg == 'danger')
      $('#alert_toast').addClass('bg-danger')
    if ($bg == 'info')
      $('#alert_toast').addClass('bg-info')
    if ($bg == 'warning')
      $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    $('#alert_toast').toast({
      delay: 3000
    }).toast('show');
  }
  window._conf = function($msg = '', $func = '', $params = []) {
    $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")")
    $('#confirm_modal .modal-body').html($msg)
    $('#confirm_modal').modal('show')
  }
</script>

<div class="footer">
  <div class="footer-content">

    <div class="footer-section about">
      <h1 id="text">About Website</h1>
      <p id="text">This site represents an online helpdesk for SKIT students.<br>It allows
        students to raise their queries and let faculty members guide them. </p>
    </div>
    <div class="footer-section links"></div>
    <div id="footerimgW">
      <a href="https://web.whatsapp.com/" target="_blank"><img src="../../IMAGES/whatapp.jpg" width="30px" height="30px"></a>
      <a href="https://www.youtube.com/" target="_blank"><img src="../../IMAGES/youtube.png" width="30px" height="30px"></a>
      <a href="https://www.facebook.com/" target="_blank"><img src="../../IMAGES/facebook.png" width="30px" height="30px"></a>
    </div>
  </div>
  <div class="footer-bottom" id="text">
    &copy;Techies
  </div>
</div>