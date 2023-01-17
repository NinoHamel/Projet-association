const dialog = document.getElementById('contact');

const openBtn = document.getElementById('openBtn');

const closeBtn = document.getElementById('closeBtn');

openBtn.addEventListener('click',function()
{
    dialog.setAttribute('open',true);         // prise en charge de l'ouverture de la popup
})

closeBtn.addEventListener('click',function()           
{ 
    dialog.removeAttribute('open');           // prise en charge de la fermeture de la popup
});


function popupBasique(page) 
{
  window.open(page);
}