/**
 * Created by ivanj on 22-Dec-16.
 */
//Prikaci ja slikata preku forma
$(".uploadDiv form").submit(function (event) {

    event.preventDefault();
    $(".color_palette").css("display","none");

    loading=function () {
        $("#imgPreview").attr("src","img/hourglass.svg");
    };

    //kreiraj data za slikata
    var formData = new FormData($(this)[0]);

    //prati ja so ajax na backend
    $.ajax({
        url: "upload.php",
        type: "POST",
        data: formData,
        async: true,
        success: function (imgSource) {

            try {
                var response = jQuery.parseJSON(imgSource);
                $(".color_palette").css("display","initial");
                $.each(response,function (key,value) {
                    if(key===0)
                    {
                        $("#imgPreview").attr("src",value);
                    }
                    else
                    {
                        $("#"+key).attr('title', value);
                        $("#"+key).css('background',value);
                        $("#"+key).css('min-height','50px');
                    }
                });
            }
            catch (e) {
                $("#imgPreview").attr("src",imgSource);
            }

        },
        cache: false,
        contentType: false,
        processData: false
    });

    loading();

});

//prati data do preview div-ot
$(document).ready(function () {
    // Na loadiranje stavi text No Image
    if($('#imgPreview').attr('src') == '#'){
        $('.no_img_error').removeClass('hidden');
        $('.previewDiv img').addClass('hidden');

        // Iskluci go Download kopceto se dodeka ne se prikace slika
        $('#downloadBtn').addClass('disabled');
        $('#downloadBtn').prop('disabled',true);
    }

    //Na upload ovozmozi go Download kopceto i prikazi ja slikata
    $('#imgUpload').change(function () {
        $('.no_img_error').addClass('hidden');
        $('.previewDiv img').removeClass('hidden');
        $(".color_palette").css("display","none");

        var file= this.files[0];
        var name = file.name;
        var size = file.size;
        var type = file.type;


        readURL(this);

        $('#downloadBtn').removeClass('disabled');
        $('#downloadBtn').prop('disabled',false);

        $('.radio_button').prop('checked',false);
    });



    $('#downloadBtn').click(function () {
            var fileURL=$("#imgPreview").attr('src');


            var a = document.createElement('a');
            a.href = fileURL;
            a.target = '_blank';
            a.download = 'imgCanvas.jpg';
            document.body.appendChild(a);
            a.click();
    });

});

//Prikaz na slika
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgPreview').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

//Pri klik na filter povikaj ja formata
$('.radio_button').change(function(){
	if(this.value != "channels"){
		$('#submit_filter').trigger('click');

		if(this.value != "red" && this.value != "green" && this.value != "blue")
        {
            $('.collapse').collapse('hide');
        }

	}
});





