from fastapi import FastAPI, UploadFile, File
from fastapi.middleware.cors import CORSMiddleware
import cv2
import numpy as np
import base64
from segmentation import FloorSegmenter

app = FastAPI()

# Autoriser ton site Astro
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"], 
    allow_methods=["*"],
    allow_headers=["*"],
)

# Initialiser l'IA au démarrage
segmenter = FloorSegmenter()

@app.post("/segment-floor")
async def segment_floor(file: UploadFile = File(...)):
    # Lire l'image reçue
    contents = await file.read()
    nparr = np.frombuffer(contents, np.uint8)
    img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)

    # Obtenir le masque du sol
    mask = segmenter.get_mask(img)

    # Convertir en base64 pour l'envoyer au frontend
    _, buffer = cv2.imencode('.png', mask)
    mask_base64 = base64.b64encode(buffer).decode('utf-8')

    return {"mask": mask_base64}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000)