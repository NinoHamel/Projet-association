bouton2.addEventListener("click", () =>
{
  l2 = document.getElementById("l2");

  if (getComputedStyle(l2).display != "none")
  {
    l2.style.display = "none";
    document.getElementById('profession').disabled = false;       /* on active le champ profession quand le champ ville de résidence n'est pas actif  */
  }
  else
  {
    l2.style.display = "block";
    document.getElementById('profession').disabled = true;        /* on active le champ ville de résidence quand le champ profession n'est pas actif */
  }
})