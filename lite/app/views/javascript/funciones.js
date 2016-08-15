function confirma(miurl, mensaje){
    question = confirm(mensaje)
    if (question !="0"){
        top.location = miurl;  
        }
}