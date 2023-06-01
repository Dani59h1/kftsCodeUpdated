<?php
/**
 * The template for displaying front page
 */

get_header();
?>



<template>
	<article class="grid-menu">
      	<img src="" alt="" />

      	<div class="tekst">
			<h3 class="title"></h3>
      </div>
    </article>
</template>

<style>

	@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

	 #container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 2rem;
	  margin-inline: 5rem;
    }

	.rykmig {
		margin-left: 5rem;
		margin-right: 5px;
	}

	h1 {
		font-size: 4rem;
	}

	.centurion {
		 text-align: center;
	}

	.centurion2 {
		 font-size: 2rem;
		 font-family: "staatliches";
		 text-decoration: underline;
		 color: #C42626;
	}

	#filtrering {
		background-color: #FFF7EC;
		padding-block: 7px;
		border-style: solid;
  		border-width: 1px;
		border-color: #C42626;
	}

	.filtrering {
		margin: 10px;
	}

	.title {
		font-family: "poppins";
		font-size: 1rem;
		font-weight: bold;
		text-decoration: underline;
		text-decoration-thickness: 2px;
	}

	.tekst {
		padding: 0;
		margin: 0;
	}
	
	 @media (max-width: 921px) {
	  #container {
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
	  margin-inline: 0;
	  padding-inline: 1rem;
	  justify-content: center;
      }
	}

	h1, h2 {
		margin: 0;
		text-align: center;
  		font-family: "staatliches";
		color: #C42626;
	}

	h1 {
		margin-bottom: 1rem;
		font-size: 3rem:
	}

	.centrermigskat {
		max-width: 700px;
		margin: 0 auto;	
		padding-inline: 1rem;
	}

	.grid-menu {
		cursor: pointer;
	}

	.selected {
	}

	@media (max-width: 770px) {

	.filtrering, .selected {
  /*background-color: #ffe5e9; */
  border: 2px solid #997fa3;
  color: #1f5373; 
  padding: 10px 24px; /* Some padding */
  margin-bottom: 0.5rem;
  margin-inline: 2rem;
  cursor: pointer; /* Pointer/hand icon */
  width: 100%; /* Set a width if needed */
  display: block; /* Make the buttons appear below each other */
	}


	.filtrering:hover, .selected:hover {
	}

	}

</style>

<section id ="primary" class="content-area">
	<main id ="main" class="site-main">

	<h1>KFTS' STUDERENDE</h1>
	<div class="centrermigskat">
		<p>På denne side kan du filtrere gennem vores talentfulde studerende. Vores studerende er alle sammen passionerede omkring deres kunst, 
		og de arbejder hårdt på at forbedre deres færdigheder og udvikle deres talent. Vi er stolte af dem alle sammen og er sikre på, at du vil finde inspiration i deres arbejde.
		Hvis du er interesseret i at arbejde med en af vores studerende, kan du kontakte os.</p>
	</div>

	<div class="centurion"><a href="https://jakobsemajergaric.dk/kea/4.SEM/eksamen/kontakt/" class="centurion2">KONTAKT OS></a></div>

		

			
			
			<label for="elever" class="rykmig">Sorter</label>
			<select name="elever" id="filtrering">
				<option data-skuespiller="alle" class="selected filtrering">Alle</option>
				
			</select>

			<section id="container"></section>
		

</section>
</main>

<script>
let skuespillere;
let categories;
let filterSkuespiller = "alle";
const select = document.querySelector("#filtrering");

			//URL for alle skuespillere i API og viser op til 100 skuespillere på siden  (?per_page=100)
			const dbUrl = "https://jakobsemajergaric.dk/kea/4.SEM/eksamen/wp-json/wp/v2/skuespiller?per_page=100";
			//kategorier oprettet i WP
			const catUrl = "https://jakobsemajergaric.dk/kea/4.SEM/eksamen/wp-json/wp/v2/categories";


async function getJson (){

	const data = await fetch(dbUrl);
	const catdata = await fetch(catUrl);

	skuespillere = await data.json();
	categories = await catdata.json();

	visSkuespillere();
	opretknapper();
	addEventListenersToSelect();
}

//Creating sorting for categories:
function opretknapper() {
  // Check if the category "alle" already exists in the dropdown
  const alleExists = Array.from(select.options).some(option => option.textContent === "Alle");

  // If the category "alle" doesn't exist, add it to the dropdown
  if (!alleExists) {
    select.innerHTML += `<option class="filtrering" data-skuespiller="alle">Alle</option>`;
  }

  categories.forEach(cat => {
    // Skip adding the category "alle" again
    if (cat.name.toLowerCase() !== "alle") {
      select.innerHTML += `<option class="filtrering" data-skuespiller="${cat.id}">${cat.name}</option>`;
    }
  });
}

function addEventListenersToSelect() {
  select.addEventListener("change", filtrering);
}

function filtrering() {
  filterSkuespiller = select.options[select.selectedIndex].dataset.skuespiller;
  console.log(filterSkuespiller);
  visSkuespillere();
}


function visSkuespillere(){
	let temp = document.querySelector("template");
	let container = document.querySelector ("#container")
	console.log("Skuespillere")
	container.innerHTML = "";
	skuespillere.forEach(skuespiller => {
		if (filterSkuespiller == "alle" || skuespiller.categories.includes(parseInt(filterSkuespiller))) {
			let klon = temp.cloneNode(true).content;

			// Henter og viser udfyldt information på siden: 
			klon.querySelector(".title").textContent = skuespiller.title.rendered;
			klon.querySelector("img").src = skuespiller.billede.guid;
			klon.querySelector(".grid-menu").addEventListener("click", ()=> {location.href = skuespiller.link;})
			container.appendChild(klon);
	}
})
}

getJson();
</script>				
</section>

<?php
get_footer();