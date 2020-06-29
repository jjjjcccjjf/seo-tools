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
  .partial{
    background: rgba(255,165,0,0.55);
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
  td {
    white-space: nowrap;
  }
</style>

<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
      <div class="col-lg-12">
        <section class="panel">
          <header class="panel-heading">
            Link Builds
              <br>  
            Legend:
             <button class="legend-btn btn btn-xs btn-success"></button> Success  
             <button class="legend-btn btn btn-xs btn-danger"></button> Failed
             <button class="legend-btn btn btn-xs btn-warning"></button> Unchecked / Needs rechecking
            <?php if ($flash_msg = $this->session->flash_msg): ?>
              <br><sub style="color: <?php echo $flash_msg['color'] ?>"><?php echo $flash_msg['message'] ?></sub>
              <?php if (isset($flash_msg['records_added'])): ?>
                <br><sub style="color: green">Records added: <?php echo $flash_msg['records_added'] ?></sub> &nbsp; <sub style="color: red">Records rejected: <?php echo $flash_msg['records_rejected'] ?></sub>
              <?php endif ?>
            <?php endif; ?>
            
               <p class="_mess" style="font-weight: 400">Please wait until the background task is finished and please <span style="font-weight: bold">DO NOT</span> try to modify any of your links while the system is checking. This may take a while.</p>
             <!--carousel start-->

              <section class="row">
                  <div id="c-slide" class="carousel slide auto panel-body col-md-7">
                      <ol class="carousel-indicators out">
                          <li class="active" data-slide-to="0" data-target="#c-slide"></li>
                          <!-- <li class="" data-slide-to="1" data-target="#c-slide"></li> -->
                          <!-- <li class="" data-slide-to="2" data-target="#c-slide"></li> -->
                      </ol>
                      <div class="carousel-inner">
                          <div class="item text-center active">
                              <h3><?php echo date('F Y') ?></h3>
                              <small class="text-muted">
                                <span style='color:green'>Successful links: <?php echo @$status_count['success'] ?></span> — 
                                <span style='color:red'>Failed: <?php echo @$status_count['failed'] ?></span> — 
                                <span style='color:orange'>Partial: <?php echo @$status_count['partial'] ?></span> — 
                                <span style='color:#f1c500'>Pending: <?php echo @$status_count['pending'] ?></span> 
                              </small>
                          </div>
                          <!-- <div class="item text-center">
                              <h3>Massive UI Elements</h3>
                              <small class="text-muted">Fully Responsive</small>
                          </div>
                          <div class="item text-center">
                              <h3>Well Documentation</h3>
                              <small class="text-muted">Easy to Use</small>
                          </div> -->
                      </div>
                      <a data-slide="prev" href="#c-slide" class="left carousel-control">
                          <i class="fa fa-angle-left"></i>
                      </a>
                      <a data-slide="next" href="#c-slide" class="right carousel-control">
                          <i class="fa fa-angle-right"></i>
                      </a>
                  </div>
              </section>
              <!--carousel end-->
          </header>
          <div class="panel-body">
            <p>
              <button type="button" class="add-btn btn btn-success btn-sm">Add new</button> 
              <button type="button" id="check_my_links" class="btn btn-info btn-sm" data-user_id='<?php echo $this->session->id ?>'>
                <i class="fa fa-refresh hidy"></i> 
                <img class="hidy2" src="<?php echo base_url('public/admin/img/gear-loader.gif')?>" >
                <span class="hidy">Recheck links</span>
                <span class="hidy2">Checking...</span>
                <span class="hidy3">Redirecting...</span>
               </button> 
             <button class="btn btn-info btn-sm">
                  <label style="margin:0px"> 
                    All &nbsp;<input style="margin:0px" type="radio" name="checky" value="" checked="checked"> 
                  </label> &nbsp;
                  <label style="margin:0px"> 
                    Unchecked only &nbsp;<input style="margin:0px" type="radio" name="checky" value="unchecked_only"> 
                  </label> &nbsp;
                  <label style="margin:0px"> 
                    Failed only &nbsp;<input style="margin:0px" type="radio" name="checky" value="failed_only"> 
                  </label>
              </button>
              <button class="btn btn-sm">
                <select name="account_name">
                  <option disabled selected="selected">Filter by Account Name</option>
                  <?php foreach ($accounts as $value): ?>
                    <option <?php echo ($value->account_name == $this->input->get('account_name')) ? 'selected="selected"': '' ?>><?php echo $value->account_name ?></option>
                  <?php endforeach ?>
                </select>
              </button>
              <a class="btn btn-warning btn-sm" href="<?php echo base_url('cms/link_builds')?>">Clear Filters</a>
            </p>
            <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="1">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Account</th>
                    <th>Webpage</th>
                    <th>Landing Page</th>
                    <th>Keywords</th>
                    <th>Strategies</th>
                    <th>Action</th>
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
                        <th scope="row"><?php echo $i++ ?></th>
                        <td><?php echo $value->account_name ?></td>
                        <td><a target="_blank" href="<?php echo $value->webpage_link ?>"><?php echo $value->webpage_link ?></a></td>
                        <td><a target="_blank" href="<?php echo $value->landing_page_link ?>"><?php echo $value->landing_page_link ?></a></td>
                        <td><?php echo $value->keywords ?></td>
                        <td><?php echo $value->strategies ?></td>
                        <td>
                          <button data-id='<?php echo $value->id; ?>' type="button"
                          data-payload='<?php echo json_encode(['id' => $value->id, 'account_name' => $value->account_name, 'webpage_link' => $value->webpage_link, 'landing_page_link' => $value->landing_page_link, 'keywords' => $value->keywords, 'strategies' => $value->strategies, 'notes' => $value->notes], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)?>'
                          class="edit-row btn btn-info btn-xs"><i class="fa fa-pencil"></i></button> 
                          <button type="button" data-id='<?php echo $value->id; ?>' class="btn btn-delete btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> 
                          <button data-placement="top" data-toggle="tooltip" data-original-title="<?php echo ucwords($value->status) ?>" class="tooltips btn btn-info btn-xs" style="border-radius: 500px;">&nbsp;<i class="fa fa-info">&nbsp;</i></button>
                          </td>
                        </tr>
                      <?php endforeach; ?>


                    <?php else: ?>
                      <tr>
                        <td colspan="7" style="text-align:center">Empty table data</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>

              <!-- pagination -->
              <style>
              .active_lg {
                background: lightgray !important
              }
              </style>
              <ul class="pagination">
                <ul class='pagination'>
                  <?php $page = ($this->input->get('page')) ?: 1; ?>
                  <li><a href="<?php echo base_url('cms/link_builds/') . "?page=1&" . @$filters;?>">&laquo;</a></li>

                  <!-- loop for desc -->
                  <?php for ($i = $page - 2; $i < ($page) ; $i++):
                    if ($i == -1 || $i == 0) {
                      continue;
                    }
                   ?>
                  <li><a href="<?php echo base_url('cms/link_builds/') . "?page=" . $i . "&" . @$filters;?>"><?= $i ?></a></li>
                  <?php endfor; ?>
                  <!-- / loop for desc -->

                  <li><a href="<?php echo base_url('cms/link_builds/') . "?page=" . $page . "&" . @$filters;?>"><?= $page ?></a></li>
                  
                  <!-- loop for asc -->
                  <?php for ($i = $page + 1; $i < ($page + 3) ; $i++):
                  if ($i == $total_pages + 1 || $i == $total_pages + 2) {
                      continue;
                  }
                  ?>
                  <li><a href="<?php echo base_url('cms/link_builds/') . "?page=" . $i . "&" . @$filters;?>"><?= $i ?></a></li>
                  <?php endfor; ?>
                  <!-- / loop for asc -->
                   

                <li><a href="<?php echo base_url('cms/link_builds/') . "?page=" . $total_pages . "&" . @$filters;?>">&raquo;</a></li>
                </ul>
              </ul>
              <!-- pagination -->

              </div>
            </div>
          </section>
        </div>
      </div>
      <!-- page end-->
    </section>
  </section>

  <!-- Modal -->
  <div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Manage</h4>
        </div>
        <div class="modal-body">

          <form role="form" method="post">
            <div class="form-group">
              <label >Account Name</label>
              <input type="text" class="form-control" name="account_name" placeholder="Account Name">
            </div>
            <div class="form-group">
              <label >Webpage Link</label>
              <input type="url" class="form-control" name="webpage_link" placeholder="Webpage link">
            </div>
            <div class="form-group">
              <label >Landing Page Link</label>
              <input type="text" class="form-control" name="landing_page_link" placeholder="Landing page link">
            </div>

            <div class="form-group">
              <label >Keywords</label>
              <input type="text" class="form-control" name="keywords" placeholder="Keywords">
            </div>

            <div class="form-group">
              <label >Strategies</label>
              <input type="text" class="form-control" name="strategies" placeholder="Strategies">
            </div>

            <div class="form-group">
              <label >Notes</label>
              <textarea class="form-control" name="notes" placeholder="Notes"></textarea>
            </div>
            <input type="hidden" name="user_id" value="<?php echo $this->session->id ?>">
            <input type="hidden" name="page" value="<?php echo $this->input->get('page') ?>">

          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            <input class="btn btn-info" type="submit" value="Save changes">
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- modal -->

<?php $this->load->view('cms/footer_importer') ?>
<!--main content end-->

<!-- <script>
  $(document).ready(function($) {
    $('.sidebar-toggle-box').click();
  });
</script> -->
  <script src="<?php echo base_url('public/admin/js/custom/') ?>link_checking_management.js"></script>
  <script src="<?php echo base_url('public/admin/js/custom/') ?>link_builds_management.js"></script>
  <script src="<?php echo base_url('public/admin/js/custom/') ?>generic.js"></script>
