class Bird {
    constructor(name) {
      this.name = name;
    }
    fly() {
      console.log(`${this.name} flies by flapping its wings.`);
    }
  }
  class Airplane {
    constructor(model) {
      this.model = model;
    }
    fly() {
      console.log(`${this.model} flies using jet engines.`);
    }
  }
  function makeFly(flyable) {
    flyable.fly();
  }
  // Demonstrasi polimorfisme
  const eagle = new Bird("Eagle");
  const boeing747 = new Airplane("Boeing 747");
  makeFly(eagle);       
  makeFly(boeing747);  
  console.log(eagle.fly());
  