from typing import List, Optional
from fastapi import APIRouter, Depends, HTTPException, status
from sqlmodel import Session, select
from database import get_session
from models import Product, Category

router = APIRouter()

# --- CATEGORIES ---

@router.get("/categories", response_model=List[Category])
def read_categories(db: Session = Depends(get_session)):
    return db.exec(select(Category)).all()

@router.post("/categories", response_model=Category, status_code=status.HTTP_201_CREATED)
def create_category(category: Category, db: Session = Depends(get_session)):
    db.add(category)
    db.commit()
    db.refresh(category)
    return category

# --- PRODUCTS ---

from pydantic import BaseModel

class ProductsResponse(BaseModel):
    items: List[Product]
    total: int

@router.get("/", response_model=ProductsResponse)
def read_products(
    category_id: Optional[int] = None,
    style: Optional[str] = None,
    type_pose: Optional[str] = None,
    piece: Optional[str] = None,
    couleur: Optional[str] = None,
    skip: int = 0,
    limit: int = 12,
    db: Session = Depends(get_session)
):
    # Base query for count and items
    statement = select(Product)
    
    if category_id:
        statement = statement.where(Product.category_id == category_id)
    if style and style != "Tous les styles":
        style_map = {"Carreaux Standard": "Standard", "Décorations & Motifs": "Décoratif / Motif"}
        statement = statement.where(Product.style == style_map.get(style, style))
    if type_pose and type_pose != "Toutes les poses":
        db_pose = "Sol" if "Sol" in type_pose else "Mur"
        statement = statement.where(Product.type_pose.contains(db_pose))
    if piece and piece != "Toutes les pièces":
        statement = statement.where(Product.piece.contains(piece))
    if couleur:
        statement = statement.where(Product.couleur == couleur)
    
    # Get total count before pagination
    total = len(db.exec(statement).all())
    
    # Get paginated items
    statement = statement.order_by(Product.id.asc()).offset(skip).limit(limit)
    items = db.exec(statement).all()
    
    return {"items": items, "total": total}

@router.get("/{product_id}", response_model=Product)
def read_product(product_id: int, db: Session = Depends(get_session)):
    product = db.get(Product, product_id)
    if not product:
        raise HTTPException(status_code=404, detail="Product not found")
    return product

from routers.activities import log_activity

@router.post("/", response_model=Product, status_code=status.HTTP_201_CREATED)
def create_product(product: Product, db: Session = Depends(get_session)):
    db.add(product)
    db.commit()
    db.refresh(product)
    log_activity("Création", "Produit", product.nom, "📦", db)
    return product

@router.put("/{product_id}", response_model=Product)
def update_product(product_id: int, product_data: Product, db: Session = Depends(get_session)):
    db_product = db.get(Product, product_id)
    if not db_product:
        raise HTTPException(status_code=404, detail="Product not found")
    
    data = product_data.dict(exclude_unset=True)
    for key, value in data.items():
        setattr(db_product, key, value)
    
    db.add(db_product)
    db.commit()
    db.refresh(db_product)
    log_activity("Modification", "Produit", db_product.nom, "📝", db)
    return db_product

@router.delete("/{product_id}")
def delete_product(product_id: int, db: Session = Depends(get_session)):
    product = db.get(Product, product_id)
    if not product:
        raise HTTPException(status_code=404, detail="Product not found")
    name = product.nom
    db.delete(product)
    db.commit()
    log_activity("Suppression", "Produit", name, "🗑️", db)
    return {"ok": True}
