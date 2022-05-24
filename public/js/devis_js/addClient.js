  $(document).ready(function(){  
      
        $("#ajaxAddClient form button").click( function(event){ 
          event.preventDefault();
          //on suprime les erreurs de formulaire
          $("#clientt_refClient label span").remove();
          $("#clientt_emailClient label span").remove();
          $("#clientt_telClient label span").remove();

          var form_data = $("#ajaxAddClient form").serialize();  //$(this).serialize(); //

            $.ajax({  
                url: '/agent/cliendevis/new',//'/agent/commercial/new',  
                type:       'POST',   
                data:    form_data ,
                async:      true,  
                success: function (response) {
                    
                    //$("#clientDevis").html("resp");
                    if(!response['errors']){
                      $("#devisMessageSuccess").html("<p>Le client a bien été enregistrer</p>");
                      $("#ajaxAddClient form").trigger("reset");
                    }

                    if(response['errors']) {
                      $("#devisMessageSuccess").html("");
                      if(response['errors']['refClient']){
                        $("#clientt_refClient label").append("<span class='invalid-feedback d-block'><span class='d-block'><span class='form-error-icon badge badge-danger text-uppercase'>Erreur</span><span class='form-error-message'>"+
                        response['errors']['refClient']+"</span></span></span>");
                      }
                      if(response['errors']['emailClient']){
                        $("#clientt_emailClient label").append("<span class='invalid-feedback d-block'><span class='d-block'><span class='form-error-icon badge badge-danger text-uppercase'>Erreur</span><span class='form-error-message'>"+
                        response['errors']['emailClient']+"</span></span></span>");
                      }
                      if(response['errors']['telClient']){
                        $("#clientt_telClient label").append("<span class='invalid-feedback d-block'><span class='d-block'><span class='form-error-icon badge badge-danger text-uppercase'>Erreur</span><span class='form-error-message'>"+
                        response['errors']['telClient']+"</span></span></span>");
                      }
                        // $("#clientt_refClient").before("ddddds");
                       }
                   
                },  
                error : function() {  
                  alert('Ajax request failed.');  

                 /* <span class="invalid-feedback d-block">
                    <span class="d-block">
                      <span class="form-error-icon badge badge-danger text-uppercase">Erreur</span>
                      <span class="form-error-message">Cette chaîne est trop courte. Elle doit avoir au minimum 10 caractères.</span>
                    </span>
                  </span>*/
                }  
            });  
            
         }); 
       

    

       

      
      
      /////////
      });  
