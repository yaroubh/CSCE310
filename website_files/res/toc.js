/**
 * This file makes a table of contents for elements with the class of 'toc-header'
 * Entire file responsible by Jacob Enerio
 */


// Initiailize Table of contents variable
var toc = `
    <nav class='toc'>
        <h3>Table of Contents:</h3>
            <ul>`;

// For each toc-header, get the link to it
$(".toc-header").each(function() {
  
  // Get the element and it's id
  let element = $(this);
  let heading = element.text();
  // Create a link to the element
  let link = "#" + element.attr("id");
  // Make the next line of the table of contents
  let next_line = `
    <li> 
      <a href='${link}'> 
        ${heading} 
      </a> 
    </li>
    `;
  // Add the next line to the table of contents
  toc += next_line;
});

// End the table of contents
toc += `
        </ul>
    </nav>
`;

// Add the table of contents to elements with the class "content"
$(".content").prepend(toc);