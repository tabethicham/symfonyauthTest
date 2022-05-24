  $(document).ready(function(){  
        $("#devis_modalitess").hide(); 
       //$("#devis_modalitess label ").css({"display":"none"}) 
        $("#devis_delaiss").hide(); 
       
        $("#devisajaxlignes").hide(); 
        //$("#ajaxdevis form ").submit( function(event){ 
        $("#nextDevisUpdate").click( function(event){ 
            event.preventDefault();
            //alert("rrrrrrr");
            var form_data = $("#ajaxdevis form").serialize();  //$(this).serialize(); //
            let refdevis=$("#devis_refDevis").val();
            
            var inpuut=refdevis.split("/")[1];//'214';//$('#lignes_devis_deviss').val();
            //alert(inpuut)
            
            $.ajax({  
                url: '/agent/devis/'+inpuut+'/edit',  
                type:       'POST',   
                data:    form_data ,
                async:      true,  
                success: function (response) {
                    //$("#ajax").load("creerCV #langues");  
                    //$("#clientDevis").html("resp"); 
                    if(!response['errors']){
                      $("#devisajax").hide();
                      $("#devisajaxlignes").show();
                      (inpuut.length == 0) ? $('#lignes_devis_deviss').val(response['ref']) : $('#lignes_devis_deviss').val(inpuut);
                      // alert(response['ddd']['id']);
                      $("#progressId").text("Etape 2");
                      $("#progressId").css('width','66%');
                    }
                    if(response['errors']){
                      //$("#devisMessageSuccess").html("");
                     /* if(response['errors']['refDevis']){
                        $("#devis_refDeviss label").append("<span class='invalid-feedback d-block'><span class='d-block'><span class='form-error-icon badge badge-danger text-uppercase'>Erreur</span><span class='form-error-message'>"+
                        response['errors']['refDevis']+"</span></span></span>");
                      }*/

                      if(response['errors']['messageDevis']){
                        $("#devis_messageDeviss label").append("<span class='invalid-feedback d-block'><span class='d-block'><span class='form-error-icon badge badge-danger text-uppercase'>Erreur</span><span class='form-error-message'>"+
                        response['errors']['messageDevis']+"</span></span></span>");
                      }
                      /*
                      if(response['errors']['delaiDevis']){
                        $("#devis_delaiss label").append("<span class='invalid-feedback d-block'><span class='d-block'><span class='form-error-icon badge badge-danger text-uppercase'>Erreur</span><span class='form-error-message'>"+
                        response['errors']['delaiDevis']+"</span></span></span>");
                      }*/

                    }


                },  
                error : function() {  
                  alert('Ajax request failed.');  
                }  
            });  
        }); 
         //fin devis
        $("#nextDevisFinUpdate").click( function(event){ 
          event.preventDefault();
          //alert("rrrrrrr");
          var form_data =$("#ajaxdevis form").serialize();// $(this).serialize();
          var inpuut=$('#lignes_devis_deviss').val();
          //alert(inpuut)
          
          $.ajax({  
              url: '/agent/devis/'+inpuut+'/edit',//'/agent/commercial/'+inpuut+'/edit',  
              type:       'POST',   
              data:    form_data ,
              async:      true,  
              success: function (response) {
                window.location.replace("http://localhost:8000/devis/"+inpuut+"/consulter");
                //effacer les donees des formulaire
                  //$("#ajax").load("creerCV #langues");  
                  //$("#clientDevis").html("resp"); 
                 // $("#devisajax").hide();
                 // $("#devisajaxlignes").show();
                 // (inpuut.length == 0) ? $('#lignes_devis_deviss').val(response['ref']) : $('#lignes_devis_deviss').val(inpuut);
                  //alert();
                  
              },  
              error : function() {  
                alert('Ajax request failed.');  
              }  
          });  
          
      }); 

        $("#lignes_devis_retour").click(function(){
          $("#devisajax").show();
          $("#devisajaxlignes").hide();
          $("#devis_modalitess").hide(); 
          
           $("#devis_delaiss").hide(); 
           $("#progressId").text("Etape 1");
           $("#progressId").css('width','33%');


        }); 

        $("#lignes_devis_next").click(function(){
          $("#progressId").text("Etape 3");
          $("#progressId").css('width','100%');

          $("#devisajax").show();
          $("#devisajaxlignes").hide();
          
          $("#devis_modalitess").show(); 
          $("#devis_delaiss").show(); 
           //$("#nextDevis").text("Ajouter");
           $("#nextDevisUpdate").css("display","none");
           $("#nextDevisFinUpdate").css("display","inline");
           

           
        }); 

      
      
      /////////
      });  











      /*
       $("#nextDevisFin").click( function(event){ 
          event.preventDefault();
          //alert("rrrrrrr");
          var form_data =$("#ajaxdevis form").serialize();// $(this).serialize();
          var inpuut=$('#lignes_devis_deviss').val();
          alert(inpuut)
          
          $.ajax({  
              url: '/agent/commercial/'+inpuut+'/edit',  
              type:       'POST',   
              data:    form_data ,
              async:      true,  
              success: function (response) {
                //window.location.replace("http://localhost:8000/");
                  //$("#ajax").load("creerCV #langues");  
                  //$("#clientDevis").html("resp"); 
                 // $("#devisajax").hide();
                 // $("#devisajaxlignes").show();
                 // (inpuut.length == 0) ? $('#lignes_devis_deviss').val(response['ref']) : $('#lignes_devis_deviss').val(inpuut);
                  //alert();
                  
              },  
              error : function() {  
                alert('Ajax request failed.');  
              }  
          });  
          
       }); 
       */
      
