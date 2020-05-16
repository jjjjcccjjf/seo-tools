<style>
  .rbutt {
    height: 20px;
    width: 20px;
    padding: 0px;
    background: #2e8ed0;
    float: right;
    margin-left: 5px;
    border-radius: 110px;
  }
  .blefty {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }
  .brighty {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0; margin-left:-4px
  }
</style>
<br>  
<br>  
<footer class="site-footer" style="position: fixed;
  left: 0;
  bottom: 0; width:100%">
    <div class="text-center">
    	<!-- <div class="pull-left" style="margin-left:15px">pagination</div> -->
      <div class="pull-left" style="margin-left:15px; color:gainsboro">
        <h5><i class="fa fa-wrench"></i> Tools Panel</h5>
      </div>
    	<div class="pull-right" style="margin-right:15px">

        <!-- <form enctype="multipart/form-data" method="post" action="<?php echo base_url('cms/link_builds/import/' . $this->session->id)?>">
          <input type="file" name="lb_upload_links" style="display:none">
        </form> -->


        <?php if ($this->session->role == 'link_builder'): ?>
          
        <form enctype="multipart/form-data" method="post" action="<?php echo base_url('cms/link_builds/import_append/' . $this->session->id)?>">
          <input type="file" name="lb_upload_links_append" style="display:none">
        </form>

        <form enctype="multipart/form-data" method="post" action="<?php echo base_url('cms/link_builds/import_update/' . $this->session->id)?>">
          <input type="file" name="lb_upload_links_update" style="display:none">
        </form>

        <a href="<?php echo base_url('uploads/import_template.csv') ?>">
          <button data-placement="top" data-toggle="tooltip" data-original-title="Download basic template for adding to collection"
        class="tooltips blefty btn btn-md btn-info">Download Template <div class="rbutt"><i class="fa fa-question"></i></div></button></a>
        <button 
        data-placement="top" data-toggle="tooltip" data-original-title="Append a whole set of links to the current collection.
        Webpage link & Landing page link combinations must be unique. 
        To use, download the template file first from Download Template button."
        class="tooltips brighty btn btn-md btn-success uplinks_append">Append Links <div class="rbutt"><i class="fa fa-question"></i></div></button></button>
    		<!-- <button class="btn btn-md btn-success uplinks">Upload Links (Replace)</button> -->
    		<a href="<?php echo base_url('cms/link_builds/export/' . $this->session->id) ?>">
          <button class="blefty btn btn-md btn-info tooltips"
          data-placement="top" data-toggle="tooltip" data-original-title="Export Links for updating" 
          >Export Links 
            <div class="rbutt"><i class="fa fa-question"></i></div>
          </button>
        </a>
        <button data-placement="top" data-toggle="tooltip" data-original-title="Update/Modify current collection of link builds.
        Webpage link & Landing page link combinations must be unique. 
        To use, download the template file first from Export Links button." class="tooltips brighty btn btn-md btn-success uplinks_update">Update Links 
          <div class="rbutt"><i class="fa fa-question"></i></div>
        </button>

        <a href="<?php echo base_url('cms/link_builds/export_report/' . $this->session->id) ?>">
          <button class="btn btn-md btn-warning tooltips"
          data-placement="top" data-toggle="tooltip" data-original-title="Download CSV for reporting purposes only" 
          >Download Report
            <div class="rbutt"><i class="fa fa-question"></i></div>
          </button>
        </a>
    	</div>
    
      <?php endif ?>



      <!-- admin  -->
      <?php if ($this->session->role == 'administrator'): ?>
        <a href="<?php echo base_url('cms/link_builds/export_report_all/' . $this->session->id) ?>">
          <button class="btn btn-md btn-warning tooltips"
          data-placement="top" data-toggle="tooltip" data-original-title="Download Complete CSV for reporting purposes only" 
          >Download Full Report
            <div class="rbutt"><i class="fa fa-question"></i></div>
          </button>
        </a>
      <?php endif ?>



        <!-- <a href="#" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a> -->
    </div>
</footer>
<!--main content end-->


<script>
	$(document).ready(function() {
    // REPLACE
    // $('.uplinks').on('click', function() { 
    //   $('input[name=lb_upload_links]').click() 
    // })

    // $('input[name=lb_upload_links]').on('change', function(){
    //   $sure = prompt('Are you sure you want to REPLACE ENTIRE selection? [Y/N]')
    //   if ( $sure == 'Y' || $sure == 'y')
    //   $(this).parent().submit()
    // })


    // Append
    $('.uplinks_append').on('click', function() { 
      $('input[name=lb_upload_links_append]').click() 
    })

    $('input[name=lb_upload_links_append]').on('change', function(){
      $sure = prompt('Are you sure you want to APPEND to selection? [Y/N]')
      if ( $sure == 'Y' || $sure == 'y')
      $(this).parent().submit()
    })

    // Update
    $('.uplinks_update').on('click', function() { 
      $('input[name=lb_upload_links_update]').click() 
    })

    $('input[name=lb_upload_links_update]').on('change', function(){
      $sure = prompt('Are you sure you want to UPDATE current selection? [Y/N]')
      if ( $sure == 'Y' || $sure == 'y')
      $(this).parent().submit()
    })
	});
</script>