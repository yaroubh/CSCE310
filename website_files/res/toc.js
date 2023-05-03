/**
 * This file makes a table of contents for elements with the class of 'toc-header'
 * 
 */

var newLine, el, title, link;

$(".toc-header").each(function() {

  el = $(this);
  title = el.text();
  link = "#" + el.attr("id");

  newLine =
    "<li>" +
      "<a href='" + link + "'>" +
        title +
      "</a>" +
    "</li>";

  ToC += newLine;



});

ToC +=
   "</ul>" +
  "</nav>";

$(".content").prepend(ToC);