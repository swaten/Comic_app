<html>

<head>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <style>
  .textdanger{
    color:#b50d0d !important;
  }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Comic</a>


  </nav>

  <div class="container pt-4" id="forms">

    <div class="row">
        <form class="col-md-7 " name="subscribe_form" id="subscribe_form">
          <div class="form-group">
            <label for="exampleInputEmail1">Add Email For Subscribe</label>
            <input type="email" class="form-control" id="email_id" name="email_id" aria-describedby="emailHelp" placeholder="Enter email">

          </div>


          <button type="submit" class="btn btn-primary" id="submit" name="submit" >Subscribe</button>
        </form>
    </div>
  </div>
  <div class="container pt-4" id="welcome" style="display:none">

    <div class="row">
        <div class="col-md-12">
        <form class="col-md-12 " name="unsubscribe_form" id="unsubscribe_form">
          <center>
            <h3>Welcome </h3>
            <label id="email_subscribed" ></label><br/>
            <input type='hidden' name='subscribed_id' id='subscribed_id'>
            <button type="submit" class="btn btn-primary" id="submit" name="unsubscribe" >Unsubscribe the email</button>

          </center>
        </form>

        </div>
    </div>
  </div>
@include('jsplugins')
</body>

<script>

$(function(){


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

       // Form-submit-jquery
        $('#subscribe_form').submit(function(e){
           e.preventDefault();

             $.ajax({

                  url:'subscribe_form',
                  type:'POST',
                  dataType:'json',
                  data: new FormData(this),
                  //data:form_id.serialize(),
                  processData:false,
                  contentType:false,
                  cache:false,
                  async:false,
                  success:function(data)
                  {
                    $('#forms').hide();
                    $('#email_subscribed').html(data.email_id);
                    $('#subscribed_id').val(data.email_id);
                    $('#welcome').show();


                  },
                  error:function (data){

                         if(data.status="422"){

                          $.each(data.responseJSON.errors,function(field_name,error){
                              $(document).find('[name='+field_name+']').after('<span class="text-strong textdanger">' +error+ '</span>')
                            })
                        }
                    }


                });
        });
        // Form-submit-jquery

        $('#unsubscribe_form').submit(function(e){
           e.preventDefault();

             $.ajax({

                  url:'unsubscribe_form',
                  type:'POST',
                  dataType:'json',
                  data: new FormData(this),
                  //data:form_id.serialize(),
                  processData:false,
                  contentType:false,
                  cache:false,
                  async:false,
                  success:function(data)
                  {
                    alert(data.msg);
                    $('#forms').show();

                    $('#welcome').hide();


                  },
                  error:function (data){

                         if(data.status="422"){

                          $.each(data.responseJSON.errors,function(field_name,error){
                              $(document).find('[name='+field_name+']').after('<span class="text-strong textdanger">' +error+ '</span>')
                            })
                        }
                    }


                });
        });



});
</script>

</html>
