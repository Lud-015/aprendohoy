var config = {
    type: Phaser.AUTO,
    width: 800,
    height: 600,
    backgroundColor: '#2d2d2d',
    scene: {
        preload: preload,
        create: create,
        update: update
    }
};

var game = new Phaser.Game(config);

function preload() {
    this.load.image("sky", "./assets/star.png");
}

function create() {

        this.star = this.add.image(0,0, "sky");
        this.star.setScale(2);
        this.star.flipX = true;
        this.star.setOrigin(0.5);
        this.star.setColliderWorldBounds(true);



        // Crear un objeto de gráficos
        const graphics = this.add.graphics();

        // Establecer el color de relleno para el cuadrado (por ejemplo, blanco)
        graphics.fillStyle(0xffffff, 1.0);

        // Dibujar un rectángulo (x, y, width, height)
        graphics.fillRect(200, 150, 100, 100);
}

function update(time, delta) {
}
