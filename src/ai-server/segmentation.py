import torch
import numpy as np
import cv2
from segment_anything import sam_model_registry, SamPredictor

class FloorSegmenter:
    def __init__(self, checkpoint_path="sam_vit_b_01ec64.pth"):
        model_type = "vit_b"
        device = "cuda" if torch.cuda.is_available() else "cpu"
        
        # Charger le modèle
        sam = sam_model_registry[model_type](checkpoint=checkpoint_path)
        sam.to(device=device)
        self.predictor = SamPredictor(sam)

    def get_mask(self, image_bgr):
        # 1. Donner l'image à l'IA
        self.predictor.set_image(image_bgr)
        
        # 2. On définit un point "guide" : le bas de l'image (milieu largeur, 90% hauteur)
        h, w = image_bgr.shape[:2]
        input_point = np.array([[w // 2, int(h * 0.9)]])
        input_label = np.array([1]) # 1 signifie "cet objet m'intéresse"

        # 3. Prédire le masque
        masks, scores, logits = self.predictor.predict(
            point_coords=input_point,
            point_labels=input_label,
            multimask_output=True,
        )

        # On prend le masque avec le meilleur score
        best_mask = masks[np.argmax(scores)]
        
        # Convertir le masque booléen en image noir et blanc (0 ou 255)
        mask_image = (best_mask.astype(np.uint8)) * 255
        return mask_image