$(document).ready(function(){
    $('#regDugme').on('click', regProvera);
    $('#loginDugme').on('click', loginProvera);
    $('#contactDugme').on('click', contactProvera);


    $('#addUserDugme').on('click', addUserProvera);
    $('#updateUserDugme').on('click', updateUserProvera);
    $('.obrisiKorisnika').on('click', obrisiKorisnika);
    $('.obrisiProizvod').on('click', obrisiProizvod);

    $('.dodaj').on('click', dodajUKorpu);
    $('.izbaciIzKorpe').on('click', izbaciIzKorpe);
    $('.kupiDugme').on('click', kupi);

    $("#selectAnketa").on('change', dohvatiOdgovore);
    $('#glasajDugmeDiv').hide();
    $('#glasaj').on("click", glasaj);
    $('#rezultatiDugme').on('click', dohvatiRezultate);

    $('#korpaLink').on('click', korpaLogovanProvera);
    $('#profilLink').on('click', profilLogovanProvera);

    $('#sortiraj').on('change', filter);
    $('.kategorija_filter').on('click', filter);
    $('.brend_filter').on('click', filter);
    $('.pol_filter').on('click', filter);
    $('#minCena').on('keyup', filter);
    $('#maxCena').on('keyup', filter);
    $('#ponistiSve').on('click', ponistiSve);
    
    $('#promenaLozinkeDugme').on('click', promenaLozinke);
    $('#zab_loz_p').on('click', prikaziSakrijResetovanje);
    $('#zab_loz_p').css('cursor', 'pointer');
    $('#zab_loz_div').hide();
    $('#resetPassEmailDugme').on('click', resetPassEmailProvera);
    $('#resetLozinkeDugme').on('click', resetLozinke);



    $(window).on('keyup', function (e) {
        if(e.keyCode == 13)
        {
            $('#loginDugme').click();
            //$('#regDugme').click();
            //$('#addUserDugme').click();
            //$('#updateUserDugme').click();
            //$('#addProductDugme').click();
            //$('#updateProductDugme').click();

        }
    });



    $('#nav li').hover(
        function() {
            $('ul', this).stop().slideDown(200);
        },
        function() {
            $('ul', this).stop().slideUp(200);
        }
    );



    slajder();

    $('.vecaSlika').simpleLightbox();

    $('#loginKorIme').focus();

    $('#loginDugme, #regDugme, #addProductDugme, #updateProductDugme, #addUserDugme, #updateUserDugme, #glasaj, #rezultatiDugme, #contactDugme, #ponistiSve, #promenaLozinkeDugme, #resetPassEmailDugme, #resetLozinkeDugme').hover(
        function(){
            $(this).css({backgroundColor : 'darkolivegreen'});
        },
        function(){
            $(this).css({backgroundColor : '#DCDCDC'});
        }
    );


    filter();


    $(document).on({
        ajaxStart: function() { $('body').addClass("loading"); },
        ajaxStop: function() { $('body').removeClass("loading"); }
    });


});


