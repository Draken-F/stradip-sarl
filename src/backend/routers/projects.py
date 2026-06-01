from typing import List, Optional
from fastapi import APIRouter, Depends, HTTPException, status
from sqlmodel import Session, select
from ..database import get_session
from ..models import Realisation, RealisationSection, RealisationSectionPhoto, Product
from sqlalchemy.orm import selectinload
from pydantic import BaseModel

router = APIRouter()

# --- SCHEMAS POUR LA RÉPONSE (AVEC RELATIONS) ---
# On utilise Pydantic pur ici pour éviter les conflits SQLModel table/schema

class PhotoRead(BaseModel):
    id: int
    image_url: str
    ordre: int
    class Config:
        from_attributes = True

class ProductRead(BaseModel):
    id: int
    nom: str
    image_url: str
    class Config:
        from_attributes = True

class SectionRead(BaseModel):
    id: int
    titre_piece: str
    description: Optional[str] = None
    image_ambiance: str
    ordre_affichage: int
    photos: List[PhotoRead] = []
    products: List[ProductRead] = []
    class Config:
        from_attributes = True

class RealisationRead(BaseModel):
    id: int
    nom: str
    ville: str
    image_globale: str
    introduction: Optional[str] = None
    sections: List[SectionRead] = []
    class Config:
        from_attributes = True

class SectionCreate(BaseModel):
    titre_piece: str
    description: Optional[str] = None
    image_ambiance: str
    ordre_affichage: int = 0
    produit_ids: List[int] = []

# --- REALISATIONS (PROJECTS) ---

@router.get("/", response_model=List[Realisation])
def read_realisations(db: Session = Depends(get_session)):
    return db.exec(select(Realisation).order_by(Realisation.id.asc())).all()

@router.get("/{realisation_id}", response_model=RealisationRead)
def read_realisation(realisation_id: int, db: Session = Depends(get_session)):
    # On utilise selectinload pour charger les sections et leurs photos/produits associés
    statement = select(Realisation).where(Realisation.id == realisation_id).options(
        selectinload(Realisation.sections).selectinload(RealisationSection.photos),
        selectinload(Realisation.sections).selectinload(RealisationSection.products)
    )
    realisation = db.exec(statement).first()

    if not realisation:
        raise HTTPException(status_code=404, detail="Realisation not found")
    return realisation

from .activities import log_activity

@router.post("/", response_model=RealisationRead, status_code=status.HTTP_201_CREATED)
def create_realisation(realisation: Realisation, db: Session = Depends(get_session)):
    db.add(realisation)
    db.commit()
    db.refresh(realisation)
    log_activity("Création", "Projet", realisation.nom, "🏗️", db)
    return realisation

@router.put("/{realisation_id}", response_model=Realisation)
def update_realisation(realisation_id: int, realisation_data: Realisation, db: Session = Depends(get_session)):
    db_realisation = db.get(Realisation, realisation_id)
    if not db_realisation:
        raise HTTPException(status_code=404, detail="Realisation not found")
    
    data = realisation_data.dict(exclude_unset=True)
    for key, value in data.items():
        setattr(db_realisation, key, value)
    
    db.add(db_realisation)
    db.commit()
    db.refresh(db_realisation)
    log_activity("Modification", "Projet", db_realisation.nom, "🛠️", db)
    return db_realisation

@router.delete("/{realisation_id}")
def delete_realisation(realisation_id: int, db: Session = Depends(get_session)):
    realisation = db.get(Realisation, realisation_id)
    if not realisation:
        raise HTTPException(status_code=404, detail="Realisation not found")
    name = realisation.nom
    db.delete(realisation)
    db.commit()
    log_activity("Suppression", "Projet", name, "🗑️", db)
    return {"ok": True}

# --- SECTIONS ---

@router.post("/{realisation_id}/sections", response_model=RealisationSection)
def create_section(realisation_id: int, section_data: SectionCreate, db: Session = Depends(get_session)):
    realisation = db.get(Realisation, realisation_id)
    if not realisation:
        raise HTTPException(status_code=404, detail="Realisation not found")
    
    db_section = RealisationSection(
        titre_piece=section_data.titre_piece,
        description=section_data.description,
        image_ambiance=section_data.image_ambiance,
        ordre_affichage=section_data.ordre_affichage,
        realisation_id=realisation_id
    )
    
    if section_data.produit_ids:
        statement = select(Product).where(Product.id.in_(section_data.produit_ids))
        products = db.exec(statement).all()
        db_section.products = products

    db.add(db_section)
    db.commit()
    db.refresh(db_section)
    return db_section


@router.get("/sections/{section_id}", response_model=SectionRead)
def read_section(section_id: int, db: Session = Depends(get_session)):
    statement = select(RealisationSection).where(RealisationSection.id == section_id).options(
        selectinload(RealisationSection.photos),
        selectinload(RealisationSection.products)
    )
    section = db.exec(statement).first()
    if not section:
        raise HTTPException(status_code=404, detail="Section not found")
    return section

@router.put("/sections/{section_id}", response_model=RealisationSection)
def update_section(section_id: int, section_data: RealisationSection, db: Session = Depends(get_session)):
    db_section = db.get(RealisationSection, section_id)
    if not db_section:
        raise HTTPException(status_code=404, detail="Section not found")
    
    data = section_data.dict(exclude_unset=True)
    for key, value in data.items():
        setattr(db_section, key, value)
    
    db.add(db_section)
    db.commit()
    db.refresh(db_section)
    return db_section

@router.delete("/sections/{section_id}")
def delete_section(section_id: int, db: Session = Depends(get_session)):
    section = db.get(RealisationSection, section_id)
    if not section:
        raise HTTPException(status_code=404, detail="Section not found")
    db.delete(section)
    db.commit()
    return {"ok": True}

# --- PHOTOS ---

@router.post("/sections/{section_id}/photos", response_model=RealisationSectionPhoto)
def create_photo(section_id: int, photo: RealisationSectionPhoto, db: Session = Depends(get_session)):
    section = db.get(RealisationSection, section_id)
    if not section:
        raise HTTPException(status_code=404, detail="Section not found")
    photo.section_id = section_id
    db.add(photo)
    db.commit()
    db.refresh(photo)
    return photo

@router.delete("/photos/{photo_id}")
def delete_photo(photo_id: int, db: Session = Depends(get_session)):
    photo = db.get(RealisationSectionPhoto, photo_id)
    if not photo:
        raise HTTPException(status_code=404, detail="Photo not found")
    db.delete(photo)
    db.commit()
    return {"ok": True}
