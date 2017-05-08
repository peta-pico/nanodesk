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
                theform.find(".alert-warning").delay(300).slideDown();

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
    var doi = $("#doi_check").val();
    //alert('the doi:'+ doi);
    $.ajax({
        type:"POST",
        url: "/ajax/doi_check.php",
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
