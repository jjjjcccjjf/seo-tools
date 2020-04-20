
<style>
	th,td {text-align:center;}
</style>
<!--main content start-->
<section id="main-content">
  <section class="wrapper site-min-height">
    <!-- page start-->
		  <div class="col-lg-12">
		  	<section class="panel">
		          <header class="panel-heading">
		          	<div class="row">
		              	<div class="col-md-3">
		              		From
		              		<input type="date" class="form-control" name="from">
		              	</div>
		              	<div class="col-md-3">
		              		To
			              	<input type="date" class="form-control" name="to">
		              	</div>
		          	</div>
		          </header>
		      </section>
		  </div>
		  <div class="col-lg-12">
		      <section class="panel">
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
					<br>		          
		      </section>
		  </div>
                  <div class="col-lg-12">
                      <section class="panel">
                          <!-- <header class="panel-heading">
                              Advanced Table
                          </header> -->
                          <table class="table table-striped table-advance table-hover">
                              <thead>
                              <tr>
                                  <th>Date</th>
                                  <th>Account name</th>
                                  <th>Webpage Link</th>
                                  <th>Landing Page</th>
                                  <th>Status</th>
                              </tr>
                              </thead>
                              <tbody>
                              <tr>
                                  <td>Date</td>
                                  <td>Account name </td>
                                  <td>http://example.com</td>
                                  <td>http://example.com</td>
                                  <td>
                                  	  <button class="btn btn-md">Success</button> &nbsp;
                                      <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                      <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                      <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                                  </td>
                              </tr>
                              </tbody>
                          </table>
                      </section>
                  </div>

    <!-- page end-->
  </section>
</section>

<script>
  $(document).ready(function($) {
    $('.sidebar-toggle-box').click();
  });
</script>
<?php $this->load->view('cms/footer_importer') ?>