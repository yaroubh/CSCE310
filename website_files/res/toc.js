/**
 * This file makes a table of contents for elements with the class of 'toc-header'
 * 
 */

// Table of contents variable
var toc = `
    <nav class='toc'>
        <h3>Table of Contents:</h3>
            <ul>`;

$(".toc-header").each(function() {
  
  // Get the element and it's id
  let element = $(this);
  let heading = element.text();
  // Create a link to the element
  let link = "#" + element.attr("id");

  let next_line = `
    <li> 
      <a href='${link}'> 
        ${heading} 
      </a> 
    </li>
    `;

    toc += next_line;
});

toc += `
        </ul>
    </nav>
`;

$(".content").prepend(toc);