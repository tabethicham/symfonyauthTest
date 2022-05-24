$(document).ready(function(){   
      $("#devisajaxlignes form").submit( function(event){  
        
         event.preventDefault();
         //alert("rrrrrrr");
         var form_data = $(this).serialize();
         $.ajax({  
            url:        '/agent/lignesdevis/new',  
            type:       'POST',   
            data:    form_data ,
            async:      true,  
            
            success: function(data) {
                      //$("#ajax").load("creerCV #langues");  

                      //$("#devisajaxlignes form").trigger("reset"); 
                     let a= $("#devisajaxlignes form #lignes_devis_deviss").val(); 
                     $("#devisajaxlignes form").trigger("reset"); 
                  
                     $("#lignes_devis_deviss").val(a);
                      let lignesdevis="<h1>Les lignes Devis  </h1> <table class='table bg-wihte'><thead><tr><th>Id</th><th>Designation</th><th>Quantite</th><th>PrixUnitHT</th><th>actions</th></tr></thead><tbody>";
                     data.forEach(ligne => {
                        lignesdevis=lignesdevis+"<tr><td>"+ligne['id']+
                                                "</td> <td>"+ligne['designation']+
                                                "</td> <td>"+ligne['quantite']+
                                                "</td> <td>"+ligne['prixUnitHT']+"</td> </tr>"
                        
                  
                      });
                      $("#lignesdevis").html(lignesdevis+"</tbody></table>");


                      },  
             error : function() {  
                alert('Ajax request failed.');  
              }  
          });  
          
       });  
    });  
 