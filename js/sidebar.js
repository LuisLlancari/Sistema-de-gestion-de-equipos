document.addEventListener("DOMContentLoaded",() => {

    function $(id){
        return document.querySelector(id);
    }

    const linkColor = document.querySelectorAll(".nav_link");

    function showNavbar(toggleId, navId, bodyId, headerId){

        const toggle    = $(toggleId);
        const nav       = $(navId);
        const bodypd    = $(bodyId);
        const headerpd  = $(headerId);
        
            //Validamos si existen las variables
            if(toggle && nav && bodypd && headerpd){
                toggle.addEventListener('click', ()=>{
                    // show navbar
                    nav.classList.toggle('show')
                    // change icon
                    toggle.classList.toggle('bx-x')
                    // add padding to body
                    bodypd.classList.toggle('body-pd')
                    // add padding to header
                    headerpd.classList.toggle('body-pd')
                });
            }
    }
    
    function colorLink(){

        if(linkColor){ 
            linkColor.forEach(l=>{

                l.classList.remove('active');
                this.classList.add('active')
            }); 
        }
    }

    showNavbar('header-toggle','nav-bar','body-pd','header');


    /*===== LINK ACTIVE =====*/
    linkColor.forEach(l=> {l.addEventListener('click', colorLink)});
});
