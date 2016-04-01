$(document).ready(function() {

//pour attraper le formulaire en click
/*$("#addArticleBtn").on("click", function () {
	alert("Je suis un cube");
});
*/

	$('#formCom').on('submit', function(event){
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
            console.log(data);
            console.log(data.success);
            console.log(data.commentaire);
             $('#formCom').before('<p class="alert alert-success">'+ data.success +'</p>');
        });
    	
    });

});