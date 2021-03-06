
$(document).ready(function() {
    //Updating
    $('.edit-row').on('click', function(){
      $('form')[0].reset() // reset the form
      const payload = $(this).data('payload')
  
      $('input[name=account_name]').removeAttr('required')
      $('input[name=webpage_link]').removeAttr('required')
      $('input[name=landing_page_link]').removeAttr('required')
      $('input[name=keywords]').removeAttr('required')
      $('input[name=strategies]').removeAttr('required')
      $('textarea[name=notes]').removeAttr('required')
  
      $('input[name=account_name]').val(payload.account_name)
      $('input[name=webpage_link]').val(payload.webpage_link)
      $('input[name=landing_page_link]').val(payload.landing_page_link)
      $('input[name=keywords]').val(payload.keywords)
      $('input[name=strategies]').val(payload.strategies)
      $('textarea[name=notes]').val(payload.notes)

      $('form').attr('action', base_url + 'cms/link_builds/update/' + $(this).data('id'))
      $('.modal').modal()
    })
  
    // Adding
    $('.add-btn').on('click', function() {
      $('form')[0].reset() // reset the form
  
      $('input[name=account_name]').attr('required', 'required')
      $('input[name=webpage_link]').attr("required", 'required')
      $('input[name=landing_page_link]').attr("required", 'required')
      // $('input[name=keywords]').attr("required", 'required')
      // $('textarea[name=notes]').attr("required", 'required')
  
      $('form').attr('action', base_url + 'cms/link_builds/add')
      $('.modal').modal()
    })
  
    //Deleting
    $('.btn-delete').on('click', function(){
  
      if (confirm('Are you sure you want to delete this?')) {
        const id = $(this).data('id')
  
        invokeForm(base_url + 'cms/link_builds/delete', {id: id});
      }
  
    })

    $('select[name=account_name]').on('change', function(){
      window.location.href = window.location.href.split('?')[0] + "?account_name=" + $(this).val()
    })
 
  
  })