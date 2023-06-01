<?php
/**
 * The template for displaying front page
 */

get_header();
?>

	<style>
.containjoe {
  display: grid;
  grid-template-columns: 1fr 2fr;
  background-color: #FFF7EC;
  padding: 20px;
  margin-inline: 4rem;
  margin-bottom: 4rem;
}

h1 {
	font-family: "staatliches";
}

p {
	font-family: "poppins";
	max-width: 75ch;
}

.image-container {
  max-width: 100%;
}

#tilbage {
			font-size: 1.5rem;
			font-family: "staatliches";
      text-decoration: underline #C42626;
      color: #C42626;
      background-color: transparent;
      border: none;
		}

		#tilbage:hover {
			transform: scale(1.1);
			transition: 0.2s;
			color: black;
      text-decoration: underline black;
		}

.content-container {
  flex: 2;
  padding-left: 20px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

h2 {
  font-size: 24px;
  margin-bottom: 10px;
  color: black;
}

.small-images {
  display: flex;
  justify-content: flex-end;
  align-items: flex-end;
  margin-top: 20px;
 
}

.small-image {
  width: 200px;
  height: 200px;
  object-fit: cover;
  cursor: pointer;
   margin-right: 1rem;
     transition: transform 0.3s;
}

.small-image:hover {
  transform: scale(1.1);
}


.small-image.enlarged {
  transform: scale(2);
  z-index: 1;
}


@media (max-width: 1068px) {
   .small-image {
    width: 90px;
    height: 90px;
    margin-bottom: 10px;
    margin-right: 10px;
  }
}

@media (max-width: 768px) {
  .containjoe {
    display: block;
    padding: 10px;
    margin-inline: 2rem;
  }

  h1 {
	padding-top: 10px;
	margin-bottom: 10px;
  }

  .content-container {
    padding-left: 0;
  }

  .small-images {
    justify-content: flex-start;
  }

  .small-image {
    width: 80px;
    height: 80px;
    margin-bottom: 10px;
    margin-right: 10px;
  }
}

@media (max-width: 576px) {
  .containjoe {
    margin-inline: 1rem;
  }

  .small-images {
    flex-wrap: wrap;
  }

  .small-image {
    width: 80px;
    height: 80px;
    margin-bottom: 5px;
    margin-right: 5px;
  }
}

@media (min-width: 770px) {
  #tilbage {
				margin-left: 2rem;
			}
}


	</style>

		<section id="primary" class="content-area">
		<main id="main" class="site-main">

    <!-- Tilbageknap på single view -->
		<form>
 		<input id="tilbage" type="button" value="< Tilbage" onclick="history.back()">
		</form>

			<article class="single">

<div class="containjoe">
    <img class="image-container img" src="" alt="Vertical Image">

  <div class="content-container">
	<div class="title">
						<h1>Titel</h1>
					</div>
     <p class="beskrivelse"></p>
    <div class="small-images">
      <img src="" alt="Small Image 1" class="small-image billed1">
      <img src="" alt="Small Image 2" class="small-image billed2">
      <img src="" alt="Small Image 2" class="small-image billed3">
    </div>
  </div>
</div>

</article>
		</main><!-- #main -->


		<script>
			let skuespiller;
			const url = "https://jakobsemajergaric.dk/kea/4.SEM/eksamen/wp-json/wp/v2/skuespiller/"+<?php echo get_the_ID()?>;
       

	const smallImages = document.querySelectorAll('.small-image');

smallImages.forEach((image) => {
  image.addEventListener('click', () => {
    // Check if the clicked image already has the enlarged class
    const isEnlarged = image.classList.contains('enlarged');

    // Remove the enlarged class from all images
    smallImages.forEach((img) => img.classList.remove('enlarged'));

    if (!isEnlarged) {
      // Add enlarged class to the clicked image
      image.classList.add('enlarged');
    }
  });
});

document.addEventListener('click', (event) => {
  // Check if the clicked element is a small image or a child of a small image
  const isSmallImage = event.target.closest('.small-image');

  // Remove enlarged class from all images if the click is outside a small image
  if (!isSmallImage) {
    smallImages.forEach((image) => image.classList.remove('enlarged'));
  }
});


			async function getJson() {
				const jsonData = await fetch(url); 
                skuespiller = await jsonData.json();
				visSkuespiller();
			}

			function visSkuespiller() {
				console.log("skuespillere") 
				document.querySelector(".img").src = skuespiller.billede.guid;
				document.querySelector(".billed1").src = skuespiller.billed1.guid;
				document.querySelector(".billed2").src = skuespiller.billed2.guid;
				document.querySelector(".billed3").src = skuespiller.billed3.guid;
				document.querySelector(".title h1").textContent = skuespiller.title.rendered;
				document.querySelector(".beskrivelse").textContent = skuespiller.beskrivelse;
		

			}
			getJson();
		</script>
	</section><!-- #primary -->

<?php
get_footer();
