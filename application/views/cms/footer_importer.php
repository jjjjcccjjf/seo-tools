<footer class="site-footer" style="position: fixed;
  left: 0;
  bottom: 0; width:100%">
    <div class="text-center">
    	<div class="pull-left" style="margin-left:15px">pagination</div>
    	<div class="pull-right" style="margin-right:15px">
        <form enctype="multipart/form-data" name="lb_form" method="post" action="<?php echo base_url('cms/link_builds/import/' . $this->session->id)?>">
          <input type="file" name="lb_upload_links" style="display:none">
        </form>
        <a href="<?php echo base_url('uploads/import_template.csv') ?>"><button class="btn btn-md btn-success">Download Empty Template</button></a>
    		<button class="btn btn-md btn-success uplinks">Upload Links</button>
    		<button class="btn btn-md btn-success">Export Report</button>
    	</div>
        <!-- <a href="#" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a> -->
    </div>
</footer>
<!--main content end-->


<script>
	$(document).ready(function() {
    $('.uplinks').on('click', function() { 
      $('input[name=lb_upload_links]').click() 
    })

    $('input[name=lb_upload_links]').on('change', function(){
      $sure = prompt('Are you sure you want to replace ENTIRE selection? [Y/N]')
      if ( $sure == 'Y' || $sure == 'y')
      $(this).parent().submit()
    })
	});
</script>