function resetLozinke() {
    var token = $('#promenaLozinkeKorisnikToken').val();
    var novaLozinka = $('#novaLozinka').val();
    var novaLozinka2 = $('#novaLozinka2').val();

    var promenaLozinkeGreske = [];

    if(novaLozinka === ""){
        promenaLozinkeGreske.push("Polje za novu lozinku mora biti popunjeno");
        $('#novaLozinkaGreska').html("Polje za novu lozinku mora biti popunjeno");
    } else if(novaLozinka.length < 6){
        promenaLozinkeGreske.push("Nova lozinka mora imati bar 6 karaktera");
        $('#novaLozinkaGreska').html("Nova lozinka mora imati bar 6 karaktera");
    } else if((novaLozinka !== novaLozinka2) && (novaLozinka2 !== "") && (novaLozinka2.length >= 6)){
        promenaLozinkeGreske.push("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska2').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#novaLozinkaGreska').html("");
    }

    if(novaLozinka2 === ""){
        promenaLozinkeGreske.push("Polje za ponovljenu lozinku mora biti popunjeno");
        $('#novaLozinkaGreska2').html("Polje za ponovljenu lozinku mora biti popunjeno");
    } else if(novaLozinka2.length < 6){
        promenaLozinkeGreske.push("Ponovljena lozinka mora imati bar 6 karaktera");
        $('#novaLozinkaGreska2').html("Ponovljena lozinka mora imati bar 6 karaktera");
    } else if((novaLozinka !== novaLozinka2) && (novaLozinka !== "") && (novaLozinka.length >= 6)){
        promenaLozinkeGreske.push("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska2').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#novaLozinkaGreska2').html("");
    }

    if(promenaLozinkeGreske.length == 0){
        var data =
            {
                token : token,
                novaLozinka : novaLozinka,
                novaLozinka2 : novaLozinka2,
                resetLozinkeDugme : "ok"
            };

        $.ajax({
            url : "modules/resetpassword.php",
            method : "POST",
            dataType : "json",
            data : data,
            success : function (data) {
                $('#resetLozinkeGreske').html("<h2>Uspešno ste promenili lozinku!</h2>");
                setTimeout(function() {
                    window.location.href = "http://localhost/php2sajt1/index.php?page=login";
                }, 5000);
            },
            error : function (xhr, status, error) {
                let greska = "";
                if(xhr.responseText != null)
                {
                    try {
                        greska = JSON.parse(xhr.responseText).message;
                    } catch (e) {
                        greska = "";
                    }
                }
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće promeniti lozinku, pokušajte kasnije";
                        break;
                    case 422:
                        poruka = "<ul>";
                        for(let i=0; i<greska.length; i++){
                            poruka += "<li>"+ greska[i] +"</li>";
                        }
                        poruka += "</ul>";
                        break;
                    case 500:
                        poruka = "Greška pri promeni lozinke, pokušajte kasnije";
                        break;
                }
                if(poruka !== "")
                    $('#resetLozinkeGreske').html("<h4>"+ poruka +"</h4>");
            }
        });
    }

}


function resetPassEmailProvera() {
    var email = $.trim($('#resetPassEmail').val());
    var proveraEmail = /^[\w]+[\.\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/;
    var greska = "";

    if(email === ""){
        greska = "Polje za email mora biti popunjeno";
        $('#resetPassEmailGreska').html("Polje za email mora biti popunjeno");
    } else if(!proveraEmail.test(email)){
        greska = "Email nije u dobrom formatu";
        $('#resetPassEmailGreska').html("Email nije u dobrom formatu");
    } else{
        $('#resetPassEmailGreska').html("");
    }

    if(greska === ""){
        var data = {
            email : email,
            resetPassEmailDugme : "ok"
        };

        $.ajax({
            url : "modules/resetpassword.php",
            method : "POST",
            dataType : "json",
            data : data,
            success : function (data) {
                $('#resetPassEmailIspis').html("<h3>Proverite email za nastavak procesa . . . . .</h3>");
                setTimeout(function() {
                    window.location.href = "http://localhost/php2sajt1/index.php";
                }, 5000);
            },
            error : function (xhr, status, error) {
                let greska = "";
                if(xhr.responseText != null)
                {
                    try {
                        greska = JSON.parse(xhr.responseText).message;
                    } catch (e) {
                        greska = "";
                    }
                }
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće resetovati lozinku, pokušajte kasnije";
                        break;
                    case 409:
                        poruka = "Ne postoji nalog sa unetim email-om";
                        break;
                    case 422:
                        poruka = greska;
                        break;
                    case 500:
                        poruka = "Greška pri resetovanju lozinke, pokušajte kasnije";
                        break;
                }
                if(poruka !== "")
                    $('#resetPassEmailIspis').html("<h4>"+ poruka +"</h4>");
            }
        });
    }
}


function prikaziSakrijResetovanje() {
    $('#zab_loz_div').toggle();
}


function promenaLozinke() {
    var korisnikID = $('#promenaLozinkeKorisnik').val();
    var trenutnaLozinka = $('#trenutnaLozinka').val();
    var novaLozinka = $('#novaLozinka').val();
    var novaLozinka2 = $('#novaLozinka2').val();

    var promenaLozinkeGreske = [];

    if(trenutnaLozinka === ""){
        promenaLozinkeGreske.push("Polje za trenutnu lozinku mora biti popunjeno");
        $('#trenutnaLozinkaGreska').html("Polje za trenutnu lozinku mora biti popunjeno");
    } else if(trenutnaLozinka.length < 6){
        promenaLozinkeGreske.push("Trenutna lozinka mora imati bar 6 karaktera");
        $('#trenutnaLozinkaGreska').html("Trenutna lozinka mora imati bar 6 karaktera");
    } else{
        $('#trenutnaLozinkaGreska').html("");
    }


    if(novaLozinka === ""){
        promenaLozinkeGreske.push("Polje za novu lozinku mora biti popunjeno");
        $('#novaLozinkaGreska').html("Polje za novu lozinku mora biti popunjeno");
    } else if(novaLozinka.length < 6){
        promenaLozinkeGreske.push("Nova lozinka mora imati bar 6 karaktera");
        $('#novaLozinkaGreska').html("Nova lozinka mora imati bar 6 karaktera");
    } else if((novaLozinka !== novaLozinka2) && (novaLozinka2 !== "") && (novaLozinka2.length >= 6)){
        promenaLozinkeGreske.push("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska2').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#novaLozinkaGreska').html("");
    }

    if(novaLozinka2 === ""){
        promenaLozinkeGreske.push("Polje za ponovljenu lozinku mora biti popunjeno");
        $('#novaLozinkaGreska2').html("Polje za ponovljenu lozinku mora biti popunjeno");
    } else if(novaLozinka2.length < 6){
        promenaLozinkeGreske.push("Ponovljena lozinka mora imati bar 6 karaktera");
        $('#novaLozinkaGreska2').html("Ponovljena lozinka mora imati bar 6 karaktera");
    } else if((novaLozinka !== novaLozinka2) && (novaLozinka !== "") && (novaLozinka.length >= 6)){
        promenaLozinkeGreske.push("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
        $('#novaLozinkaGreska2').html("Nova lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#novaLozinkaGreska2').html("");
    }


    if(promenaLozinkeGreske.length == 0){
        var data = {
            korisnikID : korisnikID,
            trenutnaLozinka : trenutnaLozinka,
            novaLozinka : novaLozinka,
            novaLozinka2 : novaLozinka2,
            promenaLozinkeDugme : "ok"
        };
        $.ajax({
            url : "modules/changepassword.php",
            method : "POST",
            dataType : "json",
            data : data,
            success : function (data) {
                $('#promenaLozinkeGreske').html("<h2>Uspešno ste promenili lozinku!</h2>");
                setTimeout(function() {
                    window.location.href = "http://localhost/php2sajt1/index.php";
                }, 5000);
            },
            error : function (xhr, status, error) {
                let greska = "";
                if(xhr.responseText != null)
                {
                    try {
                        greska = JSON.parse(xhr.responseText).message;
                    } catch (e) {
                        greska = "";
                    }
                }
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće promeniti lozinku, pokušajte kasnije";
                        break;
                    case 409:
                        $('#trenutnaLozinkaGreska').html("Trenutna lozinka nije ispravna");
                        break;
                    case 422:
                        poruka = "<ul>";
                        for(let i=0; i<greska.length; i++){
                            poruka += "<li>"+ greska[i] +"</li>";
                        }
                        poruka += "</ul>";
                        break;
                    case 500:
                        poruka = "Greška pri promeni lozinke, pokušajte kasnije";
                        break;
                }
                if(poruka !== "")
                    $('#promenaLozinkeGreske').html("<h4>"+ poruka +"</h4>");
            }
        });
    }
}


function filter() {
    var sortiraj = $('#sortiraj').val();
    var kategorija = document.getElementsByName("kategorija_filter");
    var brend = document.getElementsByName("brend_filter");
    var pol = document.getElementsByName("pol_filter");
    var minCena = $('#minCena').val();
    var maxCena = $('#maxCena').val();

    var kategorijaNiz = [];
    var brendNiz = [];
    var polNiz = [];

    for(let i=0; i<kategorija.length; i++)
    {
        if(kategorija[i].checked)
            kategorijaNiz.push("'" + kategorija[i].value + "'");
    }

    for(let i=0; i<brend.length; i++)
    {
        if(brend[i].checked)
            brendNiz.push("'" + brend[i].value + "'");
    }

    for(let i=0; i<pol.length; i++)
    {
        if(pol[i].checked)
            polNiz.push("'" + pol[i].value + "'");
    }

    var kategorijeStr = "";
    var brendoviStr = "";
    var poloviStr = "";

    if(kategorijaNiz.length){
        kategorijeStr = kategorijaNiz.join(", ");
    }

    if(brendNiz.length){
        brendoviStr = brendNiz.join(", ");
    }

    if(polNiz.length){
        poloviStr = polNiz.join(", ");
    }

    var data = {
        sortiraj : sortiraj,
        kategorijeStr : kategorijeStr,
        brendoviStr : brendoviStr,
        poloviStr : poloviStr,
        minCena : minCena,
        maxCena : maxCena,
        filterDugme : "ok"
    };

    $.ajax({
        url : "modules/filter.php",
        method : "POST",
        dataType : "json",
        data : data,
        success : function (data) {
            var proizvodi = data.message;

            if(proizvodi != null)
            {
                var kojaStranica = 1;
                var poStranici = 8;
                var brojProizvoda = proizvodi.length;
                var brojStranica = Math.ceil(brojProizvoda/poStranici);
                var from = poStranici * (kojaStranica - 1);
                var doKog = ((from+poStranici) > brojProizvoda) ? brojProizvoda : (from+poStranici);


                var ispisStranica = "";
                for(let i=0; i<brojStranica; i++)
                {
                    ispisStranica += "<a href='#' data-id='"+ (i+1) +"' class='straniceLink'>"+ (i+1) +"</a>";

                }
                $('.stranice').html(ispisStranica);

                $('.straniceLink').on('click', paginacija);


                var ispis = "";
                for(let i=from; i<doKog; i++)
                {
                    ispis += "<div class='proizvod'>";
                    ispis += "<img src='images/upload/"+ proizvodi[i].src +"' alt='"+ proizvodi[i].alt +"'/>";
                    ispis += "<div class='detaljnije2'>";
                    ispis += "<p class='ps_naziv'>"+ proizvodi[i].proizvod +"</p>";
                    ispis += "<p class='ps_cena'>"+ proizvodi[i].cena +" din.</p>";
                    ispis += "<a href='index.php?page=product&id="+ proizvodi[i].proizvodID +"' class='detaljnije'>DETALJNIJE</a>";
                    ispis += "</div>";
                    ispis += "</div>";
                }
                $('#proizvodi_sadrzaj').html(ispis);

                var sveStraniceLinkovi = document.getElementsByClassName('straniceLink');
                for(let i=0; i<sveStraniceLinkovi.length; i++)
                {
                    if(sveStraniceLinkovi[i].innerHTML == 1){
                        sveStraniceLinkovi[i].style.border = "1px solid #7971ea";
                        sveStraniceLinkovi[i].style.borderRadius = "5px";
                    }
                }

            } else{
                var nemaProizvoda = "<div id='nemaProizvoda'><h3>Nema proizvoda za izabrane filtere</h3></div>";
                $('#proizvodi_sadrzaj').html(nemaProizvoda);
                $('.stranice').html("");
            }

        },
        error : function (xhr, status, error) {
        }
    });
}

function paginacija() {
    var kojaStranica = $(this).data('id');
    var poStranici = 8;
    var from = poStranici * (kojaStranica - 1);


    var sortiraj = $('#sortiraj').val();
    var kategorija = document.getElementsByName("kategorija_filter");
    var brend = document.getElementsByName("brend_filter");
    var pol = document.getElementsByName("pol_filter");
    var minCena = $('#minCena').val();
    var maxCena = $('#maxCena').val();

    var kategorijaNiz = [];
    var brendNiz = [];
    var polNiz = [];

    for(let i=0; i<kategorija.length; i++)
    {
        if(kategorija[i].checked)
            kategorijaNiz.push("'" + kategorija[i].value + "'");
    }

    for(let i=0; i<brend.length; i++)
    {
        if(brend[i].checked)
            brendNiz.push("'" + brend[i].value + "'");
    }

    for(let i=0; i<pol.length; i++)
    {
        if(pol[i].checked)
            polNiz.push("'" + pol[i].value + "'");
    }

    var kategorijeStr = "";
    var brendoviStr = "";
    var poloviStr = "";

    if(kategorijaNiz.length){
        kategorijeStr = kategorijaNiz.join(", ");
    }

    if(brendNiz.length){
        brendoviStr = brendNiz.join(", ");
    }

    if(polNiz.length){
        poloviStr = polNiz.join(", ");
    }

    var data = {
        sortiraj : sortiraj,
        kategorijeStr : kategorijeStr,
        brendoviStr : brendoviStr,
        poloviStr : poloviStr,
        minCena : minCena,
        maxCena : maxCena,
        from : from,
        poStranici : poStranici,
        paginacijaDugme : "ok"
    };

    $.ajax({
        url : "modules/pagination.php",
        method : "POST",
        dataType : "json",
        data : data,
        success : function (data) {
            var proizvodi = data.message;

            if(proizvodi != null)
            {
                var ispis = "";
                for(let i=0; i<proizvodi.length; i++){
                    ispis += "<div class='proizvod'>";
                    ispis += "<img src='images/upload/"+ proizvodi[i].src +"' alt='"+ proizvodi[i].alt +"'/>";
                    ispis += "<div class='detaljnije2'>";
                    ispis += "<p class='ps_naziv'>"+ proizvodi[i].proizvod +"</p>";
                    ispis += "<p class='ps_cena'>"+ proizvodi[i].cena +" din.</p>";
                    ispis += "<a href='index.php?page=product&id="+ proizvodi[i].proizvodID +"' class='detaljnije'>DETALJNIJE</a>";
                    ispis += "</div>";
                    ispis += "</div>";
                }
                $('#proizvodi_sadrzaj').html(ispis);

                var sveStraniceLinkovi = document.getElementsByClassName('straniceLink');
                for(let i=0; i<sveStraniceLinkovi.length; i++)
                {
                    if(sveStraniceLinkovi[i].innerHTML == kojaStranica){
                        sveStraniceLinkovi[i].style.border = "1px solid #7971ea";
                        sveStraniceLinkovi[i].style.borderRadius = "5px";
                    } else{
                        sveStraniceLinkovi[i].style.border = "none";
                    }
                }

            } else{
                var nemaProizvoda = "<div id='nemaProizvoda'><h3>Nema proizvoda za izabrane filtere</h3></div>";
                $('#proizvodi_sadrzaj').html(nemaProizvoda);
                $('.stranice').html("");
            }

        },
        error : function (xhr, status, error) {
        }
    });
}


function ponistiSve() {
    $('#sortiraj').val("0");
    var kategorija = document.getElementsByName("kategorija_filter");
    var brend = document.getElementsByName("brend_filter");
    var pol = document.getElementsByName("pol_filter");
    $('#minCena').val("");
    $('#maxCena').val("");

    for(let i=0; i<kategorija.length; i++)
    {
        if(kategorija[i].checked)
            kategorija[i].checked = false;
    }

    for(let i=0; i<brend.length; i++)
    {
        if(brend[i].checked)
            brend[i].checked = false;;
    }

    for(let i=0; i<pol.length; i++)
    {
        if(pol[i].checked)
            pol[i].checked = false;
    }

    var data = {
        sortiraj : "0",
        kategorijeStr : "",
        brendoviStr : "",
        poloviStr : "",
        minCena : "",
        maxCena : "",
        filterDugme : "ok"
    };

    $.ajax({
        url : "modules/filter.php",
        method : "POST",
        dataType : "json",
        data : data,
        success : function (data) {
            var proizvodi = data.message;

            if(proizvodi != null)
            {
                var kojaStranica = 1;
                var poStranici = 8;
                var brojProizvoda = proizvodi.length;
                var brojStranica = Math.ceil(brojProizvoda/poStranici);
                var from = poStranici * (kojaStranica - 1);
                var doKog = ((from+poStranici) > brojProizvoda) ? brojProizvoda : (from+poStranici);


                var ispisStranica = "";
                for(let i=0; i<brojStranica; i++)
                {
                    ispisStranica += "<a href='#' data-id='"+ (i+1) +"' class='straniceLink'>"+ (i+1) +"</a>";

                }
                $('.stranice').html(ispisStranica);

                $('.straniceLink').on('click', paginacija);


                var ispis = "";
                for(let i=from; i<doKog; i++)
                {
                    ispis += "<div class='proizvod'>";
                    ispis += "<img src='images/upload/"+ proizvodi[i].src +"' alt='"+ proizvodi[i].alt +"'/>";
                    ispis += "<div class='detaljnije2'>";
                    ispis += "<p class='ps_naziv'>"+ proizvodi[i].proizvod +"</p>";
                    ispis += "<p class='ps_cena'>"+ proizvodi[i].cena +" din.</p>";
                    ispis += "<a href='index.php?page=product&id="+ proizvodi[i].proizvodID +"' class='detaljnije'>DETALJNIJE</a>";
                    ispis += "</div>";
                    ispis += "</div>";
                }
                $('#proizvodi_sadrzaj').html(ispis);

                var sveStraniceLinkovi = document.getElementsByClassName('straniceLink');
                for(let i=0; i<sveStraniceLinkovi.length; i++)
                {
                    if(sveStraniceLinkovi[i].innerHTML == 1){
                        sveStraniceLinkovi[i].style.border = "1px solid #7971ea";
                        sveStraniceLinkovi[i].style.borderRadius = "5px";
                    }
                }

            } else{
                var nemaProizvoda = "<div id='nemaProizvoda'><h3>Nema proizvoda za izabrane filtere</h3></div>";
                $('#proizvodi_sadrzaj').html(nemaProizvoda);
                $('.stranice').html("");
            }

        },
        error : function (xhr, status, error) {
        }
    });
}


function regProvera() {
    var regIme = $.trim($('#regIme').val());
    var regPrezime = $.trim($('#regPrezime').val());
    var regEmail = $.trim($('#regEmail').val());
    var regKorIme = $.trim($('#regKorIme').val());
    var regLozinka = $('#regLozinka').val();
    var regLozinka2 = $('#regLozinka2').val();

    var proveraImePrezime = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}){0,1}$/;
    var proveraEmail = /^[\w]+[\.\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/;
    var proveraKorIme = /^[\w\d\.\_]{5,15}$/;
    var regGreske = [];

    if(regIme === ""){
        regGreske.push("Polje za ime mora biti popunjeno");
        $('#regImeGreska').html("Polje za ime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regIme)){
        regGreske.push("Ime nije u dobrom formatu");
        $('#regImeGreska').html("Ime nije u dobrom formatu");
    } else{
        $('#regImeGreska').html("");
    }

    if(regPrezime === ""){
        regGreske.push("Polje za prezime mora biti popunjeno");
        $('#regPrezimeGreska').html("Polje za prezime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regPrezime)){
        regGreske.push("Prezime nije u dobrom formatu");
        $('#regPrezimeGreska').html("Prezime nije u dobrom formatu");
    } else{
        $('#regPrezimeGreska').html("");
    }

    if(regEmail === ""){
        regGreske.push("Polje za email mora biti popunjeno");
        $('#regEmailGreska').html("Polje za email mora biti popunjeno");
    } else if(!proveraEmail.test(regEmail)){
        regGreske.push("Email nije u dobrom formatu");
        $('#regEmailGreska').html("Email nije u dobrom formatu");
    } else{
        $('#regEmailGreska').html("");
    }

    if(regKorIme === ""){
        regGreske.push("Polje za korisničko ime mora biti popunjeno");
        $('#regKorImeGreska').html("Polje za korisničko ime mora biti popunjeno");
    } else if(!proveraKorIme.test(regKorIme)){
        regGreske.push("Korisničko ime mora imati 5-15 karaktera");
        $('#regKorImeGreska').html("Korisničko ime mora imati 5-15 karaktera");
    } else{
        $('#regKorImeGreska').html("");
    }


    if(regLozinka === ""){
        regGreske.push("Polje za lozinku mora biti popunjeno");
        $('#regLozinkaGreska').html("Polje za lozinku mora biti popunjeno");
    } else if(regLozinka.length < 6){
        regGreske.push("Lozinka mora imati bar 6 karaktera");
        $('#regLozinkaGreska').html("Lozinka mora imati bar 6 karaktera");
    } else if((regLozinka !== regLozinka2) && (regLozinka2 !== "") && (regLozinka2.length >= 6)){
        regGreske.push("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinkaGreska').html("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinka2Greska').html("Lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#regLozinkaGreska').html("");
    }

    if(regLozinka2 === ""){
        regGreske.push("Polje za ponovljenu lozinku mora biti popunjeno");
        $('#regLozinka2Greska').html("Polje za ponovljenu lozinku mora biti popunjeno");
    } else if(regLozinka2.length < 6){
        regGreske.push("Ponovljena lozinka mora imati bar 6 karaktera");
        $('#regLozinka2Greska').html("Ponovljena lozinka mora imati bar 6 karaktera");
    } else if((regLozinka !== regLozinka2) && (regLozinka !== "") && (regLozinka.length >= 6)){
        regGreske.push("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinkaGreska').html("Lozinka i ponovljena lozinka se ne poklapaju");
        $('#regLozinka2Greska').html("Lozinka i ponovljena lozinka se ne poklapaju");
    } else{
        $('#regLozinka2Greska').html("");
    }


    if(regGreske.length == 0){
        var data = {
            regIme : regIme,
            regPrezime : regPrezime,
            regEmail : regEmail,
            regKorIme : regKorIme,
            regLozinka : regLozinka,
            regLozinka2 : regLozinka2,
            regDugme : "ok"
        };
        $.ajax({
            url : "modules/register.php",
            method : "POST",
            dataType : "json",
            data : data,
            success : function (data) {
                $('.greske').html("<h2>Uspešno ste se registrovali!</h2><h4>Proverite email i aktivirajte nalog</h4>");
                setTimeout(function() {
                    window.location.href = "http://localhost/php2sajt1/index.php";
                }, 10000);
            },
            error : function (xhr, status, error) {
                let greska = "";
                if(xhr.responseText != null)
                {
                    try {
                        greska = JSON.parse(xhr.responseText).message;
                    } catch (e) {
                        greska = "";
                    }
                }
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguća registracija novih korisnika, pokušajte kasnije";
                        break;
                    case 409:
                        poruka = "Korisničko ime ili email već postoje";
                        break;
                    case 422:
                        poruka = "<ul>";
                        for(let i=0; i<greska.length; i++){
                            poruka += "<li>"+ greska[i] +"</li>";
                        }
                        poruka += "</ul>";
                        break;
                    case 500:
                        poruka = "Greška pri registraciji, pokušajte kasnije";
                        break;
                }
                if(poruka != "")
                    $('.greske').html("<h4>"+ poruka +"</h4>");
            }
        });
    }
}


function loginProvera() {
    var loginKorIme = $.trim($('#loginKorIme').val());
    var loginLozinka = $('#loginLozinka').val();
    var reLoginKorIme = /^[\w\d\.\_]{5,15}$/;
    var loginGreske = [];

    if(loginKorIme === ""){
        loginGreske.push("Polje za korisničko ime mora biti popunjeno");
        $('#loginKorImeGreska').html("Polje za korisničko ime mora biti popunjeno");
    } else if(!reLoginKorIme.test(loginKorIme)){
        loginGreske.push("Korisničko ime mora imati 5-15 karaktera");
        $('#loginKorImeGreska').html("Korisničko ime mora imati 5-15 karaktera");
    } else{
        $('#loginKorImeGreska').html("");
    }

    if(loginLozinka === ""){
        loginGreske.push("Polje za lozinku mora biti popunjeno");
        $('#loginLozinkaGreska').html("Polje za lozinku mora biti popunjeno");
    } else if(loginLozinka.length < 6){
        loginGreske.push("Lozinka mora imati bar 6 karaktera");
        $('#loginLozinkaGreska').html("Lozinka mora imati bar 6 karaktera");
    } else{
        $('#loginLozinkaGreska').html("");
    }

    if(loginGreske.length == 0){
        var data = {
            loginKorIme : loginKorIme,
            loginLozinka : loginLozinka,
            loginDugme : "ok"
        };

        $.ajax({
            url : "modules/login.php",
            method : "POST",
            dataType : "json",
            data : data,
            success : function (data) {
                var uloga = data.message;
                if(uloga === "Admin"){
                    window.location.href = "http://localhost/php2sajt1/index.php?page=admin";
                } else{
                    window.location.href = "http://localhost/php2sajt1/index.php";
                }
            },
            error : function (xhr, status, error) {
                let greska = "";
                if(xhr.responseText != null)
                {
                    try {
                        greska = JSON.parse(xhr.responseText).message;
                    } catch (e) {
                        greska = "";
                    }
                }
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće prijavljivanje, pokušajte kasnije";
                        break;
                    case 409:
                        $('#loginKorImeGreska').html("Pogrešno korisničko ime ili lozinka");
                        $('#loginLozinkaGreska').html("Pogrešno korisničko ime ili lozinka");
                        break;
                    case 422:
                        poruka = "<ul>";
                        for(let i=0; i<greska.length; i++){
                            poruka += "<li>"+ greska[i] +"</li>";
                        }
                        poruka += "</ul>";
                        break;
                }
                if(poruka !== "")
                    $('.greske').html("<h4>"+ poruka +"</h4>");
            }
        });
    }
}


function contactProvera() {
    var contactEmail = $.trim($('#contactEmail').val());
    var poruka= $('#poruka').val();
    var reContactEmail = /^[\w]+[\.\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/;
    var contactGreske = [];

    if(contactEmail === ""){
        contactGreske.push("Polje za email mora biti popunjeno");
        $("#contactEmailGreska").html("Polje za email mora biti popunjeno");
    } else if(!reContactEmail.test(contactEmail)){
        contactGreske.push("Email nije u dobrom formatu");
        $("#contactEmailGreska").html("Email nije u dobrom formatu");
    } else{
        $("#contactEmailGreska").html("");
    }

    if(poruka === ""){
        contactGreske.push("Polje za poruku mora biti popunjeno");
        $("#contactPorukaGreska").html("Polje za poruku mora biti popunjeno");
    } else if(poruka.length < 15 || poruka.length > 200){
        contactGreske.push("Poruka mora imati 15-200 karaktera");
        $("#contactPorukaGreska").html("Poruka mora imati 15-200 karaktera");
    } else{
        $("#contactPorukaGreska").html("");
    }

    if(contactGreske.length == 0){
        var data = {
            contactEmail : contactEmail,
            poruka : poruka,
            contactDugme : "ok"
        };

        $.ajax({
            url : "modules/mailadmin.php",
            method : "POST",
            dataType : "json",
            data : data,
            success : function (data) {
                $('#contact_greske').html("<h2>Poruka uspešno poslata!</h2>");
                setTimeout(function() {
                    window.location.href = "http://localhost/php2sajt1/index.php";
                }, 5000);
            },
            error : function (xhr, status, error) {
                let greska = "";
                if(xhr.responseText != null)
                {
                    try {
                        greska = JSON.parse(xhr.responseText).message;
                    } catch (e) {
                        greska = "";
                    }
                }
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće poslati poruku, pokušajte kasnije";
                        break;
                    case 422:
                        poruka = "<ul>";
                        for(let i=0; i<greska.length; i++){
                            poruka += "<li>"+ greska[i] +"</li>";
                        }
                        poruka += "</ul>";
                        break;
                    case 500:
                        poruka = "Greška pri slanju poruke, pokušajte kasnije";
                        break;
                }
                if(poruka != "")
                    $('#contact_greske').html("<h4>"+ poruka +"</h4>");
            }
        });
    }
}


function addUserProvera(){
    var regIme = $.trim($('#regIme').val());
    var regPrezime = $.trim($('#regPrezime').val());
    var regEmail = $.trim($('#regEmail').val());
    var regKorIme = $.trim($('#regKorIme').val());
    var regLozinka = $('#regLozinka').val();
    var regLozinka2 = $('#regLozinka2').val();
    var uloga = $('#add_uloga').val();
    var aktivan = $('#add_aktivan').val();

    var proveraImePrezime = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}){0,1}$/;
    var proveraEmail = /^[\w]+[\.\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/;
    var proveraKorIme = /^[\w\d\.\_]{5,15}$/;
    var regGreske = [];


    if(regIme === ""){
        regGreske.push("Polje za ime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regIme)){
        regGreske.push("Ime nije u dobrom formatu");
    }
    if(regPrezime === ""){
        regGreske.push("Polje za prezime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regPrezime)){
        regGreske.push("Prezime nije u dobrom formatu");
    }
    if(regEmail === ""){
        regGreske.push("Polje za email mora biti popunjeno");
    } else if(!proveraEmail.test(regEmail)){
        regGreske.push("Email nije u dobrom formatu");
    }
    if(regKorIme === ""){
        regGreske.push("Polje za korisničko ime mora biti popunjeno");
    } else if(!proveraKorIme.test(regKorIme)){
        regGreske.push("Korisničko ime mora imati 5-15 karaktera");
    }
    if(regLozinka === ""){
        regGreske.push("Polje za lozinku mora biti popunjeno");
    } else if(regLozinka.length < 6){
        regGreske.push("Lozinka mora imati bar 6 karaktera");
    }
    if(regLozinka2 === ""){
        regGreske.push("Polje za ponovljenu lozinku mora biti popunjeno");
    } else if(regLozinka2.length < 6){
        regGreske.push("Ponovljena lozinka mora imati bar 6 karaktera");
    }
    if(regLozinka !== regLozinka2){
        regGreske.push("Lozinka i ponovljena lozinka se ne poklapaju");
    }
    if(uloga === "0"){
        regGreske.push("Morate odabrati ulogu");
    }
    if(aktivan === "2"){
        regGreske.push("Morate odabrati aktivnost korisnika");
    }

    if(regGreske.length){
        var regGreskeIspis = "<ul>";
        for(let i=0; i<regGreske.length; i++){
            regGreskeIspis += "<li><h4>"+ regGreske[i] +"</h4></li>";
        }
        regGreskeIspis += "</ul>";
        $('.admin_greske').html(regGreskeIspis);
    } else{
        var data = {
            regIme : regIme,
            regPrezime : regPrezime,
            regEmail : regEmail,
            regKorIme : regKorIme,
            regLozinka : regLozinka,
            regLozinka2 : regLozinka2,
            add_uloga : uloga,
            add_aktivan : aktivan,
            addUserDugme : "ok"
        };
        $.ajax({
            url : "modules/admin.php",
            method : "POST",
            dataType : "json",
            data : data,
            success : function (data) {
                $('.admin_greske').html("<h2>Uspešno ste dodali korisnika!</h2><h4>Uskoro ćete biti prebačeni na admin stranicu sa svim korisnicima</h4>");
                setTimeout(function() {
                    window.location.href = "http://localhost/php2sajt1/index.php?page=admin&adminaction=allusers";
                }, 5000);
            },
            error : function (xhr, status, error) {
                let greska = "";
                if(xhr.responseText != null)
                {
                    try {
                        greska = JSON.parse(xhr.responseText).message;
                    } catch (e) {
                        greska = "";
                    }
                }
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće dodavanje novog korisnika, pokušajte kasnije";
                        break;
                    case 409:
                        poruka = "Korisničko ime ili email već postoje";
                        break;
                    case 422:
                        poruka = "<ul>";
                        for(let i=0; i<greska.length; i++){
                            poruka += "<li>"+ greska[i] +"</li>";
                        }
                        poruka += "</ul>";
                        break;
                }
                if(poruka != "")
                    $('.admin_greske').html("<h4>"+ poruka +"</h4>");
            }

        });
    }
}

function obrisiKorisnika() {
    if(confirm("Da li želite da obrišete korisnika?")){
        var id = $(this).data('id');
        var data =
            {
                korisnikID : id,
                deleteUserDugme : "ok"
            };
        $.ajax({
            url : "modules/admin.php",
            method : "POST",
            data : data,
            success : function (data) {
                alert('Korisnik uspešno obrisan!');
                window.location.href = "http://localhost/php2sajt1/index.php?page=admin&adminaction=allusers";
            },
            error : function (xhr,status, error) {
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće obrisati korisnika, pokušajte kasnije";
                        break;
                    case 500 :
                        poruka = "Greška pri brisanju korisnika, pokušajte kasnije";
                        break;
                }
                alert(poruka);
            }
        });
    }
}


function updateUserProvera(){
    var regIme = $.trim($('#regIme').val());
    var regPrezime = $.trim($('#regPrezime').val());
    var regEmail = $.trim($('#regEmail').val());
    var regKorIme = $.trim($('#regKorIme').val());
    var uloga = $('#add_uloga').val();
    var aktivan = $('#add_aktivan').val();
    var idUpdate = $('#idUpdate').val();

    var proveraImePrezime = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}){0,1}$/;
    var proveraEmail = /^[\w]+[\.\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/;
    var proveraKorIme = /^[\w\d\.\_]{5,15}$/;
    var regGreske = [];


    if(regIme === ""){
        regGreske.push("Polje za ime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regIme)){
        regGreske.push("Ime nije u dobrom formatu");
    }
    if(regPrezime === ""){
        regGreske.push("Polje za prezime mora biti popunjeno");
    } else if(!proveraImePrezime.test(regPrezime)){
        regGreske.push("Prezime nije u dobrom formatu");
    }
    if(regEmail === ""){
        regGreske.push("Polje za email mora biti popunjeno");
    } else if(!proveraEmail.test(regEmail)){
        regGreske.push("Email nije u dobrom formatu");
    }
    if(regKorIme === ""){
        regGreske.push("Polje za korisničko ime mora biti popunjeno");
    } else if(!proveraKorIme.test(regKorIme)){
        regGreske.push("Korisničko ime mora imati 5-15 karaktera");
    }
    if(uloga === "0"){
        regGreske.push("Morate odabrati ulogu");
    }
    if(aktivan === "2"){
        regGreske.push("Morate odabrati aktivnost korisnika");
    }

    if(regGreske.length){
        var regGreskeIspis = "<ul>";
        for(let i=0; i<regGreske.length; i++){
            regGreskeIspis += "<li><h4>"+ regGreske[i] +"</h4></li>";
        }
        regGreskeIspis += "</ul>";
        $('.admin_greske').html(regGreskeIspis);
    } else{
        var data = {
            regIme : regIme,
            regPrezime : regPrezime,
            regEmail : regEmail,
            regKorIme : regKorIme,
            add_uloga : uloga,
            add_aktivan : aktivan,
            idUpdate : idUpdate,
            updateUserDugme : "ok"
        };
        $.ajax({
            url : "modules/admin.php",
            method : "POST",
            dataType : "json",
            data : data,
            success : function (data) {
                $('.admin_greske').html("<h2>Uspešno ste izmenili korisnika!</h2><h4>Uskoro ćete biti prebačeni na admin stranicu sa svim korisnicima</h4>");
                setTimeout(function() {
                    window.location.href = "http://localhost/php2sajt1/index.php?page=admin&adminaction=allusers";
                }, 5000);
            },
            error : function (xhr, status, error) {
                let greska = "";
                if(xhr.responseText != null)
                {
                    try {
                        greska = JSON.parse(xhr.responseText).message;
                    } catch (e) {
                        greska = "";
                    }
                }
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće izmeniti korisnika, pokušajte kasnije";
                        break;
                    case 409:
                        poruka = "Korisničko ime ili email već postoje";
                        break;
                    case 422:
                        poruka = "<ul>";
                        for(let i=0; i<greska.length; i++){
                            poruka += "<li>"+ greska[i] +"</li>";
                        }
                        poruka += "</ul>";
                        break;
                }
                if(poruka != "")
                    $('.admin_greske').html("<h4>"+ poruka +"</h4>");
            }

        });
    }
}


function obrisiProizvod() {
    if(confirm("Da li želite da obrišete proizod?")){
        var proizvodID = $(this).data('id');
        var data =
            {
                proizvodID : proizvodID,
                deleteProductDugme : "ok"
            };
        $.ajax({
            url : "modules/admin.php",
            method : "POST",
            data : data,
            success : function (data) {
                alert('Proizvod uspešno obrisan!');
                window.location.href = "http://localhost/php2sajt1/index.php?page=admin&adminaction=allproducts";
            },
            error : function (xhr, status, error) {
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće obrisati korisnika, pokušajte kasnije";
                        break;
                    case 500 :
                        poruka = "Greška pri brisanju korisnika, pokušajte kasnije";
                        break;
                }
                alert(poruka);
            }
        });
    }
}


