
$(document).ready(function() {
    //Updating
    $('.edit-row').on('click', function(){
      $('form')[0].reset() // reset the form
      const payload = $(this).data('payload')
  
      $('input[name=name]').removeAttr('required')
      $('input[name=email]').removeAttr('required')
      $('input[name=password]').removeAttr('required')
      $('input[id=confirm_password]').removeAttr('required')
  
      $('input[name=name]').val(payload.name)
      $('input[name=email]').val(payload.email)
      $('form').attr('action', base_url + 'cms/users/update/' + payload.id)
      $('.modal').modal()
    })
  
    // Adding
    $('.add-btn').on('click', function() {
      $('form')[0].reset() // reset the form
  
      $('input[name=name]').attr('required', 'required')
      $('input[name=email]').attr("required", 'required')
      $('input[name=password]').attr("required", 'required')
      $('input[id=confirm_password]').attr("required", 'required')
  
      $('form').attr('action', base_url + 'cms/users/add')
      $('.modal').modal()
    })
  
    //Deleting
    $('.btn-delete').on('click', function(){
  
      let p = prompt("Are you sure you want to delete this? Type DELETE to continue", "");
      if (p === 'DELETE') {
        const id = $(this).data('id')
  
        invokeForm(base_url + 'cms/users/delete', {id: id});
      }
  
    })
  
    $('form').on('submit', function (){
  
      let p = $('input[name=password]').val()
      let cp = $('input[id=confirm_password]').val()
  
      if (!(p === cp)) {
        alert('Passwords don\'t match')
        return false
      }
  
    })
  
  })