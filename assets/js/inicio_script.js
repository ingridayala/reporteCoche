const sliderWrapper = document.querySelector("#sliderWrapper");
const sliderSelection = document.querySelectorAll(".sliderCaption");
const sliderbuttons = document.querySelectorAll(".slide-button");
const sliderHeader = document.querySelector("#slider-header");
const sliderText = document.querySelector("#slider-text");
const sliderAnchor = document.querySelector("#slider-anchor");


const textos = [
  {
    titulo: "Este es un titulo de lo mas importante",
    subtitulo: "Si ya lo sabes, no lo digas",
    labelButton: "Prueba el boton",
  },
  {
    titulo: "Este titulo ya no es tan importante",
    subtitulo: "No te preocupes, no es el ultimo",
    labelButton: "Este tambien es un boton",
  },
  {
    titulo: "Este titulo es el menos importante",
    subtitulo: "Venga ya, no te hagas el loco",
    labelButton: "No pulses este boton pls",
  },
];


function goToSlide(n) {
  // use the insertAdjacentElement method to move the selected slide 1,2 or 3 to the first position
  sliderWrapper.insertAdjacentElement("afterbegin", sliderSelection[n - 1]);

  sliderbuttons.forEach((button) => {
    button.classList.remove("active-slide-button");
  });
  sliderbuttons[n - 1].classList.add("active-slide-button");

  sliderHeader.textContent = textos[n - 1].titulo;
  sliderText.textContent = textos[n - 1].subtitulo;
  sliderAnchor.textContent = textos[n - 1].labelButton;

}

window.addEventListener("load", () => {
  goToSlide(1);
});