function dodajUKorpu() {
    var proizvodID = $(this).data('id');
    var korisnikID = $('#sessionIdKor').val();

    if(korisnikID == ""){
        alert("Morate se prijaviti da bi dodali proizvod u korpu");
    } else{
        var data =
            {
                proizvodID : proizvodID,
                korisnikID : korisnikID,
                dodajUKorpuDugme : "ok"
            };
        $.ajax({
            url : "modules/shop.php",
            method : "POST",
            data : data,
            success : function (data) {
                alert("Proizvod je dodat u korpu!");
            },
            error : function (xhr, status, error) {
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće dodavati u korpu, pokušajte kasnije";
                        break;
                    case 500:
                        poruka = "Greška pri dodavanju u korpu, pokušajte kasnije";
                        break;
                }
                alert(poruka);
            }
        });
    }
}


function izbaciIzKorpe() {
    if(confirm("Da li želite da izbacite proizvod iz korpe?")){
        var proizvodID = $(this).data('id');
        var korisnikID = $('#idKorIzbaci').val();
        var data =
            {
                proizvodID : proizvodID,
                korisnikID : korisnikID,
                izbaciIzKorpeDugme : "ok"
            };
        $.ajax({
            url : "modules/shop.php",
            method : "POST",
            data : data,
            success : function (data) {
                window.location.href = "http://localhost/php2sajt1/index.php?page=shop";
            },
            error : function (xhr, status, error) {
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće izbaciti proizvod iz korpe, pokušajte kasnije";
                        break;
                    case 500 :
                        poruka = "Greška pri izbacivanju proizvoda iz korpe, pokušajte kasnije";
                        break;
                }
                alert(poruka);
            }
        });
    }

}


