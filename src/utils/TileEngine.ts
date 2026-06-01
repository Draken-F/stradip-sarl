import * as THREE from 'three';

export class TileEngine {
    private scene: THREE.Scene;
    private camera: THREE.PerspectiveCamera;
    private renderer: THREE.WebGLRenderer;
    private floorMesh: THREE.Mesh | null = null;
    private textureLoader: THREE.TextureLoader;

    constructor(canvas: HTMLCanvasElement) {
        this.scene = new THREE.Scene();
        this.textureLoader = new THREE.TextureLoader();
        
        this.camera = new THREE.PerspectiveCamera(75, canvas.width / canvas.height, 0.1, 1000);
        this.camera.position.z = 5;
        this.camera.position.y = 2; // On lève un peu la caméra pour mieux voir le sol

        this.renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
        this.renderer.setSize(canvas.clientWidth, canvas.clientHeight);

        // Ajout d'une lumière de base dès le début
        const light = new THREE.AmbientLight(0xffffff, 1.2);
        this.scene.add(light);
    }

    public async loadTile(url: string, tileWidthCm: number, tileHeightCm: number) {
        const texture = await this.textureLoader.loadAsync(url);
        texture.wrapS = THREE.RepeatWrapping;
        texture.wrapT = THREE.RepeatWrapping;
        
        // Ajustement de la répétition
        texture.repeat.set(1000 / tileWidthCm, 1000 / tileHeightCm);

        const material = new THREE.MeshStandardMaterial({ 
            map: texture,
            roughness: 0.2,
            metalness: 0.0 
        });

        if (this.floorMesh) {
            this.floorMesh.material = material;
        } else {
            const geometry = new THREE.PlaneGeometry(30, 30); // Un peu plus grand pour couvrir tout le sol
            this.floorMesh = new THREE.Mesh(geometry, material);
            this.floorMesh.rotation.x = -Math.PI / 2;
            this.scene.add(this.floorMesh);
        }

        this.render();
    }

    public async setupRoom(roomImageUrl: string, maskImageUrl: string) {
        // CORRECTION : On vérifie si floorMesh existe avant d'agir
        if (!this.floorMesh) {
            // Si le mesh n'existe pas encore, on crée un matériau par défaut temporaire
            // Ou on appelle loadTile avec une texture par défaut
            console.warn("floorMesh n'est pas encore initialisé. Appel de loadTile requis.");
            return; 
        }

        const maskTexture = await this.textureLoader.loadAsync(maskImageUrl);
        
        // On récupère le matériau actuel pour ne pas perdre la texture du carrelage chargée
        const currentMaterial = this.floorMesh.material as THREE.MeshStandardMaterial;

        // On met à jour le matériau avec le masque de l'IA
        currentMaterial.alphaMap = maskTexture;
        currentMaterial.transparent = true;
        currentMaterial.needsUpdate = true; // Force Three.js à rafraîchir le shader

        this.render();
    }

    public render() {
        this.renderer.render(this.scene, this.camera);
    }

    public setRotation(x: number) {
        // CORRECTION : Vérification du null
        if (this.floorMesh) {
            this.floorMesh.rotation.x = x;
            this.render();
        }
    }

    // ... code existant ...

    // Nouvelle méthode pour changer dynamiquement le carrelage
    public async changeTexture(url: string, tileWidthCm: number, tileHeightCm: number) {
        if (!this.floorMesh) return;

        // Charger la nouvelle image
        const newTexture = await this.textureLoader.loadAsync(url);
        newTexture.wrapS = THREE.RepeatWrapping;
        newTexture.wrapT = THREE.RepeatWrapping;
        newTexture.repeat.set(1000 / tileWidthCm, 1000 / tileHeightCm);

        // Mettre à jour le matériau existant
        const currentMaterial = this.floorMesh.material as THREE.MeshStandardMaterial;
        currentMaterial.map = newTexture;
        currentMaterial.needsUpdate = true; // Indispensable pour que Three.js recalcule l'affichage

        this.render();
    }
}