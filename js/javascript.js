$(function() {
    var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    var login = true;
    var mail = true;
    var pwd = true;
    $("#mail").blur(function() {
        if($(this).val() == "") {
             $(this).next().show().html("<img src='templates/img/check-rouge.png''> L'adresse e-mail ESCEM n'est pas valide.");           
             $('#submitInscription').attr("id", "noSubmit");
             $('#noSubmit').attr("disabled","disabled");
             mail = false;
        } else if (!ck_email.test($(this).val())) {
            $(this).next().show().html("<img src='templates/img/check-rouge.png''>L\'adresse e-mail n'est pas valide.");
            $('#submitInscription').attr("id", "noSubmit");
            $('#noSubmit').attr("disabled","disabled");
             mail = false;
        }
        else {
            $(this).next().show().html("<img src='templates/img/check-vert.png''>");
            mail = true;
            if(mail == true && login == true && pwd == true) {
                $('#noSubmit').attr("id", "submitInscription");
                $('#submitInscription').removeAttr("disabled"); 
            }
            
        }
    });
    
    $("#login").blur(function() {
        if($(this).val() == "") {
             $(this).next().show().html("<img src='templates/img/check-rouge.png''> Votre login n'est pas valide.");           
             $('#submitInscription').attr("id", "noSubmit");
             $('#noSubmit').attr("disabled","disabled");
             login = false;
        }
        else {
            $(this).next().show().html("<img src='templates/img/check-vert.png''>");
            login = true;
            if(mail == true && login == true && pwd == true) {
                $('#noSubmit').attr("id", "submitInscription");
                $('#submitInscription').removeAttr("disabled"); 
            }
            
        }
    });
    
    $("#pwd").blur(function() {
        if($(this).val() == "" || $(this).val().length < 6) {
             $(this).next().show().html("<img src='templates/img/check-rouge.png''> Votre password n'est pas valide. (6 caractères minimum)");           
             $('#submitInscription').attr("id", "noSubmit");
             $('#noSubmit').attr("disabled","disabled");
             pwd = false;
        }
        else {
            $(this).next().show().html("<img src='templates/img/check-vert.png''>");
            pwd = true;
            if(mail == true && login == true && pwd == true) {
                $('#noSubmit').attr("id", "submitInscription");
                $('#submitInscription').removeAttr("disabled"); 
            }
            
        }
    });

    $("#pwdCo").blur(function() {
        if($(this).val() == "" || $(this).val().length < 6) {
             $(this).next().show().html("<img src='templates/img/check-rouge.png''>");           
             $('#submitConnexion').attr("id", "noSubmit");
             $('#noSubmit').attr("disabled","disabled");
             pwd = false;
        }
        else {
            $(this).next().show().html("<img src='templates/img/check-vert.png''>");
            pwd = true;
            if(login == true && pwd == true) {
                $('#noSubmit').attr("id", "submitConnexion");
                $('#submitConnexion').removeAttr("disabled"); 
            }
            
        }
    });
    
    $("#loginCo").blur(function() {
        if($(this).val() == "") {
             $(this).next().show().html("<img src='templates/img/check-rouge.png''>");           
             $('#submitConnexion').attr("id", "noSubmit");
             $('#noSubmit').attr("disabled","disabled");
             login = false;
        }
        else {
            $(this).next().show().html("<img src='templates/img/check-vert.png''>");
            login = true;
            if(login == true && pwd == true) {
                $('#noSubmit').attr("id", "submitConnexion");
                $('#submitConnexion').removeAttr("disabled"); 
            }
            
        }
    });
    
        $('.pagination').click(function() {
        var page = $(this).attr('name');
        $('a#currentPagi').removeAttr("id");
        $(this).attr("id","currentPagi");
        pa = 'page='+page;
        $.ajax ({
            type: "POST",
            data: pa,
            url : "index.php?page=ajaxclassement",
            success: function(html) {
                $(".classement li").remove();
                $(".classement ul").append(html);
                $(".classement ul li:first").fadeIn("slow");
            }
        })
    });
    
    $('.pagina').click(function() {
        var page = $(this).attr('name');
        $('a#currentPagi').removeAttr("id");
        $(this).attr("id","currentPagi");
        pa = 'page='+page;
        $.ajax ({
            type: "POST",
            data: pa,
            url : "index.php?page=classementajax",
            success: function(html) {
                $("#classement").remove();
                $("#class").append(html);
                $("#class").fadeIn("slow");
            }
        })
    });
});