function kupi() {
    if(confirm("Da li želite da izvršite kupovinu?")){
        var korisnikID = $(this).data('id');
        var data =
            {
                korisnikID : korisnikID,
                kupiDugme : "ok"
            };
        $.ajax({
            url : "modules/shop.php",
            method : "POST",
            data : data,
            success : function (data) {
                alert("Kupovina uspešno izvršena!");
                window.location.href = "http://localhost/php2sajt1/index.php?page=shop";
            },
            error : function (xhr, status, error) {
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće izvršiti kupovinu, pokušajte kasnije";
                        break;
                    case 500 :
                        poruka = "Greška pri izvršavanju kupovine, pokušajte kasnije";
                        break;
                }
                alert(poruka);
            }
        });
    }
}


function dohvatiOdgovore() {
    var pitanjeID = $('#selectAnketa').val();
    $('#izaberiteOdgovor').html("");
    if(pitanjeID != "0"){
        var data =
            {
                pitanjeID : pitanjeID,
                dohvatiOdgovoreDugme : "ok"
            };
        $.ajax({
            url : "modules/survey.php",
            method : "POST",
            dataType : "json",
            data : data,
            success : function (data) {
                let podaci = data.message;

                let ispisPodaci = "<ul>";
                for(let i=0; i<podaci.length; i++){
                    ispisPodaci += "<li><input type='radio' value='"+ podaci[i].odgovorID +"' id='glasajOdgovori' name='glasajOdgovori'/>"+ podaci[i].odgovor +"</li>";
                }

                ispisPodaci += "</ul>";

                $('#odgovori').html(ispisPodaci);
                $('#glasajDugmeDiv').show();
            },
            error : function (xhr, status, error) {
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nema odgovora za izabrano pitanje";
                        break;
                    case 409:
                        poruka = "Trenutno nema odgovora za izabrano pitanje";
                        break;
                }
                if(poruka != "")
                    $('#odgovori').html("<h4>"+ poruka +"</h4>");
            }
        });
    } else{
        $('#odgovori').html("");
        $('#glasajDugmeDiv').hide();
    }
}


