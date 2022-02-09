window.onload = function() {
  var paragraph = document.querySelectorAll("p");

  function getUnicode() {
    let lang = this.lang;
    let text = this.textContent;
    let params = "lang=" + lang + "&text=" + text;
    console.log(params);
    new simpleAjax("multiscript.php", "get",params,okGetUnicode,koGetUnicode);
  }

  function okGetUnicode(request) {
    console.log(request);
    let response = JSON.parse(request.response);
    let text = response.text;
    let lang = response.lang;
    //let paragraph = document.querySelector("p[lang='" + lang + "']");
    console.log(paragraph);
    console.log(text);
  }

  function koGetUnicode() {
    alert("Il y a eu un problème, veuillez raffraichir la page");
  }
    

  for(let i = 0; i < paragraph.length; i++) {
    paragraph[i].addEventListener("click", getUnicode);
    console.log(paragraph[i]);
  }

};