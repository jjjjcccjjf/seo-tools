
$(document).ready(function() {
    //Updating
  
    $('form').on('submit', function (){
  
      let p = $('input[name=password]').val()
      let cp = $('input[id=confirm_password]').val()
  
      if (!(p === cp)) {
        alert('Passwords don\'t match')
        return false
      }
  
    })
  
  })