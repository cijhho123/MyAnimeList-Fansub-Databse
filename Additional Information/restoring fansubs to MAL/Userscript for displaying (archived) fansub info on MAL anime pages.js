// ==UserScript==
// @name         MAL Fansubs Archive
// @version      2
// @description  Displays archived fansub info on MAL anime pages
// @author       /u/iBzOtaku
// @match        https://myanimelist.net/anime/*
// @grant        none
// ==/UserScript==

(function() {
    'use strict';

    window.hidesubs = false;

    var id = document.getElementById("myinfo_anime_id").value;

    var heading = document.createElement("h2");
    heading.appendChild(document.createTextNode("Fansubs"));
    document.getElementsByClassName("pb24")[0].appendChild(document.createElement("br"));
    document.getElementsByClassName("pb24")[0].appendChild(heading);

    var loader = document.createElement("a");
    loader.setAttribute('href', "javascript:void(0)");
    loader.innerText = "loading...";

    fetch("https://api.malfansubs.xyz/?id=" + id).
    then(data => data.text()).
    then(function(data) {
        loader.style.textDecoration = "none";
        loader.style.color = "black";
        loader.innerHTML = "";

        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = 'hidelang';
        checkbox.onclick = function()
        {
            var elements = document.getElementsByClassName("nonenglish");

            if(checkbox.checked) {
                for (var x = 0; x < elements.length; x++)
                { elements[x].style.display = "none"; }
            } else {
                for (var y = 0; y < elements.length; y++)
                { elements[y].style.display = "block"; }
            }
        };

        var newlabel = document.createElement("Label");
        newlabel.setAttribute("for", "hidelang");
        newlabel.innerHTML = "Hide non-English subs";

        loader.appendChild(checkbox);
        loader.appendChild(newlabel);

        var htmlresponse = document.createElement('div');
        htmlresponse.innerHTML = data.trim();

        var links = htmlresponse.getElementsByClassName("commentToggle");

        for (var i = 0; i < links.length; i++) {
            links[i].onclick = function()
            {
                var box = document.getElementById("comments" + this.e);
                var style = box.currentStyle ? box.currentStyle.display : getComputedStyle(box, null).display;

                if(style === "none") box.style.display = "block";
                else box.style.display = "none";
            };
            links[i].e = links[i].id;
        }

        document.getElementsByClassName("pb24")[0].appendChild(htmlresponse);

        if(window.hidesubs) checkbox.click();
    });

    document.getElementsByClassName("pb24")[0].appendChild(loader);
    document.getElementsByClassName("pb24")[0].appendChild(document.createElement("br"));
    document.getElementsByClassName("pb24")[0].appendChild(document.createElement("br"));
})();