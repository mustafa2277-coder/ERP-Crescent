<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ERP | Login</title>
     @yield('css')
    
</head>

    

        @yield('content')
        @yield('js')
<script>
    
    /*setInterval(function(){ 
            var csrfToken = $('[name="csrf_token"]').attr('content');
            $.ajax({
                      url: "http://crescent.cherryberry.website/pos/public/index.php/refreshToken",
                      type: "GET",
                      headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                   },
                     
                      //beforeSend: function() {  $('#payModal').modal('hide'); $('#loading').show();},
                      
                      success: function(data) {
                         console.log('data:'+data);
                         $('input[name="_token"]').val(data);
                      }

                    });
            }, 5000);*/
   
</script> 
    
</body>
</html>
