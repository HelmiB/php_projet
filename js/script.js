function search(el){
    if(el=='patient'){
        var users = document.querySelectorAll('.numRegistre');
    }else if(el=='medecin'){
        var users = document.querySelectorAll('.matricule');
    }
    var searchBar = document.querySelector('#searchBar');
    
    if(searchBar.value != ''){
        //console.log(searchBar.value);
        for(var i = 0; i<users.length; i++){
            users[i].parentElement.parentElement.className += " hidden";
            //console.log(users[i].innerHTML+' a pour class :'+users[i].classList);
        }

        for(var i = 0; i<users.length; i++){
            if(searchBar.value == users[i].innerHTML){
                users[i].parentElement.parentElement.className = "user";
                //console.log(users[i].innerHTML+' correspond à la recherche.');
            }
        }    
    }else{
        //console.log('searchBar vide');
        for(var i = 0; i<users.length; i++){
            users[i].parentElement.parentElement.className = "user";
        }
    }
}

function rdvTracker(){
    var seanceNom = document.querySelectorAll('.nom');
    var seanceDate = document.querySelectorAll('.seance__date');
    var searchBar = document.querySelector('#searchBar');
    var dateSearchBar = document.querySelector('#dateSearchBar');

    //console.log(dateSearchBar.value);

    if(searchBar.value != ''){
        console.log(searchBar.value);
        for(var i=0; i<seanceNom.length; i++){
            seanceNom[i].parentElement.parentElement.className += " hidden";
            console.log(seanceNom[i].innerHTML+' a pour class :'+seanceNom[i].classList);
        }
        for(var i=0; i<seanceNom.length; i++){
            if(seanceNom[i].innerHTML.toLowerCase() == searchBar.value.toLowerCase()){
                seanceNom[i].parentElement.parentElement.className = "seance";
                console.log(seanceNom[i].innerHTML+' correspond à la recherche.');
            }
        }
    }else{
        console.log('searchBar vide');
        for(var i=0; i<seanceNom.length; i++){
            seanceNom[i].parentElement.parentElement.className = "seance";
        }
    }
    if(dateSearchBar.value != ''){
        console.log(dateSearchBar.value);
        for(var i=0; i<seanceDate.length; i++){
            seanceDate[i].parentElement.className += " hidden";
            console.log(seanceDate[i].innerHTML+' a pour class :'+seanceDate[i].classList);
        }
        for(var i=0; i<seanceDate.length; i++){
            if(seanceDate[i].innerHTML == dateSearchBar.value){
                seanceDate[i].parentElement.className = "seance__container";
                console.log(seanceDate[i].innerHTML+' correspond à la recherche.');
            }
        }
    }else{
        console.log('dateSearchBar vide');
        for(var i=0; i<seanceDate.length; i++){
            seanceDate[i].parentElement.className = "seance__container";
        }
    }
}
function tri(){
    var item = document.querySelectorAll('.admin__article');
    var categorie = document.querySelectorAll('.categorie');
    var categorieBar = document.querySelector('#categorieSearch');
    var checkBar = document.querySelector('#checkSearch');

    if(categorieBar.options[categorieBar.selectedIndex].value != 'Tous'){
        for(var i=0; i<categorie.length; i++){
            categorie[i].parentElement.className += " hidden";
        }
        console.log(categorieBar.options[categorieBar.selectedIndex].value);
        for(var i=0; i<categorie.length; i++){
            if(categorie[i].innerHTML.toLowerCase() == categorieBar.options[categorieBar.selectedIndex].value.toLowerCase()){
                categorie[i].parentElement.classList.remove("hidden");
            }
        }
    }else{
        console.log('Tous');
        for(var i=0; i<categorie.length; i++){
            categorie[i].parentElement.classList.remove("hidden");
        }
    }
    if(checkBar.options[checkBar.selectedIndex].value != 'Tous'){
        for(var i=0; i<item.length; i++){
            item[i].className += " hidden";
        }
        console.log(checkBar.options[checkBar.selectedIndex].value);
        if(checkBar.options[checkBar.selectedIndex].value == 'Traites'){
            for(var i=0; i<item.length; i++){
                if(item[i].classList.contains("traite")){
                    item[i].classList.remove("hidden");
                }
            }
        }else if(checkBar.options[checkBar.selectedIndex].value == 'Non-traites'){
            for(var i=0; i<item.length; i++){
                if(item[i].classList.contains("nonTraite")){
                    item[i].classList.remove("hidden");
                }
            }
        }
    }else{
        console.log('Tous');
        for(var i=0; i<item.length; i++){
            item[i].classList.remove("hidden");
        }
    }
}

function sort(){
    var users = document.querySelectorAll('.nom');
    var service = document.querySelectorAll('.serviceNom');
    var serviceBar = document.querySelector('#serviceSearch');
    var searchBar = document.querySelector('#searchBar');

    if(searchBar.value != ''){
        console.log(searchBar.value);
        for(var i = 0; i<users.length; i++){
            users[i].parentElement.parentElement.className += " hidden";
            //console.log(users[i].innerHTML+' a pour class :'+users[i].classList);
        }

        for(var i = 0; i<users.length; i++){
            console.log(users[i].innerHTML.toLowerCase());
            console.log(searchBar.value.toLowerCase());
            if(searchBar.value.toLowerCase() == users[i].innerHTML.toLowerCase()){
                users[i].parentElement.parentElement.classList.remove('hidden');
                console.log(users[i].innerHTML+' correspond à la recherche.');
            }
        }    
    }else{
        console.log('searchBar vide');
        for(var i = 0; i<users.length; i++){
            users[i].parentElement.parentElement.classList.remove('hidden');
        }
    }
    if(serviceBar.options[serviceBar.selectedIndex].value != 'Tous'){
        for(var i=0; i<service.length; i++){
            service[i].parentElement.parentElement.className += " hidden";
        }
        console.log(serviceBar.options[serviceBar.selectedIndex].value);
        for(var i=0; i<service.length; i++){
            if(service[i].innerHTML.toLowerCase() == serviceBar.options[serviceBar.selectedIndex].value.toLowerCase()){
                service[i].parentElement.parentElement.classList.remove("hidden");
                console.log(service[i].innerHTML+' correspond à la recherche.');
            }
        }
    }else{
        console.log('Tous');
        for(var i=0; i<service.length; i++){
            service[i].parentElement.parentElement.classList.remove("hidden");
        }
    }
}

function ConfirmMessage(str, dest) {
    if (confirm("Confirmer ?")) { // Clic sur OK
        var xmlhttp = new XMLHttpRequest();
        console.log(dest);
        xmlhttp.open("GET", dest + str, true);
        xmlhttp.send();
        location.reload();
    }
}