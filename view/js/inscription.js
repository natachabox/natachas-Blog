$(document).ready(function() {

//pour attraper le formulaire en click
/*$("#addArticleBtn").on("click", function () {
	alert("Je suis un cube");
});
*/

	$('#inscriptionForm').on('submit', function(event) {
    	event.preventDefault(); //stopper le comportement par défaut du formulaire
        
        var dataForm = $(this).serialize();
        console.log(dataForm);

        // url est optionnel vu que l'on fait le traitement sur la même page
        $.ajax({
        
        	type: "POST",
            data: dataForm,
            url: window.location.href,
            dataType: 'json' // Permet de spécifier que l'on récupère des informations au format json
        
        }).done(function(data){

            if(data.errors != 'undefined')
            {
                var divError = $('#displayError');
                var pError = $('<p class="alert alert-danger"></p>');
                divError.empty();
                for (var value in data.errors)
                {
                    pError.append(value+'<br>');
                }
                divError.append(pError);
            }
            else
            {

                console.log(data);
                console.log(data.success);
                //$('.alert-success').remove();
                $('#inscriptionForm').before('<p class="alert alert-success hidden">'+ data.success +'</p>');
                //$('.hidden').fadeIn(1000).removeClass('hidden');
                // clear le formulaire
                //$('#inscriptionForm')[0].reset();
            }
        });
    	
    });

});