function glasaj() {
    var korisikLogovan = $('#contactKorisnikLogovan').val();
    var odgovori = document.getElementsByName("glasajOdgovori");
    var odgovorID = "";
    var pitanjeID = $('#selectAnketa').val();
    for(let i=0; i<odgovori.length; i++){
        if(odgovori[i].checked){
            odgovorID = odgovori[i].value;
        }
    }

    if(korisikLogovan === ""){
        $('#izaberiteOdgovor').html("<h4>Morate se prijaviti da bi glasali</h4>");
    } else if(odgovorID === ""){
        $('#izaberiteOdgovor').html("<h4>Izaberite odgovor</h4>");
    } else{
        var data =
            {
                pitanjeID : pitanjeID,
                odgovorID : odgovorID,
                glasajDugme : "ok"
            };
        $.ajax({
            url : "modules/survey.php",
            dataType : "json",
            method : "POST",
            data : data,
            success : function (data) {
                $('#izaberiteOdgovor').html("<h4>Uspešno ste glasali!</h4>");
            },
            error : function (xhr, status, error) {
                let poruka = "";
                switch (xhr.status){
                    case 404 :
                        poruka = "Trenutno nije moguće glasati na anketu";
                        break;
                    case 422:
                        poruka = "Na ovu anketu ste već glasali";
                        break;
                    case 500:
                        poruka = "Greska, pokušajte kasnije";
                        break;
                }
                if(poruka != "")
                    $('#izaberiteOdgovor').html("<h4>"+ poruka +"</h4>");
            }
        });
    }
}


