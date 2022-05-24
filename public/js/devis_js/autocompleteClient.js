/** autocomplete client form devis**/

/* initialisation paramètres globaux : */
var cache = {}; /* tableau cache de tous les termes */
var term = null; /* terme renseigné dans le champ input */
var baseUrl = 'localhost:8000/'; /* url du site */
baseUrl = '';

$(document).ready(function() {
  
    /* city autocomplete */
    $('#devis_clientt').autocomplete({
       //  minLength:2, /* nombre de caractères minimaux pour lancer une recherche */
        delay:200, /* delais après la dernière touche appuyée avant de lancer une recherche */
      //  scrollHeight:320,
       //appendTo:'', /* div ou afficher la liste des résultats, si null, ce sera une div en position fixe avant la fin de </body> */
       
        /* dès qu'une recherche se lance, source est executé, il peut contenir soit un tableau JSON de termes, soit une fonctions qui retournera un résultat */
        source:function(request,response){
         
                $.ajax({
                    type:'GET',
                    url:'/client/jsoon/em/'+request.term,
                    data:{q:request.term},//e.term,
                    dataType:"json",
                    async:true,
                   // cache:true,
                    success:function(data){
                        if(data.length>0){
                        // response(data);
                        let client="";
                        data.forEach(element => {
                        client=client+""+"<a href='#'style='margin-left:10px' class='autoClient'>"+ element+"</a><br>"
                    
                        });
                        $("#clientDevis").html(client);

                      //  $("#clientDevis").html("<li>"+"<a href='#' class='bg-success'>"+ data[0]+"choisir</p></a> "+"<li>"+data[1]+"<button>choisir</button></li> ");
                        $("#clientDevis").show();
                        $(".autoClient").on("click",function(e){ 
                            e.preventDefault();
                            let a=$(this).text()
                            $("#devis_clientt").val(a);
                            $("#clientDevis").hide();
                          /*  $("#devis_clientt").val(a.split(" ")[1]);
                            $("#devis_iid").val(a.split(" ")[0]);
                            $("#clientDevis").hide();*/
                        });
                        
                    }
                        else{
                            data=['aucun résultat trouvé ...']
                           response(data);

                        }
                    }
                });
            },
        minLength:2,

                       
        });
});




/****************************/

