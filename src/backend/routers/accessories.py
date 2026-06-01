from typing import List, Optional
from fastapi import APIRouter, Depends, HTTPException, status
from sqlmodel import Session, select
from ..database import get_session
from ..models import Accessory

router = APIRouter()

@router.get("/", response_model=List[Accessory])
def read_accessories(
    categorie: Optional[str] = None,
    db: Session = Depends(get_session)
):
    statement = select(Accessory)
    if categorie:
        statement = statement.where(Accessory.categorie_acc == categorie)
    return db.exec(statement).all()

@router.get("/{accessory_id}", response_model=Accessory)
def read_accessory(accessory_id: int, db: Session = Depends(get_session)):
    accessory = db.get(Accessory, accessory_id)
    if not accessory:
        raise HTTPException(status_code=404, detail="Accessory not found")
    return accessory

from .activities import log_activity

@router.post("/", response_model=Accessory, status_code=status.HTTP_201_CREATED)
def create_accessory(accessory: Accessory, db: Session = Depends(get_session)):
    db.add(accessory)
    db.commit()
    db.refresh(accessory)
    log_activity("Création", "Accessoire", accessory.nom, "🛠️", db)
    return accessory

@router.put("/{accessory_id}", response_model=Accessory)
def update_accessory(accessory_id: int, accessory_data: Accessory, db: Session = Depends(get_session)):
    db_accessory = db.get(Accessory, accessory_id)
    if not db_accessory:
        raise HTTPException(status_code=404, detail="Accessory not found")
    
    data = accessory_data.dict(exclude_unset=True)
    for key, value in data.items():
        setattr(db_accessory, key, value)
    
    db.add(db_accessory)
    db.commit()
    db.refresh(db_accessory)
    log_activity("Modification", "Accessoire", db_accessory.nom, "📝", db)
    return db_accessory

@router.delete("/{accessory_id}")
def delete_accessory(accessory_id: int, db: Session = Depends(get_session)):
    accessory = db.get(Accessory, accessory_id)
    if not accessory:
        raise HTTPException(status_code=404, detail="Accessory not found")
    name = accessory.nom
    db.delete(accessory)
    db.commit()
    log_activity("Suppression", "Accessoire", name, "🗑️", db)
    return {"ok": True}
