$('.ajaxsubmit').click(function(e)
{
    e.preventDefault();

    //check required fields

    //rename buttons
    var submitButtin = $(this);
    submitButtin.addClass('m-progress disabled').prop('disabled', true);

    var theform = $(this).closest(".ajaxform");

    $.ajax({
        type:"POST",
        url: theform.attr('action'),
        data:theform.serialize(),
        dataType:"json",
        cache:false,
        beforeSend: function()
		{
            $(".preloader").hide().show();
            $(".alert-success").hide();
            $(".alert-warning").hide();
            $(".alert-danger").hide();
            $(".alert-default").hide();
            $(".alert-primary").hide();
            $(".required").removeClass("redBorder");
        },

        success:function(data)
		{
            submitButtin.removeClass("m-progress disabled").prop('disabled', false);

            if(data.response == true)
            {
                $("#formholder").slideUp();
                theform.find(".alert-success").delay(300).slideDown();
            }

            if(data.response == false)
            {
                theform.find(".alert-warning").delay(300).slideDown().text(data.message);
                console.log(data.errors);
                // errors are found
                if(data.errors.length <= 1)
                {
                    $.each(data.errors, function(i, item){
						console.log(data.errors[i]);
                        theform.find('#'+data.errors[i]).addClass("redBorder");
                        theform.find('#'+data.errors[i]+'_alt').show();
                    });
                }
            }

			if(data.response =="error")
            {
                theform.find(".alert-danger").delay(300).slideDown();
            }


            if(data.redirect == true)
			{
                // similar behavior as an HTTP redirect
                window.location.replace(data.redirect_url);

                // similar behavior as clicking on a link
                //window.location.href = "http://stackoverflow.com";
            }

        }

    });//end ajax

});

//ajax info
$("#doi_submit").click(function(e)
{
    e.preventDefault();
    var theFormAction = $('#doi_submit').closest('form').attr('action');
    var doi = $("#doi_check").val();
    //alert('the doi:'+ doi);
    $.ajax({
        type:"POST",
        url: theFormAction,
        dataType:"json",
        data:{ doi:doi },
        cache:false,
        beforeSend: function()
        {
            $(".w3loader").hide().show();
            $(".error").hide();
            $(".success").hide();
            $("#doi_results").hide();
            $("#upload_doi").hide();
            $(".alert").hide();
        },

        success: function(result)
        {
            $(".w3loader").hide();

            if ( result.title === null || result.title == false || result.title === '' || result.title ==="null" )
            {
                $(".error").show();
            }
            else
            {
                //the paper is found
                $("#upload_doi").show();
                $("#doi_results").delay(300).slideDown(500);

                $.each(result, function(key, value)
                {
                    console.log(key, value);
                    if(value != null || value != false || value !='' || value !='null')
                    {
                        $("#doi_"+key).text(value);
                        $("#"+key).val(value);
                    }
                });
            }

            //alert(result);
        }
    }); // end ajax
});



$('form.ajax-required .required').bind('keyup change',function()
{
	var empty = false;

    $('form.ajax-required .required').each(function()
    {
        if ($(this).val() == '' || $(this).val() == false)
		{
            empty = true;
			console.log( $(this) );
        }
    });

    if (empty)
	{
        $('.ajax-required-submit').attr('disabled', 'disabled');
    }
    else
	{
        $('.ajax-required-submit').removeAttr('disabled');
    }


});



$('.required').change(function(){
	$(this).removeClass('redBorder');
	$(this).closest('.redBorder').removeClass('redBorder');
});


$('ul.tabs li a').click(function(e)
{
    e.preventDefault();
  var tab = $(this).attr('href');

  if($(this).hasClass('inactive'))
  { 
  //this is the start of our condition 
    $('ul.tabs li a').addClass('inactive');          
    $('ul.tabs li a').removeClass('active');          
    $(this).removeClass('inactive');
    $(this).addClass('active');

    $('.tabs-content').hide();
    $(tab).fadeIn('slow');
 }
});


$(document).ready(function()
{

    $("#doi_check").on("change paste focus", function(){
        //alert($(this).val());

        var x = $(this).val().replace('http://dx.doi.org/', '').replace('dx.doi.org/', '').replace('https://doi.org/', '').replace('http://doi.org/', '');
        $(this).val($.trim(x));
    });

    $('.add-aida').click( function(e)
    {
        e.preventDefault();
        var aida_item = '<div class="aida-item col-md-12"><div class="col-md-3"><label for="">Does:</label><select name="aida_option[]" id="something" class="form-control"><option value="Confirms">Claim</option><option value="Refutes">Refutes</option><option value="option 3">option 3</option></select></div><div class="col-md-8"><label for="">AIDA Sentence:</label><textarea name="aida[]" id="" class="form-control"></textarea><input type="hidden" class="aida_id" name="aida_id[]" value=""><input type="hidden" class="aida_action" name="aida_action[]" value="insert"></div><div class="col-md-1"><br><button class="delete-aida btn btn-md btn-default"><i class=" glyphicon glyphicon-trash"></i></button></div></div><!-- end aida -->';
        $('.aida-list--target').append(aida_item);

    });

    $("#doi_submit").click( function(e){
        e.preventDefault();

        //$('#doi_results').show();
        $('#manual_input').hide();
    })

    $('#manual_btn').click( function(e)
    {
        e.preventDefault();

        $('#doi_results').hide();
        $('#manual_input').show();
    });


});

$('body').on('click', '.delete-aida', function(e){
    e.preventDefault();
    $(this).closest('.aida-item').slideUp().remove();
});
