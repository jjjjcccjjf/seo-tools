<style>
  .success {
    background: rgba(0,255,0,0.15);
  }
  .failed {
    background: rgba(255,0,0,0.15);
  }
  .pending{
    background: rgba(233,212,96,0.15);
  }
  .legend-btn{
    width:30px;
    margin:0px 3px 0px 3px;
  }
  .hidy2 {
    height:15px;
    width:15px; 
    display:none;
  }
  .hidy3{
    display:none;
  }
  ._mess{
    margin-top:15px;
    display:none;
  }
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
		              		<input type="date" class="form-control filterz" name="from" value="<?php echo $this->input->get('from') ?>">
		              	</div>
		              	<div class="col-md-3">
		              		To
			              	<input type="date" class="form-control filterz" name="to" value="<?php echo $this->input->get('to') ?>">
		              	</div>
                    <div class="col-md-3">
                      Account name
                      <select class="form-control filterz" name="account_name">
                      <option disabled selected="selected">Filter by Account Name</option>
                        <?php foreach ($accounts as $value): ?>
                          <option <?php echo ($value->account_name == $this->input->get('account_name')) ? 'selected="selected"': '' ?>><?php echo $value->account_name ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <br>&nbsp;
                        <a class="btn btn-warning btn-sm" href="<?php echo base_url('cms/link-builder-tool')?>">Clear Filters</a>
                    </div>
		          	</div>
		          </header>
		      </section>
		  </div>
		  <div class="col-lg-12">
		      <section class="panel">
<figure class="highcharts-figure">
    <div id="containerss"></div>
    <p class="highcharts-description"> 
    </p>
</figure>		          
		      </section>
		  </div>
                  <div class="col-lg-12">
                      <section class="panel">
                          <!-- <header class="panel-heading">
                              Advanced Table
                          </header> -->
                          <table class="table table-bordered">
                              <thead>
                              <tr>
                                  <th>Date</th>
                                  <th>Account name</th>
                                  <th>Webpage Link</th>
                                  <th>Landing Page</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php if (count($res) > 0 ): ?>

                              <?php $i = 1; 
                              if ($this->input->get('page') > 1) {
                                $i = ($this->input->get('page') - 1) * 100;
                              }
                              foreach ($res as $key => $value): ?>
                                <tr class="<?php echo $value->status ?>">
                                  <th scope="row"><?php echo $value->created_at_f ?></th>
                                  <td><?php echo $value->account_name ?></td>
                                  <td><a target="_blank" href="<?php echo $value->webpage_link ?>"><?php echo $value->webpage_link ?></a></td>
                                  <td><a target="_blank" href="<?php echo $value->landing_page_link ?>"><?php echo $value->landing_page_link ?></a></td>
                                </tr>
                                <?php endforeach; ?>


                              <?php else: ?>
                                <tr>
                                  <td colspan="4" style="text-align:center">Empty table data</td>
                                </tr>
                              <?php endif; ?>


                              <!-- <tr>
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
                              </tr> -->
                              </tbody>
                          </table>
                      </section>

                                    <!-- pagination -->
              <style>
              .active_lg {
                background: lightgray !important
              }
              </style>
              <ul class="pagination">
                <ul class='pagination'>
                  <?php $page = ($this->input->get('page')) ?: 1; ?>
                  <li><a href="<?php echo base_url('cms/link-builder-tool/') . "?page=1&" . @$filters;?>">&laquo;</a></li>

                  <!-- loop for desc -->
                  <?php for ($i = $page - 2; $i < ($page) ; $i++):
                    if ($i == -1 || $i == 0) {
                      continue;
                    }
                   ?>
                  <li><a href="<?php echo base_url('cms/link-builder-tool/') . "?page=" . $i . "&" . @$filters;?>"><?= $i ?></a></li>
                  <?php endfor; ?>
                  <!-- / loop for desc -->

                  <li><a href="<?php echo base_url('cms/link-builder-tool/') . "?page=" . $page . "&" . @$filters;?>"><?= $page ?></a></li>
                  
                  <!-- loop for asc -->
                  <?php for ($i = $page + 1; $i < ($page + 3) ; $i++):
                  if ($i == $total_pages + 1 || $i == $total_pages + 2 || $total_pages == 0) {
                      continue;
                  }
                  ?>
                  <li><a href="<?php echo base_url('cms/link-builder-tool/') . "?page=" . $i . "&" . @$filters;?>"><?= $i ?></a></li>
                  <?php endfor; ?>
                  <!-- / loop for asc -->
                   

                <li><a href="<?php echo base_url('cms/link-builder-tool/') . "?page=" . $total_pages . "&" . @$filters;?>">&raquo;</a></li>
                </ul>
              </ul>
              <!-- pagination -->
                  </div>

    <!-- page end-->
  </section>
</section>

<script src="<?php echo base_url('public') ?>/code/highcharts.js"></script>
<script src="<?php echo base_url('public') ?>/code/modules/exporting.js"></script>
<script src="<?php echo base_url('public') ?>/code/modules/export-data.js"></script>
<script src="<?php echo base_url('public') ?>/code/modules/accessibility.js"></script>


<script>
  $(document).ready(function($) {
    $('.sidebar-toggle-box').click();
    $('.sidebar-toggle-box').click();

    $('.filterz').on('change', function() {
      window.location.href = window.location.href.split('?')[0] 
      + "?from=" + $('input[name=from]').val() 
      + "&to=" + $('input[name=to]').val() 
      + "&account_name=" + ($('select[name=account_name]').val() ? $('select[name=account_name]').val() : '')
    })
  });
</script>

<script type="text/javascript">
Highcharts.chart('containerss', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Link Builder Stats of <?php echo $this->session->name ?>'
    },
    subtitle: {
        text: 'Links categorized by Month'
    },
    xAxis: {
        categories: [
            <?php foreach ($months as $value) {
              echo "'$value',";
            } ?>
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Links'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    colors: ['rgba(0,255,0,0.55)', 'rgba(255,0,0,0.55)', 'rgba(233,212,96,0.55)'],
    series: [{
        name: 'Success',
        data: [<?php 
            $success_str = '';
            foreach ($success_arr as $value) {
              $success_str .= "$value,";
            } echo rtrim($success_str, ','); ?>]

    }, {
        name: 'Failed',
        data: [<?php 
            $failed_str = '';
            foreach ($failed_arr as $value) {
              $failed_str .= "$value,";
            } echo rtrim($failed_str, ','); ?>]

    }, {
        name: 'Pending',
        data: [<?php 
            $pending_str = '';
            foreach ($pending_arr as $value) {
              $pending_str .= "$value,";
            } echo rtrim($pending_str, ','); ?>]

    }]
});
    </script>
<?php $this->load->view('cms/footer_importer') ?>