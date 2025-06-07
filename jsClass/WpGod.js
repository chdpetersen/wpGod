class WpGod {
    constructor() {
        this.events();
    }

    events(){
      this.outputConsole('Testing');
     
    }

    outputConsole(messaje) {
        console.log(messaje);
    }
}

new WpGod();