function dohvatiRezultate() {
	var korisikLogovan = $('#contactKorisnikLogovan').val();
    var pitanjeID = $('#selectAnketa').val();
	
	if(korisikLogovan === ""){
        $('#izaberiteOdgovor').html("<h4>Morate se prijaviti da bi videli rezultate glasanja</h4>");
    } else{
		var data =
        {
            pitanjeID : pitanjeID,
            dohvatiRezultateDugme : "ok"
        };
    $.ajax({
        url : "modules/survey.php",
        method : "POST",
        dataType : "json",
        data : data,
        success : function (data) {
            let podaci = data.message;

            let ispisPodaci = "<ul>";
            for(let i=0; i<podaci.length; i++){

                ispisPodaci += "<li><p>"+ podaci[i].odgovor + " - " + podaci[i].broj_glasova;
                if(podaci[i].broj_glasova == 1){
                    ispisPodaci += " glas";
                } else if((podaci[i].broj_glasova > 1) && (podaci[i].broj_glasova < 5)){
                    ispisPodaci += " glasa";
                } else{
                    ispisPodaci += " glasova";
                }
                ispisPodaci += "</p></li>";
            }

            ispisPodaci += "</ul>";

            $('#izaberiteOdgovor').html(ispisPodaci);
        },
        error : function (xhr, status, error) {
            let poruka = "";
            switch (xhr.status) {
                case 404 :
                    poruka = "Trenutno nije moguće videti rezultate glasanja";
                    break;
                case 422:
                    poruka = "Trenutno nema rezultata za izabrano pitanje";
                    break;
            }
            if(poruka != "")
                $('#izaberiteOdgovor').html("<h4>"+ poruka +"</h4>");
        }
    });
	}
}


function korpaLogovanProvera() {
    alert("Morate se prijaviti da bi pristupili korpi");
}

function profilLogovanProvera() {
    alert("Morate se prijaviti da bi pristupili profilu");
}


function slajder(){
    var trenutna = $('.trenutna');
    var sledeca = trenutna.next().length ? trenutna.next() : trenutna.parent().children(':first');
    trenutna.hide().removeClass('trenutna');
    sledeca.fadeIn('slow').addClass('trenutna');
    setTimeout(slajder, 5000);
}