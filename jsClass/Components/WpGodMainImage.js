class WpGodMainImage {
    constructor() {
        this.events();
    }

    events(){
      this.outputConsole('Testing Main Image');
      const MainImage = document.getElementById('WpGodMainImage');
      MainImage.addEventListener('click', this.outputConsole('click en la imagen'));
    }

    outputConsole(messaje) {
        console.log(messaje);
    }
}

new WpGodMainImage();